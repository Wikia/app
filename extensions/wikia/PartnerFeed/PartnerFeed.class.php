<?php
/**
 * @author Jakub Kurcek
 * @package MediaWiki
 * @subpackage SpecialPage
 */

class ExtendedFeedItem extends FeedItem {
	/**#@+
	 * @var string
	 * @private
	 */
	var $OtherTags = array();

	/**#@-*/

	/**#@+
	 * @todo document
	 * @param $Url URL uniquely designating the item.
	 */
	function __construct( $title, $description, $url, $date = '', $author = '', $comments = '', $OtherTags = false ) {
		parent::__construct( $title, $description, $url, $date , $author , $comments );
		$this->OtherTags = !empty( $OtherTags ) ? $OtherTags : array();
	}

	public function getOtherTag( $sTag ) {
		return ( !empty( $this->OtherTags[$sTag] ) )
				? $this->xmlEncode( $this->OtherTags[$sTag] )
				: '';
	}
	public function getOtherTags() {
		return $this->OtherTags;
	}

}

class PartnerRSSFeed extends RSSFeed {

	function outItem( $item ) {

		global $wgOut;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"item"		=> $item
		));
		
		echo $oTmpl->render( "rss-item" );
	}

	function outHeader() {
		global $wgVersion;

		$this->outXmlHeader();
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"language"		=> $this->getLanguage(),
			"title"			=> $this->getTitle(),
			"url"			=> $this->getUrl(),
			"timeNow"		=> $this->formatTime( wfTimestampNow() ),
			"description"		=> $this->getDescription(),
			"version"		=> $wgVersion
		));

		echo $oTmpl->render( "rss-header" );
		
	}

}

class PartnerAtomFeed extends AtomFeed {

	function outItem( $item ) {
		
		global $wgMimeType;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"item"		=> $item
		));

		echo $oTmpl->render( "atom-item" );
	}

	function outHeader() {
		global $wgVersion;


		$this->outXmlHeader();
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"language"		=> $this->getLanguage(),
			"feedId"		=> $this->getFeedId(),
			"title"			=> $this->getTitle(),
			"selfUrl"		=> $this->getSelfUrl(),
			"url"			=> $this->getUrl(),
			"timeNow"		=> $this->formatTime( wfTimestampNow() ),
			"description"		=> $this->getDescription(),
			"version"		=> $wgVersion
		));

		echo $oTmpl->render( "atom-header" );

	}
}
