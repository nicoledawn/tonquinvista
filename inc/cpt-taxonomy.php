<?php
/**
 * Setting up Custom Post Types for Tonquin Vista.
 *
 * @package Tonquin_Vista
 */

/**  Adding custom post types */
function tonquin_vista_register_custom_post_types() {

	// Projects CPT.
	$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name' ),
		'menu_name'          => _x( 'Testimonials', 'admin menu' ),
		'name_admin_bar'     => _x( 'Testimonials', 'add new on admin bar' ),
		'add_new'            => _x( 'Add New', 'Testimonial' ),
		'add_new_item'       => __( 'Add New Testimonial' ),
		'new_item'           => __( 'New Testimonial' ),
		'edit_item'          => __( 'Edit Testimonial' ),
		'view_item'          => __( 'View Testimonial' ),
		'all_items'          => __( 'All Testimonials' ),
		'search_items'       => __( 'Search Testimonials' ),
		'parent_item_colon'  => __( 'Parent Testimonial:' ),
		'not_found'          => __( 'No Testimonials found.' ),
		'not_found_in_trash' => __( 'No Testimonials found in Trash.' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
        'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'tonquin-testimonials' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-format-quote',
	);
	register_post_type( 'tonquin-testimonials', $args );

}
add_action( 'init', 'tonquin_vista_register_custom_post_types', 0 );

/**  Register custom taxonomies for post types */
function tonquin_vista_register_taxonomies() {

	// Taxonomy for projects CPT - Project Type (Faculty and Administrative).
	$labels = array(
		'name'              => _x( 'Area', 'taxonomy general name' ),
		'singular_name'     => _x( 'Area', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Areas' ),
		'all_items'         => __( 'All Areas' ),
		'parent_item'       => __( 'Parent Area' ),
		'parent_item_colon' => __( 'Parent Area:' ),
		'edit_item'         => __( 'Edit Area' ),
		'update_item'       => __( 'Update Area' ),
		'add_new_item'      => __( 'Add New Area' ),
		'new_item_name'     => __( 'New Area' ),
		'menu_name'         => __( 'Area' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'testimonial-area' ),
	);

	register_taxonomy( 'tonquin-testimonial-area', array( 'tonquin-testimonials' ), $args );
}
add_action( 'init', 'tonquin_vista_register_taxonomies' );

/** Flushes rewrites if theme is switched */
function tonquin_vista_rewrite_flush() {
	tonquin_vista_register_custom_post_types();
	tonquin_vista_register_taxonomies();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'tonquin_vista_rewrite_flush' );