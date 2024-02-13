<div id="service-section" style="display: block;">
    <div class="container">
        <div>
            <!-- Text on the left -->
            <h5>Our services</h5>
            <p>Price is an accurate estimate based on the standard scope of work</p>
        </div>

        <?php
        // Get all subcategories of the 'carpet' category
        $carpet_subcategories = get_terms('product_cat', array(
            'parent'     => get_term_by('slug', 'carpet', 'product_cat')->term_id,
            'hide_empty' => false,
        ));

        // Define the desired order of subcategories
        $desired_order = array('carpet-cleaning-denver', 'upholstery-cleaning-denver' , 'additional-cleaning');

        // Sort the subcategories based on the desired order
        usort($carpet_subcategories, function ($a, $b) use ($desired_order) {
            return array_search($a->slug, $desired_order) - array_search($b->slug, $desired_order);
        });

        foreach ($carpet_subcategories as $subcategory) :
        ?>
            <div class="row">
                <div class="col-12">
                    <p class="h5 mobile-category"><?php echo esc_html($subcategory->name); ?></p>
                </div>
            </div>
            <div class="row product-data-row">
                <?php
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => -1,
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    => $subcategory->term_id,
                        ),
                    ),
                );

                $loop = new WP_Query($args);

                while ($loop->have_posts()) : $loop->the_post();
                    global $product;

                    $product_id = $product->id;
                ?>
                    <div class="col-6 col-md-3 ">
                        <div class="card mb-5">
                            <?php
                            if (has_post_thumbnail()) {
                                $thumbnail_url = get_the_post_thumbnail_url($product->ID, 'medium');
                                $width = 100;  // Set your desired width
                                $height = 200; // Set your desired height
                                echo '<img src="' . esc_url($thumbnail_url) . '" class="card-img-top" alt="Product Image" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '">';
                            }

                            ?>
                            <div class="card-body product-card-item">
                                <div class="product-input-qty-options">
                                    <div class="input-group product-input-qty-row" style="display: none;">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-number product-quantity-change" data-type="minus" data-field="quant">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </span>
                                        <input type="hidden" class="carpet_single_product_info" product-id="<?php echo $product_id ?>">
                                        <input type="text" name="quant" class="form-control input-number-qty" value="0" min="0" max="999999">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-number product-quantity-change" data-type="plus" data-field="quant">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <div class="input-group d-flex justify-content-end product-plus-btn-show">
                                        <button type="button" class="btn btn-success product-quantity-change" data-type="plus" data-field="quant">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="text-center mx-auto mt-3">
                                    <p class="card-title h5 mobile-product-title"><?php the_title(); ?></p>
                                     <p class="card-price"><?php echo $product->get_price_html() . '/' . $product->get_short_description(); ?></p>

                                    <!-- Button trigger modal -->
                                    <a type="button" class="border-0 text-decoration-underline" data-bs-toggle="modal" data-bs-target="#productDetailsModal<?php echo $product_id; ?>">
                                        Details
                        </a>


                                </div>
                            </div>
                        </div>



                        <!-- Modal -->
                        <div class="modal fade" id="productDetailsModal<?php echo $product_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your dynamic content here -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                if (has_post_thumbnail()) {
                                                    $thumbnail_url = get_the_post_thumbnail_url($product->ID, 'large');
                                                    echo '<img src="' . esc_url($thumbnail_url) . '" class="img-fluid" alt="Product Image">';
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Title:</strong> <?php the_title(); ?></p>
                                                <p><strong>Price:</strong> <?php echo $product->get_price_html() . '/' . $product->get_short_description(); ?></p>
                                                <div class="product-input-qty-options mt-3">
                                                    <div class="input-group product-input-qty-row input-group product-input-qty-row-modal">
                                                        <!-- Quantity input code here -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Product description -->
                                        <div class="mt-3">
                                            <p><strong>Description:</strong></p>
                                            <?php echo wpautop($product->get_description()); ?>
                                            <div class="product-input-qty-options mt-5 product-input-qty-options-modal">
                                                <div class="input-group product-input-qty-row input-group product-input-qty-row-modal">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-danger btn-number product-quantity-change" data-type="minus" data-field="quant">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </span>
                                                    <input type="hidden" class="carpet_single_product_info" product-id="<?php echo $product_id ?>">
                                                    <input type="text" name="quant" class="form-control input-number-qty" value="0" min="0" max="999999">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-success btn-number product-quantity-change" data-type="plus" data-field="quant">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                <?php endwhile; ?>
            </div>
        <?php endforeach; ?>
        <?php wp_reset_postdata(); ?>
    </div>


</div>