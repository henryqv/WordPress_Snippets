<?php
// ACF Códigos en Cabecera, Body y Footer
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_62d01d981632a',
	'title' => 'Setup',
	'fields' => array(
		array(
			'key' => 'field_63ebbfac4a3ec',
			'label' => 'Códigos en Cabecera, Body y Footer',
			'name' => 'codigos_en_cabecera_body_y_footer',
			'aria-label' => '',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_63ebbfb44a3ed',
					'label' => 'Header',
					'name' => 'header_code',
					'aria-label' => '',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'maxlength' => '',
					'rows' => '',
					'placeholder' => '',
					'new_lines' => '',
				),
				array(
					'key' => 'field_63ebbfd04a3ee',
					'label' => 'Body',
					'name' => 'body_code',
					'aria-label' => '',
					'type' => 'textarea',
					'instructions' => 'Código que se mostrará luego de abrir la etiqueta <body>',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'maxlength' => '',
					'rows' => '',
					'placeholder' => '',
					'new_lines' => '',
				),
				array(
					'key' => 'field_63ebbfec4a3ef',
					'label' => 'Footer',
					'name' => 'footer_code',
					'aria-label' => '',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'maxlength' => '',
					'rows' => '',
					'placeholder' => '',
					'new_lines' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'general-settings',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
));

endif;		


//
// Permitir subir archivos SVG
add_filter(
	'upload_mimes',
	function ( $upload_mimes ) {
		// Por defecto, sólo los usuarios administradores pueden añadir SVG.
		// Para permitir más tipos de usuarios, edita o comenta las líneas siguientes, pero ten cuidado con los riesgos de seguridad si permites que cualquier usuario cargue archivos SVG.
		if ( ! current_user_can( 'administrator' ) ) {
			return $upload_mimes;
		}

		$upload_mimes['svg']  = 'image/svg+xml';
		$upload_mimes['svgz'] = 'image/svg+xml';

		return $upload_mimes;
	}
);
add_filter(
	'wp_check_filetype_and_ext',
	function ( $wp_check_filetype_and_ext, $file, $filename, $mimes, $real_mime ) {

		if ( ! $wp_check_filetype_and_ext['type'] ) {

			$check_filetype  = wp_check_filetype( $filename, $mimes );
			$ext             = $check_filetype['ext'];
			$type            = $check_filetype['type'];
			$proper_filename = $filename;

			if ( $type && 0 === strpos( $type, 'image/' ) && 'svg' !== $ext ) {
				$ext  = false;
				$type = false;
			}

			$wp_check_filetype_and_ext = compact( 'ext', 'type', 'proper_filename' );
		}

		return $wp_check_filetype_and_ext;

	},
	10,
	5
);

//
// Deshabilitar completamente los comentarios
add_action('admin_init', function () {
    // Redirigir a cualquier usuario que intente acceder a la página de comentarios
    global $pagenow;
    
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }

    // Eliminar metabox de comentarios del dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Desactivar el soporte para comentarios y trackbacks en los tipos de post
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Cerrar los comentarios en el frontend
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Ocultar los comentarios ya existentes
add_filter('comments_array', '__return_empty_array', 10, 2);

// Eliminar la página de comentarios en el menú
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Eliminar los enlaces de comentarios de la barra de administración
add_action('admin_bar_menu', function () {
    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
}, 0);

// Disable URL Links in WordPress Comments
remove_filter( 'comment_text', 'make_clickable', 9 );



//
//  Eliminamos las <p> en CF7
add_filter( 'wpcf7_autop_or_not', '__return_false' );

//
// add categories for attachments
function add_categories_for_attachments() {
    register_taxonomy_for_object_type( 'multimedia_taxonomy', 'attachment' );
}
add_action( 'init' , 'add_categories_for_attachments' );

// add tags for attachments
function add_tags_for_attachments() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'add_tags_for_attachments' );


//
// Disable Language Switcher on Login Page
add_filter( 'login_display_language_dropdown', '__return_false' );


//
// Disable WordPress Admin Bar on Frontend for all users 
add_filter( 'show_admin_bar', '__return_false' );


//
// Change Howdy Admin Text in Admin Area
function wpcode_snippet_replace_howdy( $wp_admin_bar ) {
 
    // Edit the line below to set what you want the admin bar to display intead of "Howdy,".
    $new_howdy = 'Bienvenido,';
 
    $my_account = $wp_admin_bar->get_node( 'my-account' );
    $wp_admin_bar->add_node(
        array(
            'id'    => 'my-account',
            'title' => str_replace( 'Howdy,', $new_howdy, $my_account->title ),
        )
    );
}
 
