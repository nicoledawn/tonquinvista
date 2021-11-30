<?php

/**
 * Display category image and title as a Hero section on category archive
 */
add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {


    if ( is_product_category('cabins') ){

        add_filter( 'get_the_archive_title', function ($title) {
            if ( is_tax() ) {
                $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
            } 
            return $title;
            });
       
	    global $wp_query;
	    $cat = $wp_query->get_queried_object();
	    $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );

        echo '<div class="hero-container">';
        the_archive_title( '<h1 class="page-title">', '</h1>' );
            if ( $thumbnail_id ) {
                echo '<div class="hero-image-container">';
                echo wp_get_attachment_image( $thumbnail_id, $size = 'full');
                echo '</div>';
            }
        echo '</div>';
	}
}       

// Add map to the Cabins Product Category Page

add_action( 'woocommerce_after_main_content', 'add_map' );
function add_map() {
    if ( is_product_category('cabins') )        {
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'posts_per_page'        => -1,
            'tax_query'             => array(
                array(
                    'taxonomy'      => 'product_cat',
                    'field' => 'term_id', 
                    'terms'         => 24,
                    'operator'      => 'IN',
                ),
            )
        );
        $products = new WP_Query($args);

        echo "<div class='map-container'><div class='wrap'><div class='acf-map'>";

        while ( $products->have_posts() ) : $products->the_post();

            $location = get_field('single_cabin_location');
            $title = get_the_title(); // Get the title
                if( !empty($location) ) {
                ?>
                    <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
                            <div class="marker-modals">
                                <h4><a href="<?php the_permalink(); ?>" rel="bookmark"> <?php the_title(); ?></a></h4>
                        
                                <p class="address"><?php echo $location['address']; ?></p>
                            </div>
                    </div>
                <?php
                }
        endwhile;

        echo '</div></div></div>';
        wp_reset_postdata();
    }
}

/**
 * Remove product count
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );


/**
 * Remove product sorting dropdown
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/**
 * Cabin order on archive 
 */
add_filter('woocommerce_get_catalog_ordering_args', 'woocommerce_catalog_orderby');
function woocommerce_catalog_orderby( $args ) {
    if( is_product_category( 'cabins' ) ) { 
        $args['orderby']  = 'title';
        $args['order']    = 'ASC';
    }
    return $args;
}
add_action( 'woocommerce_after_shop_loop_item_title', 'custom_field_display_below_title', 2 );

/**
 * Remove breadcrumbs on Cabin archive page
 */
add_filter( 'woocommerce_before_main_content', 'remove_breadcrumbs');
function remove_breadcrumbs() {
    if( is_product_category( 'cabins' ) || is_shop()) {
        remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
    }
}


/**
 * Get ACFS for Cabin archive page
 */
function custom_field_display_below_title(){
    if( is_product_category( 'cabins' ) ) {
        global $product;

        // Display ACF text
        if( $beds = get_field( 'number_of_bedrooms', $product->get_id() ) ) {
            echo '<p>Bedrooms: ' . $beds . '</p>';
        }

        if( $baths = get_field( 'number_of_bathrooms', $product->get_id() ) ) {
            echo '<p>Bathrooms: ' . $baths . '</p>';
        }

        if( $sleeps = get_field( 'sleeps_max', $product->get_id() ) ) {
            echo '<p>Sleeps: ' . $sleeps . '</p>';
        }
    }
}