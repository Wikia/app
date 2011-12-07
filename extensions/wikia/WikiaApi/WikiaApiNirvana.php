<?php
/**
 * WikiaApiNirvana
 *
 * @author Jakub Olek
 *
 */
 
$wgAPIModules['nirvana'] = 'WikiaApiNirvana';

class WikiaApiNirvana extends ApiBase {

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action, '' /* prefix for parameters... so controller becomes $controller (if it were 'nirvana' then 'nirvanaController' would become $nirvanaController) */ );
	}

	/**
	 * See functions below for expected URL params
	 */
	public function execute() {
		global $wgRequest, $wgCacheBuster;
		wfProfileIn(__METHOD__);

		extract( $this->extractRequestParams() );

		// TODO: IMPLEMENT HERE :)
		// TODO: IMPLEMENT HERE :)

		$result = $this->getResult();
		// TODO: REMOVE - JUST AN EXAMPLE
/*		if(empty($imageUrl)){
			$result->addValue( 'image', "error", "No good, representiative image was found for this page." ); // TODO: i18n
		} else {
			$result->addValue( 'image', $this->getModuleName(), $imageUrl );
		}
*/
		wfProfileOut(__METHOD__);
	}
/*
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

	// Examples
	protected function getQueryExamples() {
		return array (
			'api.php?action=nirvana&controller=PhotoPop&method=Play',
			'api.php?action=nirvana&wisTitle=LyricWiki:Community_Portal',
			'api.php?action=nirvana&wisId=90286',
		);
	}
*/
}