add_filter( 'admin_bar_menu', 'wpcode_snippet_replace_howdy', 25 );


//
// Remove Welcome Panel From the WordPress Admin Dashboard
add_action(
    'admin_init',
    function () {
        remove_action( 'welcome_panel', 'wp_welcome_panel' );
    }
);


//
// hidden Category title
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );


//
// Redirigir a la Home al cerrar sesión
function cerrar_sesion_y_redirigir_a_inicio() {
    // Cerrar la sesión actual
    wp_logout();

    // Redirigir al usuario a la página de inicio
    wp_redirect(home_url());
    exit;
}


//
// Remove all dashboard widgets
add_action('wp_dashboard_setup', 'wpdocs_remove_dashboard_widgets');

function wpdocs_remove_dashboard_widgets(){
	remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
	remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Quick Press
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Recent Drafts
	remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
	remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Other WordPress News
	// use 'dashboard-network' as the second parameter to remove widgets from a network dashboard.
}


//
// email validation cf7
// add_filter( 'wpcf7_validate_email*', 'custom_email_confirmation_validation_filter', 20, 2 );
  
// function custom_email_confirmation_validation_filter( $result, $tag ) {
// 	if ( 'your-email-confirm' == $tag->name ) {
// 		$your_email = isset( $_POST['your-email'] ) ? trim( $_POST['your-email'] ) : '';
// 		$your_email_confirm = isset( $_POST['your-email-confirm'] ) ? trim( $_POST['your-email-confirm'] ) : '';
	
// 		if ( $your_email != $your_email_confirm ) {
// 			$result->invalidate( $tag, "¿Estás seguro(a) que esta es la dirección correcta?" );
// 		}
// 	}  
// 	return $result;
// }


//
// Desactivar actualizaciones automáticas
//
// Desactiva actualizaciones automáticas del núcleo de WordPress
add_filter( 'auto_update_core', '__return_false' );
// Desactiva las actualizaciones automáticas de los plugins
add_filter( 'auto_update_plugin', '__return_false' );
// Desactiva las actualizaciones automáticas de los temas
add_filter( 'auto_update_theme', '__return_false' );


//
// Ocultar el mensaje de actualización de WordPress
function wp_hide_update() {
	remove_action('admin_notices', 'update_nag', 3);
}

add_action('admin_menu','wp_hide_update');


//
// Ver miniatura de la imagen destacada de entradas y páginas en vista general de administración
//
// Establecer el tamaño de la miniatura
add_image_size( 'j0e_admin-featured-image', 60, 60, false );

// Añade el filtro de columnas de posts y páginas. La misma función para ambos.
add_filter('manage_posts_columns', 'j0e_add_thumbnail_column', 2);
add_filter('manage_pages_columns', 'j0e_add_thumbnail_column', 2);
function j0e_add_thumbnail_column($j0e_columns){
  $j0e_columns['j0e_thumb'] = __('Image');
  return $j0e_columns;
}
// Añadir miniatura de imagen destacada a la tabla WP Admin.
add_action('manage_posts_custom_column', 'j0e_show_thumbnail_column', 5, 2);
add_action('manage_pages_custom_column', 'j0e_show_thumbnail_column', 5, 2);
function j0e_show_thumbnail_column($j0e_columns, $j0e_id){
  switch($j0e_columns){
    case 'j0e_thumb':
    if( function_exists('the_post_thumbnail') )
      echo the_post_thumbnail( 'j0e_admin-featured-image' );
    break;
  }
}
// Mueve la nueva columna al primer lugar.
add_filter('manage_posts_columns', 'j0e_column_order');
function j0e_column_order($columns) {
  $n_columns = array();
  $move = 'j0e_thumb'; // qué columna mover
  $before = 'title'; // mover antes de esta columna

  foreach($columns as $key => $value) {
    if ($key==$before){
      $n_columns[$move] = $move;
    }
    $n_columns[$key] = $value;
  }
  return $n_columns;
}
// Ajustar el ancho de la columna (dar formato con CSS)
add_action('admin_head', 'j0e_add_admin_styles');
function j0e_add_admin_styles() {
  echo '<style>.column-j0e_thumb {width: 60px;}</style>';
}
