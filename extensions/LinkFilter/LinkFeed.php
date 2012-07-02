<?php
/**
 * Generates a RSS feed of the most recent submitted links.
 *
 * @file
 * @ingroup Extensions
 */
class LinkFeed extends RSSFeed {

	/**
	 * Output the header for this feed.
	 */
	function outHeader() {
		global $wgServer, $wgScriptPath, $wgEmergencyContact;

		$stuff = '';
		// This message is used by the ArticleMetaDescription extension
		$message = trim( wfMsgForContent( 'description' ) );
		if( !wfEmptyMsg( 'description', $message ) ) {
			$stuff = '<description>' . $message . "</description>\n\t\t";
		}

		$this->outXmlHeader();
?><rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:feedburner="http://rssnamespace.org/feedburner/ext/1.0">
	<channel>
		<title><?php echo wfMsgExt( 'linkfilter-feed-title', 'parsemag' ) ?></title>
		<link><?php echo $wgServer . $wgScriptPath ?></link>
		<?php echo $stuff ?><language><?php echo $this->getLanguage() ?></language>
		<pubDate><?php echo $this->formatTime( time() ) ?></pubDate>
		<managingEditor><?php echo $wgEmergencyContact ?></managingEditor>
		<webMaster><?php echo $wgEmergencyContact ?></webMaster>
<?php
	}

	/**
	 * Output an individual feed item.
	 *
	 * @param $item
	 */
	function outItem( $item ) {
		$url = $item->getUrl();
?>
	<item>
		<title><?php echo $item->getTitle() ?></title>
		<description><![CDATA[<?php echo $item->getDescription() ?>]]></description>
		<link><?php echo $url ?></link>
		<guid isPermaLink="true"><?php echo $url ?></guid>
	</item>
<?php
	}

} // end of the class