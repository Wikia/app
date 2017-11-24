<?php
/**
 * WikiaApiImageServing
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

class WikiaApiImageServing extends ApiBase {

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action, 'wis' /* prefix for parameters... so wisTitle becomes $Title */ );
	}

	/**
	 * See functions below for expected URL params
	 */
	public function execute() {
		global $wgRequest, $wgStyleVersion;
		wfProfileIn(__METHOD__);

		extract( $this->extractRequestParams() );

		// Allow optionally using a prefixed-title instead of the page_id.
		if(empty($Id)){
			$title = Title::newFromText( $Title );
			if(is_object($title)){
				$Id = $title->getArticleID();
			}
		}
		
		$article = Article::newFromID( $Id );
		if(is_object($article)){

			// Automatically follow redirects.
			if($article->isRedirect()){
				$title = $article->followRedirect();
				if(is_object($title)){ // if this is not an object, then we're pretty unlikely to get any good image matches, but more likely to get them for the original ID.
					$Id = $title->getArticleID();
				}
			}

			$imageUrl = null;
			$imageServing = new ImageServing( array( $Id ) );
			foreach ( $imageServing->getImages( 1 ) as $key => $value ){
				$imgTitle = Title::newFromText( $value[0]['name'], NS_FILE );
				$imgFile = wfFindFile($imgTitle);
				if(!empty($imgFile)){
					$imageUrl = wfReplaceImageServer( $imgFile->getFullUrl(), $wgStyleVersion );
				}
			}

			$result = $this->getResult();
			if(empty($imageUrl)){
				$result->addValue( 'image', "error", "No good, representiative image was found for this page." ); // TODO: i18n
			} else {
				$result->addValue( 'image', $this->getModuleName(), $imageUrl );
			}
		}
		wfProfileOut(__METHOD__);
	}

	public function getAllowedParams() {
		return array (
			'Id' => array(
				ApiBase :: PARAM_TYPE => "integer",
				ApiBase :: PARAM_MIN => 0,
			),
			'Title' => array(
				ApiBase :: PARAM_TYPE => "string"
			)
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiImageServing.php sean';
	}

	public function getParamDescription()
	{
		return array
		(
			'Id'	=> 'article Id (integer)',
			'Title' => 'article Title (string)',
		);
	}

	public function getDescription()
	{
		return array
		(
			"This module is used to return one image from specified article given either the article id or article title (with prefix if applicable)."
		);
	}

	/**
	 * Examples
	 */
	public function getExamples() {
		return array (
			'api.php?action=imageserving&wisTitle=Cake',
			'api.php?action=imageserving&wisTitle=LyricWiki:Community_Portal',
			'api.php?action=imageserving&wisId=90286',
		);
	}
}
