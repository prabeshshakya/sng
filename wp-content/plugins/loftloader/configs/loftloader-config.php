<?php
// Not allowed by directly accessing.
if(!defined('ABSPATH')){
	die('Access not allowed!');
}
/**
 * Configuration file for plugin option sections
 *   fields and the default settings
 * 
 * @package   LoftLoader
 * @version   1.0
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team

 * @since version 1.0
 */

if(!file_exists('loftloader_settings_fields') && !file_exists('loftloader_settings_default_value')){
	add_filter('loftloader_settings_fields', 'loftloader_settings_fields');
    /**
     * @description hook callback function to register the fields of loftloader
     * @param array $fields
     * @return array merge fields to the array passed by
     */
	function loftloader_settings_fields($fields = array()){
		return array_merge((array)$fields, array(
			array(
				'title'   => esc_html__('Show Preloader', 'loftloader'),
				'args'    => array(),
				'content' => array(
					array(
						'name'        => 'enable',
						'type'        => 'Checkbox',
						'title'       => esc_html__('Enable LoftLoader', 'loftloader'),
						'description' => esc_html__('Suggest keep it enabled if the site has a lot of images or large videos.', 'loftloader'),
						'options'     => array(
							'on' => array('label' => '')
						),
						'extra' => array(
							'class' => 'loftloader-enabled'
						)
					),
					array(
						'name'        => 'homepage',
						'type'        => 'Checkbox',
						'title'       => esc_html__('For homepage only', 'loftloader'),
						'description' => esc_html__('If enabled, the LoftLoader will be shown on homepage only', 'loftloader'),
						'options'     => array(
							'on' => array('label' => '')
						),
						'extra' => array(
							'class' => 'loftloader-enable-homepage-only'
						)
					)
				)
			),
			array(
				'title'   => '',
				'args'    => array('nolist' => true, 'nowrap' => true),
				'content' => array(
					array(
						'name'        => 'settings',
						'type'        => 'Preloader_Preview',
						'title'	      => '',
						'description' => '',
						'options'     => array(
							array(
								'section'     => 'preview',
								'title'       => esc_html__('Preview', 'loftloader'),
								'description' => esc_html__('Hover onto frame below to preview ending animation.', 'loftloader')
							),
							array(
								'section' => 'setting',
								'content' => array(
									array(
										'title'   => esc_html__('Background', 'loftloader'),
										'content' => array(
											array(
												'name'    => 'background[effect]',
												'type'    => 'select',
												'title'   => esc_html__('Select preloader ending animation', 'loftloader'),
												'options' => array(
													'fade'             => array('label' => esc_html__('Fade', 'loftloader')),
													'slide-left-right' => array('label' => esc_html__('Slide Left & Right', 'loftloader')),
													'slide-up'         => array('label' => esc_html__('Slide Up', 'loftloader')),
													'slide-up-down'    => array('label' => esc_html__('Slide Up & Down', 'loftloader'), 'selected' => true)
												),
												'extra' => array(
													'id' => 'preloader-background-style',
												)
											),
											array(
												'name'    => 'background[color]',
												'type'    => 'color-picker',
												'title'   => esc_html__('Preloader background color', 'loftloader'),
												'options' => array(
													'defaultValue' => '#222222'
												),
												'extra' => array(
													'id' => 'preloader-background-color',
												)
											),
											array(
												'name'    => 'background[opacity]',
												'type'    => 'slider',
												'title'   => esc_html__('Preloader background opacity', 'loftloader'),
												'options' => array(
													'default' => 100,
													'min'     => 0,
													'max'     => 100,
													'step'    => 5
												),
												'extra'	=> array(
													'class' => 'slider-opacity'
												)
											)
										)
									),
									array(
										'title'   => esc_html__('Animation', 'loftloader'),
										'content' => array(
											array(
												'name'    => 'animation[type]',
												'type'    => 'select',
												'title'   => esc_html__('Select preloader loading animation', 'loftloader'),
												'options' => array(
													'pl-sun'        => array('label' => esc_html__('1 - Spinning Sun', 'loftloader')),
													'pl-circles'    => array('label' => esc_html__('2 - Luminous Circles', 'loftloader')),
													'pl-wave'       => array('label' => esc_html__('3 - Wave', 'loftloader')),
													'pl-square'     => array('label' => esc_html__('4 - Spinning Square', 'loftloader')),
													'pl-frame'      => array('label' => esc_html__('5 - Drawing Frame', 'loftloader')),
													'pl-imgloading' => array('label' => esc_html__('6 - Loading Custom Image', 'loftloader'))
												),
												'extra' => array(
													'id'    => 'preloader-animation',
													'class' => 'preloader-dependency-parent'
												)
											),
											array(
												'name'    => 'animation[color]',
												'type'    => 'color-picker',
												'title'   => esc_html__('Preloader animation color', 'loftloader'),
												'options' => array(
													'defaultValue' => '#222222'
												),
												'extra'	=> array(
													'id'           => 'preloader-animation-color',
													'wrapperClass' => 'preloader_animation preloader_animation-pl-sun preloader_animation-pl-circles preloader_animation-pl-wave preloader_animation-pl-square preloader_animation-pl-frame'
												)
											),
											array(
												'name'    => 'animation[image]',
												'type'    => 'media',
												'title'   => esc_html__('Upload custom image/logo', 'loftloader'),
												'options' => array(
													'removeButton' => true
												),
												'extra' => array(
													'wrapperClass' => 'preloader_animation preloader_animation-pl-frame preloader_animation-pl-imgloading'
												)
											),
											array(
												'name'    => 'animation[width]',
												'type'    => 'number',
												'title'   => esc_html__('Custom image width - optional (if provided, the value should be between 1 - 400)', 'loftloader'),
												'options' => array(),
												'extra' => array(
													'wrapperClass' => 'preloader_animation preloader_animation-pl-imgloading preloader-custom-image-width'
												)
											)
										)
									)
								)
							)
						)
					)
				)
			)
		));
	}
	add_filter('loftloader_settings_default_value', 'loftloader_settings_default_value');
    /**
     * @description hook callback function to set the default value of loftloader settings
     * @param array $settings
     * @return array merge values to the array passed by
     */
	function loftloader_settings_default_value($settings){
		return array_merge((array)$settings, array(
			'enable' => 'on',
			'homepage' => '',
			'settings'         => array(
				'background'   => array(
					'effect'   => 'fade',
					'color'    => '#000000',
					'opacity'  => '95%'
				),
				'animation' => array(
					'type'  => 'pl-sun',
					'color' => '#248acc',
					'image' => array(
						'url' => LOFTLOADER_URI . 'img/loftloader-logo.png',
						'id'  => ''
					),
					'width' => '76'
				)
			)
		));
	}
}

