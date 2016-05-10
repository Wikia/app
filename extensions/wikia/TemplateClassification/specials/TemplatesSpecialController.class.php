<?php

class TemplatesSpecialController extends WikiaSpecialPageController {

	const ITEMS_PER_PAGE = 20;

	public $type;
	public $templateName;
	public $templates = [];
	public $groups;

	function __construct() {
		parent::__construct( 'Templates' );
	}

	public function init() {
		$this->specialPage->setHeaders();
		$this->specialPage->getOutput()->setPageTitle( wfMessage( 'special-templates' )->plain() );

		\Wikia::addAssetsToOutput( 'templates_hq_scss' );
	}

	public function index() {
		$allTemplates = $this->getAllTemplates();

		if ( !empty( $allTemplates ) ) {
			$classifiedTemplates = $this->getClassifiedTemplates( $allTemplates );

			$this->groups = $this->getTemplateGroups( $classifiedTemplates );
			$this->templateName = $this->getVal( 'template' );
			$this->type = $this->getVal( 'type', $this->getDefaultType() );
			$page = $this->request->getInt( 'page', 1 ) - 1;

			if ( !empty( $this->templateName ) ) {
				$this->templates = $this->filterTemplatesByName( $allTemplates, $classifiedTemplates );
			} else {
				$this->templates = $this->getTemplates( $allTemplates, $classifiedTemplates );
			}

			$total = $this->getTotalTemplatesNum();

			if ( $total > self::ITEMS_PER_PAGE ) {
				$this->sliceTemplates( $page );
				$this->preparePagination( $total, $page );
			}
		}

		$this->response->setValues( [
			'templates' => $this->templates,
			'type' => $this->type,
			'groups'=> $this->groups,
			'templateName' => $this->templateName
		] );
	}

	public function exception() {}

