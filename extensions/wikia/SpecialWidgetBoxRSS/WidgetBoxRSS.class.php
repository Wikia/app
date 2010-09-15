<?php
/**
 *
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

class WidgetBoxRSSFeed extends RSSFeed {

	function outItem( $item ) {
		echo "		<item> \n";
		echo "			<title><![CDATA[{$item->getTitle()}]]></title> \n";
		echo "			<link><![CDATA[{$item->getUrl()}]]></link> \n";
		echo "			<description><![CDATA[{$item->getDescription()}]]></description> \n";
		if( $item->getDate() ) {
			echo "			<pubDate><![CDATA[{$this->formatTime( $item->getDate() )}]]></pubDate> \n";
		}
		if( $item->getAuthor() ) {
			echo "			<dc:creator><![CDATA[{$item->getAuthor()}]]></dc:creator> \n";
		}
		if( $item->getComments() ) {
			echo "			<comments><![CDATA[{$item->getComments()}]]></comments> \n";
		}
		foreach( $item->OtherTags as $key => $val ) {
			echo "			<{$key}><![CDATA[{$item->getOtherTag($key)}]]></{$key}> \n";
		}
		echo "		</item> \n";
	}
}

class WidgetBoxAtomFeed extends AtomFeed {

	function outItem( $item ) {
		global $wgMimeType;

		echo "		<entry> \n";
		echo "			<id><![CDATA[{$item->getUrl()}]]></id> \n";
		echo "			<title><![CDATA[{$item->getTitle()}]]></title> \n";
		echo "			<link rel='alternate' type='".$wgMimeType."' href='".$item->getUrl()."'/> \n";
		echo "			<summary><![CDATA[{$item->getDescription()}]]></summary> \n";
		if( $item->getDate() ) {
			echo "			<updated><![CDATA[{$this->formatTime( $item->getDate() )}]]></updated> \n";
		}
		if( $item->getAuthor() ) {
			echo "			<author><![CDATA[{$item->getAuthor()}]]></author> \n";
		}
		foreach( $item->OtherTags as $key => $val ) {
			echo "			<{$key}><![CDATA[<{$item->getOtherTag($key)}>]]></{$key}> \n";
		}
		echo "		</entry> \n";
	}
}
?>