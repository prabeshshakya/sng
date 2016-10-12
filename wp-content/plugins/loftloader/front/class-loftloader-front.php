<?php
// Not allowed by directly accessing.
if(!defined('ABSPATH')){
	die('Access not allowed!');
}

/**
 * Main class for front display
 * 
 * @package   LoftLoader
 * @version   1.0
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team

 * @since version 1.0
 */

if(!class_exists('LoftLoader_Front')){
	class LoftLoader_Front{
		private $loader_enabled; // Flag to tell whether loftloader enabled
		private $homepage_only; // Flag to tell show loftloader on homepage only
		private $loader_settings; // Get the loader settings
		public function __construct(){
			$this->get_settings();
			if($this->loader_enabled){
				if(!$this->homepage || is_front_page()){
					add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
					add_action('wp_head',   array($this, 'loader_custom_styles'), 100);
					add_action('wp_footer',	array($this, 'show_loader_html'));
				}
			}
		}
		/**
		* @description get the plugin settings
		*/
		public function get_settings(){ 
			$default  = apply_filters('loftloader_settings_default_value', array());
			$settings = get_option('loftloader-custom-settings', $default);
			$this->loader_enabled = (!empty($settings['enable']) && ($settings['enable'] == 'on')) ? true : false;
			$this->homepage = (!empty($settings['homepage']) && ($settings['homepage'] == 'on')) ? true : false;
			$this->loader_settings = $settings;
		}
		/**
		 * @description enqueue the scripts and styles for front end
		 */
		public function enqueue_scripts(){
			wp_enqueue_script('loftloader-front-main', LOFTLOADER_JS_URI . 'front/loftloader.js', array('jquery'), '1.0', true);
			wp_enqueue_style('loftloader-animation');
		}
		/**
		 * @description custom css for front end
		 */
		public function loader_custom_styles(){
			$styles = get_option('loftloader-custom-styles', '');
			echo empty($styles) ? '' : '<style type="text/css">' . $styles . '</style>';
		}
		/**
		 * @description loftloader html
		 */
		public function show_loader_html(){
			$loader  = $this->loader_settings['settings']; // Preloader settings
			$background = $loader['background']; // Preloader background settings
			$animation  = $loader['animation']; // Preloader animation settings
			$html  = '<div id="loftloader-wrapper" class="' . $animation['type'] . '">';
			$html .= '<div class="loader-inner"><div id="loader">';
			$html .= in_array($animation['type'], array('pl-frame', 'pl-imgloading'))
				? '<span></span><img srcset="' . $animation['image']['url'] . '" src="' . $animation['image']['url'] . '" alt="preloder">' : '<span></span>';
			$html .= '</div></div>';
			switch($background['effect']){
				case 'fade':
					$html .= '<div class="loader-section section-fade"></div>';
					break;
				case 'slide-up':
					$html .= '<div class="loader-section section-slide-up"></div>';
					break;
				case 'slide-up-down':
					$html .= '<div class="loader-section section-up"></div>';
					$html .= '<div class="loader-section section-down"></div>';
					break;
				default:
					$html .= '<div class="loader-section section-left">';
					$html .= '</div><div class="loader-section section-right"></div>';
			}
			$html .= '</div>';
			echo $html;
		}
	}
	new LoftLoader_Front();
}