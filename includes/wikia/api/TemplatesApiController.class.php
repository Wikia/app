<?php

class TemplatesApiController extends WikiaApiController {

	/**
	 * Returns metadata for all templates used on a specified article.
	 *
	 * CORE-20: this is an experimental API that can change in the near future
	 *
	 * @throws InvalidParameterApiException
	 */
	public function getMetadata() {
		$pageid = $this->getRequiredParam( 'pageid' );
		$title = Title::newFromID( $pageid );

		if ( !$title || !$title->exists() ) {
			throw new NotFoundApiException();
		}

		$templates = [];

		// parse an article to get the list of all templates
		$parser = new Parser();
		$opts = ParserOptions::newFromContext( $this->getContext() );
		$out = $parser->parse(
			Article::newFromTitle( $title , $this->getContext())->getContent(),
			$title, $opts
		);

		$templatesInArticle = $out->getTemplates();

		// fetch templates metadata
		if ( array_key_exists( NS_TEMPLATE, $templatesInArticle ) ) {
			$templateClassification = new TemplateClassificationService();

			foreach ( $templatesInArticle[NS_TEMPLATE] as $templateTitle => $templateId ) {
				$templates[] = [
					'name' => $templateTitle,
					'id' => $templateId,
					'type' => $templateClassification->getType( $this->wg->CityId, $templateId )
				];
			}
		}

		# var_dump(__METHOD__, $out->getTemplateIds()); die;

		$response = [
			'title' => $title->getPrefixedText(),
			'templates' => $templates,
			'categories' => array_keys( $out->getCategories() )
		];

		$this->setResponseData( $response );
	}
}
