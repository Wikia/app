<?php

class RadioField extends BaseField
{
	const TYPE = 'radio';
	const PROPERTY_CHOICES = 'choices';

	protected function getType() {
		return self::TYPE;
	}
	
	public function __construct($options = []) {
		parent::__construct($options);
		
		if( isset($options['choices']) ) {
			$this->setProperty(self::PROPERTY_CHOICES, $options['choices']);
		}
	}
	
	public function render($attributes = []) {
		$data = [];
		$data['type'] = $this->getType();
		$choices = $this->getChoices();
		$choices = ( empty($choices) ) ? [$this->getValue()] : $this->getChoices();
		
		$out = '';

		$labelMessage = $this->getProperty(self::PROPERTY_LABEL);
		if( $labelMessage instanceof Message) {
			$label = new Label($labelMessage);
			$out .= $label->render();
		}
		
		foreach($choices as $choice) {
			if( !empty($choice['label']) ) {
				$label = new Label($choice['label']);
				$out .= $label->render();
			}
			
			$data['value'] = $choice['value'];
			
			$out .= $this->renderInternal(__CLASS__, $attributes, $data);
		}
		
		return $out;
	}
	
	protected function getChoices() {
		return $this->getProperty(self::PROPERTY_CHOICES);
	}
}
