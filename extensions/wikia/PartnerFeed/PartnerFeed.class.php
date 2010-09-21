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
	function __construct( $Title, $Description, $Url, $Date = '', $Author = '', $Comments = '', $OtherTags = false ) {
		$this->Title = $Title;
		$this->Description = $Description;
		$this->Url = $Url;
		$this->Date = $Date;
		$this->Author = $Author;
		$this->Comments = $Comments;
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
		
		echo $oTmpl->execute( "rss-item" );
	}
}

class PartnerAtomFeed extends AtomFeed {

	function outItem( $item ) {
		
		global $wgMimeType;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"item"		=> $item
		));

		echo $oTmpl->execute( "atom-item" );
	}
}
?>