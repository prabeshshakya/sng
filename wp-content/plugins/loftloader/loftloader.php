<?php
/*
Plugin Name: LoftLoader
Plugin URI: http://www.loftocean.com/
Description: An easy to use plugin to add an animated preloader to your website with fully customisations.
Version: 1.0.1
Author: Loft Ocean
Author URI: http://www.loftocean.com/
Text Domain: loftloader
Domain Path: /languages
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


/**
 * LoftLoader main file
 * 
 * @package   LoftLoader
 * @version   1.0
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team
 */

// Not allowed by directly accessing.
if(!defined('ABSPATH')){
	die('Access not allowed!');
}

if(!class_exists('LoftLoader')){
	register_activation_hook(__FILE__, 'loftloader_activate'); // 
	register_deactivation_hook(__FILE__, 'loftloader_deactivate');
	/*
	 * Update the plugin version for initial version
	 */
	function loftloader_activate(){
		update_option('loftloader_plugin_version', '1.0.0');
	}
	/**
	 * Do nothing for initial version
	 */
	function loftloader_deactivate(){ }
	/**
	 * Define the constant used in this plugin
	 */
	define('LOFTLOADER_ROOT', dirname(__FILE__) . '/');
	define('LOFTLOADER_NAME', plugin_basename( __FILE__ ));
	define('LOFTLOADER_URI',  plugin_dir_url( __FILE__ ));
	define('LOFTLOADER_JS_URI',  LOFTLOADER_URI . 'js/'); 
	define('LOFTLOADER_CSS_URI', LOFTLOADER_URI . 'css/');

	/**
	 * Main plugin class
	 * @since version 1.0.0
	 */
	class LoftLoader{
		public function __construct(){
			load_plugin_textdomain('loftloader', false, dirname(plugin_basename(__FILE__)) . '/languages/'); // Load the text domain
			$this->load_configs();
			add_action('init', array($this, 'load_settings')); // Load the plugin settings
			add_action('wp', array($this, 'load_front')); // Load the front main class
			add_action('wp_enqueue_scripts', array($this, 'enqueue_loader_styles'));
			add_action('admin_enqueue_scripts', array($this, 'enqueue_loader_styles'));
		}
		/**
		* @description load configuration files
		*/
		public function load_configs(){
			require_once LOFTLOADER_ROOT . 'configs/loftloader-config.php';
		}
		/**
		 * @description load plugin settings main class
		 */
		public function load_settings(){
			is_admin() ? require_once LOFTLOADER_ROOT . 'settings/class-loftloader-settings.php' : '';
		}
		/**
		 * @description load plugin front main class
		 */
		public function load_front(){
			!is_admin() ? require_once LOFTLOADER_ROOT . 'front/class-loftloader-front.php' : '';
		}
		/**
		* @description register the loader style css for both plugin setting page and front end
		*/
		public function enqueue_loader_styles(){
			wp_register_style('loftloader-animation', LOFTLOADER_CSS_URI . 'loftloader-animation.css', array(), '1.0');
		}
	}
	new LoftLoader(); // Enable LoftLoader
}
?>
