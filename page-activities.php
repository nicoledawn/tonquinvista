<?php
/**
 * The template for displaying the activities page.
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
                // Div for overlay purposes
                ?>
                <div class="hero-container">
                    <?php
                    // page from ACF
                    $activities_title = get_field( 'activities_title' );
                    if ( $activities_title ) :
                        ?>
                        <h1 class='entry-title'><?php echo esc_html( $activities_title ); ?></h1>
                        <?php
                    endif;

                    // Hero banner from ACF
                    $activities_hero = get_field( 'activities_hero' );
                    if ( $activities_hero ) :
                        ?>
                        <div class="hero-image-container">
                            <?php
                            echo wp_get_attachment_image( $activities_hero, 'full' );
                            ?>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
                <?php
                    
                // Activities Intro (head) Text from ACF
                $activities_text = get_field( 'activities_text' );
                if ( $activities_text ) :
                    ?>
                    <section class="activities-text">
                        <p> <?php echo acf_esc_html( $activities_text ); ?> </p>
                    </section>
                    <?php
                endif;
                ?>

                <!-- Style for tabs added to sass/components/navigation/_navigation.scss -->
                <section id="explore-experiences">
                    <ul id="nav-tab" class="nav-tab-ul">
                        <li><a href="#experiences" class="active">Experience</a></li>
                        <li><a href="#explore">Explore</a></li>
                    </ul>

                    <div id="tab-content">
                        <section class='tab-pane active' id="experiences">
                            <?php
                            // Intro text for Experience section
                            $experiences_group = get_field( 'experience_group' );
                            if ( $experiences_group ) :
                                ?>
                                <section class="experience-intro">
                                    <p> <?php echo acf_esc_html( $experiences_group['experience_intro'] ); ?> </p>
                                </section>
                                <?php
                            endif;

                            // Gift Card Button
                            if ( $experiences_group['gift_card_btn_text'] ) :
                                ?>
                                <a href="#gift-card-section" class='gift-card-btn'><?php echo esc_html( $experiences_group['gift_card_btn_text'] ); ?></a>
                                <?php
                            endif;
                            ?>

                            
                            <?php
                            // Testimonials card - article tag already in template part
                            get_template_part('template-parts/testimonials-random', get_post_type());
                            ?>
                            

                            <?php 
                            // Single Experiences pulled into experiences tab
                            $args = array( 
                                'post_type'      => 'product', 
                                'posts_per_page' => '-1',
                                'product_cat'    => 'experiences', 
                                'orderby'        => 'title',
                            );

                            $query = new WP_Query( $args );
                            ?>
                            <div class="card-container">
                            <?php
                            while ( $query->have_posts() ) : 
                                $query->the_post();
                                ?>
                                <section class="experience-card-content">
                                    <div class="card-top">
                                        <h3> <?php echo get_the_title(); ?> </h3>
                                        <div class="card-image">
                                        <?php                                
                                        the_post_thumbnail('large');  
                                        ?>
                                        </div>
                                    </div>
                                    <div class="experience-text-container">
                                        <?php
                                        the_content();
                                        ?>
                                    </div>
                                    <a href="<?php echo get_permalink() ?>" id='experience-book-btn'>Book Now</a>
                                </section>
                                <?php
                            endwhile;
                            wp_reset_postdata(); 
                            ?>
                            </div>
                            <?php
                            
                            // Gift card Header and intro text
                            ?>
                            <section class="gift-card-section" id='gift-card-section'>
                                <h2><?php echo esc_html( $experiences_group['gift_card_header'] ); ?></h2>

                                <p><?php echo acf_esc_html( $experiences_group['gift_card_text'] ); ?></p>
                                
                                <?php
                                // Output all gift card products
                                $gift_args = array( 
                                    'post_type'      => 'product', 
                                    'posts_per_page' => '-1',
                                    'product_cat'    => 'gift-cards', 
                                    'orderby'        => 'title',
                                );

                                $gift_query = new WP_Query( $gift_args );
                                ?>
                                <div class="card-container">
                                <?php
                                while ( $gift_query->have_posts() ) : 
                                    $gift_query->the_post();
                                    ?>
                                    <section class="gift-card-content">
                                        <div class="card-top">
                                            <h3 id='gift-card-title'> <?php echo get_the_title(); ?> </h3>
                                            <div class="card-image">
                                                <?php
                                                the_post_thumbnail('large');  
                                                ?>
                                            </div>
                                        
                                            <a href="<?php echo get_permalink() ?>" id='gift-card-purchase'>Purchase</a>
                                        </div>
                                    </section>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                                </div>
                            </section>
                        </section>

                        <section class='tab-pane' id="explore">
                            <?php 
                            // Explore items - Local Vendors and Tourism in the Area
                            $explore_group = get_field( 'explore_group' );
                            
                            if ( $explore_group ) :
                                ?>
                                <section class="explore-intro">
                                    <p> <?php echo acf_esc_html( $explore_group['explore_intro'] ); ?> </p>
                                </section>

                                <h2> <?php echo esc_html( $explore_group['vendors_title'] ); ?> </h2>
                                
                                <div class="all-vendor-cards">
                                    <?php
                                    //Repeater for local vendors 
                                    if ( have_rows( 'explore_group' ) ) :
                                        while ( have_rows( 'explore_group' ) ) :
                                            the_row();
                                            if ( have_rows( 'local_vendors' ) ) :
                                                while ( have_rows( 'local_vendors' ) ) : 
                                                    the_row();
                                                    ?>
                                                    <article class="vendor-container">
                                                        <h3> <?php the_sub_field('vendor_name'); ?> </h3>

                                                        <a href="<?php echo esc_url( get_sub_field('vendor_url')); ?>" target='_blank'>
                                                            <?php
                                                            echo wp_get_attachment_image( get_sub_field( 'vendor_logo' ), 'medium');
                                                            ?>
                                                        </a>

                                                        <a href="<?php echo esc_url( get_sub_field('vendor_url')); ?>" class="explore-button" target='_blank'><?php echo esc_html($explore_group['vendors_btn_text']) ?></a>

                                                        <div class="explore-text-container">
                                                            <p> <?php the_sub_field('vendor_description') ?> </p>
                                                        </div>
                                                    </article>
                                                    <div class="separator"></div>
                                                    <?php
                                                endwhile;
                                            endif;
                                        endwhile;
                                    endif;  
                                    ?>
                                </div>

                                <h2 id='tourism-heading'><?php echo esc_html( $explore_group['tourism_title'] ); ?></h2>
                                <div class="all-tourism-cards">
                                    <?php
                                    //Repeater for Tourism Group
                                    if ( have_rows( 'explore_group' ) ) :
                                        while ( have_rows( 'explore_group' ) ) :
                                            the_row();
                                            if ( have_rows( 'tourism' ) ) :
                                                while ( have_rows( 'tourism' ) ) : 
                                                    the_row();
                                                    ?>
                                                    <article class="tourism-container">
                                                        <h3> <?php esc_html( the_sub_field( 'tourism_name' ) ); ?> </h3>

                                                        <a href="<?php echo esc_url( get_sub_field('tourism_url')); ?>" target='_blank'>
                                                            <?php
                                                            echo wp_get_attachment_image( get_sub_field( 'tourism_logo' ), 'medium');
                                                            ?>
                                                        </a>

                                                        <a href="<?php echo esc_url( get_sub_field('tourism_url')); ?>" class="explore-button" target='_blank'><?php echo esc_html($explore_group['tourism_btn_text']) ?></a>

                                                        <div class="explore-text-container">
                                                            <p> <?php esc_html( the_sub_field('tourism_description') ) ?> </p>
                                                        </div>
                                                    </article>
                                                    <div class="separator"></div>
                                                    <?php
                                                endwhile;
                                            endif;
                                        endwhile;
                                    endif; 
                                ?>
                                </div>
                                <?php
                            endif;
                            ?>
                        </section>
                    </div>
                </section>
                
                <?php 
            endif;
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
