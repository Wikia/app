<?php

use Wikia\ContentReview\ContentReviewStatusesService;
use Wikia\ContentReview\Helper;

class TemplatesSpecialController extends WikiaSpecialPageController {

	const ITEMS_PER_PAGE = 20;
	const TEMPLATES_MEMC_KEY = 'special-templates';
	const TEMPLATES_MEMC_VER = '1.0';

	function __construct() {
		parent::__construct( 'Templates', 'template-classification-templates', true );
	}

	public function init() {
		$this->specialPage->setHeaders();

		\Wikia::addAssetsToOutput( 'templates_hq_scss' );
	}

	protected function checkAccess() {
		if( !$this->wg->User->isLoggedIn() ) {
			return false;
		}
		return true;
	}

	public function index() {
		$this->specialPage->setHeaders();
/*
		if( !$this->checkAccess() ) {
			$this->displayRestrictionError();
			return false;
		}
*/
		$template = $this->getVal( 'template' );
		$type = $this->getVal( 'type' );
		$page = $this->request->getInt( 'page', 1 ) - 1;

		$groupedTemplates = $this->getTemplates();
		$groups = $this->getTemplateGroups( $groupedTemplates );

		$groupedTemplates = $this->filterTemplates( $groupedTemplates, $type, $template );

		$total = $this->getTotalTemplatesNum( $groupedTemplates );

		if ( $total > self::ITEMS_PER_PAGE ) {
			$groupedTemplates = $this->sliceTemplates( $groupedTemplates, $page );
			$this->paginatiorBar = $this->preparePagination( $total, $page, $type, $template );
		}

		$this->type = $type;
		$this->template = $template;
		$this->groups = $groups;

		$this->groupedTemplates = $groupedTemplates;
	}

	private function getTemplates() {
		$classifiedTemplates = [];
		$allTemplates = $this->getAllTempaltes();

		try {
			$classifiedTemplates = ( new \TemplateClassificationService() )->getTemplatesOnWiki( $this->wg->CityId );
		} catch( \Exception $e ) {
		}

		return $this->groupTemplates( $allTemplates, $classifiedTemplates );
	}

	private function filterTemplates( $groupedTemplates, $type, $template ) {
		if ( !empty( $type ) ) {
			$groupedTemplates = isset( $groupedTemplates[$type] ) ? [ $type => $groupedTemplates[$type] ] : [];
		}

		if ( !empty( $template ) && !empty( $groupedTemplates ) ) {
			foreach( $groupedTemplates as $group => $templates ) {
				if ( $pageId = array_search( $template, array_column( $groupedTemplates[$group], 'title', 'page_id' ) ) ) {
					break;
				}
			}

			$groupedTemplates = !empty( $pageId ) && !empty($group) ? [ $group => [ $pageId => $groupedTemplates[$group][$pageId] ] ] : [];
		}

		return $groupedTemplates;
	}

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

	private function prepareTemplate( $pageId, $template ) {
		$title = Title::newFromID( $pageId );

		if ( $title instanceof Title ) {
			$template['url'] = $title->getLocalURL();
			$template['wlh'] = SpecialPage::getTitleFor( 'Whatlinkshere', $title->getPrefixedText() )->getLocalURL();
			$template['revision'] = $this->getRevisionData( $title );
		}

		return $template;
	}

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

	private function preparePagination( $total, $page, $type, $templateName ) {
		$itemsPerPage = self::ITEMS_PER_PAGE;
		$params = [ 'page' => '%s' ];

		if ( $type ) {
			$params['type'] = $type;
		}

		if ( $templateName ) {
			$params['template'] = $templateName;
		}

		if( $total > $itemsPerPage ) {
			$paginator = Paginator::newFromArray( array_fill( 0, $total, '' ), $itemsPerPage, 3, false, '',  self::ITEMS_PER_PAGE );
			$paginator->setActivePage( $page );
			$url = urldecode( $this->specialPage->getTitle()->getLocalUrl( $params ) );
			$this->paginatorBar = $paginator->getBarHTML( $url );
		}
	}

	private function sliceTemplates( $groupedTemplates, $page ) {
		$in = 0;

		$offset = $page * self::ITEMS_PER_PAGE;
		$limit = self::ITEMS_PER_PAGE;

		$slicedTemplates = [];

		foreach ( $groupedTemplates as $group => $templates  ) {
			$count = count($templates) - 1;

			if ( !$in ) {
				if ( $count - $offset >= 0 ) {
					$slicedTemplates[$group] = array_slice( $templates, $offset, $limit, true );
				} else {
					$offset -= $count;
				}
			} else {
				$slicedTemplates[$group] = array_slice( $templates, 0, $limit, true );
			}

			$added = count( $slicedTemplates[$group] );
			$in += $added;
			$limit -= $added;

			if ( $in == self::ITEMS_PER_PAGE ) { break; }
		}

		return $slicedTemplates;
	}

	private function getTemplateGroups( $groupedTemplates ) {
		return array_keys( $groupedTemplates );
	}

	private function getTotalTemplatesNum( $groupedTemplates ) {
		return array_sum( array_map( 'count', $groupedTemplates ) );
	}

	private function getMemcKey() {
		return wfMemcKey( self::TEMPLATES_MEMC_KEY, self::TEMPLATES_MEMC_VER );
	}

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
