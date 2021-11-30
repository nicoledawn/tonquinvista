<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tonquin_Vista
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<!-- <div class="mobile-menu-bg" id="mobile-menu-bg">
<div class="toggle-container">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"></button>
</div>
</div> -->
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'tonquin-vista' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<div class="site-name-container">
					<h1 class="site-title "><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				</div>
				<?php
			else :
				?>
				<div class="site-name-container">
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				</div>
				<?php
			endif;
			$tonquin_vista_description = get_bloginfo( 'description', 'display' );
			if ( $tonquin_vista_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $tonquin_vista_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<div class="toggle-container">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="screen-reader-text"><?php esc_html_e( 'Primary Menu', 'tonquin-vista' ); ?></span>
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" id='open-icon'>
						<path d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/>
					</svg>
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 30 30" id='close-icon'>
						<path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"/>
					</svg>
				</button>
			</div>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			// THIS CODE WILL ADD A WOOCOMMERCE CART TO THE HEADER WITH $VALUE | ITEMS IN CART

			// if ( function_exists( 'tonquin_vista_woocommerce_header_cart' ) ) {
			// 	tonquin_vista_woocommerce_header_cart();
			// }
			?>
		</nav><!-- #site-navigation -->
			<?php
				
			?>
	</header><!-- #masthead -->
