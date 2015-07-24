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
	 * Run before index. First make sure the user can access page, then set the title, disable
	 * redirects, and add the css.
	 */
	public function init() {
		$this->disableRedirects();
		$this->setTitle();
		$this->addCss();
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

	/**
	 * Adds stylesheet to output
	 */
	private function addCss() {
		$this->response->addAsset( 'special_user_activity_css' );
	}

	/**
	 * @template specialUserActivity
	 */
	public function index() {
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
			'items' => $data['items'],
			'total' => $data['total'],
    		'totalReturned' => $data['totalReturned'],
			'pagination' => $this->getPagination( $data['total'], $page, $order )
		] );
	}

	private function getPagination( $total, $page, $order ) {
		$pagination = '';
		if ( $total > self::ITEMS_PER_PAGE ) {
			$pages = \Paginator::newFromArray( array_fill( 0, $total, '' ), self::ITEMS_PER_PAGE );
			$pages->setActivePage( $page - 1 );

			$linkToSpecialPage = \SpecialPage::getTitleFor( 'UserActivity' )->escapeLocalUrl();
			$pagination = $pages->getBarHTML( $linkToSpecialPage.'?page=%s&order='.$order );
		}

		return $pagination;
	}
}
