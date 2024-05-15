<?php

//
// Incluir Bootstrap CSS
function bootstrap_css() {
	wp_enqueue_style( 'bootstrap_reboot',
        'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap-reboot.min.css',
        array(),
        '5.2.3'
        );
    wp_enqueue_style( 'bootstrap_grid',
        'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap-grid.min.css',
        array(),
        '5.2.3'
        );
}
add_action( 'wp_enqueue_scripts', 'bootstrap_css');


//
// Slick slider
// CSS
function slickslider_css() {
	wp_enqueue_style( 'slickslider_css',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
            array(),
            '1.8.1'
        );
    wp_enqueue_style( 'slickslidertheme_css',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css',
            array(),
            '1.8.1'
        );
}
add_action( 'wp_enqueue_scripts', 'slickslider_css');
// JS
function slickslider_js() {
	wp_enqueue_script( 'slickslider_js',
                    'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
                    array(),
                    '1.8.1',
                    true);
}
add_action( 'wp_enqueue_scripts', 'slickslider_js');


//
// ANIMATE CSS
// CSS
function animate_css() {
    wp_enqueue_style('animate_css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
}
add_action( 'wp_enqueue_scripts', 'animate_css');


//
// GRIDDER
// CSS
// function gridder_css() {
//     wp_enqueue_style('gridder_css', get_stylesheet_directory_uri().'/css/jquery.gridder.css');
// }
// add_action( 'wp_enqueue_scripts', 'gridder_css');
// // JS
// function gridder_js() {
// 	wp_enqueue_script('gridder_js', get_stylesheet_directory_uri().'/js/jquery.gridder.js', array('jquery'), '1.0.0', true);
// }
// add_action( 'wp_enqueue_scripts', 'gridder_js');


//
// Fancybox
// CSS
// function fancybox_css() {
// 	wp_enqueue_style( 'fancybox_css',
//                         get_stylesheet_directory_uri() . '/css/fancybox.css',
//                         array(),
//                         wp_get_theme()->get('Version')
//                     );
// }
// add_action( 'wp_enqueue_scripts', 'fancybox_css');
// JS
// function fancybox_js() {
// 	wp_enqueue_script( 'fancybox_js',
//                         get_stylesheet_directory_uri().'/js/fancybox.js', array('jquery'), false, true);
// }
// add_action( 'wp_enqueue_scripts', 'fancybox_js');


// jQueryUI
// 
// JS
add_action('wp_enqueue_scripts', 'jqueryui_js');
function jqueryui_js() {
    wp_enqueue_script( 'jqueryui_js',
            'https://code.jquery.com/ui/1.13.2/jquery-ui.js',
            array(),
            '1.13.2',
            true);
}
add_action( 'wp_enqueue_scripts', 'jqueryui_js');
// CSS 
function jqueryui_css() {
	wp_enqueue_style( 'jqueryui_css',
            'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css',
            array(),
            '1.13.2'
        );
}
add_action( 'wp_enqueue_scripts', 'jqueryui_css');



//
// Admin CSS
function admin_style() {
    wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/css/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

//
// Adding CSS Style Custom Theme
function custom_enqueue_styles() {
	wp_enqueue_style( 'custom-style',
                        get_stylesheet_directory_uri() . '/style.css',
                        array(),
                        // wp_get_theme()->get('Version')
                    );
    wp_enqueue_style( 'theme-style',
                        get_stylesheet_directory_uri() . '/css/main.min.css',
                        array(),
                        // '1.0.8',
                        wp_get_theme()->get('Version')
                    );
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_styles');

// Custom JS
/* Custom script with jQuery as a dependency, enqueued in the footer */
function tutsplus_enqueue_custom_js() {
    wp_enqueue_script('custom', get_stylesheet_directory_uri().'/js/main.js', array('jquery'), false, true);
}
add_action('wp_enqueue_scripts', 'tutsplus_enqueue_custom_js');