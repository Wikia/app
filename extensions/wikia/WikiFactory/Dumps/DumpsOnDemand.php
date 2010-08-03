<?php

/**
 * simple hook for displaying additional informations in Special:Statistics
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */
$wgHooks[ "CustomSpecialStatistics" ][] = "DumpsOnDemand::customSpecialStatistics";
$wgExtensionMessagesFiles[ "DumpsOnDemand" ] =  dirname( __FILE__ ) . '/DumpsOnDemand.i18n.php';

class DumpsOnDemand {

	const BASEURL = "http://wiki-stats.wikia.com";

	/**
	 * @access public
	 * @static
	 */
	static public function customSpecialStatistics( &$specialpage, &$text ) {
		global $wgOut, $wgDBname, $wgLang, $wgRequest, $wgTitle, $wgUser,
			$wgCityId;

		wfLoadExtensionMessages( "DumpsOnDemand" );

		/**
		 * read json file with dumps information
		 */

		$tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$index = array();

		$json = Http::get( self::getUrl( $wgDBname, "index.json" ), 5 );
		if( $json ) {
			$index = (array )Wikia::json_decode( $json );
		}

		/**
		 * get last dump request timestamp
		 */
		$wiki = WikiFactory::getWikiByID( $wgCityId );
		if( strtotime(wfTimestampNow()) - strtotime($wiki->city_lastdump_timestamp)  > 7*24*60*60 ) {
			$tmpl->set( "available", true );
		}
		else {
			$tmpl->set( "available", false );
		}

		$tmpl->set( "title", $wgTitle );
		$tmpl->set( "isAnon", $wgUser->isAnon() );

		$tmpl->set( "curr", array(
			"url" => self::getUrl( $wgDBname, "pages_current.xml.gz" ),
			"timestamp" => !empty( $index["pages_current.xml.gz"]->mwtimestamp )
				? $wgLang->timeanddate( $index[ "pages_current.xml.gz"]->mwtimestamp )
				: "unknown"
		));

		$tmpl->set( "full", array(
			"url" => self::getUrl( $wgDBname, "pages_full.xml.gz" ),
			"timestamp" => !empty( $index[ "pages_full.xml.gz" ]->mwtimestamp )
				? $wgLang->timeanddate( $index[ "pages_full.xml.gz" ]->mwtimestamp )
				: "unknown"
		));
		$tmpl->set( "index", $index );
		$text .= $tmpl->render( "dod" );

		if( $wgRequest->wasPosted() && !$wgUser->isAnon() ) {
			self::sendMail();
			Wikia::log( __METHOD__, "info", "request was posted" );
			$text = Wikia::successbox( wfMsg( "dump-database-request-requested" ) ) . $text;
		}

		return true;
	}

	/**
	 * return url to place where dumps are stored
	 *
	 * @static
	 * @access public
	 *
	 * @return String
	 */
	static public function getUrl( $database, $file, $baseurl = false ) {
		$database = strtolower( $database );

		return sprintf(
			"%s/%s/%s/%s/%s",
			( $baseurl === false ) ? self::BASEURL : $baseurl,
			substr( $database, 0, 1),
			substr( $database, 0, 2),
			$database,
			$file
		);
	}

	/**
	 * @static
	 * @access public
	 */
	static public function sendMail() {
		global $wgDBname, $wgServer, $wgCityId, $wgUser;

		$title = SpecialPage::getTitleFor( "Statistics" );
		$body = sprintf(
			"Database dump request for %s, city id %d\nurl %s\nRequested by %s\n",
			$wgDBname, $wgCityId, $title->getFullUrl(), $wgUser->getName()
		);

		UserMailer::send(
			new MailAddress( "dumps@wikia-inc.com" ),
			new MailAddress( "dump-request@wikia-inc.com" ),
			"Database dump request for {$wgDBname}",
			$body,
			null /*reply*/,
			null /*ctype*/,
			'DumpRequest'
		);

		/**
		 * @todo universal WikiFactory metod for that
		 */
		$dbw = WikiFactory::db( DB_MASTER );
		$dbw->update(
			"city_list",
			array( "city_lastdump_timestamp" => wfTimestampNow() ),
			array( "city_id" => $wgCityId ),
			__METHOD__
		);
	}
}
