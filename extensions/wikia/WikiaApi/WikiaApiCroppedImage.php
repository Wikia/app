<?php
/*
 * Author: Jakub Kurcek
 * Needs ImageServing extension to be usable.
 */

if (!defined('MEDIAWIKI')) {
	die();
}

class WikiaApiCroppedImage extends ApiBase {

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action, 'img' );
	}

	public function execute() {
		global $wgRequest;

		$imgId = $imgSize = null;
		
		extract( $this->extractRequestParams() );
		
		wfProfileIn(__METHOD__);
		$test = new imageServing( array( $Id ), $Size);
		foreach ( $test->getImages( 1 ) as $key => $value ){
			$imageUrl = $value[0]['url'];
		}
		$result = $this->getResult();
		$result->addValue( 'image', $this->getModuleName(), $imageUrl );
		wfProfileOut(__METHOD__);
	}

	public function getAllowedParams() {
		return array (
			'Id' => array(
				ApiBase :: PARAM_TYPE => "integer",
				ApiBase :: PARAM_MIN => 0,
			),
			'Size' => array(
				ApiBase :: PARAM_TYPE => "integer",
				ApiBase :: PARAM_MIN => 0,
			)
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiCroppedImage.php jakub';
	}

	public function getParamDescription()
	{
		return array
		(
			'Id'	=> 'article Id (integer)',
			'Size'	=> 'size of cropped image (integer)',
		);
	}

	public function getDescription()
	{
		return array
		(
			" This module is used to return one cropped image from specified article \n ".
			" No example because article id is specific for every wikia ",
		);
	}

}
?>
