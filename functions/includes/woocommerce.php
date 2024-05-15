<?php 
//
// Woocommerce support
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


// lightbox woocommerce
add_theme_support( 'wc-product-gallery-zoom' );
// add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

//
//


//
//
//WOOCOMMERCE HOOKS
// change order of description
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );

// Remove related products output
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

// Añadir descripción corta en página de tienda
// add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_single_excerpt', 5);

// limitar a 20 palabras
add_filter('woocommerce_short_description', 'limit_product_short_description', 10, 1);
function limit_product_short_description($post_excerpt)
{
	//error_log("Test log");
    if (!is_product())
    {
        $pieces = explode(" ", $post_excerpt);
        $post_excerpt = implode(" ", array_splice($pieces, 0, 25)); // en esta línea se limita a 25
    }
    return $post_excerpt.''; // entre las comillas se pueden poner puntos suspensivos
}

//
// Ocultar Descargas
// add_filter( 'woocommerce_account_menu_items', 'ocultar_descargas', 999 );
// function ocultar_descargas( $items ) {
// unset($items['downloads']);
// return $items;
// }

//
// Cambiar Tienda a 3 columnas
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
    function loop_columns() {
        return 3; // Indicar aquí el número de columnas que queremos. En este caso se mostrarían 3
    }
}

//
// Contenido adicional en  single product
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_custom_content', 70 );
function woocommerce_template_custom_content(){
    // echo 'test';
    // include("template-parts/addcontent-product.php"); 
    // include("/template-parts/social-share.php");
    include( get_template_directory() . '/template-parts/social-share.php' ); 
}


add_action( 'woocommerce_payment_complete', 'execute_post_payment_functions', 10 );
function execute_post_payment_functions( $order_id ){

}


// ocultar thumnb en product page, mostrar solo galería
// Ocultar la imagen destacada en la página del producto y mostrar solo las imágenes de la galería
// add_action( 'woocommerce_before_single_product_summary', 'hide_featured_image_and_show_gallery_images_on_product_page', 1 );

// function hide_featured_image_and_show_gallery_images_on_product_page() {
//     global $product;

//     // Verificar si estamos en la página de un producto y si hay imágenes en la galería
//     if ( is_product() && $product->get_gallery_image_ids() ) {
//         // Ocultar la imagen destacada
//         remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

//         // Mostrar solo las imágenes de la galería
//         add_action( 'woocommerce_before_single_product_summary', 'show_product_gallery_images', 20 );
//     }
// }

// function show_product_gallery_images() {
//     global $product;

//     // Obtener las IDs de las imágenes de la galería
//     $gallery_image_ids = $product->get_gallery_image_ids();

//     // Verificar si hay imágenes en la galería
//     if ( $gallery_image_ids ) {
//         // Comenzar el contenedor de la galería
//         echo '<div class="woocommerce-product-gallery woocommerce-product-gallery--with-images">
//         <div class="flex-viewport" style="overflow: hidden; position: relative; height: 443.344px;">
// 		<div class="woocommerce-product-gallery__wrapper" style="width: 400%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
//         <div class="woocommerce-product-gallery__image">';

//         // Mostrar cada imagen de la galería
//         foreach ( $gallery_image_ids as $image_id ) {
//             echo wp_get_attachment_image( $image_id, 'woocommerce_single', false, array( 'class' => 'woocommerce-product-gallery__image' ) );
//         }

//         // Cerrar el contenedor de la galería
//         echo '</div></div></div></div>';
//     }
// }






//
// Remover el sidebar de WooCommerce en todas las páginas
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


function hq_remove_woocommerce_tabs( $tabs ) {
    // unset( $tabs['description'] );
    unset( $tabs['additional_information'] );
    unset( $tabs['reviews'] );
    return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'hq_remove_woocommerce_tabs', 99 );


//
// Deshabilitar el SKU en WooCommerce
add_filter( 'wc_product_sku_enabled', '__return_false' );

//
// Añadir checkbox de consentimiento en el registro de WooCommerce
add_action( 'woocommerce_register_form_start', 'nwp_add_register_form_privacy_policy', 9 );
function nwp_add_register_form_privacy_policy () {
  
    woocommerce_form_field( 'privacy_policy', array(
        'type'          => 'checkbox',
        'class'         => array('form-row privacy'),
        'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
        'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
        'required'      => true,
        'label'         => 'He leído y acepto la <a href="url-politica-privacidad">política de privacidad</a>',
    )); 
      
}


