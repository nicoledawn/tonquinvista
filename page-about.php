<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tonquin_Vista
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
		while ( have_posts() ) :
			the_post();

			if( function_exists( 'get_field' )) :

				echo '<div class="hero-container">';

						the_title( '<h1 class="page-title">', '</h1>' );

						$about_img = get_field( 'about_hero' );
						$size = 'full'; // (thumbnail, medium, large, full or custom size)
			
						if ( $about_img ) :
							echo '<div class="hero-image-container">';
							echo wp_get_attachment_image( $about_img, $size );
							echo '</div>';
						endif; 
				echo '</div>'; ?>

				<section class="owner-info"> 

					<?php
					$owner_img = get_field( 'owner_image' );
					$size = 'large'; // (thumbnail, medium, large, full or custom size)

					if ( $owner_img ) :
						echo wp_get_attachment_image( $owner_img, $size );
					endif; 
			
					if ( get_field('about_owners') ) : ?>
						
						<p><?php the_field( 'about_owners' ); ?> </p> 
						<?php 
					endif; ?>
				</section>

				<!-- Info Tabs -->
				<div id="explore-experiences" class="about">

					<ul id="nav-tab" class="nav-tab-ul">
						<li class="active"><a href="#gettinghere">Getting Here</a></li>
						<li><a href="#contactinfo">Hours & Address</a></li>
						<li><a href="#localweather">Local Weather</a></li>
					</ul>
				
					<div id="tab-content">
						<section class='tab-pane active' id="gettinghere">
							<?php

							if ( get_field('map_title') ) : ?>
								
								<h2><?php the_field( 'map_title' ); ?> </h2> 
								<?php 
							endif; 

							$location = get_field('main_office_map');
							if( $location ): ?>
			
								<div class="acf-map" data-zoom="16">
									<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
							
									<p class="address"><?php echo $location['address']; ?></p>
									</div>
								</div>

								<?php
							endif; ?>
						</section>

						<section class='tab-pane' id="contactinfo">
			
							<?php if( have_rows('address', 125) ): ?>
								<?php while( have_rows('address', 125) ): the_row(); 
		
									// Get sub field values.
									$addressline1 = get_sub_field('street_address');
									$addressline2 = get_sub_field('address_details');
									$phone = get_sub_field('phone_number'); ?>
		
									<div id="contact-address">
										<p><?php echo $addressline1 ?><br/>
										<?php echo $addressline2 ?><br/>
										<?php echo $phone ?></p>
										<?php
										if ( get_field('hours') ) : ?>
										
											<p><?php the_field( 'hours' ); ?> </p> 
											<?php 
										endif; ?>
									</div>
								<?php endwhile;
							 	endif;

							if ( get_field('contact_page_link') ) : ?>
								
								<a class="button" href="<?php the_field( 'contact_page_link' ); ?>">Visit our Contact Page</a>
								<?php 
							endif; ?>
						</section>

						<section class='tab-pane' id="localweather">

							<?php		
							if ( get_field('weather_heading') ) : ?>
								
								<h2><?php the_field( 'weather_heading' ); ?> </h2> 
								<?php 
							endif; 

							// Weather Atlas Widget shortcode
							echo do_shortcode( '[shortcode-weather-atlas city_selector=325344 layout="horizontal" background_color="#637368" daily=5 unit_c_f="c"]' ); ?>
						</section>	
					</div>
				</div>	
				<?php
			endif;
		endwhile; ?>

</main><!-- #main -->

<?php
get_footer();