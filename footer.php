<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tonquin_Vista
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="footer-menus">
			<nav id="social-nav" class="social-nav">
				<?php wp_nav_menu( array('theme_location' => 'social') ); ?>
			</nav>

			<section class="newsletter">
			<?php $form_widget = new \MailPoet\Form\Widget();
			echo $form_widget->widget(array('form' => 0, 'form_type' => 'php')); ?>
			</section>
			<nav id="footer-nav" class="footer-nav">
				<?php wp_nav_menu( array('theme_location' => 'footer') ); ?>
			</nav>
		</div>
		<div class="site-info">
			<span class="sep">&copy; 2021 Tonquin Vista Cabins | All rights reserved</span>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