if(!class_exists('LoftLoader_Setting_Manager')){
    /**
     * LoftLoader settings manager class
     *   
     * @since LoftLoader version 1.0
     */
	require_once LOFTLOADER_ROOT . 'settings/form/class-loftloader-form-base.php';
	require_once LOFTLOADER_ROOT . 'settings/form/class-loftloader-checkbox.php';
	require_once LOFTLOADER_ROOT . 'settings/form/class-loftloader-preview.php';
	class LoftLoader_Setting_Manager {
		public $section_id; // Section unique id
		protected $section_title; // Section title
		protected $extra_info; // Other arguments needed when registered the sections
		public function __construct(){
			$this->section_id = 'loftloader-custom-settings';
			$this->section_title = esc_html__('LoftLoader Settings', 'loftloader');
		}
		/**
		 * @description render setting section content
		 */
		public function render_settings_section(){
			// Register the section
			echo '<h1 class="loftloader-option-section-title">' . $this->section_title . '</h1>';
			$fields  = apply_filters('loftloader_settings_fields', array()); // Get all fields of current section
			if($fields && is_array($fields)){
				foreach($fields as $field){
					echo (isset($field['args']['nowrap']) && $field['args']['nowrap']) ? '' : '<div class="setting-group">';
					echo empty ($field['title']) ? '' : '<h3>' . $field['title'] . '</h3>';
					$this->render_settings_field(array('admin' => $field['args'], 'form' => $field['content']));
					echo (isset($field['args']['nowrap']) && $field['args']['nowrap']) ? '' : '</div>';
				}
			}
			$this->settings_fields(); // Show the hidden fields
		}
		/**
		 * @description output the form elements of each fields registered
		 */
		private function render_settings_field($args){
			$default = apply_filters('loftloader_settings_default_value', array());
			$default = isset($default) ? $default : array();
			$values  = get_option($this->section_id, $default);
			$inList  = !empty($args['admin']['nolist']) ? false : true; // Wrap the output html in ul list or not

			echo $inList ? '<ul class="form-list">' : '';
			foreach($args['form'] as $element){ // Output each form elements
				if(!empty($element)){
					$class = 'LoftLoader_' . $element['type']; // Get class name of element type
					// Get the value and name of each element
					if(strpos($element['name'], '[') !== false){
						$subs  = strtr($element['name'], array(']' => '', '[' => ']['));
						$name  = $this->section_id . '[' . $subs . ']'; // Name of each form element
						$value = $values;
						foreach(explode('][', $subs) as $sub){
							$value = !empty($value[$sub]) ? $value[$sub] : '';
						}
					}
					else{
						$name  = $this->section_id . '[' . $element['name'] . ']'; // Name of each form element
						$value = !empty($values[$element['name']]) ? $values[$element['name']] : ''; // Value of each element
					}
					$extra    = isset($element['extra']) ? $element['extra'] : array(); // Any extra arguments
					$options  = isset($element['options']) ? $element['options'] : array(); // Options for some form elements, like checkbox/radio/select
					$newField = new $class($name, $element['title'], $element['description'], $options, $value, $extra); // Instantiate the element
					echo $inList ? '<li>' : '';
					$newField->render(); // Output the element
					echo $inList ? '</li>' : '';
				}
			}
			echo $inList ? '</ul>' : '';
		}
		/*
		 * @description show the hidden input
		 */
		private function settings_fields(){
			$page = $this->section_id;
			echo "<input type='hidden' name='option_page' value='" . $page . "' />";
			echo '<input type="hidden" name="action" value="update" />';
			wp_nonce_field("$page-options");
		}
		/**
		* @description register setting for saving custom settings
		*/
		public function register_setting(){
			global $new_whitelist_options;
			$option_group = $option_name = $this->section_id;
			$new_whitelist_options[$option_group][] = $option_name;
			add_filter("sanitize_option_{$option_name}", array($this, 'save_custom_styles'));
		}
		/**
		* @description save the custom styles from the custom plugin settings
		*/
		public function save_custom_styles($args){
			$css = '';
			if(isset($args['enable']) && ($args['enable'] === 'on')){
				$color = $args['settings']['animation']['color'];
				$bgColor = $args['settings']['background']['color'];
				$bgOpacity = intval($args['settings']['background']['opacity']) / 100;
				$css .= '#loftloader-wrapper .loader-section {' . PHP_EOL . "\t" . 'background: ' . $bgColor . ';' . PHP_EOL . "\t" . 'opacity: ' . $bgOpacity . ';' . PHP_EOL . '}' . PHP_EOL;
				switch($args['settings']['animation']['type']){
					case 'pl-sun':
						$css .= '#loftloader-wrapper.pl-sun #loader span,' . PHP_EOL . '#loftloader-wrapper.pl-sun #loader span:before {' . PHP_EOL . "\t" . 'background: ' . $color . ';' . PHP_EOL . '}' . PHP_EOL;
						break;
					case 'pl-circles':
						$css .= '#loftloader-wrapper.pl-circles #loader span,' . PHP_EOL . '#loftloader-wrapper.pl-circles #loader:before,' . PHP_EOL . '#loftloader-wrapper.pl-circles #loader:after {' . PHP_EOL . "\t" . 'background: ' . $color . ';' . PHP_EOL . '}' . PHP_EOL;
						break;
					case 'pl-wave':
						$css .= '#loftloader-wrapper.pl-wave #loader span,' . PHP_EOL . '#loftloader-wrapper.pl-wave #loader:before,' . PHP_EOL . '#loftloader-wrapper.pl-wave #loader:after {' . PHP_EOL . "\t" . 'background: ' . $color . ';' . PHP_EOL . '}' . PHP_EOL;
						break;
					case 'pl-square':
						$css .= '#loftloader-wrapper.pl-square #loader span {' . PHP_EOL . "\t" . 'border: 4px solid ' . $color . ';' . PHP_EOL . '}' . PHP_EOL;
						break;
					case 'pl-frame':
						$css .= '#loftloader-wrapper.pl-frame #loader:before,' . PHP_EOL . '#loftloader-wrapper.pl-frame #loader:after,' . PHP_EOL . '#loftloader-wrapper.pl-frame #loader span:before,' . PHP_EOL . '#loftloader-wrapper.pl-frame #loader span:after {' . PHP_EOL . "\t" . 'background-color: ' . $color . ';' . PHP_EOL . '}' . PHP_EOL;
						break;
					case 'pl-imgloading':
						$css .= empty($args['settings']['animation']['width']) ? '' : '#loftloader-wrapper.pl-imgloading #loader {' . PHP_EOL . "\t" . 'width: ' . $args['settings']['animation']['width'] . 'px;' . PHP_EOL . '}' . PHP_EOL;
						$css .= '#loftloader-wrapper.pl-imgloading #loader span {' . PHP_EOL . "\t" . 'background-size: cover;' . PHP_EOL . "\t" . 'background-image: url(' . $args['settings']['animation']['image']['url'] . ');' . PHP_EOL . '}' . PHP_EOL;
						break;
				}
			}
			update_option('loftloader-custom-styles', $css);
			return $args;
		}
		/**
		* @description reset loader setting and custom styles
		*/
		public function reset_settings(){
			delete_option('loftloader-custom-styles');
			delete_option('loftloader-custom-settings');
		}
	}
}