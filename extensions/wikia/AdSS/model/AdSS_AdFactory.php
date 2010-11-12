<?php

class AdSS_AdFactory {

	static function createFromForm( $f ) {
		if( $f->get( 'wpType' ) == 'banner' ) {
			$ad = new AdSS_BannerAd();
		} else {
			$ad = new AdSS_TextAd();
		}
		$ad->loadFromForm( $f );
		return $ad;
	}

	static function createFromId( $id ) {
		global $wgAdSS_DBname;

		$dbr = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$row = $dbr->selectRow( 'ads', '*', array( 'ad_id' => $id ), __METHOD__ );
		if( $row === false ) {
			// invalid ad_id
			return null;
		} else {
			return self::createFromRow( $row );
		}
	}

	static function createFromRow( $row ) {
		if( $row->ad_type == 'b' ) {
			$ad = new AdSS_BannerAd();
		} else {
			$ad = new AdSS_TextAd();
		}
		$ad->loadFromRow( $row );
		return $ad;
	}

}
