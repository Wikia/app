<?php

namespace UserActivity;

class SpecialController extends \WikiaSpecialPageController {

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const PAGE_NAME = 'UserActivity';
	const PAGE_TITLE = 'User Activity';

	const ITEMS_PER_PAGE = 10;

	public function __construct() {
		parent::__construct( self::PAGE_NAME, '', $listed = false );
	}

	/**
	 * Run before index. Set the title and disable redirects.
	 */
	public function init() {
		$this->disableRedirects();
		$this->setTitle();
		$this->addAssets();
	}

	/**
	 * Disable redirects. Some operations called in the controllers will cause the page to
	 * redirect (eg Article::newFromTitle()). We always want to return to Special:SendEmail.
	 */
	private function disableRedirects() {
		$this->wg->Out->enableRedirects( false );
	}

	/**
	 * Set's the <h1> and <title> tags, and suppresses the generic "Special Page" subtitle.
	 */
	private function setTitle() {
		$this->getContext()->getOutput()->setHTMLTitle( self::PAGE_TITLE );
		$this->getContext()->getOutput()->setPageTitle( self::PAGE_TITLE );
		$this->wg->SupressPageSubtitle = true;
	}

	private function addAssets() {
		$this->response->addAsset( 'special_user_activity_js' );
		$this->response->addAsset( 'special_user_activity_scss' );
	}

	/**
	 * @template specialUserActivity
	 */
	public function index() {
		if ( $this->wg->User->isAnon() ) {
			$this->getResponse()->redirect( '/' );
			return;
		}

		$limit = $this->getVal( 'limit', self::ITEMS_PER_PAGE );
		$page = $this->getVal( 'page', 1 );
		$order = $this->getVal( 'order', 'lastedit:desc' );

		$resp = $this->sendRequest( 'UserActivity\Controller', 'index', [
			'limit' => $limit,
			'offset' => ( $page - 1 ) * $limit,
			'order' => $order,
		] );
		$data = $resp->getData();

		$this->getResponse()->setData( [
			'pageDescription' => wfMessage( 'user-activity-page-description' )->text(),
			'tableTitle' => wfMessage( 'user-activity-table-title' )->text(),
			'tableEdits' => wfMessage( 'user-activity-table-edits' )->text(),
			'tableLastEdit' => wfMessage( 'user-activity-table-lastedit' )->text(),
			'tableRights' => wfMessage( 'user-activity-table-rights' )->text(),
			'items' => $data['items'],
			'username' => $this->app->wg->User->getName(),
			'total' => $data['total'],
			'totalReturned' => $data['totalReturned'],
			'pagination' => $this->getPagination( $data['total'], $page, $order )
		] );
	}

	private function getPagination( $total, $page, $order ) {
		$pagination = '';
		if ( $total > self::ITEMS_PER_PAGE ) {
			$pages = \Paginator::newFromCount( $total, self::ITEMS_PER_PAGE );
			$pages->setActivePage( $page );

			$linkToSpecialPage = \SpecialPage::getTitleFor( 'UserActivity' )->escapeLocalUrl();
			$pagination = $pages->getBarHTML( $linkToSpecialPage.'?page=%s&order='.$order );
		}

		return $pagination;
	}
}
