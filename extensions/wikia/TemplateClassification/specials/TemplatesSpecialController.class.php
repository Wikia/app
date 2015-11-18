<?php

use Wikia\ContentReview\ContentReviewStatusesService;
use Wikia\ContentReview\Helper;

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
		$this->specialPage->getOutput()->setPageTitle( wfMessage( 'special-templates' )->escaped() );

		\Wikia::addAssetsToOutput( 'templates_hq_scss' );
	}

	public function index() {
		$groupedTemplates = $this->getTemplates();

		if ( empty( $groupedTemplates ) ) {
			$this->groups = $this->getTemplateGroups( $groupedTemplates );
			$this->templateName = $this->getVal( 'template' );
			$this->type = $this->getVal( 'type', $this->getDefaultType() );
			$page = $this->request->getInt( 'page', 1 ) - 1;

			$this->templates = $this->filterTemplates( $groupedTemplates );

			$total = $this->getTotalTemplatesNum();

			if ( $total > self::ITEMS_PER_PAGE ) {
				$this->sliceTemplates( $page );
				$this->preparePagination( $total, $page );
			}
		}

		$this->setVal( 'templates', $this->templates );
		$this->setVal( 'type', $this->type );
		$this->setVal( 'groups', $this->groups );
		$this->setVal( 'templateName', $this->templateName );
	}

	/**
	 * Get tempaltes on wiki with their classification
	 *
	 * @return array
	 */
	private function getTemplates() {
		$classifiedTemplates = [];
		$allTemplates = $this->getAllTempaltes();

		try {
			$classifiedTemplates = ( new \TemplateClassificationService() )->getTemplatesOnWiki( $this->wg->CityId );
		} catch( \Exception $e ) {
		}

		return $this->groupTemplates( $allTemplates, $classifiedTemplates );
	}

	/**
	 * Filter templates by name or type
	 *
	 * @param $groupedTemplates
	 * @return array
	 */
	private function filterTemplates( $groupedTemplates ) {
		$filteredTemplates = [];

		if ( !empty( $this->templateName ) && !empty( $groupedTemplates ) ) {
			foreach( $groupedTemplates as $group => $templates ) {
				if ( $pageId = array_search(
						$this->templateName,
						array_column( $groupedTemplates[$group], 'title', 'page_id' )
					)
				) {
					$filteredTemplates = [ $groupedTemplates[$group][$pageId] ];
					$this->type = $group;
				}
			}
		} elseif ( !empty( $this->type ) && isset( $groupedTemplates[$this->type] ) ) {
			$filteredTemplates = $groupedTemplates[$this->type];
		}

		return $filteredTemplates;
	}

	/**
	 * Assign each template to type
	 *
	 * @param array $allTemplates all tempaltes on wiki
	 * @param array $classifiedTemplates all classified templates on wiki
	 * @return array
	 */
	private function groupTemplates( $allTemplates, $classifiedTemplates ) {
		$templates = [];

		foreach ( $allTemplates as $pageId => $template ) {
			$template = $this->prepareTemplate( $pageId, $template );

			if ( !isset( $classifiedTemplates[$pageId] )
				|| !in_array( $classifiedTemplates[$pageId], TemplateClassificationService::$templateTypes )
			) {
				$templates[TemplateClassificationService::TEMPLATE_UNKNOWN][$pageId] = $template;
			} else {
				$templates[$classifiedTemplates[$pageId]][$pageId] = $template;
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
			$data['timestamp'] = wfTimestamp( TS_UNIX, $revision->getTimestamp() );

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
		$itemsPerPage = self::ITEMS_PER_PAGE;
		$params = [ 'page' => '%s' ];

		if ( $this->type ) {
			$params['type'] = $this->type;
		}

		if ( $this->templateName ) {
			$params['template'] = $this->templateName;
		}

		if( $total > $itemsPerPage ) {
			$paginator = Paginator::newFromArray( array_fill( 0, $total, '' ), $itemsPerPage, 3, false, '',  self::ITEMS_PER_PAGE );
			$paginator->setActivePage( $page );
			$url = urldecode( $this->specialPage->getTitle()->getLocalUrl( $params ) );
			$this->paginatorBar = $paginator->getBarHTML( $url );
		}
	}

	/**
	 * Slice templates list for pagination
	 *
	 * @param $page
	 */
	private function sliceTemplates( $page ) {
		$offset = $page * self::ITEMS_PER_PAGE;
		$limit = self::ITEMS_PER_PAGE;

		$this->templates = array_slice( $this->templates, $offset, $limit, true );
	}

	/**
	 * Get all existing template types on wiki
	 *
	 * @param array $groupedTemplates
	 * @return array
	 */
	private function getTemplateGroups( $groupedTemplates ) {
		return array_keys( $groupedTemplates );
	}

	/**
	 * Get number of templates
	 *
	 * @return int
	 */
	private function getTotalTemplatesNum() {
		return count( $this->templates );
	}

	private function getDefaultType() {
		if ( in_array( $this->groups, \TemplateClassificationService::TEMPLATE_UNKNOWN ) ) {
			return \TemplateClassificationService::TEMPLATE_UNKNOWN;
		} else {
			return $this->groups[0];
		}
	}

	/**
	 * Get all templates on wiki with number of pages on which are included
	 *
	 * @return bool|mixed
	 * @throws \FluentSql\Exception\SqlException
	 */
	private function getAllTempaltes() {
		$db = wfGetDB( DB_SLAVE );

		$templates = ( new \WikiaSQL() )
			->SELECT( 'page_id', 'page_title', 'COUNT(tl_from) AS count' )
			->FROM( 'page' )
			->LEFT_JOIN( 'templatelinks')->ON( 'page_title', 'tl_title' )
			->WHERE( 'page_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->GROUP_BY( 'page_id' )
			->ORDER_BY( ['count', 'DESC'] )
			->runLoop( $db, function( &$templates, $row ) {
				$templates[$row->page_id] = [
					'page_id' => $row->page_id,
					'title' => $row->page_title,
					'count' => $row->count
				];
			});

		return $templates;
	}
}
