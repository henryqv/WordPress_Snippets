<?php 
//
// personalizar frase Gracias por crear con WordPress
function modify_footer_admin () {
    echo 'Página realizada por <a href="https://www.henryquevedo.com" target="_blank">Henry Quevedo</a>';
}
add_filter('admin_footer_text', 'modify_footer_admin');


//
// Add Custom Dashboard Widgets in WordPress
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
 
function my_custom_dashboard_widgets() {
global $wp_meta_boxes;
 
wp_add_dashboard_widget('custom_help_widget', 'Theme Support', 'custom_dashboard_help');
}
 
function custom_dashboard_help() {
echo '<p>Bienvenido! Necesitas ayuda? Contacta al desarrollador <a href="mailto:henryqv@gmail.com">aquí</a>.<br>Para otros servicios contacta con: <a href="https://henryquevedo.com" target="_blank">Henry Quevedo</a></p>';
}