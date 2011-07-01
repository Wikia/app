<?php
/**
 * WikiaApiImageService
 *
 * @author Sean Colombo <sean@wikia-inc.com>
 * @author Jakub Kurcek
 *
 * This API function returns a full-size image URL given the article name.
 *
 * Requires the wikia ImageServing extension.
 *
 * If you have an article id and would like a thumbnail for an article, use
 * WikiaApiCroppedImage instead.
 */

$wgAPIModules['imageserving'] = 'WikiaApiImageServing';

class WikiaApiImageService extends ApiBase {

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action, 'img' );
	}

	/**
	 * See functions below for expected URL params
	 */
	public function execute() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		extract( $this->extractRequestParams() );

		$imageServing = new ImageServing( array( $Id ) );
		foreach ( $imageServing->getImages( 1 ) as $key => $value ){
/*
			$tmpTitle = Title::newFromText( $value[0]['name'], NS_FILE );
			$image = wfFindFile( $tmpTitle );
			$imageInfo = getimagesize( $image->getPath() );
			$imageUrl = wfReplaceImageServer(
				$image->getThumbUrl(
					$imageServing->getCut( $imageInfo[0], $imageInfo[1] )."-".$image->getName()
				)
			);
*/
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
