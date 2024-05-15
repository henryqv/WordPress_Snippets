<?php

/**
** Gutenberg add_theme_support
**/

add_theme_support( 'editor-color-palette', array(
    array(
        'name'  => esc_attr__( 'black', 'base_theme' ),
        'slug'  => 'black',
        'color' => '#444444',
    ),
    array(
        'name'  => esc_attr__( 'white', 'base_theme' ),
        'slug'  => 'white',
        'color' => '#ffffff',
    ),
    array(
        'name'  => esc_attr__( 'lightsteel', 'base_theme' ),
        'slug'  => 'lightsteel',
        'color' => '#DCE2E8',
    ),
    array(
        'name'  => esc_attr__( 'steel', 'base_theme' ),
        'slug'  => 'steel',
        'color' => '#9EACBB',
    ),
    array(
        'name'  => esc_attr__( 'darkgray', 'base_theme' ),
        'slug'  => 'lightgray',
        'color' => '#C7C7C7',
    ),
    array(
        'name'  => esc_attr__( 'darkgray', 'base_theme' ),
        'slug'  => 'darkgray',
        'color' => '#667585',
    ),
) );


// Disable custom colors
add_theme_support( 'disable-custom-colors' );

// Default block styles
add_theme_support( 'wp-block-styles' );

// Wide Alignment
add_theme_support( 'align-wide' );

// Custom units
add_theme_support( 'custom-units', 'rem', 'em', 'px' );

// Appearance Tools
add_theme_support( 'appearance-tools' );

add_theme_support( 'border' );

add_theme_support( 'link-color' );

add_theme_support( 'block-template-parts' );

// Font sizes
add_theme_support( 'editor-font-sizes', array(
    array(
        'name' => esc_attr__( 'Small', 'base_theme' ),
        'size' => 11,
        'slug' => 'small'
    ),
    array(
        'name' => esc_attr__( 'Regular', 'base_theme' ),
        'size' => 14,
        'slug' => 'regular'
    ),
    array(
        'name' => esc_attr__( 'Large', 'base_theme' ),
        'size' => 30,
        'slug' => 'large'
    ),
    array(
        'name' => esc_attr__( 'Huge', 'base_theme' ),
        'size' => 45,
        'slug' => 'huge'
    )
) );



// Enqueue block editor style
function mm_block_editor_styles() {
    // Editor styles.
    wp_enqueue_style( 'mm-block-editor-styles', get_theme_file_uri( '/css/style-editor.css' ), false, '1.0', 'all' );
}

add_action( 'enqueue_block_editor_assets', 'mm_block_editor_styles' );

//
// Menus
function mis_menus() {
	register_nav_menus (
		array(
			'menu_principal' => ( 'Menú principal' ),
            'menu_tienda' => ( 'Menú Tienda' ),
            'menu_footer' => ( 'Menú Footer' ),
            'menu_legal' => ( 'Menú Legal' ),
		)
	);
}
add_action('init', 'mis_menus');


//
// post formats
add_theme_support( 'post-formats', array( 'aside', 'quote', 'status', 'image', 'gallery', 'chat', 'link', 'audio', 'video' ) );
// add post-formats to post_type 'post'
add_post_type_support( 'post', 'post-formats' );

//
// thumbnails
if ( function_exists( 'add_theme_support' ) )
add_theme_support( 'post-thumbnails' );

//
//excerpt
add_post_type_support('page', 'excerpt');

//
// limitar excerpt
function excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

//
// paginado noticias
function pagination_bar( $custom_query ) {

    $total_pages = $custom_query->max_num_pages;
    $big = 999999999; // need an unlikely integer

    if ($total_pages > 1){
        $current_page = max(1, get_query_var('paged'));

        echo paginate_links(array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => $current_page,
            'total' => $total_pages,
        ));
    }
}

//
// Custom logo
function themename_custom_logo_setup() {
    $defaults = array(
    'height'      => 37,
    'width'       => 133,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array( 'site-title', 'site-description' ),
);
add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'themename_custom_logo_setup' );



