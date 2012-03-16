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
		parent :: __construct( $main, $action, 'img' /* prefix for parameters... so imgId becomes $Id */ );
	}

	public function execute() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		extract( $this->extractRequestParams() );
		$imageServing = new ImageServing( array( $Id ), $Size, array("w" => $Size, "h" => $Height));
		foreach ( $imageServing->getImages( 1 ) as $key => $value ){
			$tmpTitle = Title::newFromText( $value[0]['name'], NS_FILE );
			$image = wfFindFile( $tmpTitle );
			if ( !($image instanceof File && $image->exists()) ) {
				$this->dieUsage( 'File not found', 'filenotfound' );
			}
			$imageInfo = getimagesize( $image->getPath() );
			$imageUrl = $imageServing->getUrl($image->getName(), $imageInfo[0], $imageInfo[1]);
		}
		$result = $this->getResult();
		$result->addValue( 'image', $this->getModuleName(), $imageUrl );
		$result->addValue( 'imagepage', $this->getModuleName(), $tmpTitle->getFullUrl() );
		
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
			),
			'Height' => array(
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
			'Height' => 'image Height used for right cropped image proportions (integer)'
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
