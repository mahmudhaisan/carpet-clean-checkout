<?php

/**
 * Plugin Name: Carpet Clean Checkout
 * Plugin URI: https://github.com/mahmudhaisan/
 * Description: Carpet Clean Checkout
 * Author: Mahmud haisan
 * Author URI: https://github.com/mahmudhaisan
 * Developer: Mahmud Haisan
 * Developer URI: https://github.com/mahmudhaisan
 * Text Domain: cyc
 * Domain Path: /languages
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


if (!defined('ABSPATH')) {
    die('are you cheating');
}

define("CYC_PLUGINS_PATH", plugin_dir_path(__FILE__));
define("CYC_PLUGINS_DIR_URL", plugin_dir_url(__FILE__));


add_action('wp_enqueue_scripts', 'cyc_custom_enqueue_assets');


// Enqueue CSS and JavaScript
function cyc_custom_enqueue_assets()
{


    // Call the function to get the filtered selected date and time
    $filtered_selected_date_time = get_filtered_selected_date_time();


    // Serialize the array to pass it to JavaScript
    $filtered_selected_date_time_json = json_encode($filtered_selected_date_time);


    wp_enqueue_style('bootstrap-min', plugin_dir_url(__FILE__) . 'assets/css/bootstrap.min.css');
    wp_enqueue_style('fontawesome-css-min', plugin_dir_url(__FILE__) . 'assets/css/fontawesome.min.css');
    wp_enqueue_style('mark-calender-style', plugin_dir_url(__FILE__) . 'assets/css/mark-your-calendar.css');
    wp_enqueue_style('jquery-ui-css', plugin_dir_url(__FILE__) . 'assets/css/jquery-ui.css');
    wp_enqueue_style('style-css', plugin_dir_url(__FILE__) . 'assets/css/style.css');



    wp_enqueue_script('bootstrap-min', plugin_dir_url(__FILE__) . 'assets/js/bootstrap.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('script-animate-js', plugin_dir_url(__FILE__) . 'assets/js/jquery-animate-number.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('mark-calender-js', plugin_dir_url(__FILE__) . 'assets/js/mark-your-calendar.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('jquery-ui-js', plugin_dir_url(__FILE__) . 'assets/js/jquery-ui.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('script-js', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), '1.0.0', true);
    wp_localize_script(
        'script-js',
        'carpet_checkout',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'filtered_selected_date_time' => $filtered_selected_date_time_json // Pass the serialized array

        )
    );
}


include_once CYC_PLUGINS_PATH . '/includes/admin/admin.php';
include_once CYC_PLUGINS_PATH . '/includes/frontend/frontend.php';

if (is_admin() && defined('DOING_AJAX') && DOING_AJAX) {
    include_once CYC_PLUGINS_PATH . '/ajax.php';
}
