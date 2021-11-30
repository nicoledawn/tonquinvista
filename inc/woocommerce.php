<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Tonquin_Vista
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function tonquin_vista_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 200,
			'gallery_thumbnail_image_width' => 200,
			'single_image_width'    => 1920,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'tonquin_vista_woocommerce_setup' );


//  Woocommerce single image size 

add_filter( 'woocommerce_get_image_size_single', function( $size ) {
	return array(
	'width' => 1920,
	'height' => 1250,
	'crop' => 1,
	);
	} );
/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function tonquin_vista_woocommerce_scripts() {
	wp_enqueue_style( 'tonquin-vista-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'tonquin-vista-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'tonquin_vista_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function tonquin_vista_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'tonquin_vista_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function tonquin_vista_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'tonquin_vista_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'tonquin_vista_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function tonquin_vista_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'tonquin_vista_woocommerce_wrapper_before' );

if ( ! function_exists( 'tonquin_vista_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function tonquin_vista_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'tonquin_vista_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'tonquin_vista_woocommerce_header_cart' ) ) {
			tonquin_vista_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'tonquin_vista_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function tonquin_vista_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		tonquin_vista_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'tonquin_vista_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'tonquin_vista_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function tonquin_vista_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'tonquin-vista' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'tonquin-vista' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'tonquin_vista_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function tonquin_vista_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php tonquin_vista_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

// ** Single Product Information Organisation

remove_action(
	'woocommerce_single_product_summary', 
	'woocommerce_template_single_title', 
	5
);

remove_action(
	'woocommerce_single_product_summary', 
	'woocommerce_template_single_price', 
	10
);

add_action(
	'woocommerce_before_single_product_summary', 
	'woocommerce_template_single_title', 
	5
);

add_action(
	'woocommerce_single_product_summary', 
	'woocommerce_output_product_data_tabs', 
	20
);

remove_action(
	'woocommerce_after_single_product_summary', 
	'woocommerce_output_product_data_tabs', 
	10
);

remove_action(
	'woocommerce_single_product_summary', 
	'woocommerce_template_single_meta', 
	40
);

remove_action(
	'woocommerce_after_single_product_summary', 
	'woocommerce_output_related_products', 
	20
);

// remove the woocommerce sidebar

remove_action( 
	'woocommerce_sidebar', 
	'woocommerce_get_sidebar', 
	10 ); 

// Remove the WooCommerce reviews tab

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['reviews'] )	;		// Remove the reviews tab
	unset( $tabs['accommodation_booking_time'] ); //remove check in/out times tab
    return $tabs;
}

// randomly generated cabin testimonial

add_action('woocommerce_after_single_product_summary', 'testimonials', 9);

function testimonials() {

	get_template_part( 'template-parts/testimonials', 'random' );	

		
};

//  check availability button on product page that scrolls you to the availability calendar
add_action('woocommerce_single_product_summary', 'check_availability_btn', 5);

function check_availability_btn() {
	if (has_term('Cabins', 'product_cat') || has_term('Experiences', 'product_cat')) {
?>
		<button class="button" onClick= "document.getElementById('wc-bookings-booking-form').scrollIntoView().stopPropogation();">Check Availability</button>
		<?php
	} else {
		return;
	}
		
};

// Add custom tab content for amenities and rates tabs

add_action('woocommerce_single_product_summary', 'woocommerce_custom_tabs', 20);

function woocommerce_custom_tabs() {

	/** Requiring file that has custom tab content for the cabin pages */
	get_template_part( 'template-parts/cabin', 'tabs' );
		
};

//Links to cabin and experience pages

add_action('woocommerce_after_single_product_summary', 'see_all_cabins_experiences_btn', 10);

function see_all_cabins_experiences_btn() {
	$more_cabins_btn = get_field('more_cabins_button');
	$activities_btn = get_field('see_activities');

	?>
<section class="product-page-links">
	<?php

	if($more_cabins_btn) {
		?><a class="button" href="<?php echo esc_url(get_term_link($more_cabins_btn)); ?>">See Our <?php echo esc_html($more_cabins_btn->name);?></a>
<?php
	} else {
		return;
	};

	if($activities_btn) {
		?><a class="button" href="<?php echo esc_url($activities_btn); ?>">See Activities</a>
<?php
	} else {
		return;
	};

?>
</section>
<?php
};


// removes all woocommerce breadcrumbs
add_action( 'init', 'woo_remove_wc_breadcrumbs' );
function woo_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

