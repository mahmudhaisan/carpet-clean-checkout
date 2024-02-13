<?php
// Add a custom dashboard page to the admin menu
function carpet_dashboard_menu_page()
{
    add_menu_page(
        'Carpet Dashboard',
        'Carpet Dashboard',
        'manage_options',
        'carpet_dashboard_page',
        'render_carpet_dashboard_page'
    );
}
add_action('admin_menu', 'carpet_dashboard_menu_page');

// Render the custom dashboard page
function render_carpet_dashboard_page()
{
?>
    <div class="wrap">
        <h2>Custom Dashboard</h2>
    </div>
<?php
}



// Assuming this function is part of your theme's functions.php file or a custom plugin

// Hook the function to display booking information on the admin order details page
add_action('woocommerce_admin_order_data_after_billing_address', 'display_booking_info_after_billing_address', 10, 1);

// The function to display booking information
function display_booking_info_after_billing_address($order)
{
    $order_id = $order->get_id(); // Use get_id() instead of ID

    // Get selected date and time
    $selected_date = get_post_meta($order_id, '_selected_date', true);
    $selected_time = get_post_meta($order_id, '_selected_time', true);

    echo '<div id="booking-info-after-billing" class="order_data_column">'; // Add class for styling

    if (!empty($selected_date)) {
        echo '<p><strong>Schedule Date:</strong> ' . esc_html($selected_date) . '</p>';
    }

    if (!empty($selected_time)) {
        echo '<p><strong>Schedule Time:</strong> ' . esc_html($selected_time) . '</p>';
    }

    echo '</div>';
}
