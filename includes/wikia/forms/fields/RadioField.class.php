<?php

class RadioField extends BaseField
{
	public function __construct($options = []) {
		parent::__construct($options);
		
		if( isset($options['choices']) ) {
			$this->setProperty(self::PROPERTY_CHOICES, $options['choices']);
		}
	}
	
	public function render($attributes = []) {
		$choices = $this->getChoices();
		$choices = ( empty($choices) ) ? [$this->getValue()] : $this->getChoices();

		$out = '';
		$i = 0;
		
		//FIXME: this is hack; we need to think about how to remove it: overwrite renderLabel or other method?
		$this->setProperty(self::PROPERTY_LABEL, null);
		foreach($choices as $choice) {
			if( !empty($choice['label']) ) {
				$out .= $choice['label']->render($this->getId($i));
			}
			
			$data['value'] = $choice['value'];
			$out .= $this->renderInternal(__CLASS__, $attributes, $data, $i);
			$i++;
		}
		
		return $out;
	}

	public function getId($index = null) {
		$out = parent::getId();
		
		if( !is_null($index) ) {
			$out .= '_' . $index;
		}
		
		return $out;
	}
}
