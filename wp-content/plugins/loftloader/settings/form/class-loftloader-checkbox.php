<?php
// Not allowed by directly accessing.
if(!defined('ABSPATH')){
	die('Access not allowed!');
}
/**
 * Plugin option form element class 
 *   Type Checkbox
 * 
 * @package   LoftLoader
 * @version   1.0
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team

 * @since version 1.0
 */

if(!class_exists('LoftLoader_Checkbox')){
	class LoftLoader_Checkbox extends LoftLoader_Form_Base{
		/**
		 * @description rewrite the content function
		 */
		protected function content(){
			$html = '';
			if($this->options){
				$value = $this->values;
				$class = '';
				$id	= '';
				if(count($this->options) == 1){
					$class = (isset($this->extra['class']) && $this->extra['class'])? ' class="' . $this->extra['class'] . '"' : '';
					$id	= (isset($this->extra['id'])	&& $this->extra['id'])   ? ' id="'. $this->extra['id'] . '"'		: '';
				}
				foreach($this->options as $val=>$attr){
					$checked  = checked($value, $val, false);
					$disabled = (isset($attr['disabled']) && $attr['disabled']) ? ' disabled' : '';
					$html .= '<label><input' . $id . $class . ' type="checkbox" name="' . $this->name . '" value="' . $val . '"' . $checked . $disabled . '>' . $attr['label'] . '<div class="on-off"><span></span></div></label>';
				}
			}
			return $html;
		}
	}
}