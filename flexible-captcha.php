<?php
/*
Plugin Name: Flexible Captcha
Plugin URI: http://www.jsterup.com
Description: A plugin to create configurable captcha images on any form.
Version: 0.3
Author: Jeff Sterup
Author URI: http://www.jsterup.com
License: GPL2
*/
require_once(WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)) . "/lib/FlexibleCaptcha.class.php");


$FlexibleCaptcha = new FlexibleCaptcha(WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)), plugins_url("", __FILE__));

register_activation_hook(__FILE__,array($FlexibleCaptcha, 'activate'));
register_deactivation_hook(__FILE__, array($FlexibleCaptcha, 'deactivate'));

add_action('init',  array($FlexibleCaptcha, 'setup_nonce'));
add_filter('init',  array($FlexibleCaptcha, 'check_for_captcha_request'), 1, 1);

add_action('admin_menu', array($FlexibleCaptcha, 'admin_menu'));

add_shortcode('FC_captcha_fields', array($FlexibleCaptcha, 'display_captcha_shortcode'));

add_action('wp_ajax_FC_submit_default_dimensions',  array($FlexibleCaptcha, 'submit_default_dimensions'));
add_action('wp_ajax_FC_submit_request_key',  array($FlexibleCaptcha, 'submit_request_key'));
add_action('wp_ajax_FC_submit_colors',  array($FlexibleCaptcha, 'submit_colors'));
add_action('wp_ajax_FC_delete_font_file',  array($FlexibleCaptcha, 'delete_font_file'));
add_action('wp_ajax_FC_submit_general_settings',  array($FlexibleCaptcha, 'submit_general_settings'));

##Comments form
add_action( 'comment_form_after_fields', array($FlexibleCaptcha, 'add_to_comment_form'));
add_filter( 'preprocess_comment', array($FlexibleCaptcha, 'check_comment_submit'));

##Registration form
add_action('register_form',array($FlexibleCaptcha, 'add_to_registration_form'));
add_action('register_post',array($FlexibleCaptcha, 'check_registration_submit'),1,3);


add_action('wp_enqueue_scripts', array($FlexibleCaptcha, 'add_jquery_to_header'));
?>