<?php

use Wikia\ContentReview\ContentReviewStatusesService;
use Wikia\ContentReview\Helper;

class TemplatesSpecialController extends WikiaSpecialPageController {

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

		$classifiedTemplates = [];
		$allTemplates = $this->getAllTempaltes();

		try {
			$classifiedTemplates = ( new \TemplateClassificationService() )->getTemplatesOnWiki( $this->wg->CityId );
		} catch( \Exception $e ) {
			var_dump('error');
		}

		$groupedTemplates = $this->prepareTemplates( $allTemplates, $classifiedTemplates );
		$groups = array_keys( $groupedTemplates );

		if ( !is_null( $type ) ) {
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

		$this->type = $type;
		$this->template = $template;

		$this->groups = $groups;
		$this->groupedTemplates = $groupedTemplates;
	}

	private function prepareTemplates( $allTemplates, $classifiedTemplates ) {
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
