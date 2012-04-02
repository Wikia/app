<?php

class AdSS_AdminController {

	private $tabs = array( 'adList', 'billing', 'reports' );
	private $selectedTab = 'adList';

	function execute( $sub ) {
		global $wgOut, $wgUser;

		if( !$wgUser->isAllowed( 'adss-admin' ) ) {
			$wgOut->permissionRequired( 'adss-admin' );
			return;
		}

		if( isset( $sub[1] ) && ( $sub[1] == 'download' ) &&
		    isset( $sub[2] ) && ( is_numeric( $sub[2] ) ) ) {
			if( $this->downloadAd( $sub[2] ) ) {
				return;
			}
		}

		if( isset( $sub[1] ) && in_array( $sub[1], $this->tabs ) ) {
			$this->selectedTab = $sub[1];
		}

		$this->displayPanel();
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AdSS/css/admin.scss'));
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
		$maxY = ceil( max( $d ) / 100 ) * 100;

		$ts = time();
		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$res = $dbr->select( 'billing', array( 'date( billing_timestamp ) as billing_date', 'sum(-billing_amount) as income' ), 'billing_ad_id > 0', __METHOD__, array( 'GROUP BY' => "billing_date HAVING billing_date BETWEEN '" . date('Y-m-01', $ts) . "' AND '" . date('Y-m-t', $ts) . "'", 'ORDER BY' => 'billing_date' ) );
		$md = array();
		$mxl0 = array();
		foreach( $res as $row ) {
			$md[] = $row->income;
			$mxl0[] = $row->billing_date;
		}
		if( count( $md ) > 0 ) {
			$mmaxY = ceil( max( $md ) / 100 ) * 100;
		}
		else {
			$mmaxY = 0;
		}

		$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/admin' );
		$tmpl->set( 'w', 500 );
		$tmpl->set( 'h', 300 );
		$tmpl->set( 'maxY', $maxY );
		$tmpl->set( 'mmaxY', $mmaxY );
		$tmpl->set( 'd', implode( ',', array_reverse( $d ) ) );
		$tmpl->set( 'xl0', implode( '|', array_reverse( $xl0 ) ) );
		$tmpl->set( 'md', implode( ',', array_reverse( $md ) ) );
		$tmpl->set( 'mxl0', implode( '|', array_reverse( $mxl0 ) ) );

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
					'HAVING'   => 'billing_balance <> 0',
					'ORDER BY' => 'billing_user_id',
					)
				);
		$lines = array();
		foreach( $res as $row ) {
//var_dump($res);
			$user = AdSS_User::newFromId( $row->billing_user_id );
			$lines[] = array(
					'user'       => ( is_object( $user ) ? $user->toString() : "unknown" ),
					'amount'     => $row->billing_balance,
					'lastBilled' => $row->last_billed,
					);
		}
		$tmpl->set( 'lines', $lines );

		$wgOut->addHTML( $tmpl->render( 'reports' ) );

	}

	function downloadAd( $adId ) {
		global $wgAdSS_BannerUploadDirectory, $wgOut;

		$ad = AdSS_AdFactory::createFromId( $adId );
		if( $ad && ( $ad->type == 'b' ) ) {
			$magic = MimeMagic::singleton();
			$mime = $magic->guessMimeType( $wgAdSS_BannerUploadDirectory . "/" . $ad->id, false );
			wfDebug( "MIME for " . $wgAdSS_BannerUploadDirectory . "/" . $ad->id . " is $mime\n" );
			if( $mime ) {
				$ext = explode( ' ', $magic->getExtensionsForType( $mime ) );
				$filename = "adss-banner-{$ad->id}.{$ext[0]}";

				$wgOut->disable();
				wfResetOutputBuffers();
				header( "Content-Disposition: attachment;filename={$filename}" );
				header( "Content-Type: $mime" );
				header( "Content-Length: " . filesize( $wgAdSS_BannerUploadDirectory . "/" . $ad->id ) );
				readfile( $wgAdSS_BannerUploadDirectory . "/" . $ad->id );

				return true;
			}
		}
		return false;
	}

	static function acceptAdAjax( $id, $token ) {
		global $wgUser, $wgAdSS_ReadOnly;

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
			$r = array( 'result' => 'error', 'respmsg' => wfMsgWikiHtml( 'readonlytext', wfReadOnlyReason() ) );
			$response->addText( Wikia::json_encode( $r ) );
			return $response;
		}

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
		global $wgUser, $wgAdSS_ReadOnly;

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
			$r = array( 'result' => 'error', 'respmsg' => wfMsgWikiHtml( 'readonlytext', wfReadOnlyReason() ) );
			$response->addText( Wikia::json_encode( $r ) );
			return $response;
		}

		if( !$wgUser->isAllowed( 'adss-admin' ) ) {
			$r = array( 'result' => 'error', 'respmsg' => 'no permission' );
		} elseif( $token != AdSS_Util::getToken() ) {
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

	static function getAdAjax( $id ) {
		global $wgUser;

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if( !$wgUser->isAllowed( 'adss-admin' ) ) {
			$r = array( 'result' => 'error', 'respmsg' => 'Permission error' );
		} else {
			$ad = AdSS_AdFactory::createFromId( $id );
			if( $id == $ad->id ) {
				$r = array( 'result' => 'success', 'ad' => $ad );
			} else {
				$r = array( 'result' => 'error', 'respmsg' => 'wrong id' );
			}
		}
		$response->addText( Wikia::json_encode( $r ) );

		return $response;
	}

	static function editAdAjax( $id, $url, $text, $desc ) {
		global $wgUser, $wgAdSS_ReadOnly;

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
			$r = array( 'result' => 'error', 'respmsg' => wfMsgWikiHtml( 'readonlytext', wfReadOnlyReason() ) );
			$response->addText( Wikia::json_encode( $r ) );
			return $response;
		}

		if( !$wgUser->isAllowed( 'adss-admin' ) ) {
			$r = array( 'result' => 'error', 'respmsg' => 'no permission' );
		} else {
			$ad = AdSS_AdFactory::createFromId( $id );
			if( $id == $ad->id ) {
				if( $ad->type == 't' ) {
					$ad->url = $url;
					$ad->text = $text;
					$ad->desc = $desc;
					$ad->save();

					AdSS_Util::flushCache( $ad->pageId, $ad->wikiId );
					AdSS_Util::commitAjaxChanges();
					$r = array(
						'result' => 'success',
						'id'     => $id,
					);
				} else {
					$r = array( 'result' => 'error', 'respmsg' => 'you can edit only text ads' );
				}
			} else {
				$r = array( 'result' => 'error', 'respmsg' => 'wrong id' );
			}
		}
		$response->addText( Wikia::json_encode( $r ) );

		return $response;
	}

	static function getAdChangeAjax( $id ) {
		global $wgUser;

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if( !$wgUser->isAllowed( 'adss-admin' ) ) {
			$r = array( 'result' => 'error', 'respmsg' => 'Permission error' );
		} else {
			$ad = AdSS_AdFactory::createFromId( $id );
			if( $id == $ad->id ) {
				$adc = new AdSS_AdChange( $ad );
				if( $adc->loadFromDB() ) {
					$r = array( 'result' => 'success', 'adc' => $adc );
				} else {
					$r = array( 'result' => 'error', 'respmsg' => 'wrong id' );
				}
			} else {
				$r = array( 'result' => 'error', 'respmsg' => 'wrong id' );
			}
		}
		$response->addText( Wikia::json_encode( $r ) );

		return $response;
	}

	static function approveAdChangeAjax( $id, $url, $text, $desc ) {
		global $wgUser, $wgAdSS_ReadOnly;

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
			$r = array( 'result' => 'error', 'respmsg' => wfMsgWikiHtml( 'readonlytext', wfReadOnlyReason() ) );
			$response->addText( Wikia::json_encode( $r ) );
			return $response;
		}

		if( !$wgUser->isAllowed( 'adss-admin' ) ) {
			$r = array( 'result' => 'error', 'respmsg' => 'no permission' );
		} else {
			$ad = AdSS_AdFactory::createFromId( $id );
			if( $id == $ad->id ) {
				$ad->url = $url;
				$ad->text = $text;
				$ad->desc = $desc;
				$ad->save();

				$adc = new AdSS_AdChange( $ad );
				$adc->delete();

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

	static function rejectAdChangeAjax( $id ) {
		global $wgUser, $wgAdSS_ReadOnly;

		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
			$r = array( 'result' => 'error', 'respmsg' => wfMsgWikiHtml( 'readonlytext', wfReadOnlyReason() ) );
			$response->addText( Wikia::json_encode( $r ) );
			return $response;
		}

		if( !$wgUser->isAllowed( 'adss-admin' ) ) {
			$r = array( 'result' => 'error', 'respmsg' => 'no permission' );
		} else {
			$ad = AdSS_AdFactory::createFromId( $id );
			if( $id == $ad->id ) {
				$adc = new AdSS_AdChange( $ad );
				$adc->delete();
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
