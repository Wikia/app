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
	private $wikiaId;

	function __construct( TemplateClassificationService $tcs, $wikiaId ) {
		$this->tcs = $tcs;
		$this->wikiaId = $wikiaId;
	}

	public function getRecognizedTemplatesUsedOnNamespaces( $namespaces ) {
		$recognizedTemplates = $this->getTemplates( true );
		if ( !$namespaces ) {
			return $recognizedTemplates;
		}
		$namespacesTemplates = $this->getNamespacesTemplates( $this->getDB(), $namespaces );
		return $this->intersectSets( $namespacesTemplates, $recognizedTemplates );
	}

	public function getNotRecognizedTemplatesUsedOnNamespaces( $namespaces ) {
		$notRecognizedTemplates = $this->getTemplates( false );
		if ( !$namespaces ) {
			return $notRecognizedTemplates;
		}
		$namespacesTemplates = $this->getNamespacesTemplates( $this->getDB(), $namespaces );
		return $this->intersectSets( $namespacesTemplates, $notRecognizedTemplates );
	}

	public function isRecognized( $type ) {
		return $type !== TemplateClassificationService::TEMPLATE_UNKNOWN
		&& $type !== AutomaticTemplateTypes::TEMPLATE_UNCLASSIFIED
		&& $type !== AutomaticTemplateTypes::TEMPLATE_OTHER;
	}

	private function getTemplates( $getRecognized = true ) {
		try {
			$templates = $this->tcs->getTemplatesOnWiki( $this->wikiaId );
		} catch ( \Swagger\Client\ApiException $exception ) {
			$context = [ 'TCSApiException' => $exception ];
			$this->handleException( $context );
			return [];
		}
		foreach ( $templates as $pageId => $type ) {
			$isRecognized = $this->isRecognized( $type );
			$shouldRemove = $getRecognized ? !$isRecognized : $isRecognized;
			if ( $shouldRemove ) {
				unset( $templates[$pageId] );
			}
		}
		return $templates;
	}

	private function getNamespacesTemplates( $db, $namespaces ) {
		$sql = ( new \WikiaSQL() )
			->SELECT()->DISTINCT( 'p2.page_id as temp_id' )
			->FROM( 'page' )->AS_( 'p' )
			->INNER_JOIN( 'templatelinks' )->AS_( 't' )
			->ON( 't.tl_from', 'p.page_id' )
			->INNER_JOIN( 'page' )->AS_( 'p2' )
			->ON( 'p2.page_title', 't.tl_title' )
			->WHERE( 'p.page_namespace' )->IN( $namespaces )
			->AND_( 'p2.page_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->AND_( 'p.page_id' )->NOT_EQUAL_TO( Title::newMainPage()->getArticleID() );

		$pages = $sql->runLoop( $db, function ( &$pages, $row ) {
			$pages[] = $row->temp_id;
		} );

		return $pages;
	}

	/**
	 * Remove templates from second set that doesn't exist in first set
	 */
	private function intersectSets( $namespacesTemplates, $recognizedTemplates ) {
		$namespacesRecognizedTemplates = [];
		foreach ( $recognizedTemplates as $pageId => $type ) {
			if ( in_array( $pageId, $namespacesTemplates ) ) {
				$namespacesRecognizedTemplates[] = $pageId;
			}
		}
		return $namespacesRecognizedTemplates;
	}

	private function getDB() {
		$wikiaDBName = WikiFactory::IDtoDB( $this->wikiaId );
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
