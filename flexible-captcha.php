<?php
/*
Plugin Name: Flexible Captcha
Plugin URI: http://www.jsterup.com
Description: A plugin to create configurable captcha images on any form.
Version: 2.0.2
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

add_action('wp_ajax_FC_delete_font_file',  array($FlexibleCaptcha, 'delete_font_file'));
add_action('wp_ajax_FC_submit_settings',  array($FlexibleCaptcha, 'submit_settings'));

##Comments form
add_action( 'comment_form_after_fields', array($FlexibleCaptcha, 'add_to_comment_form'));
add_action( 'comment_form_logged_in_after', array($FlexibleCaptcha, 'add_to_comment_form'));
add_filter( 'preprocess_comment', array($FlexibleCaptcha, 'check_comment_submit'));

##Registration form
add_action('register_form',array($FlexibleCaptcha, 'add_to_registration_form'));
add_action('register_post',array($FlexibleCaptcha, 'check_registration_submit'),1,3);

#Login Form
add_action('login_form', array($FlexibleCaptcha, 'add_to_login_form'));
add_action('login_form_bottom', array($FlexibleCaptcha, 'add_to_login_form_bottom'));
add_filter('authenticate', array($FlexibleCaptcha, 'check_login_submit'), 40, 3);

add_action('wp_enqueue_scripts', array($FlexibleCaptcha, 'add_jquery_to_header'));
add_action('login_enqueue_scripts', array($FlexibleCaptcha, 'add_jquery_to_header'));
?>