<?php
/*
Plugin Name: WooCommerce Selfie Upload
Plugin URI: https://codewp.ai
Description: Extend the WooCommerce registration form with a mandatory selfie upload field.
Version: 1.0
Author: CodeWP Assistant
Author URI: https://codewp.ai
Text Domain: codewp
*/

// Add enctype to form to allow file uploads
add_action('woocommerce_register_form_tag', 'cwpai_enctype_custom_registration_forms');
function cwpai_enctype_custom_registration_forms() {
    echo 'enctype="multipart/form-data"';
}

// Add a file input to the registration form
add_action('woocommerce_register_form', 'cwpai_add_selfie_field_to_registration_form');
function cwpai_add_selfie_field_to_registration_form() {
    ?>
    <p class="form-row validate-required" id="selfie" data-priority="">
        <label for="selfie" class="">Selfie (JPG, PNG)<abbr class="required" title="required">*</abbr></label>
        <span class="woocommerce-input-wrapper">
            <input type='file' name='selfie' accept='image/jpeg, image/png' required>
        </span>
    </p>
    <?php
}

// Validate the selfie upload field
add_filter('woocommerce_registration_errors', 'cwpai_validate_selfie_field', 10, 3);
function cwpai_validate_selfie_field($errors, $username, $email) {
    if (isset($_FILES['selfie']) && $_FILES['selfie']['error'] !== UPLOAD_ERR_OK) {
        $errors->add('selfie_error', __('Please upload a valid selfie.', 'woocommerce'));
    }
    return $errors;
}

// Save the selfie file after registration
add_action('user_register', 'cwpai_save_selfie_field', 1);
function cwpai_save_selfie_field($customer_id) {
    if (isset($_FILES['selfie']) && $_FILES['selfie']['error'] === UPLOAD_ERR_OK) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        $attachment_id = media_handle_upload('selfie', 0);
        if (is_wp_error($attachment_id)) {
            // Optionally handle the error here; logging, display error message, etc.
            error_log('Selfie upload error: ' . $attachment_id->get_error_message());
        } else {
            // Save the attachment ID in user meta
            update_user_meta($customer_id, 'cwpai_selfie_attachment_id', $attachment_id);
        }
    }
}

// Display the uploaded selfie in the admin user profile
add_action('show_user_profile', 'cwpai_show_selfie_field_in_admin');
add_action('edit_user_profile', 'cwpai_show_selfie_field_in_admin');
function cwpai_show_selfie_field_in_admin($user) {
    $attachment_id = get_user_meta($user->ID, 'cwpai_selfie_attachment_id', true);
    if ($attachment_id) {
        $selfie_url = wp_get_attachment_url($attachment_id);
        echo '<h3>Selfie</h3>';
        echo '<p><img src="' . esc_url($selfie_url) . '" width="300px" height="auto" /></p>';
    }
}
?>