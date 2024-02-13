<?php


add_action('wp_ajax_add_single_carpet_product_to_cart', 'add_single_carpet_product_to_cart');
add_action('wp_ajax_nopriv_add_single_carpet_product_to_cart', 'add_single_carpet_product_to_cart');

function add_single_carpet_product_to_cart()
{
    // Get product ID and quantity from the AJAX request
    $product_id = intval($_POST['carpetSingleProductId']);
    $product_qty = intval($_POST['productItemQty']);



    if (is_in_cart($product_id)) {


        remove_cart_item_by_product_id($product_id);

        // Product is not in the cart, add it with the specified quantity
        WC()->cart->add_to_cart($product_id, $product_qty);
    } else {

        // Product is not in the cart, add it with the specified quantity
        WC()->cart->add_to_cart($product_id, 1);
    }


    // Get updated cart HTML
    ob_start();

    // Ensure WooCommerce is active
    if (class_exists('WooCommerce')) {
        // Get the cart
        $cart = WC()->cart;

        // Check if the cart is not empty
        if (!$cart->is_empty()) {
            echo '<div class="card p-3 mt-4">';
            echo '<h6 class="mb-4">Items</h6>';

            // Loop through each cart item
            foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
                // Get product data
                $product_id = $cart_item['product_id'];
                $product = wc_get_product($product_id);
                $product_name = $product->get_name();
                $quantity = $cart_item['quantity'];
                $price = wc_price($product->get_price());
                $product_total = wc_price($product->get_price() * $quantity);

                // Display item details
                echo '<div class="confirm-product-item">';
                echo '<div class="item-details">';
                echo '<p class="mb-1">' . esc_html($product_name) . '</p>';
                echo '<p class="mb-1">Qty: ' . esc_html($quantity) . ' @ ' . $price . '</p>';
                echo '</div>';
                // Display product total on the right side
                echo '<div class="item-total">';
                echo '<p class="mb-1">' . $product_total . '</p>';
                echo '</div>';
                echo '</div>';
            }

            // Display the total
            echo '<div class="confirm-products-total mt-4">';
            echo '<p class="mb-1">Total</p>';
            echo '<p>' . $cart->get_cart_total() . '</p>';
            echo '</div>';

            echo '</div>';
        } else {
            // Cart is empty
            echo '<p>Your cart is empty.</p>';
        }
    }


    $cart_html = ob_get_clean();


    $subtotal = WC()->cart->get_subtotal();

    // Return the cart subtotal as a JSON response
    $response = array(
        'success' => true,
        'subtotal' => $subtotal,
        'cart_info' => $cart_html
    );



    echo json_encode($response);


    wp_die();
}



function is_in_cart($ids)
{
    // Initialise
    $found = false;

    // Loop through cart items
    foreach (WC()->cart->get_cart() as $cart_item) {
        // For an array of product IDs
        if (is_array($ids) && (in_array($cart_item['product_id'], $ids) || in_array($cart_item['variation_id'], $ids))) {
            $found = true;
            break;
        }
        // For a unique product ID (integer or string value)
        elseif (!is_array($ids) && ($ids == $cart_item['product_id'] || $ids == $cart_item['variation_id'])) {
            $found = true;
            break;
        }
    }

    return $found;
}


function remove_cart_item_by_product_id($product_id)
{
    // Get cart contents
    $cart = WC()->cart->get_cart();

    // Loop through cart items
    foreach ($cart as $cart_item_key => $cart_item) {
        // Check if the product ID matches
        if ($product_id == $cart_item['product_id']) {
            // Remove the cart item
            WC()->cart->remove_cart_item($cart_item_key);
            break; // Exit the loop after removing the item
        }
    }
}


// In your theme's functions.php or in a custom plugin
function carpet_process_booking()
{
    // Get the input values from the AJAX request
    $input_values = $_POST['inputs'];
    $selected_date = $_POST['selected_date'];
    $selected_time = $_POST['selected_time'];

    // Create a new WooCommerce order
    $order = wc_create_order();

    // Get the current cart
    $cart = WC()->cart;

    // Loop through the current cart items and add them to the order as line items
    foreach ($cart->get_cart() as $cart_item) {
        // Get product data
        $product_id = $cart_item['product_id'];
        $product_name = get_the_title($product_id);
        $product_quantity = $cart_item['quantity'];

        // Add line item to the order
        $order->add_product(wc_get_product($product_id), $product_quantity, array(
            'subtotal' => $cart_item['line_subtotal'],
            'total'    => $cart_item['line_total'],
            'name'     => $product_name,
        ));
    }

    // Loop through the input values and add them to the order as billing data
    foreach ($input_values as $input) {
        $item_name = $input['name'];
        $item_value = $input['value'];

        // Add billing data (assuming 'billing_' prefix, adjust as needed)
        switch ($item_name) {
            case 'Full Name':
                // Split full name into first name and last name
                $full_name_parts = explode(' ', $item_value, 2);
                $first_name = isset($full_name_parts[0]) ? $full_name_parts[0] : '';
                $last_name = isset($full_name_parts[1]) ? $full_name_parts[1] : '';

                $order->set_billing_first_name($first_name);
                $order->set_billing_last_name($last_name);
                break;

            case 'Service Address':
                $order->set_billing_address_1($item_value);
                break;

            case 'Unit':
                $order->set_billing_address_2($item_value);
                break;

            case 'City':
                $order->set_billing_city($item_value);
                break;

            case 'State':
                $order->set_billing_state($item_value);
                break;

            case 'Zip':
                $order->set_billing_postcode($item_value);
                break;

            case 'Mobile Phone':
                $order->set_billing_phone($item_value);
                break;
				
			case 'Email':
                $order->set_billing_email($item_value);
                break;


            default:
                // Handle unknown billing field
                break;
        }
    }


    
    $order->update_meta_data('_selected_date', $selected_date);
    $order->update_meta_data('_selected_time', $selected_time);


    // Calculate totals
    $order->calculate_totals();

	
	 // Set the order status to "processing"
    $order->update_status('processing');
	
    // Save order
    $order->save();



    wp_die();
}

// Hook for the AJAX action
add_action('wp_ajax_carpet_process_booking', 'carpet_process_booking');
add_action('wp_ajax_nopriv_carpet_process_booking', 'carpet_process_booking'); // For non-logged-in users
