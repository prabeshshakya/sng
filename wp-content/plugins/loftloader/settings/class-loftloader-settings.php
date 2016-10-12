<?php
// Not allowed by directly accessing.
if(!defined('ABSPATH')){
	die('Access not allowed!');
}

/**
 * Main class for plugin option page
 * 
 * @package   LoftLoader
 * @version   1.0
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team

 * @since version 1.0
 */

if(!class_exists('LoftLoader_Settings')){
	class LoftLoader_Settings{
		private $page_id; // Plugin setting page id
		private $setting_manager; // Settings section to render/save settings
		public function __construct(){
			$this->page_id = 'loftloader-settings';
			$this->setting_manager = new LoftLoader_Setting_Manager();

			add_filter('plugin_action_links_' . LOFTLOADER_NAME, array($this, 'plugin_action_links'));
			add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
			add_action('print_media_templates', array($this, 'media_styles')); // Print media styles for media uploader
			add_action('admin_menu', array($this, 'add_settings_menu')); // Add plugin option menu item
			add_action('admin_init', array($this, 'register_settings')); // Register setting fields
			add_action('admin_notices', array($this, 'reset_update'));
			add_action('wp_ajax_loftloader_reset_settings', array($this, 'reset_settings')); // Reset the plugin option settings
		}
		/**
		* @description add a plugin action link to plugin setting page
		*/
		public function plugin_action_links($links){
			$action_links = array(
				'settings' => '<a href="' . admin_url('options-general.php?page=' . $this->page_id) . '" title="' . esc_attr__('View LoftLoader Settings', 'loftloader') . '">' . esc_html__('Settings', 'loftloader') . '</a>'
			);
			return array_merge($action_links, $links);
		}
		/**
		 * @description enqueue the style when show media uploader template
		 */
		public function media_styles(){
			wp_enqueue_style('loftloader-media-style', LOFTLOADER_CSS_URI . 'settings/loftloader-media.css');
		}
		/**
		 * @description register and enqueu scripty and styles
		 */
		public function enqueue_scripts(){
			if(isset($_GET['page']) && ($_GET['page'] == $this->page_id)){
				$js_vars  = array(
					'img_base' => (LOFTLOADER_URI . 'img/'),
					'fail_text' => esc_html__('Sorry, but the request failed. Please try again later.', 'loftloader'),
					'confirm_text' => esc_html__('Are you sure want to reset all settings?', 'loftloader'),
					'ajax' => array(
						'url' => admin_url('admin-ajax.php'),
						'action' => 'loftloader_reset_settings',
						'nonce' => wp_create_nonce('loftloader-reset-settings')
					)
				);
				// Register the scripts and styles
				wp_register_script('loftloader-setting',   LOFTLOADER_JS_URI . 'settings/loftloader-settings.js', array('jquery', 'wp-color-picker', 'jquery-ui-slider'), '1.0');
				wp_localize_script('loftloader-setting',  'loftloader_vars',  $js_vars);

				wp_register_style('loftloader-jqueryui', LOFTLOADER_CSS_URI . 'jquery-ui.css', array(), '1.0');
				wp_register_style('loftloader-settings', LOFTLOADER_CSS_URI . 'settings/loftloader-settings.css',  array('wp-color-picker', 'loftloader-jqueryui'), '1.0');

				// Enqueue the scripts and styles
				wp_enqueue_media();
				wp_enqueue_script('loftloader-setting');
				wp_enqueue_style('loftloader-settings');
				wp_enqueue_style('loftloader-animation');
			}
		}
		/**
		 * @description add plugin settings menu
		 */
		public function add_settings_menu(){
			add_options_page(
				esc_html__('LoftLoader Settings', 'loftloader'), // Page title on html head
				esc_html__('LoftLoader', 'loftloader'), // Menu item label
				'manage_options',
				$this->page_id,
				array($this, 'render_settings_page')
			); // Register the plugin option subpage
		}
		/**
		 * @description register the settings for saving
		 */
		public function register_settings(){
			$this->setting_manager->register_setting();
		}
		/**
		 * @description get settings content
		 */
		private function get_settings_content(){
			ob_start();
			$this->setting_manager->render_settings_section();
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}
		/**
		 * @description get settings page template
		 */
		public function render_settings_page(){
			$footer = '<div class="panel-footer">' . $this->get_buttons() . '</div>';
			$content = $this->get_settings_content();
			$action = admin_url('options.php');
			$html = <<<ETO
					<div class="wrap">
						<div id="loftloader-options-panel" class="loftloader-options-panel">
							<form method="post" action="$action">
								<div class="panel-content">
									$content
								</div>
								<!-- panel-content -->
								$footer
							</form>
						</div>
					</div>
ETO;
			echo $html;
		}
		/**
		 * @description get save button
		 * @return save button html
		*/
		private function get_buttons(){
			$btns  = '<p class="submit"><input type="submit" name="submit" id="submit" class="submit button button-primary" value="' . esc_attr__('Save Changes', 'loftloader') . '"></p>';
			$btns .= '<p class="reset"><input type="submit" class="button button-primary reset" value="' . esc_attr__('Reset All Settings', 'loftloader') . '"></p>';
			return $btns;
		}
		/**
		 * @description reset loftloader settings
		 */
		public function reset_settings(){
			check_ajax_referer('loftloader-reset-settings', 'nonce');
			$this->setting_manager->reset_settings();
			update_option('loftloader_settings_reset', 'done');
			wp_send_json_success();
			wp_die();
		}
		/**
		 * @description show reset confirm message
		 */
		public function reset_update(){
			if(get_option('loftloader_settings_reset', '') == 'done'){
				add_settings_error('loftloader-options', esc_attr('loftloader_settings_reset_notice'), esc_html__('LoftLoader settings have been reset.', 'loftloader'), 'updated');
				delete_option('loftloader_settings_reset');
			}
		}
	}
	new LoftLoader_Settings();
}