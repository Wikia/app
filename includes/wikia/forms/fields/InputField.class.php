<?php

class InputField extends BaseField {

	/**
	 * @desc $properties array key name for input field type
	 */
	const PROPERTY_TYPE = 'type';

	/**
	 * @desc $properties array key name for checked attribute
	 */
	const PROPERTY_CHECKED = 'checked';

	/**
	 * @desc Default input field type
	 */
	const DEFAULT_INPUT_FIELD_TYPE = 'text';

	public function __construct( $options = [] ) {
		parent::__construct( $options );

		if( isset( $options['type'] ) ) {
			$this->setProperty( self::PROPERTY_TYPE, $options['type'] );
		}

		// mostly for checkbox and radio buttons
		if( isset( $options['checked'] ) ) {
			$this->setProperty( self::PROPERTY_CHECKED, $options['checked'] );
		}

	}

	protected function getType() {
		$propertiesType = $this->getProperty( self::PROPERTY_TYPE );

		if( !empty( $propertiesType ) ) {
			$result = $propertiesType;
		} else {
			$result = self::DEFAULT_INPUT_FIELD_TYPE;
		}

		return $result;
	}

	/**
	 * @see BaseField::render()
	 */
	public function render($attributes = [], $index = null) {
		$data = [];
		$data['type'] = $this->getType();

		$checked = $this->getProperty( self::PROPERTY_CHECKED );
		if( !empty($checked) ) {
			$attributes['checked'] = $checked;
		}

		return $this->renderInternal(__CLASS__, $attributes, $data, $index);
	}

}
