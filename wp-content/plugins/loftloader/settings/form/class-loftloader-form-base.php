<?php
// Not allowed by directly accessing.
if(!defined('ABSPATH')){
	die('Access not allowed!');
}
/**
 * Plugin option form element class 
 *   The base class of each type of form element
 * 
 * @package   LoftLoader
 * @version   1.0
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team

 * @since version 1.0
 */

if(!class_exists('LoftLoader_Form_Base')){
	abstract class LoftLoader_Form_Base{
		protected $name; // Form element name
		protected $title; // Field title
		protected $description; // Field description
		protected $extra; // Extra arguments, may include the class infos
		protected $options; // Option for some type of form element, radio/select/check
		protected $values; // Form element value
		public function __construct($name, $title, $description, $options, $values, $extra = array()){
			$this->name    = $name;
			$this->title   = $title;
			$this->extra   = $extra;
			$this->values  = $values;
			$this->options = $options;
			$this->description = $description;
		}
		/**
		 * @description show the html of each form element
		 */
		public function render(){
			if($this->options){
				$replace = array('[[TITLE]]' => $this->title, '[[DESCRIPTION]]' => $this->description(), '[[INFO]]' => $this->field_info(), '[[LINKS]]' => $this->links(), '[[CONTENT]]' => $this->content());
				echo strtr($this->template(), $replace);
			}
		}
		/**
		 * @description form element HTML template
		 */
		protected function template(){
			$class = (isset($this->extra['wrapperClass']) && $this->extra['wrapperClass'])? ' ' . $this->extra['wrapperClass'] : '';
			$html  = <<<ETO
						<div class="list-title">
							<h4>[[TITLE]]</h4>
							[[DESCRIPTION]][[INFO]][[LINKS]]
						</div>
						<div class="list-content$class">
							<fieldset><legend class="screen-reader-text"><span>[[TITLE]]</span></legend>[[CONTENT]]</fieldset>
						</div>
ETO;
			return $html;
		}
		/**
		 * @description get field content
		 */
		protected function content(){
			$html	  = '';
			if($this->options){
				foreach($this->options as $val=>$text){
					$checked = ($default_value[$this->name] == $val)?' checked':'';
					$html .= '<label><input type="checkbox" name="' . $this->name . '" value="' . $val . '"' . $checked . '>' . $text['label'] . '</label>';
				}
			}
			return $html;
		}
		/**
		 * @description get field info if any, normally this should be the tips
		 */ 
		protected function field_info(){
			$html  = '';
			if(isset($this->extra['info'])){
				$html .= '<p><i class="fa fa-info-circle"></i> ' . $this->extra['info'] . '</p>';
			}
			return $html;
		}
		/**
		 * @description field description if any
		 */
		protected function description(){
			$html  = '';
			if(isset($this->description) && !empty($this->description)){
				$html .= '<span class="description">' . $this->description . '</span>';
			}
			return $html;
		}
		/**
		 * @description fields links if any
		 */
		protected function links(){
			$html = '';
			if(isset($this->extra['links']) && is_array($this->extra['links'])){
				$html  .= '<ul>';
				foreach($this->extra['links'] as $text=>$link){
					$html .= '<li><a href="' . $link . '">' . $text . '</a></li>';
				}
				$html  .= '</ul>';
			}
			return $html;
		}
	}
}