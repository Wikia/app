<?php
/**
 * This model implements query printout models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMQueryPrintoutModel extends WikiObjectModel {
	protected $m_property;
	protected $m_label;
	protected $m_aggregation;

	public function __construct( $property, $label = '', $aggregation = '' ) {
		parent::__construct( WOM_TYPE_QUERYPRINTOUT );
		$this->m_property = $property;
		$this->m_label = $label;

		$this->m_aggregation = ( defined( 'SMW_AGGREGATION_VERSION' ) ? $aggregation : '' );
	}

	public function getProperty() {
		return $this->m_property;
	}

	public function getLabel() {
		return $this->m_label;
	}

	public function getAggregation() {
		return $this->m_aggregation;
	}

	public function getWikiText() {
		return '?' . $this->m_property .
			( $this->m_aggregation == '' ? "" : ( '>' . $this->m_aggregation ) ) .
			( $this->m_label == '' ? "" : ( '=' . $this->m_label ) ) . '|';
	}

	public function setXMLAttribute( $key, $value ) {
		if ( $value == '' ) throw new MWException( __METHOD__ . ": value cannot be empty" );

		if ( $key == 'property' ) {
			$this->m_property = $value;
		} elseif ( $key == 'label' ) {
			$this->m_label = $value;
		} elseif ( defined( 'SMW_AGGREGATION_VERSION' ) && $key == 'aggregation' ) {
			$this->m_aggregation = $value;
		} else {
			throw new MWException( __METHOD__ . ": invalid key/value pair: property=property name, label=query label" .
				( defined( 'SMW_AGGREGATION_VERSION' ) ? ", aggregation=agg_type" : "" ) );
		}
	}

	protected function getXMLAttributes() {
		return 'property="' . self::xml_entities( $this->m_property ) . '"' .
			( $this->m_aggregation == '' ? "" : ( ' aggregation="' . self::xml_entities( $this->m_aggregation ) . '"' ) ) .
			( $this->m_label == '' ? "" : ( ' label="' . self::xml_entities( $this->m_label ) . '"' ) );
	}
}
