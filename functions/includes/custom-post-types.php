<?php
// Custom Post Type 

    // creating (registering) the custom type 
    register_post_type( 'artista', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
    // let's now add all the options for this post type
    array('labels' => array(
    'name' => __('Artistas', 'customtheme'), /* This is the Title of the Group */
    'singular_name' => __('Artista', 'customtheme'), /* This is the individual type */
    'all_items' => __('Artistas', 'customtheme'), /* the all items menu item */
    'add_new' => __('Añadir nuevo', 'customtheme'), /* The add new menu item */
    'add_new_item' => __('Añadir nuevo', 'customtheme'), /* Add New Display Title */
    'edit' => __( 'Editar', 'customtheme' ), /* Edit Dialog */
    'edit_item' => __('Editar', 'customtheme'), /* Edit Display Title */
    'new_item' => __('Añadir nuevo', 'customtheme'), /* New Display Title */
    'view_item' => __('Ver', 'customtheme'), /* View Display Title */
    'search_items' => __('Buscar', 'customtheme'), /* Search Custom Type Title */ 
    'not_found' =>  __('No se encontró ningún registro.', 'customtheme'), /* This displays if there are no entries yet */ 
    'not_found_in_trash' => __('No se encontró ningún registro.', 'customtheme'), /* This displays if there is nothing in the trash */
    'parent_item_colon' => ''
    ), /* end of arrays */
    'description' => __( 'Artistas', 'customtheme' ), /* Custom Type Description */
    'public' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'show_ui' => true,
    'query_var' => true,
    'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */ 
    'menu_icon' => 'dashicons-groups', /* the icon for the custom post type menu */
    'rewrite'	=> array( 'slug' => 'artist', 'with_front' => false ), /* you can specify its url slug */
    'has_archive' => false, /* you can rename the slug here */
    'capability_type' => 'page',
    'hierarchical' => false,
    'show_in_rest' => true,
    /* the next one is important, it tells what's enabled in the post editor */
    'supports' => array( 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions', 'page-attributes' ),
    // 'taxonomies' => array( 'category', 'post_tag' ),
    'taxonomies' => array()
    ) /* end of options */
    ); /* end of register post type */	


?>