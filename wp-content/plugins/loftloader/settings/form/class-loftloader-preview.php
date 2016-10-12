<?php
// Not allowed by directly accessing.
if(!defined('ABSPATH')){
	die('Access not allowed!');
}
/**
 * Plugin option form element class 
 *   Type Preloader_Preview, actually this includes a set of settings and a preview for these settings
 * 
 * @package   LoftLoader
 * @version   1.0
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team

 * @since version 1.0
 */

if(!class_exists('LoftLoader_Preloader_Preview')){
	class LoftLoader_Preloader_Preview extends LoftLoader_Form_Base{
		private $preview; // Section preview
		private $setting; // Section setting
		public function __construct($name, $title, $description, $options, $values, $extra = array()){
			parent::__construct($name, $title, $description, $options, $values, $extra);
			// Assign the setting for each section
			foreach($options as $section){
				switch($section['section']){
					case 'preview':
						$this->preview = $section;
						break;
					case 'setting':
						$this->setting = $section;
						break;
				}
			}
		}
		/**
		 * @description rewrite the render function
		 */
		public function render(){
			if(!empty($this->preview) && !empty($this->setting)){
				$replace  = array(
								'[[PREVIEW-TITLE]]'       => $this->preview_title(),
								'[[PREVIEW-DESCRIPTION]]' => $this->preview_description(),
								'[[PREVIEW-CONTENT]]'     => $this->preview_content(),
								'[[SETTING-CONTENT]]'     => $this->setting_content()
							);
				echo strtr($this->template(), $replace);
			}
		}
		/**
		 * @description rewrite the html template function
		 */
		protected function template(){
			$html = <<<ETO
						<div class="preview-section">
							<div class="preview-wrapper"><h3>[[PREVIEW-TITLE]]</h3>[[PREVIEW-DESCRIPTION]][[PREVIEW-CONTENT]]</div>
							<div class="preview-settings">[[SETTING-CONTENT]]</div>
						</div>
ETO;
			return $html;
		}
		/**
		 * @description add new function to get the preview title
		 */
		protected function preview_title(){
			return $this->get_property($this->preview, 'title');
		}
		/**
		 * @description add new function to get the preview description
		 */
		protected function preview_description(){
			$description = $this->get_property($this->preview, 'description');
			if($description){
				return '<span class="description">' . $description . '</span>';
			}
		}
		/**
		 * @description add new function to get the preview content
		 */
		protected function preview_content(){
			$html  = '<div class="preview-frame">';
			$html .= '<div id="loftloader-wrapper">';
			$html .= '<div class="loader-inner"><div id="loader"><span></span></div></div>';
			$html .= '<div class="loader-section section-up"></div>';
			$html .= '<div class="loader-section section-down"></div>';
			$html .= '</div>';
			$html .= '</div>';
			return $html;
		}
		/**
		 * @description add new function to get the settings content
		 */
		protected function setting_content(){
			$html = '';
			if(!empty($this->setting)){
				foreach((array)$this->setting['content'] as $item){
					$returnHTML = $this->setting_section_html($item['content']);
					if(!empty($returnHTML)){
						$html .= '<div class="setting-group">';
						$html .= '<h3>' . $item['title'] . '</h3>';
						$html .= '<ul>' . $returnHTML . '</ul>';
						$html .= '</div>';
					} 
				}
			}
			return $html;
		}
		/**
		 * @description add new function to get the settings elements html
		 */
		protected function setting_section_html($section){
			$html = '';
			$values = $this->values;
			foreach((array)$section as $element){
				$elementHTML = '';
				if(strpos($element['name'], '[') !== false){
					$subs  = (strpos($element['name'], '[') !== false) ? strtr($element['name'], array(']' => '', '[' => '][')) : $element['name'];
					$name  = $this->name . '[' . $subs . ']'; // Name of the element
					$value = $values;
					foreach(explode('][', $subs) as $sub){
						$value = $value[$sub];
					}
				}
				else{
					$name  = $this->name . '[' . $element['name'] . ']'; // Element name
					$value = $values[$element['name']]; // Element value
				}
				$value = is_array($value) ? $value : trim($value);
				switch($element['type']){
					case 'number':
						$elementHTML .= '<input type=number name="' . $name . '" value="' . $value . '" min=1 max=400 title="Number between 1-400"> px';
						break;
					case 'select':
						if(is_array($element['options']) && (count($element['options']) > 0)){
							$class		= (isset($element['extra']) && isset($element['extra']['class']) && $element['extra']['class']) ? ' class="' . $element['extra']['class'] . '"' : '';
							$id		   = (isset($element['extra']) && isset($element['extra']['id']) && $element['extra']['id'])	   ? ' id="' . $element['extra']['id'] . '"'	   : '';
							$elementHTML  = '<select name="' . $name . '"'. $class . $id .'>';
							foreach((array)$element['options'] as $val => $attr){
								$selected	 = selected($value, $val, false);
								$elementHTML .= '<option value="' . $val . '"' . $selected . '>' . $attr['label'] . '</option>';
							}
							$elementHTML .= '</select>';
						}
						break;
					case 'color-picker':
						$id		  = (isset($element['extra']) && isset($element['extra']['id']) && $element['extra']['id']) ? ' id="' . $element['extra']['id'] . '"' : '';
						$value	   = !empty($value) ? $value : $element['options']['defaultValue'];
						$value	   = !empty($value) ? $value : '#222222';
						$elementHTML =  '<input' . $id . ' class="loader-color-picker" type="text" name="' . $name . '" value="' . $value . '" data-default-color="' . $value . '" />';
						break;
					case 'media':
						$val = array_filter($value);
						if(!empty($val)){
							$elementHTML  = '<div class="bg-img-holder"><img src="' . $value['url'] . '"></div>';
							$elementHTML .= '<a class="button loader-set-image hide">' . esc_html__('Upload Image', 'loftloader') . '</a>';
							$elementHTML .= '<span class="bg-img-remove">' . esc_html__('Remove Image', 'loftloader') . '</span>';
							$elementHTML .= '<input class="admin-image-id" type="hidden" value="' . ($value['id'] ? $value['id']: '') . '" name="' . $name . '[id]">';
							$elementHTML .= '<input class="admin-image-url preloader-preview-image" type="hidden" value="' . ($value['url'] ? $value['url'] : '') . '" name="' . $name . '[url]">';
						}
						else{
							$elementHTML  = '<a class="button loader-set-image">' . esc_html__('Upload Image', 'loftloader') . '</a>';
							$elementHTML .= '<span class="bg-img-remove hide">' . esc_html__('Remove Image', 'loftloader') . '</span>';
							$elementHTML .= '<input class="admin-image-id" type="hidden" name="' . $name . '[id]">';
							$elementHTML .= '<input class="admin-image-url preloader-preview-image" type="hidden" name="' . $name . '[url]">';
						} 
						break;
					case 'slider':
						$class		= (isset($element['extra']) && isset($element['extra']['class']) && $element['extra']['class'])	 ? ' ' . $element['extra']['class'] : '';
						$value		= !empty($value) ? $value : $element['options']['default'];
						$value		= !empty($value) ? $value : '100';
						$min		  = (isset($element['options']) && isset($element['options']['min']) && $element['options']['min'])   ? $element['options']['min']	   : 0;
						$max		  = (isset($element['options']) && isset($element['options']['max']) && $element['options']['max'])   ? $element['options']['max']	   : 100;
						$step		 = (isset($element['options']) && isset($element['options']['step']) && $element['options']['step']) ? $element['options']['step']	  : 5;
						$elementHTML .= '<label class="amount opacity">';
						$elementHTML .= '<input name="' . $name . '" type="text" class="opacity-amount" readonly value="' . $value . '">';
						$elementHTML .= '</label>';
						$elementHTML .= '<div class="ui-slider loader-ui-slider' . $class . '" data-default="' . intval($value) . '" data-min="' . $min . '" data-max="' . $max . '" data-step="' . $step . '"></div>';
						$elementHTML .= '</fieldset>';
						break;
				}
				$wrapperClass = (isset($element['extra']) && isset($element['extra']['wrapperClass']) && $element['extra']['wrapperClass']) ? $element['extra']['wrapperClass'] : '';
				$template = $this->element_template($wrapperClass);
				$replace  = array('[[TITLE]]' => $element['title'], '[[CONTENT]]' => $elementHTML);
				$html    .= strtr($template, $replace);
			}
			return !empty($html) ? $html : false;
		}
		/**
		 * @description the element template
		 */ 
		private function element_template($class){
			$class = !empty($class) ? ' class="' . $class . '"' : '';
			$html  = <<<ETO
						<li$class>
							<h4>[[TITLE]]</h4>
							<fieldset><legend class="screen-reader-text"><span>[[TITLE]]</span></legend>[[CONTENT]]</fieldset>
						</li>	
ETO;
			return $html;
		}
		/**
		 * @description helper function to get the element from array provided
		 */
		private function get_property($var, $index){
			if(isset($var[$index])){
				return $var[$index];
			}
			return false;
		}
	}
}