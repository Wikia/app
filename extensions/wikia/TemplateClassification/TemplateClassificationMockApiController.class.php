<?php
/**
 * TemplateClassificationMockApiController is just for mocking data from the real service.
 *
 * Will be removed once the service is deployed.
 */

class TemplateClassificationMockApiController extends WikiaApiController {
	const TYPE_FIELD = 'type';

	public function getTemplateType( $articleId ) {
		$articleId = $this->request->getInt( 'articleId' );
		/* Use cache to have consistent results for same pages due to randomization */
		$type = WikiaDataAccess::cache(
			wfMemcKey( 'template-classification-type-for-page', $articleId ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$rand = array_rand( TemplateClassification::$templateTypes );
				return TemplateClassification::$templateTypes[$rand];
			}
		);
		$this->response->setVal( self::TYPE_FIELD, $type );
	}
}
