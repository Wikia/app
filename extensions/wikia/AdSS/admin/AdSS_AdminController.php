<?php

class AdSS_AdminController {

	private $tabs = array( 'adList', 'billing', 'reports' );
	private $selectedTab = 'adList';

	function execute( $sub ) {
		global $wgOut, $wgAdSS_templatesDir, $wgUser;

		if( !$wgUser->isAllowed( 'adss-admin' ) ) {
			$wgOut->permissionRequired( 'adss-admin' );
			return;
		}

		if( isset( $sub[1] ) && in_array( $sub[1], $this->tabs ) ) {
			$this->selectedTab = $sub[1];
		}

		$this->displayPanel();
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/AdSS/css/admin.scss' ) );
	}

	function displayTabs() {
		global $wgOut, $wgAdSS_templatesDir;

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/admin' );
		$tmpl->set( 'selfUrl', Title::makeTitle( NS_SPECIAL, "AdSS/admin" )->getLocalURL() );
		$tmpl->set( 'selectedTab', $this->selectedTab );
		$tmpl->set( 'tabs', $this->tabs );
		$wgOut->addHTML( $tmpl->render( 'tabs' ) );
	}

	function displayPanel() {
		$this->displayTabs();
		call_user_func( array( $this, 'display'.ucfirst($this->selectedTab ) ) );
	}

	function displayAdList() {
		global $wgAdSS_templatesDir, $wgOut;

		AdSS_Util::generateToken();
		$token = AdSS_Util::getToken();

		$pager = new AdSS_AdminAdListPager();
		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/admin' );
		$tmpl->set( 'token', $token );
		$tmpl->set( 'navigationBar', $pager->getNavigationBar() );
		$tmpl->set( 'filterForm', $pager->getFilterForm() );
		$tmpl->set( 'adList', $pager->getBody() );
		$wgOut->addHTML( $tmpl->render( 'adList' ) );
	}

	function displayBilling() {
		global $wgOut, $wgAdSS_templatesDir;

		$pager = new AdSS_AdminBillingPager();

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/admin' );
		$tmpl->set( 'navigationBar', $pager->getNavigationBar() );
		$tmpl->set( 'billing', $pager->getBody() );

		$wgOut->addHTML( $tmpl->render( 'billing' ) );
	}

	function displayReports() {
		global $wgOut, $wgAdSS_DBname, $wgAdSS_templatesDir;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$res = $dbr->select( 'billing', array( 'date( billing_timestamp ) as billing_date', 'sum(-billing_amount) as income' ), 'billing_ad_id > 0', __METHOD__, array( 'GROUP BY' => 'billing_date', 'ORDER BY' => 'billing_date desc', 'LIMIT' => 7 ) );
		$d = array();
		$xl0 = array();
		foreach( $res as $row ) {
			$d[] = $row->income;
			$xl0[] = $row->billing_date;
		}
		
		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/admin' );
		$tmpl->set( 'w', 600 );
		$tmpl->set( 'h', 300 );
		$tmpl->set( 'maxY', 250 );
		$tmpl->set( 'd', implode( ',', array_reverse( $d ) ) );
		$tmpl->set( 'xl0', implode( '|', array_reverse( $xl0 ) ) );

		$dbr->freeResult( $res );
		$res = $dbr->select(
				'billing',
				array(
					'billing_user_id',
					'sum(-billing_amount) as billing_balance',
					'max( if (billing_ppp_id>0, billing_timestamp, null ) ) as last_billed',
					),
				null,
				__METHOD__,
				array(
					'GROUP BY' => 'billing_user_id',
					'HAVING'   => 'billing_balance > 0',
					'ORDER BY' => 'billing_user_id',
					)
				);
		$lines = array();
		foreach( $res as $row ) {
			$lines[] = array(
					'user'       => AdSS_User::newFromId( $row->billing_user_id )->toString(),
					'amount'     => $row->billing_balance,
					'lastBilled' => $row->last_billed,
					);
		}
		$tmpl->set( 'lines', $lines );

		$wgOut->addHTML( $tmpl->render( 'reports' ) );

	}

	static function acceptAdAjax( $id, $token ) {
		global $wgUser, $wgAdSS_DBname;

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if( !$wgUser->isAllowed( 'adss-admin' ) ) {
			$r = array( 'result' => 'error', 'respmsg' => 'no permission' );
		} elseif( $token != AdSS_Util::getToken() ) {
			$r = array( 'result' => 'error', 'respmsg' => 'token mismatch' );
		} else {
			$ad = AdSS_AdFactory::createFromId( $id );
			if( ( $ad->id != $id ) || ( $ad->closed != null ) || ( $ad->expires != null ) ) {
				$r = array( 'result' => 'error', 'respmsg' => 'no such ad' );
			} else {
				if( $ad->pageId > 0 ) {
					$title = Title::newFromID( $ad->pageId );
					if( !$title || !$title->exists() ) {
						$r = array( 'result' => 'error', 'respmsg' => 'no such article' );
					}
				}

				if( empty( $r ) ) {
					$billing = new AdSS_Billing();
					if( $billing->addCharge( $ad ) ) {
						$ad->refresh();
						AdSS_Util::flushCache( $ad->pageId, $ad->wikiId );
						AdSS_Util::commitAjaxChanges();
						$r = array(
							'result'  => 'success',
							'id'      => $ad->id,
							'expires' => wfTimestamp( TS_DB, $ad->expires ),
						);
					} else {
						$r = array(
							'result'  => 'error',
							'respmsg' => 'Could not charge user',
						);
					}
				}
			}
		}
		$response->addText( Wikia::json_encode( $r ) );

		return $response;
	}

	static function closeAdAjax( $id, $token ) {
		global $wgUser;

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if( !$wgUser->isAllowed( 'adss-admin' ) && ( $token == AdSS_Util::getToken() ) ) {
			$r = array( 'result' => 'error', 'respmsg' => 'token mismatch' );
		} else {
			$ad = AdSS_AdFactory::createFromId( $id );
			if( $id == $ad->id ) {
				$ad->close();

				AdSS_Util::flushCache( $ad->pageId, $ad->wikiId );
				AdSS_Util::commitAjaxChanges();
				$r = array(
						'result' => 'success',
						'id'     => $id,
					  );
			} else {
				$r = array( 'result' => 'error', 'respmsg' => 'wrong id' );
			}
		}
		$response->addText( Wikia::json_encode( $r ) );

		return $response;
	}

}
