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
		global $wgOut, $wgAdSS_DBname;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$res = $dbr->select( 'billing', array( 'date( billing_timestamp ) as billing_date', 'sum(-billing_amount) as income' ), 'billing_ad_id > 0', __METHOD__, array( 'GROUP BY' => 'billing_date', 'ORDER BY' => 'billing_date desc', 'LIMIT' => 7 ) );
		$d = array();
		$x = array();
		foreach( $res as $row ) {
			$d[] = $row->income;
			$x[] = $row->billing_date;
		}

		$w=600; $h=300;
		$wgOut->addHTML( "<img width=\"$w\" height=\"$h\" src=\"http://chart.apis.google.com/chart?chxt=x,y&chbh=a&chs={$w}x{$h}&cht=bvg&chco=A2C180&chd=t:".implode( ",", array_reverse($d) )."&chm=N*cUSD0*,000000,0,-1,12&chxl=0:|".implode( "|", array_reverse($x) )."|&chtt=Daily+Income+(last+7+days)\" />" );
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
			$ad = AdSS_Ad::newFromId( $id );
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
			$ad = AdSS_Ad::newFromId( $id );
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
