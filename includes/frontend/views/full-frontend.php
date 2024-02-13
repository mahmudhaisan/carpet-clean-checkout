    <!-- Header Bar -->
    <div class="container-fluid bg-dark">
        <div class="row  text-white pt-3 pb-3 mx-5">
            <div class="col">
                <!-- Your site logo or other content goes here -->
            </div>
            <div class="col d-flex justify-content-end"> <!-- Add ml-auto class here -->
                <?php
                // Get the cart URL
                $cart_url = wc_get_cart_url();

                // Get the cart count
                $cart_count = WC()->cart->get_cart_contents_count();
                
                ?>
                <div class="cart-icon">
                    <span> <?php echo get_woocommerce_currency_symbol(); ?></span>
                    <span class="cart-count"><?php echo esc_html($cart_count); ?></span>
                    <i class="fas fa-shopping-cart fa-lg"></i>

                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid pt-3 bg-light">

        <div class="row">
            <!-- Left Side - 3 Columns -->
            <div class="col-md-3 d-none d-md-block">

                <div class="container mx-3 p-3">


                   	<p class="contact-info">
                    	 <strong>Phone:</strong> <a href="tel:+19703682626" class="text-decoration-none">+1 970-368-2626</a>
					</p>
                   
					
					<p class="contact-info">
               			 <strong>Email:</strong> <a href="mailto:carpet.couch.clean@gmail.com" class="text-decoration-none">carpet.couch.clean@gmail.com</a>
            		</p>
					
                    <p><strong>Hours</strong></p>
                    <!-- Days and Hours Table -->
                    <table class="table">

                        <tbody>
                            <tr>
                                <td>Monday</td>
                                <td>8:00am - 8:00pm</td>
                            </tr>
                            <tr>
                                <td>Tuesday</td>
                                <td>8:00am - 8:00pm</td>
                            </tr>
                            <tr>
                                <td>Wednesday</td>
                               	<td>8:00am - 8:00pm</td>
                            </tr>
                            <tr>
                                <td>Thursday</td>
                                <td>8:00am - 8:00pm</td>
                            </tr>
                            <tr>
                                <td>Friday</td>
                                <td>8:00am - 8:00pm</td>
                            </tr>
                            <tr>
                                <td>Saturday</td>
                                <td>8:00am - 8:00pm</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Right Side - 9 Columns -->
            <div class="col-md-9 booking-right-part">


                <div class="service-success-row" style="display: none;">
                    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 300px; padding: 40px; border: 1px solid #ccc; border-radius: 10px; background-color: #f8f9fa;">
                        <h3>Successfully Booking Completed. We will inform you soon</h3>

                        <!-- Reload Link -->
                        <a href="" class="btn btn-primary text-white mt-3 reload-link">Reload Page</a>
                    </div>
                </div>



                <div class="service-booking-row">




                    <?php

                    require CYC_PLUGINS_PATH . '/includes/frontend/views/service-section.php';
                    require CYC_PLUGINS_PATH . '/includes/frontend/views/schedule-section.php';
                    require CYC_PLUGINS_PATH . '/includes/frontend/views/confirm-section.php';

                    // Specify the path to your icon file within the plugin
                    $left_arrow_path = CYC_PLUGINS_DIR_URL .  'assets/icons/left.svg';
                    $right_arrow_path = CYC_PLUGINS_DIR_URL .  'assets/icons/right.svg';

                    ?>







                    <!-- Sticky bar at the bottom pc-->
                    <div class="bg-dark text-white p-3 d-none d-md-block checkout-footer-sticky mt-5" id="big-screen-footer-nav" style="display: none;">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <!-- Left: Image Logo -->
                                <div class="col-2">
                                    <?php
                                    $custom_logo_id = get_theme_mod('custom_logo');
                                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

                                    if ($logo) {
                                        echo '<img src="' . esc_url($logo[0]) . '" alt="Logo" class="img-fluid">';
                                    }
                                    ?>
                                </div>


                                <!-- Middle: Buttons -->
                                <div class="col-8 text-center">
                                    <button type="button" class="btn btn-outline-light bg-transparent border-0" id="product-checkout-first-section">Service</button>
                                    <span class="mx-2">&gt;</span>

                                    <button type="button" class="btn btn-outline-light bg-transparent border-0" id="product-checkout-second-section" disabled>Schedule</button>
                                    <span class="mx-2">&gt;</span>
                                    <button type="button" class="btn btn-outline-light bg-transparent border-0" id="product-checkout-third-section" disabled>Confirm</button>

                                </div>

                                <!-- Right: Next Button -->
                                <div class="col-2 text-end">
                                    <div class="next-btn-area">
                                        <button type="button" class="btn btn-light service-next-btn" disabled>Next</button>
                                        <button type="button" class="btn btn-light schedule-next-btn" disabled style="display: none;">Next</button>
                                        <button type="button" class="btn btn-light booking-confirm-btn" disabled style="display: none;">Confirm</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <!-- Mobile -->
                    <div class="bg-dark checkout-footer-sticky p-3 d-block d-md-none">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-white left-progress">
                                    0% progress
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex justify-content-end">
                                    <div class="p-2 bd-highlight text-white">


                                        <div id="service-btn-part-mobile">
                                            <button type="button" class="btn btn-success rounded-0" id="mobile-service-right-btn" disabled>
                                                <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>


                                        <div id="schedule-btn-part-mobile" style="display: none;">
                                            <button type="button" class="btn btn-success rounded-0" id="mobile-schedule-prev">
                                                <i class="fas fa-arrow-left"></i>
                                            </button>
                                            <button type="button" class="btn btn-success rounded-0" id="mobile-schedule-next" disabled>
                                                <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>


                                        <div id="confirm-btn-part-mobile" style="display: none;">
                                            <button type="button" class="btn btn-success rounded-0" id="mobile-confirm-prev">
                                                <i class="fas fa-arrow-left"></i>
                                            </button>
                                            <button type="button" class="btn btn-success booking-confirm-btn rounded-0" id="mobile-confirm-next" disabled>
                                                Book
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
