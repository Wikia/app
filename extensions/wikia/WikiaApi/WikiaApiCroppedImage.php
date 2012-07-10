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

			// BugId:31460 ForeignAPIFile does not support loading metadata from the file itself.
			// Note, that ForeignAPIFile::getPath() is a dommy method and always returns false, so
			// the 'File not found' dieUsage() call in the next if block is inevitable for ForeignAPIFile objects.
			if ($FailOnFileNotFound && false == ( $image instanceof ForeignAPIFile ) ) {
				$image->loadFromFile();  // side effect forces isMissing() check to fail if file really does not exist
			}
			if ( !($image instanceof File && $image->exists() )
				|| $image->isMissing() || $image->mime == 'unknown/unknown'
			) {
				$this->dieUsage( 'File not found', 'filenotfound' );
			}
			$width = $image->getWidth();
			$height = $image->getHeight();
			$imageUrl = $imageServing->getUrl( $image->getName(), $width, $height );
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
			),
			'FailOnFileNotFound' => array(
				ApiBase :: PARAM_TYPE => 'boolean',
				ApiBase :: PARAM_ISMULTI => false,
				ApiBase :: PARAM_DFLT => false,
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
			'Height' => 'image Height used for right cropped image proportions (integer)',
			'FailOnFileNotFound' => 'force API call to fail if image does not exist (boolean)'
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
