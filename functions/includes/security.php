<?php 

// Bloquear las peticiones URL maliciosas
global $user_ID; if($user_ID) {
    if(!current_user_can('administrator')) {
        if (strlen($_SERVER['REQUEST_URI']) > 255 ||
            stripos($_SERVER['REQUEST_URI'], "eval(") ||
            stripos($_SERVER['REQUEST_URI'], "CONCAT") ||
            stripos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
            stripos($_SERVER['REQUEST_URI'], "base64")) {
                @header("HTTP/1.1 414 Request-URI Too Long");
                @header("Status: 414 Request-URI Too Long");
                @header("Connection: Close");
                @exit;
        }
    }
}


//
// // Disable the Plugin and Theme Editor
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}


//
// Block WordPress Admin Area for Everyone Except Administrators
add_action( 'admin_init', function() {
    if ( ! current_user_can( 'administrator' ) ) {
       wp_redirect( home_url() );
       exit;
    }
} );


//  
// SEGURIDAD - Evita el codigo HTML en los comentarios, para proteger de inyecciones de codigo
add_filter('pre_comment_content', 'wp_specialchars');


//
// stop user enumeration
if (!is_admin()) {
    // default URL format
    if (preg_match('/author=([0-9]*)/i', $_SERVER['QUERY_STRING'])) die(); add_filter('redirect_canonical', 'shapeSpace_check_enum', 10, 2);
}
function shapeSpace_check_enum($redirect, $request) {
    // permalink URL format
    if (preg_match('/\?author=([0-9]*)(\/*)/i', $request)) die(); else return $redirect;
}


//
// Remove WordPress Version Number
function wpb_remove_version() {
    return '';
}
add_filter('the_generator', 'wpb_remove_version');


//
// Disable XML-RPC in WordPress
add_filter('xmlrpc_enabled', '__return_false');


//
// Desactivar la API REST
// add_filter(
// 	'rest_authentication_errors',
// 	function ( $access ) {
// 		return new WP_Error(
// 			'rest_disabled',
// 			__( 'La API REST de WordPress ha sido deshabilitada.' ),
// 			array(
// 				'status' => rest_authorization_required_code(),
// 			)
// 		);
// 	}
// );


//
// changing the default login cookie expiration time
// add_filter( 'auth_cookie_expiration', 'wpdev_login_session' );
// function wpdev_login_session( $expire ) {
// // Set login session limit in seconds
// return 7200; // (1200 Seconds = 20 minutes)
// }




//
// Agrega este código en el archivo functions.php de tu tema o en un plugin personalizado

// function cerrar_sesion_si_inactivo() {
//     // Comprueba si el usuario está conectado
//     if (is_user_logged_in()) {
//         $user = wp_get_current_user();
//         $user_id = $user->ID;

//         // Obtiene la última vez que se actualizó la actividad del usuario
//         $last_active = get_user_meta($user_id, 'ultima_actividad', true);

//         // Comprueba si ha pasado más de 10 minutos desde la última actividad
//         if ($last_active && (time() - $last_active > 600)) { // 600 segundos = 10 minutos
//             // Cierra la sesión del usuario
//             wp_logout();
//             // Redirige al usuario a la página de inicio de sesión o a donde prefieras
//             wp_redirect(wp_login_url());
//             exit;
//         }
//     }
// }

// // Hook para ejecutar la función al cargar cualquier página
// add_action('init', 'cerrar_sesion_si_inactivo');

// // Hook para actualizar la marca de tiempo de la última actividad del usuario en cada carga de página
// function actualizar_ultima_actividad() {
//     if (is_user_logged_in()) {
//         $user = wp_get_current_user();
//         $user_id = $user->ID;
//         update_user_meta($user_id, 'ultima_actividad', time());
//     }
// }
// add_action('init', 'actualizar_ultima_actividad');