//
// Option page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Configuración Web',
		'menu_title'	=> 'Configuración Web',
		'menu_slug' 	=> 'general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	// acf_add_options_page(array(
	// 	'page_title' 	=> 'Megamenú',
	// 	'menu_title'	=> 'Megamenú',
	// 	'menu_slug' 	=> 'megamenu',
	// 	'capability'	=> 'edit_posts',
	// 	'redirect'		=> false
	// ));
	
}

//
//Mensaje de error en login
function login_errors_message() {
    return 'Ooooops!';
}
add_filter('login_errors', 'login_errors_message');


//
//sidebar
function sidebar(){
    register_sidebar(
        array(
            'name'          => __( 'Footer 1', 'customtheme' ),
            'id'            => 'footer_1',
            'before_widget' => '<div class="footer_1">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>',
        ),
        array(
            'name'          => __( 'Footer 2', 'customtheme' ),
            'id'            => 'footer_2',
            'before_widget' => '<div class="footer_2">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>',
        ),
        array(
            'name'          => __( 'Footer 3', 'customtheme' ),
            'id'            => 'footer_3',
            'before_widget' => '<div class="footer_3">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>',
        ),
        array(
            'name'          => __( 'Footer 4', 'customtheme' ),
            'id'            => 'footer_4',
            'before_widget' => '<div class="footer_4">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>',
        )
    );
}
add_action('init','sidebar');


//
// Logo login 
function my_login_logo() { ?>
    <?php 
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $custom_logo_id , 'medium' );
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo $image[0]; ?>);
            height: 70px;
            width: 232px;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
<?php }
//end my_login_logo()
add_action( 'login_enqueue_scripts', 'my_login_logo' );
function my_login_logo_url() {
    return home_url();
}//end my_login_logo_url()
add_filter( 'login_headerurl', 'my_login_logo_url' );
function my_login_logo_url_title() {
    return get_option('blogname');
}//end my_login_logo_url_title()
add_filter( 'login_headertitle', 'my_login_logo_url_title' );


// Desactivar enlaces a adjuntos 
function cleanup_attachment_link( $link ) {
    return;
}
add_filter( 'attachment_link', 'cleanup_attachment_link' );


//widgets_footer
function widgets_footer(){
    register_sidebar(
        array(
            'name'          => __( 'Footer 1', 'base_theme' ),
            'id'            => 'footer_1',
            'before_widget' => '<div class="footer_1">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        )
    );
    register_sidebar(
        array(
            'name'          => __( 'Footer 2', 'base_theme' ),
            'id'            => 'footer_2',
            'before_widget' => '<div class="footer_2">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        )
    );
    register_sidebar(
        array(
            'name'          => __( 'Footer 3', 'base_theme' ),
            'id'            => 'footer_3',
            'before_widget' => '<div class="footer_3">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        )
    );
    register_sidebar(
        array(
            'name'          => __( 'Footer 4', 'base_theme' ),
            'id'            => 'footer_4',
            'before_widget' => '<div class="footer_4">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        )
    );
    register_sidebar(
        array(
            'name'          => __( 'Footer 5', 'base_theme' ),
            'id'            => 'footer_5',
            'before_widget' => '<div class="footer_5">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        )
    );
    register_sidebar(
        array(
            'name'          => __( 'Footer 6', 'base_theme' ),
            'id'            => 'footer_6',
            'before_widget' => '<div class="footer_6">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        )
    );
}
add_action('init','widgets_footer');


//
// Custom post types
require_once( __DIR__ . '/includes/custom-post-types.php');

//
// Developer
require_once( __DIR__ . '/includes/developer.php');

//
// Security
require_once( __DIR__ . '/includes/security.php');

//
// WooCommerce 
require_once( __DIR__ . '/includes/woocommerce.php');

//
// Libraries
require_once( __DIR__ . '/includes/libraries.php');

//
// Gutenberg Blocks
// require_once( __DIR__ . '/includes/blocks.php');

//
// Requireds para no sobrecargar el functions
require_once( __DIR__ . '/includes/more-functions.php');
