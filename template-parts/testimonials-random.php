<?php

/**
 * Template part for displaying testimonials
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FWD_Starter_Theme
 */


// Filter for cabin testimonials




if (has_term('Cabins', 'product_cat')) {
    $args = array(
        'post_type'      => 'tonquin-testimonials',
        'posts_per_page' => 1,
        'orderby'         => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'tonquin-testimonial-area',
                'field'    => 'name',
                'terms'    => 'Cabin',
            ),
        ),

    );
} else if (has_term('Experiences', 'product_cat')) {    // filter for experience testimonials
    $args = array(
        'post_type'      => 'tonquin-testimonials',
        'posts_per_page' => 1,
        'orderby'         => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'tonquin-testimonial-area',
                'field'    => 'name',
                'terms'    => 'Experience',
            ),
        ),

    );

} else { // remaining is General only
    $args = array(
        'post_type'      => 'tonquin-testimonials',
        'posts_per_page' => 1,
        'orderby'         => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'tonquin-testimonial-area',
                'field'    => 'name',
                'terms'    => 'General',
            ),
        ),

    );
} ; 

$query = new WP_Query($args);



    if ($query->have_posts()) {
?>
<article class="testimonial">
        <h4 >Guest Testimonials</h4>
        <?php

        while ($query->have_posts()) {
            $query->the_post();

            if (get_field('quote_body')) {
        ?>
                <blockquote><?php the_field('quote_body'); ?> - <cite><?php the_field('quote_author'); ?></cite></blockquote>
                
</article>
        <?php };
        };
        wp_reset_postdata();
    };







