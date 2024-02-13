<?php


add_shortcode('carpet_clean_service_shortcode', 'cyc_carpet_clean_service_shortcode');

function cyc_carpet_clean_service_shortcode()
{

    // Get the cart instance
    $cart = WC()->cart;

    // Check if the cart object is not null
    if ($cart && method_exists($cart, 'is_empty')) {
        // Check if the cart is empty
        if (!$cart->is_empty()) {

            $cart->empty_cart();
        }

        ob_start(); // Start output buffering

        require CYC_PLUGINS_PATH . '/includes/frontend/views/full-frontend.php';

        $output = ob_get_clean(); // Get the output and clean the buffer
        return $output;
    }
}



// Add meta data after billing address in WooCommerce order edit page
add_action('woocommerce_admin_order_data_after_billing_address', 'add_selected_date_and_time_to_order_edit_page', 10, 1);

function add_selected_date_and_time_to_order_edit_page($order)
{
    // Get selected date and time from order meta
    $selected_date = $order->get_meta('_selected_date');
    $selected_time = $order->get_meta('_selected_time');

    // Display selected date and time after billing address
    if ($selected_date && $selected_time) {
        echo '<p><strong>' . __('Selected Date:', 'woocommerce') . '</strong> ' . $selected_date . '</p>';
        echo '<p><strong>' . __('Selected Time:', 'woocommerce') . '</strong> ' . $selected_time . '</p>';
    }
}




// Add selected date and time to order email meta
add_action('woocommerce_email_order_meta', 'add_selected_date_and_time_to_order_email', 10, 4);

function add_selected_date_and_time_to_order_email($order, $sent_to_admin, $plain_text, $email)
{
    // Get selected date and time from order meta
    $selected_date = $order->get_meta('_selected_date');
    $selected_time = $order->get_meta('_selected_time');

    // Display selected date and time in the order email meta
    if ($selected_date && $selected_time) {
        echo '<h2>' . __('Selected Date and Time', 'woocommerce') . '</h2>';
        echo '<p><strong>' . __('Date:', 'woocommerce') . '</strong> ' . $selected_date . '</p>';
        echo '<p><strong>' . __('Time:', 'woocommerce') . '</strong> ' . $selected_time . '</p>';
    }
}




function get_filtered_selected_date_time() {
    global $wpdb;

    // Prepare the SQL query
    $query = $wpdb->prepare("
        SELECT * 
        FROM {$wpdb->prefix}wc_orders_meta
        WHERE meta_key IN (%s, %s)
    ", '_selected_date', '_selected_time');

    // Execute the query
    $results = $wpdb->get_results($query);

    // Initialize arrays to store selected date and time with their corresponding order IDs
    $selected_date_time = array();

    // Loop through the results
    foreach ($results as $result) {
        $order_id = $result->order_id;
        $meta_key = $result->meta_key;
        $meta_value = $result->meta_value;

        // Check if the meta key is '_selected_date' or '_selected_time'
        if ($meta_key === '_selected_date') {
            // Store selected date along with its corresponding order ID
            $selected_date_time[$order_id]['selected_date'] = $meta_value;
        } elseif ($meta_key === '_selected_time') {
            // Store selected time along with its corresponding order ID
            $selected_date_time[$order_id]['selected_time'] = $meta_value;
        }
    }

    // Get the current date
    $current_date = date('Y-m-d');

    // Initialize an empty array to store filtered results
    $filtered_selected_date_time = array();

    // Loop through the selected date and time array
    foreach ($selected_date_time as $order_id => $data) {
        $selected_date = $data['selected_date'];

        // Compare the selected date with the current date
        if ($selected_date >= $current_date) {
            // Store the entry in the filtered array
            $filtered_selected_date_time[] = $data;
        }
    }

    return $filtered_selected_date_time;
}
