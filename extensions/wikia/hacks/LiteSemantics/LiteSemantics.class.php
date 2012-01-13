<?php

class LiteSemanticsParser {

	static protected $instance = null;
	protected $sText = '';
	protected $aData = array();

	protected function __construct() {

	}

	protected function __clone() {

	}

	static public function getInstance() {
		if (self::$instance == null) {
			self::$instance = new LiteSemanticsParser;
		}
		return self::$instance;
	}

	function parse( $sText ){
		$this->setText( $sText );
		$this->parseData();
		return $this->getResults();
	}

	protected function insertData( $sText, $iOffset ) {
		
		$oData = F::build(
			'LiteSemanticsData',
			array(
				$this->getDataText( $sText ),
				$iOffset,
				$this->getDataName( $sText )
			)
		);

		$this->insertProperties( $oData, $sText );

		if ( $oData->isValid() ){
			$this->aData[ $iOffset ] = $oData;
		}
	}

	protected function insertProperties( $oData, $sDataText ){
		preg_match_all(
			'/<prop.*>(.|\n)*<\/.*prop.*>/iU',
			$sDataText,
			$aPregResults
		);

		if ( !isset( $aPregResults[0] ) ){
			return false;
		}

		foreach( $aPregResults[0] as $aDataResult ){
			$oRes = simplexml_load_string( $aDataResult );
			if (	!isset( $oRes['name'] ) ||
				!isset( $oRes['name'][0] ) || 
				empty( $oRes['name'][0] )
			){
				break;
			}
			$sMeaning = $oRes['name']['0'];
			$sValue = preg_replace( '/<(\/|)(prop|data)[^>]*>/iU', '', $aDataResult );
			$oData->addProperty( $sMeaning, $sValue );
		}
	}

	protected function getDataText( $sText ){
		return preg_replace( '/<(\/|)(data|prop)[^>]*>/iU', '', $sText );
	}

	protected function getDataName( $sText ){
		preg_match( '/<data.*(name)=("[^"]*")>/iU', $sText, $result );
		return isset( $result[2] ) ? $result[2] : false;
	}

	protected function setText($sText) {
		$this->sText = $sText;
	}

	protected function parseData() {
		preg_match_all(
			'/<data.*>(.|\n)*<\/.*data.*>/iU',
			$this->sText,
			$aPregResults,
			PREG_OFFSET_CAPTURE
		);

		if ( !isset( $aPregResults[0] ) ){
			return false;
		}

		foreach( $aPregResults[0] as $aDataResult ){
			$this->insertData( $aDataResult[0], $aDataResult[1] );
		}
	}

	protected function getResults() {
		return $this->aData;
	}

}

class LiteSemanticsData {

	protected $sText = '';
	protected $sName = '';
	protected $aProperties = array();
	protected $iOffset = false;

	function __construct($sText, $iOffset, $sName = '') {
		$this->sText = $sText;
		$this->sName = $sName;
	}

	function addProperty($sMeaning, $mValue) {
		$aProperties[] = F::build('LiteSemanticsProperty', array($sMeaning, $mValue));
	}

	function fitsPattern($oPattern) {
		if ($oPattern instanceof LiteSemanticsParserPattern) {
			/* some logic here */
		}
		return false;
	}

	function isValid(){
		return true;
	}
}

class LiteSemanticsProperty {

	var $sMeaning = '';
	var $mValue = '';

	function __construct($sMeaning, $mValue) {
		$this->sMeaning = $sMeaning;
		$this->mValue = $mValue;
	}
}

class LiteSemanticsParserPattern {
	
}