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
			//FIXME refactor this piece into another data class
			$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
			$row = $dbw->selectRow(
					array( 'ads', 'pp_tokens', 'pp_agreements' ),
					'*',
					array(
						'ad_id' => $id,
						'ad_id = ppt_ad_id',
						'ppt_token = ppa_token',
						'ad_closed' => null,
						'ad_expires' => null,
					     ),
					__METHOD__
					);
			if( $row === false ) {
				$r = array( 'result' => 'error', 'respmsg' => 'no such ad' );
			} else {
				$ad = AdSS_Ad::newFromRow( $row );
				if( $id != $ad->id ) {
					$r = array( 'result' => 'error', 'respmsg' => 'no such ad' );
				} else {
					$title = null;
					if( $ad->pageId > 0 ) {
						$title = Title::newFromID( $ad->pageId );
						if( !$title || !$title->exists() ) {
							$r = array( 'result' => 'error', 'respmsg' => 'no such title' );
						}
					}

					if( empty( $r ) ) {
						$pp = new PaymentProcessor();
						$respArr = array();
						if( $pp->collectPayment( $row->ppa_baid, $ad->price['price'] * $ad->weight, $respArr ) ) {
							$ad->refresh();

							$r = array(
									'result'  => 'success',
									'id'      => $ad->id,
									'expires' => wfTimestamp( TS_DB, $ad->expires ),
								  );
						} else {
							if( ( $respArr['RESULT'] ==  12 ) && ( $respArr['RESPMSG'] == 'Declined: 10201-Agreement was canceled' ) ) {
								$ad->close();
								$r = array( 'result' => 'error', 'respmsg' => 'billing agreement canceled' );
							} else {
								$r = array( 'result' => 'error', 'respmsg' => "paypal error:\n$respArr[RESPMSG]" );
							}
						}
						AdSS_Util::flushCache( $ad->pageId, $ad->wikiId );
						AdSS_Util::commitAjaxChanges();
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
