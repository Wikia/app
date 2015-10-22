<?php
/**
 * Mock service class for TemplateClassification
 */

class TemplateClassificationMockService extends WikiaService {

	/**
	 * @param int $articleId
	 * @return string
	 */
	public function getTemplateType( $articleId ) {
		if ( empty( $articleId ) ) {
			return '';
		}
		/* Use cache to have consistent results for same pages due to randomization */
		$type = WikiaDataAccess::cache(
			wfMemcKey( 'template-classification-type-for-page', $articleId ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$types = array_diff(
					TemplateClassification::$templateTypes,
					[ TemplateClassification::TEMPLATE_UNCLASSIFIED ]
				);
				$types = array_merge( $types, [''] );
				return $types[ array_rand( $types ) ];
			}
		);
		return $type;
	}

	public function setTemplateType($articleId, $templateType) {

	}
}
