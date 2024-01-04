<?php
/*
Plugin Name: YES Login
Description: custom login page
Donate link: https://yesandagency
Author: Yes& Agency
Author URI: https://yesandagency
Version: 1.9.8
Requires at least: 4.1
Tested up to: 6.1
Requires PHP: 7.0
Domain Path: languages
Text Domain: yes-login
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Plugin constants
define( 'YES_Login_VERSION', '1.0.0' );
define( 'YES_Login_FOLDER', 'yes-login' );

define( 'YES_Login_URL', plugin_dir_url( __FILE__ ) );
define( 'YES_Login_DIR', plugin_dir_path( __FILE__ ) );
define( 'YES_Login_BASENAME', plugin_basename( __FILE__ ) );

require_once YES_Login_DIR . 'autoload.php';

register_activation_hook( __FILE__, array( '\IAVI\YES_Login\Plugin', 'activate' ) );

add_action( 'plugins_loaded', 'plugins_loaded_YES_Login_plugin' );
function plugins_loaded_YES_Login_plugin() {
	\IAVI\YES_Login\Plugin::get_instance();

	load_plugin_textdomain( 'yes-login', false, dirname( YES_Login_BASENAME ) . '/languages' );
}


function yes_login_style() {
    echo '<style type="text/css">
        body.login {
            background-color: #FEE289;
        }
        body.login #login h1 a {
            background-image: url(' . plugin_dir_url( __FILE__ ) . 'logo.png);
            width: auto;
            height: 100px;
            background-size: contain;
        }
    </style>';
}

add_action('login_head', 'yes_login_style');

/**
 * Remove reutrn to Pantheon button
 */
function remove_return_to_Pantheon_button_scripts_and_styles() 
{

    wp_dequeue_style('pantheon-login-mods');

    wp_dequeue_script('pantheon-login-mods');

}

add_action( 'login_enqueue_scripts', 'remove_return_to_Pantheon_button_scripts_and_styles', 25 );

function disable_return_to_Pantheon_button()
{

    remove_action('login_header', 'Return_To_Pantheon_Button_HTML');

    remove_action('login_enqueue_scripts', 'Pantheon_Enqueue_Login_script');

    remove_action('login_enqueue_scripts', 'Pantheon_Enqueue_Login_style');
}

add_action( 'after_setup_theme', 'disable_return_to_Pantheon_button', 10 );