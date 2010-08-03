<?php
/**
 * CategoryFeed extension for MediaWiki 1.4+
 *
 * Copyright (C) 2005 Gabriel Wicke <wicke@wikidev.net>
 * http://wikidev.net
 * 
 * uses bits from recentchanges feeds
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or 
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @todo Create in-page version, especially useful for wikinews
 */


$wgExtensionFunctions[] = 'setupCatRSSExtension';
$wgExtensionCredits['other'][] = array(
	'name' => 'Category Feed',
	'svn-date' => '$LastChangedDate: 2009-02-13 20:13:48 +0100 (ptk, 13 lut 2009) $',
	'svn-revision' => '$LastChangedRevision: 47224 $',
	'author' => 'Gabriel Wicke',
	'description' => 'Uses bits from recentchanges feeds. Create in-page version, especially useful for wikinews',
	'descriptionmsg' => 'catfeed-desc',
	'url' => 'http://wikidev.net',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['catfeed'] = $dir . 'catfeed.i18n.php';

if( $wgCategoryMagicGallery ) 
	require_once('ImageGallery.php');

function setupCatRSSExtension() {

	global $IP;
	require_once( "$IP/includes/CategoryPage.php" );
	require_once("Feed.php");
	wfLoadExtensionMessages( 'catfeed' );
	global $wgHooks;

	$wgHooks['CategoryPageView'][] = 'viewCatFeed';
	global $wgParser;
	$wgParser->setHook( "catnews", "viewCatNewslist" );


	class CategoryByDate extends CategoryPage {
		/**
		* Feed for recently-added members of a category based on cl_timestamp
		* Uses bits of the recentchanges feeds (caching and formatting)
		*/
		
		var $mLimit = 50;
		var $mDatelevel = 2;

		function CategoryByDate( &$title, $tarray = false ) {
			global $wgRequest;
			$this->mTitle = $title;
			$this->mFeedFormat = $wgRequest->getVal( 'feed', '' );
			$this->mTitleStrings = array();
			if ( is_array($tarray) ) {
				foreach($tarray as $title) {
					$this->mTitleStrings[] = $title->getDBkey();
				}
			} else {
				$this->mTitleStrings[] = $title->getDBkey();
			}
		}

		function view() {
			// cache handling in subclass
			return $this->getData();
		}
		function getData() {
			$fname = __CLASS__ . '::' . __FUNCTION__;
			$this->mMaxTimeStamp = 0;
			
			$dbr =& wfGetDB( DB_SLAVE );
			$set = implode( ',', array_map(
				array( &$dbr, 'addQuotes' ),
				$this->mTitleStrings ) );
			$res = $dbr->select(
				array( 'cur', 'categorylinks' ),
				array( 'cur_title', 'cur_namespace', 'cur_text', 'cur_user_text', 'cl_sortkey', 'cl_timestamp' ),
				array( 'cl_from          =  cur_id',
				'cl_to IN (' . $set . ')',
				'cur_is_redirect' => 0),
				$fname,
				array( 'ORDER BY' => 'cl_timestamp DESC, cl_sortkey ASC',
				'LIMIT'    => $this->mLimit ));
				$rows = array();
			while( $row = $dbr->fetchObject ( $res ) ) {
				$rows[] = $row;
				if ( $row->cl_timestamp > $this->mMaxTimeStamp ) {
					$this->mMaxTimeStamp = $row->cl_timestamp;
				}
			}
			return $this->formatRows( &$rows );
		}

		# strip images, links, tags
		function formatSummary ( $text ) {
			global $wgContLang;
			$prefixes = array_keys($wgContLang->getLanguageNames());
			$prefixes[] = $wgContLang->getNsText(NS_CATEGORY);
			$imgprefix = $wgContLang->getNsText(NS_IMAGE);
			$text = "\n".$text;

			$rules = array(
				"/\[\[(".implode('|',$prefixes)."):[^\]]*\]\]/i" => "", # interwiki links, cat links
				"/\[\[(?!".$imgprefix.")([^\[\]]+)\|([^[\]\|]*)\]\]/" => "\$2", # piped links
				"/\[\[(?!".$imgprefix.")([^\[\]]+)\]\]/i" => "\$1", # links
				"/\[http:\/\/[^\s]+\s*(.*?)\]/" => "\$1", # external links
				"/\[\[(".$imgprefix."|Image|Media):[^\]]*\]\]/i" => "", # images, plus int. prefix
				"/<br([^>]{1,60})>/i" => "\n", # break
				"/{{([^}]+)}}/s" => "", # templates
				"/<table[^>]{0,660}>(.{1,1200})<\/table>/si" => "", # short tables are removed
				"/\n{\|(.{1,1200})\n\|}/s" => "", # short tables are removed
				"/\n\|-.*(?=\n)/" => "", # table row in long tables
				"/\n{?\|.*\|?(?=\n)/" => "", # table cell in long tables
				"/\n===\s*(.*)\s*===\s*\n/" => "\n* \$1\n", # h3
				"/\n==\s*(.*)\s*==\s*\n/" => "\n* \$1\n", # h2
				"/\n=\s*(.*)\s*=\s*\n/" => "\n* \$1\n", # h1
				"/'''([^']+)'''/" => "\$1", # bold
				"/''([^']+)''/" => "\$1", # italic
				"/\n----+/" => "", # hr
				"/<([^>]{1,2000})>/s" => "", # any html tags
				"/__\w{1,60}__/i" => "", # __notoc__ etc
				"/(\n\s*)+/" => "\n" # many newlines
			);

			$text = preg_replace( array_keys($rules), array_values($rules), $text); 
			
			# only return the first few chars for now
			$shorttext = $wgContLang->truncate( trim( $text ), 145 );
			return htmlspecialchars( $shorttext );
		}
		
		function setLimit($limit) {
			$this->mLimit=$limit;
		}
		
		function setDatelevel($datelevel) {
			$this->mDatelevel=$datelevel;
		}

	}

	class CategoryByDateFeed extends CategoryByDate {

		function view() {
			global $wgRequest;
			global $messageMemc, $wgDBname;
			global $wgFeedClasses, $wgTitle, $wgSitename, $wgContLanguageCode;

			if( !isset( $wgFeedClasses[$this->mFeedFormat] ) ) {
				wfHttpError( 500, "Internal Server Error", "Unsupported feed type." );
				return false;
			}
			$feedTitle = $this->mTitle->getPrefixedText() . ' - ' . $wgSitename;
			$this->feed = new $wgFeedClasses[$this->mFeedFormat](
				$feedTitle,
				htmlspecialchars( wfMsgForContent( 'catfeedsummary' ) ),
				$wgTitle->getFullUrl() );
						
			$pagekey = md5( $this->mTitle->getDBkey() );
			$timekey = "$wgDBname:catfeed:$pagekey:$this->mFeedFormat:limit:{$this->mLimit}:timestamp";
			$key = "$wgDBname:catfeed:$pagekey:$this->mFeedFormat:limit:{$this->mLimit}";
			$cachedFeed = false;
			$adddeltimestamp = $wgDBname.':Category:'.$pagekey.':adddeltimestamp';
			
			$catLastAddDel = $messageMemc->get( $adddeltimestamp );

			if( $feedLastmod = $messageMemc->get( $timekey )
			and $catLastAddDel <= $feedLastmod ) {
				wfDebug( "CatFeed: loading feed from cache ($key; $feedLastmod; $catLastAddDel )...\n" );
				$cachedFeed = $messageMemc->get( $key );
			} else {
				wfDebug( "CatFeed: cached feed timestamp check failed ($feedLastmod; $catLastAddDel) timekey: $timekey; adddel: $adddeltimestamp \n" );

			}
			if( is_string( $cachedFeed ) ) {
				wfDebug( "CatFeed: Outputting cached feed\n" );
				$this->feed->httpHeaders();
				echo $cachedFeed;
			} else {
				wfDebug( "CatFeed: rendering new feed and caching it\n" );
				ob_start();
				$this->getData();
				$cachedFeed = ob_get_contents();
				ob_end_flush();

				$expire = 3600 * 24; # One day
				$messageMemc->set( $key, $cachedFeed );
				$messageMemc->set( $timekey, $catLastAddDel , $expire );
			}
			return true;
		}

		function formatRows( $rows ) {
			global $wgSitename, $wgFeedClasses, $wgContLanguageCode;

			$this->feed->outHeader();
			foreach( $rows as $row ) {
				$title = Title::makeTitle( $row->cur_namespace, $row->cur_title );
				$item = new FeedItem(
					$title->getPrefixedText(),
					$this->formatSummary( $row->cur_text ),
					$title->getFullURL(),
					$row->cl_timestamp,
					$row->cur_user_text,
					'' #$talkpage->getFullURL()
				);
				$this->feed->outItem( $item );
			}
			$this->feed->outFooter();
		}

	}

	class CategoryByDateNewslist extends CategoryByDate {
		
		function formatRows( $rows ) {
			# format members of a category as 'news list' within a page
			# useful for portals, probably wikinews etc
			# todo: allow multiple categories to be merged ('or' in sql)
			global $wgUser, $wgLang;
			$skin = &$wgUser->getSkin();
			$list = '';
			$ts = $closedl = $date = $oldns = $oldtitle = '';
			foreach( $rows as $row ) {
				# check for duplicates, cheaper than in the db
				if($row->cur_namespace != $oldns or $row->cur_title != $oldtitle) {
					$oldns = $row->cur_namespace;
					$oldtitle = $row->cur_title;
					$title = Title::makeTitle( $row->cur_namespace, $row->cur_title );
					$ts = $row->cl_timestamp;
					$newdate = $wgLang->date( wfTimestamp( TS_MW, $ts ) );
					if( $date != $newdate ) {
						$date = $newdate;
						$list .= "$closedl\n<h{$this->mDatelevel}> ".$date." </h{$this->mDatelevel}>\n<dl>";
						$closedl = '</dl>';
					}
					$list .= '<dt>' . $skin->makeKnownLinkObj($title) .
					' <span style="font-size: 0.76em;font-weight:normal;">' .
					$wgLang->time( wfTimestamp( TS_MW, $ts ) ) . '</span></dt><dd> ' .
					$this->formatSummary( $row->cur_text ).'</dd>';
				}
			}
			return $list . $closedl;
		}
	}

}

function viewCatFeed( &$CategoryPage ) {
	global $wgRequest;
	$catfeed = new CategoryByDateFeed($CategoryPage->mTitle);
	# nothing to do,CategoryPage::view continues
	if(!$wgRequest->getBool('feed',false)) return true;
	
	# else continue
	$catfeed->view();
	# stop CategoryPage::view from continuing
	return false;
}
function viewCatNewslist( $input ) {
	$text = '';
	
	# Defaults
	#
	# Number of headlines to be shown	
	$limit=50;
	# Header level to be used for dates
	$datelevel=2;
	
	# Extract possible options from input
	getCatOption($limit,$input,"limit");
	getCatOption($datelevel,$input,"datelevel");	

	$iptitles = split("\n",trim($input));
	$dbtitles = array();
	
	# Add only valid title objects
	foreach ( $iptitles as $title ) {
		$addtitle = Title::newFromUrl($title);
		if(get_class($addtitle)=="title") {
			$dbtitles[] = $addtitle;
		}
	}
	# search for 5 categories max for now 
	$dbtitles = array_slice($dbtitles, 0, 4);
	if(count($dbtitles)>0) {
		$catnews = new CategoryByDateNewslist($dbtitles[0], $dbtitles);
		$catnews->setLimit($limit);
		$catnews->setDatelevel($datelevel);		
		$text .= $catnews->view();
	}
	
	return $text;
}

function getCatOption(&$value,&$input,$name) {

	if(preg_match("/$name\s*=\s*(\d+)/mi",$input,$matches)) {
		$value=$matches[1];
		# Extract from input
		$input=preg_replace("/$name\s*=\s*\d+/mi","",$input);		
	} 
}

