<?php
/**
 * This model implements Template Field models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMTemplateFieldModel extends WOMParameterModel {
	protected $m_bindingProperty = null;

	public function __construct( $key = '', $property = null ) {
		parent::__construct( $key );

		$this->m_typeid = WOM_TYPE_TMPL_FIELD;
		$this->m_bindingProperty = $property;
	}

	public function bindProperty( $property ) {
		$this->m_bindingProperty = $property;
	}
}
