<?php

class TemplatesApiController extends WikiaApiController {

	private static $TEMPLATES_BLACKLIST = [
		'!',
		'!!',
	];
	private static $templates = [];

	/**
	 * Register templates names and parameters as we parse the article
	 *
	 * @param PPFrame_DOM $frame
	 * @param Title $title
	 * @param DOMElement[] $numberedArgs
	 * @param DOMElement[] $namedArgs
	 * @throws \Swagger\Client\ApiException
	 */
	static function onPreprocessorDOMNewTemplateFrame(
		PPFrame_DOM $frame, Title $title, array $numberedArgs, array $namedArgs
	) {
		global $wgCityId;

		// skip blacklisted templates, e.g. ! or !!
		if ( in_array( $title->getText(), self::$TEMPLATES_BLACKLIST ) ) {
			return;
		}

		// skip templates without names arguments
		if ( empty( $namedArgs ) ) {
			return;
		}

		// collect template's parameters
		$parameters = [];
		foreach($namedArgs as $name => $argData) {
			$parameters[ $name ] = $argData->textContent;
		}

		$templateClassification = new TemplateClassificationService();

		self::$templates[] = [
			'name' => $title->getText(),
			'id' => $title->getArticleID(),
			'type' => $templateClassification->getType( $wgCityId, $title->getArticleID() ),
			'parameters' => $parameters,
		];
	}

	/**
	 * Returns metadata for all templates used on a specified article.
	 *
	 * CORE-20: this is an experimental API that can change in the near future
	 *
	 * @throws WikiaHttpException
	 * @throws \Swagger\Client\ApiException
	 */
	public function getMetadata() {
		$pageid = $this->getRequiredParam( 'pageid' );
		$title = Title::newFromID( $pageid );

		if ( !$title || !$title->exists() ) {
			throw new NotFoundApiException();
		}

		// register a hook that will collect templates metadata
		self::$templates = [];
		Hooks::register(
			'PreprocessorDOMNewTemplateFrame',
			[ $this, 'onPreprocessorDOMNewTemplateFrame' ]
		);

		// parse an article to get the list of all templates
		$parser = new Parser();
		$opts = ParserOptions::newFromContext( $this->getContext() );
		$out = $parser->parse(
			Article::newFromTitle( $title , $this->getContext())->getContent(),
			$title, $opts
		);

		$response = [
			'title' => $title->getPrefixedText(),
			'templates' => self::$templates,
			'categories' => array_keys( $out->getCategories() )
		];

		$this->setResponseData( $response );
	}
}
