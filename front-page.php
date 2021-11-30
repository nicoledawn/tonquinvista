<?php
/**
 * The template for displaying the home page
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tonquin_Vista
 */

get_header();
?>

	<main id="primary" class="site-main">
        <?php
        while( have_posts() ) :
            the_post();
            ?>

            <section id="slider-container">
                <!-- Slider main container -->
                <div class="swiper">
                <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <div class="swiper-slide">
                            <div class="slide-image">
                                <?php
                                echo wp_get_attachment_image(get_field('slider_image_1'), 'full');
                                ?>
                            </div>

                            <div class="slide-text-container">
                                <h2 class='slide-heading'><?php echo esc_html(get_field('slider_heading_1')); ?></h2>
                                <p class='slide-text'><?php echo esc_html(get_field('slider_text_1')); ?></p>
                                <a href="<?php echo esc_url(get_field('slider_btn_link_1')['url']); ?>" class='slide-button'><?php echo esc_html(get_field('slider_btn_text_1')); ?></a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="slide-image">
                                <?php
                                echo wp_get_attachment_image(get_field('slider_image_2'), 'full');
                                ?>
                            </div>

                            <div class="slide-text-container">
                                <h2 class='slide-heading'><?php echo esc_html(get_field('slider_heading_2')); ?></h2>
                                <p class='slide-text'><?php echo esc_html(get_field('slider_text_2')); ?></p>
                                <a href="<?php echo esc_url(get_field('slider_btn_link_2')['url']); ?>" class='slide-button'><?php echo esc_html(get_field('slider_btn_text_2')); ?></a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="slide-image">
                                <?php
                                echo wp_get_attachment_image(get_field('slider_image_3'), 'full');
                                ?>
                            </div>

                            <div class="slide-text-container">
                                <h2 class='slide-heading'><?php echo esc_html(get_field('slider_heading_3')); ?></h2>
                                <p class='slide-text'><?php echo esc_html(get_field('slider_text_3')); ?></p>
                                <a href="<?php echo esc_url(get_field('slider_btn_link_3')['url']); ?>" class='slide-button'><?php echo esc_html(get_field('slider_btn_text_3')); ?></a>
                            </div>
                        </div>
                    </div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>

                </div>
            </section>

            <section id="tonquin-logo">
                <?php
                $home_logo = get_field('home_logo');
                echo wp_get_attachment_image($home_logo, 'medium');
                ?>
            </section>

            <section id="home-intro">
                <?php 
                $home_intro = get_field('home_intro_text');
                ?>
                <p> <?php echo acf_esc_html($home_intro); ?> </p>
            </section>
        <div class="cabin-experience-wrapper">
            <section id="see-cabins">
                <?php 
                $cabins_group = get_field( 'see_cabins_group' );
                $see_cabins_btn = get_field( 'see_cabins_button' );
                ?>
                <h2 id="title-cabin"> <?php echo esc_html( $cabins_group['see_cabins_header'] ); ?> </h2>
                <div class="frame frame-cabin">
                <article id="see-cabin-card">
                    
                    <?php
                    echo wp_get_attachment_image( $cabins_group['see_cabins_image'], 'large', '', array("id"=>"img-cabin"));
                    ?>
                    <p> <?php echo esc_html( $cabins_group['see_cabins_text'] ); ?> </p>
                    <a id="btn-cabins" href="<?php echo esc_url( get_term_link( $see_cabins_btn ) ); ?>">See Cabins</a>                   
                </article>
                </div>
            </section>

            <section id="see-experiences">
                <?php 
                    $see_experiences = get_field('see_experiences_group');
                    ?>
                    <h2 id="title-experience"> <?php echo esc_html( $see_experiences['see_experiences_header'] ) ?> </h2>
                    <div class="frame frame-experience">
                    <article id="see-experiences-card">
                        <?php
                        echo wp_get_attachment_image( $see_experiences['see_experiences_image'], 'large', '', array("id"=>"img-experience"));
                        ?>
                        <p> <?php echo esc_html( $see_experiences['see_experiences_text'] ) ?> </p>
                        <a id="btn-experiences" href="<?php echo esc_url( $see_experiences['see_experiences_btn'] ); ?>">See Experiences</a>
                    </article>
                    </div>
            </section>
        </div>
            <section id="instagram-container">
                <?php echo do_shortcode( '[instagram-feed]' ); ?>
            </section>

            <!-- Add random testimonial template part -->
            <section id="testimonial-container">
            <?php 
            get_template_part( 'template-parts/testimonials-random', get_post_type() );
            ?>
            </section>

        
        <?php
        endwhile;
        ?>
	</main><!-- #main -->

<?php
get_footer();