//
// Añade un campo personalizado para la imagen del tag
function custom_add_tag_image_field() {
    ?>
    <div class="form-field">
        <label for="tag-image"><?php esc_html_e( 'Tag Image', 'text-domain' ); ?></label>
        <input type="text" name="tag-image" id="tag-image" class="tag-image-field" value="">
        <p class="description"><?php esc_html_e( 'Enter the URL for the tag image.', 'text-domain' ); ?></p>
    </div>
    <?php
}
add_action( 'product_tag_add_form_fields', 'custom_add_tag_image_field', 10, 2 );
// Guarda el valor del campo personalizado
function custom_save_tag_image_field( $term_id ) {
    if ( isset( $_POST['tag-image'] ) ) {
        $image_url = esc_url_raw( $_POST['tag-image'] );
        if ( ! empty( $image_url ) ) {
            add_term_meta( $term_id, 'tag_image', $image_url, true );
        }
    }
}
add_action( 'created_product_tag', 'custom_save_tag_image_field', 10, 2 );
add_action( 'edited_product_tag', 'custom_save_tag_image_field', 10, 2 );
// Recupera y muestra la imagen en la página de edición del tag
function custom_edit_tag_image_field( $term ) {
    $image_url = get_term_meta( $term->term_id, 'tag_image', true );
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="tag-image"><?php esc_html_e( 'Tag Image', 'text-domain' ); ?></label></th>
        <td>
            <input type="text" name="tag-image" id="tag-image" class="tag-image-field" value="<?php echo esc_url( $image_url ); ?>">
            <p class="description"><?php esc_html_e( 'Enter the URL for the tag image.', 'text-domain' ); ?></p>
        </td>
    </tr>
    <?php
}
add_action( 'product_tag_edit_form_fields', 'custom_edit_tag_image_field', 10, 2 );
// Muestra la imagen en la página de edición del tag
function custom_display_tag_image( $term_id ) {
    $image_url = get_term_meta( $term_id, 'tag_image', true );
    if ( ! empty( $image_url ) ) {
        echo '<img src="' . esc_url( $image_url ) . '" alt="Tag Image">';
    }
}




//
// Add Whislist
/*
 * Step 1. Add Link (Tab) to My Account menu
 */
// add_filter ( 'woocommerce_account_menu_items', 'hqwishlist_link', 40 );
// function hqwishlist_link( $menu_links ){
	
// 	$menu_links = array_slice( $menu_links, 0, 5, true ) 
// 	+ array( 'lista-de-deseos' => 'Lista de deseos' )
// 	+ array_slice( $menu_links, 5, NULL, true );
// 	return $menu_links;
// }
// /*
//  * Step 2. Register Permalink Endpoint
//  */
// add_action( 'init', 'hq_add_endpoint' );
// function hq_add_endpoint() {
// 	// WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
// 	add_rewrite_endpoint( 'lista-de-deseos', EP_PAGES );
// }
// /*
//  * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
//  */
// add_action( 'woocommerce_account_lista-de-deseos_endpoint', 'hq_my_account_endpoint_content' );
// function hq_my_account_endpoint_content() {
// 	// of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
// 	echo do_shortcode( '[yith_wcwl_wishlist]' ); 
//     //echo '<p>Hello World!</p>';
// }
/*
 * Step 4
 */
// Go to Settings > Permalinks and just push "Save Changes" button.


//
// Unidades vendidas
// add_action( 'woocommerce_single_product_summary', 'dl_unidades_vendidas_woocommerce', 20 );

// function dl_unidades_vendidas_woocommerce() {
// global $product;
// $units_sold = get_post_meta( $product->id, 'total_sales', true );
// echo '
// <p>' . '<i class="fa fa-cart-plus" aria-hidden="true"></i>' . sprintf( __( ' Unidades Vendidas: %s', 'woocommerce' ), $units_sold ) . '</p>
// ';
// }

//
// whislist counter
// if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_get_items_count' ) ) {
// function yith_wcwl_get_items_count() {
//     ob_start();
//     ? >
//     <span class="yith-wcwl-items-count">
//         <!-- <i class="yith-wcwl-icon fa fa-star-o"> -->
//             <?php echo esc_html( yith_wcwl_count_all_products() ); ? >
//         <!-- </i> -->
//     </span>
//     <?php
//     return ob_get_clean();
// }
// add_shortcode( 'yith_wcwl_items_count', 'yith_wcwl_get_items_count' );
// }

// if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_ajax_update_count' ) ) {
// function yith_wcwl_ajax_update_count() {
//     wp_send_json( array(
//         'count' => yith_wcwl_count_all_products()
//     ) );
// }
// add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
// add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
// }

// if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_enqueue_custom_script' ) ) {
// function yith_wcwl_enqueue_custom_script() {
//     wp_add_inline_script(
//         'jquery-yith-wcwl',
//         "
//         jQuery( function( $ ) {
//             $( document ).on( 'added_to_wishlist removed_from_wishlist', function() {
//             $.get( yith_wcwl_l10n.ajax_url, {
//                 action: 'yith_wcwl_update_wishlist_count'
//             }, function( data ) {
//                 $('.yith-wcwl-items-count').html( data.count );
//             } );
//             } );
//         } );
//         "
//     );
// }
// add_action( 'wp_enqueue_scripts', 'yith_wcwl_enqueue_custom_script', 20 );
// }
