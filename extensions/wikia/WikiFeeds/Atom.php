<?php

/**
 * WikiFeeds
 *
 * A WikiFeeds extension for MediaWiki
 * Provides Atom feed
 *
 * @author Andrew Yasinsky
 * @copyright Copyright (C) 2008 Andrew Yasinsky, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/WikiFeeds/Atom.php");
 */
 
 /*
 * Custom Atom feed extends wikiaton Feed.php
 * 1. add new custom handles
 * 2. fire up
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named WikiFeeds.\n";
	exit(1) ;
}

global $wgFeedClasses;
$wgFeedClasses['watom'] = 'WAtomFeed';

$dir = dirname(__FILE__);

$wgAutoloadClasses['Atom'] = $dir . '/Atom_body.php';
$wgSpecialPages['atom'] = array( /*class*/ 'Atom', /*name*/ 'Atom', /* permission */'', /*listed*/ false, /*function*/ false, /*file*/ false );

 /**
 * Generate a modified Atom feed
 */
class WAtomFeed extends ChannelFeed {
	/**
	 * @todo document
	 */
	function formatTime( $ts ) {
		// need to use RFC 822 time format at least for rss2.0
		return gmdate( 'Y-m-d\TH:i:s', wfTimestamp( TS_UNIX, $ts ) );
	}

	/**
	 * Outputs a basic header for Atom 1.0 feeds.
	 */
	function outHeader() {
		global $wgVersion, $wgCityId, $wgLogo, $wgFavicon, $wgRightsText;
		$hub = WikiFactoryHub::getInstance();
		$catname = $hub->getCategoryName($wgCityId);

		$this->outXmlHeader();
		?><feed xmlns="http://www.w3.org/2005/Atom" xml:lang="<?php print $this->getLanguage() ?>">
		<title><?php print $this->getTitle() ?></title>
		<link rel="self" type="application/atom+xml" href="<?php print $this->getSelfUrl() ?>"/>
		<link rel="alternate" type="text/html" href="<?php print $this->getUrl() ?>"/>
		<updated><?php print $this->formatTime( wfTimestampNow() ) ?>Z</updated>
		<id>wikia:<?php print $wgCityId ?></id>
		<category><?php print $catname ?></category>
		<rights><?php print $wgRightsText ?></rights>
		<logo><?php print $wgLogo ?></logo>
		<icon><?php print $wgFavicon ?></icon>
<?php
	}

	/**
	 * Atom 1.0 requires a unique, opaque IRI as a unique indentifier
	 * for every feed we create. For now just use the URL, but who
	 * can tell if that's right? If we put options on the feed, do we
	 * have to change the id? Maybe? Maybe not.
	 *
	 * @return string
	 * @private
	 */
	function getFeedId() {
		return $this->getSelfUrl();
	}

	/**
	 * Atom 1.0 requests a self-reference to the feed.
	 * @return string
	 * @private
	 */
	function getSelfUrl() {
		global $wgRequest;
		return htmlspecialchars( $wgRequest->getFullRequestURL() );
	}

	/**
	 * Output a given item.
	 * @param $item
	 */
	function outItem( $item ) {
		global $wgMimeType,$wgCityId,$wgContLang,$wgArticlePath,$wgServer;
		$c='';
		$t = $item->getTitle();
		$titleObj = Title::newFromText($t);
		$articleId = $titleObj->getArticleID();
		$revId = $titleObj->getLatestRevID();
		$categories = $titleObj->getParentCategories();
		$category_string = $wgContLang->getNSText( NS_CATEGORY ) . ':';
		$url = $titleObj->getFullURL();
		$rc_user_text = $item->getAuthor();

		foreach( $categories as $key=>$value ) {
			$c .= '<category term="' . str_replace( '_', ' ', str_replace( $category_string, '', $key) ) . '" />' . "\n\t\t" ;
		}

		$ut = explode('.',$rc_user_text);
		if ( count($ut) == 4 ) {
			//ip;
			$uurl = '';
		} else {
			//username;
			$uurl = '<uri>' . str_replace('$1' , 'User:'. $rc_user_text, $wgServer.$wgArticlePath) . '</uri>';
		}

	?>
	<entry>
		<id>wikia:<?php print $wgCityId ?>:<?php print $articleId ?>:<?php print $revId ?></id>
		<title><?php print $t ?></title>
		<link rel="alternate" type="<?php print $wgMimeType ?>" href="<?php print $url ?>"/>
		<?php if( $item->getDate() ) { ?>
<updated><?php print $this->formatTime( $item->getDate() ) ?>Z</updated>
		<?php } ?>
<?php print $c ?>
<author><name><?php print $item->getAuthor() ?></name><?php print $uurl ?></author>
	</entry>

<?php /* FIXME need to add comments
	<?php if( $item->getComments() ) { ?><dc:comment><?php print $item->getComments() ?></dc:comment><?php }?>
	  */
	}

	/**
	 * Outputs the footer for Atom 1.0 feed (basicly '\</feed\>').
	 */
	function outFooter() {?>
	</feed><?php
	}
}