	/**
	 * Get all classified templates on wiki
	 *
	 * @return array
	 */
	private function getClassifiedTemplates( $allTemplates ) {
		$classifiedTemplates = [];

		try {
			$classifiedTemplates = ( new \UserTemplateClassificationService() )->getTemplatesOnWiki( $this->wg->CityId );
		} catch( \Swagger\Client\ApiException $e ) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'SpecialTemplatesException', [ 'ex' => $e ] );
			$this->forward( __CLASS__, 'exception' );
		}

		$classifiedTemplates = array_intersect_key( $classifiedTemplates, $allTemplates );

		return $classifiedTemplates;
	}

	/**
	 * Get all templates on wiki with number of pages on which are included
	 *
	 * @return bool|mixed
	 * @throws \FluentSql\Exception\SqlException
	 */
	private function getAllTemplates() {
		$db = wfGetDB( DB_SLAVE );

		$templates = ( new \WikiaSQL() )
			->SELECT( 'page_id', 'qc_title', 'qc_value' )
			->FROM( 'querycache' )
			->LEFT_JOIN( 'page' )
			->ON( 'page_title', 'qc_title' )
			->WHERE( 'qc_type' )->EQUAL_TO( 'Mostlinkedtemplates' )
			->AND_( 'qc_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->AND_( 'page_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->AND_( 'page_is_redirect' )->EQUAL_TO( 0 )
			->ORDER_BY( ['qc_value', 'DESC'] )
			->runLoop( $db, function( &$templates, $row ) {
				$templates[$row->page_id] = [
					'page_id' => $row->page_id,
					'title' => $row->qc_title,
					'count' => $row->qc_value
				];
			} );

		return $templates;
	}

	/**
	 * Filter templates by name
	 *
	 * @param array $allTemplates
	 * @param array $classifiedTemplates
	 * @return array
	 */
	private function filterTemplatesByName( $allTemplates, $classifiedTemplates ) {
		$templates = [];

		$pageId = array_search(
			strtolower( $this->templateName ),
			array_map( 'strtolower', array_column( $allTemplates, 'title', 'page_id' ) )
		);

		if ( $pageId ) {
			$templates[$pageId] = $this->prepareTemplate( $pageId, $allTemplates[$pageId] );
			$this->type = $this->getTemplateType( $pageId, $classifiedTemplates );
		}

		return $templates;
	}

	/**
	 * Get templates depending by type
	 *
	 * @param array $allTemplates
	 * @param array $classifiedTemplates
	 * @return array
	 */
	private function getTemplates( $allTemplates, $classifiedTemplates ) {
		if ( $this->type === TemplateClassificationService::TEMPLATE_UNKNOWN ) {
			return $this->getUnknownTemplates( $allTemplates, $classifiedTemplates );
		}

		return $this->getTemplatesByType( $allTemplates, $classifiedTemplates );
	}

	/**
	 * Get all unknown templates
	 *
	 * @param array $allTemplates all tempaltes on wiki
	 * @param array $classifiedTemplates all classified templates on wiki
	 * @return array
	 */
	private function getUnknownTemplates( $allTemplates, $classifiedTemplates ) {
		$templates = [];

		foreach ( $allTemplates as $pageId => $template ) {
			if ( !isset( $classifiedTemplates[$pageId] ) || !$this->isUserType( $classifiedTemplates[$pageId] ) ) {
				$templates[$pageId] = $this->prepareTemplate( $pageId, $template );
			}
		}

		return $templates;
	}

	/**
	 * Get templates on wiki by type
	 *
	 * @param array $allTemplates
	 * @param array $classifiedTemplates
	 * @return array
	 */
	private function getTemplatesByType( $allTemplates, $classifiedTemplates ) {
		$templates = [];
		$templateIds = array_keys( $classifiedTemplates, $this->type );

		foreach ( $templateIds as $pageId ) {
			if ( isset( $allTemplates[$pageId] ) ) {
				$templates[$pageId] = $this->prepareTemplate( $pageId, $allTemplates[$pageId] );
			}
		}

		return $templates;
	}

	/**
	 * Get data about template page
	 *
	 * @param int $pageId
	 * @param array $template
	 * @return mixed
	 * @throws MWException
	 */
	private function prepareTemplate( $pageId, $template ) {
		$title = Title::newFromID( $pageId );

		if ( $title instanceof Title ) {
			$template['url'] = $title->getLocalURL();
			$template['wlh'] = SpecialPage::getTitleFor( 'Whatlinkshere', $title->getPrefixedText() )->getLocalURL();
			$template['revision'] = $this->getRevisionData( $title );
			$template['count'] = $this->wg->Lang->formatNum( $template['count'] );

			if ( ( new UserTemplateClassificationService() )->isInfoboxType( $this->type ) ) {
				$template['subgroup'] = !empty( PortableInfoboxDataService::newFromTitle( $title )->getData() ) ?
					wfMessage( 'special-templates-portable-infobox' )->escaped() :
					wfMessage( 'special-templates-non-portable-infobox' )->escaped();
			}
		}

		return $template;
	}

	/**
	 * Get data about tempalte page last revision
	 *
	 * @param Title $title
	 * @return array
	 * @throws MWException
	 */
	private function getRevisionData( Title $title ) {
		$data = [];
		$revision = Revision::newFromId( $title->getLatestRevID() );

		if ( $revision instanceof Revision ) {
			$data['timestamp'] = $this->wg->Lang->date( $revision->getTimestamp() );

			$user = $revision->getUserText();

			if ( $revision->getUser() ) {
				$userpage = Title::newFromText( $user, NS_USER )->getFullURL();
			} else {
				$userpage = SpecialPage::getTitleFor( 'Contributions', $user )->getFullUrl();
			}

			$data['username'] = $user;
			$data['userpage'] = $userpage;
		}

		return $data;
	}

	/**
	 * Prepare pagination
	 *
	 * @param int $total
	 * @param int $page
	 */
	private function preparePagination( $total, $page ) {
		$params = [ 'page' => '%s' ];

		if ( $this->type ) {
			$params['type'] = $this->type;
		}

		if ( $this->templateName ) {
			$params['template'] = $this->templateName;
		}

		$paginator = Paginator::newFromCount( $total, self::ITEMS_PER_PAGE );
		$paginator->setActivePage( $page + 1 );
		$url = urldecode( $this->specialPage->getTitle()->getLocalUrl( $params ) );
		$this->paginatorBar = $paginator->getBarHTML( $url );
	}

	/**
	 * Slice templates list for pagination
	 *
	 * @param int $page
	 */
	private function sliceTemplates( $page ) {
		$offset = $page * self::ITEMS_PER_PAGE;
		$limit = self::ITEMS_PER_PAGE;

		$this->templates = array_slice( $this->templates, $offset, $limit, true );
	}

	/**
	 * Get all existing and user facing template types on wiki
	 *
	 * @param array $classifiedTemplates
	 * @return array
	 */
	private function getTemplateGroups( $classifiedTemplates ) {
		$groups = array_unique( $classifiedTemplates );

		foreach ( $groups as $id => $group ) {
			if ( !$this->isUserType( $group ) ) {
				unset( $groups[$id] );
			}
		}

		if ( !in_array( TemplateClassificationService::TEMPLATE_UNKNOWN, $groups ) ) {
			$groups[] = TemplateClassificationService::TEMPLATE_UNKNOWN;
		}

		sort( $groups );

		return $groups;
	}

	/**
	 * Get number of templates
	 *
	 * @return int
	 */
	private function getTotalTemplatesNum() {
		return count( $this->templates );
	}

	/**
	 * Get template type
	 *
	 * @param int $pageId
	 * @param array $classifiedTemplates
	 * @return string
	 */
	private function getTemplateType( $pageId, $classifiedTemplates ) {
		if ( !isset( $classifiedTemplates[$pageId] ) || !$this->isUserType( $classifiedTemplates[$pageId] ) ) {
			return TemplateClassificationService::TEMPLATE_UNKNOWN;
		}

		return $classifiedTemplates[$pageId];
	}

	/**
	 * Get default type
	 *
	 * @return string
	 */
	private function getDefaultType() {
		if ( in_array( TemplateClassificationService::TEMPLATE_UNKNOWN, $this->groups ) ) {
			return TemplateClassificationService::TEMPLATE_UNKNOWN;
		}

		return $this->groups[0];
	}

	/**
	 * Check if given type is user facing
	 *
	 * @param string $type
	 * @return bool
	 */
	private function isUserType( $type ) {
		return in_array( $type, UserTemplateClassificationService::$templateTypes );
	}
}
