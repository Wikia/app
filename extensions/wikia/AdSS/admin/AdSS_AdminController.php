<?php

class AdSS_AdminController {

	function execute( $subpage ) {
		global $wgOut, $wgAdSS_templatesDir, $wgUser;

		if( !$wgUser->isAllowed( 'adss-admin' ) ) {
			$wgOut->permissionRequired( 'adss-admin' );
			return;
		}

		AdSS_Util::generateToken();
		$token = AdSS_Util::getToken();

		$pager = new AdSS_AdminPager();
		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/admin' );
		$tmpl->set( 'token', $token );
		$tmpl->set( 'navigationBar', $pager->getNavigationBar() );
		$tmpl->set( 'filterForm', $pager->getFilterForm() );
		$tmpl->set( 'adList', $pager->getBody() );
		$wgOut->addHTML( $tmpl->render( 'adList' ) );
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
