<?php

/**
 * Class provides methods to retrieve a list of templates defined as recognized
 * Also provides possibility to restrict list of templates to those used only on pages within certain namespaces
 * (both directly and indirectly)
 * e.g. wgContentNamespaces
 */

class RecognizedTemplatesProvider {
	const ERROR_MESSAGE = 'ExternalTemplatesProviderError';

	private $tcs;
	private $wikiId;
	private $namespaces;
	private $namespacesTemplates;

	/**
	 * @param TemplateClassificationService $tcs
	 * @param int $wikiId
	 * @param array $namespaces - allowed namespaces
	 */
	public function __construct( TemplateClassificationService $tcs, $wikiId, $namespaces = [] ) {
		$this->tcs = $tcs;
		$this->wikiId = $wikiId;
		$this->namespaces = $namespaces;
	}

	/**
	 * Get recognized templates on wiki from given namespaces (if set)
	 *
	 * @return array
	 */
	public function getRecognizedTemplates() {
		$recognizedTemplates = $this->getRecognizedTemplatesFromService();
		return array_intersect_key( $recognizedTemplates, $this->getNamespacesTemplates() );
	}

	/**
	 * Get unrecognized templates on wiki from given namespaces (if set)
	 *
	 * @return array
	 */
	public function getNotRecognizedTemplates() {
		$recognizedTemplates = $this->getRecognizedTemplatesFromService();
		return array_diff_key( $this->getNamespacesTemplates(), $recognizedTemplates );
	}

	/**
	 * Check if given type is unrecognized
	 *
	 * @param String $type
	 * @return bool
	 */
	public static function isUnrecognized( $type ) {
		return in_array( $type, [
			TemplateClassificationService::TEMPLATE_UNKNOWN,
			TemplateClassificationService::TEMPLATE_UNCLASSIFIED,
			TemplateClassificationService::TEMPLATE_OTHER,
			TemplateClassificationService::TEMPLATE_DIRECTLY_USED,
		] );
	}

	/**
	 * Get all templates from given namespaces
	 *
	 * @return array|bool|mixed
	 * @throws Exception
	 * @throws \FluentSql\Exception\SqlException
	 */
	public function getNamespacesTemplates() {
		if ( isset( $this->namespacesTemplates ) ) {
			return $this->namespacesTemplates;
		}

		$sql = ( new \WikiaSQL() )
			->SELECT()->DISTINCT( 'p2.page_id as temp_id' )
			->FROM( 'page' )->AS_( 'p' )
			->INNER_JOIN( 'templatelinks' )->AS_( 't' )
			->ON( 't.tl_from', 'p.page_id' )
			->INNER_JOIN( 'page' )->AS_( 'p2' )
			->ON( 'p2.page_title', 't.tl_title' )
			->WHERE( 'p2.page_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->AND_( 'p.page_id' )->NOT_EQUAL_TO( Title::newMainPage()->getArticleID() );
		if ( !empty( $this->namespaces ) ) {
			$sql->AND_( 'p.page_namespace' )->IN( $this->namespaces );
		}

		$this->namespacesTemplates = $sql->runLoop( $this->getDB(), function ( &$pages, $row ) {
			$pages[$row->temp_id] = $row->temp_id;
		} );

		return $this->namespacesTemplates;
	}

	private function getRecognizedTemplatesFromService() {
		$classifiedTemplates = $this->getClassifiedTemplates();
		return $this->unsetUnrecognized( $classifiedTemplates );
	}

	private function unsetUnrecognized( $classifiedTemplates ) {
		foreach ( $classifiedTemplates as $pageId => $type ) {
			if ( self::isUnrecognized( $type ) ) {
				unset( $classifiedTemplates[$pageId] );
			}
		}
		// Now it's recognizedTemplates
		return $classifiedTemplates;
	}

	/**
	 * Get all classified templates
	 * @return array
	 */
	private function getClassifiedTemplates() {
		try {
			$templates = $this->tcs->getTemplatesOnWiki( $this->wikiId );
		} catch ( \Swagger\Client\ApiException $exception ) {
			$context = [ 'TCSApiException' => $exception ];
			$this->handleException( $context );
			return [];
		}
		return $templates;
	}

	private function getDB() {
		$wikiaDBName = WikiFactory::IDtoDB( $this->wikiId );
		return wfGetDB( DB_SLAVE, [], $wikiaDBName );
	}

	/**
	 * @desc handle exceptions
	 *
	 * @param array $context
	 */
	private function handleException( $context ) {
		\Wikia\Logger\WikiaLogger::instance()->error( self::ERROR_MESSAGE, $context );
	}
}
