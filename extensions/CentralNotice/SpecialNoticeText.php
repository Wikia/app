<?php

class SpecialNoticeText extends NoticePage {
	var $project = 'wikipedia';
	var $language = 'en';
	
	function __construct() {
		parent::__construct( "NoticeText" );
	}
	
	/**
	 * Clients can cache this as long as they like -- if it changes,
	 * we'll be bumping things at the loader level, bringing a new URL.
	 *
	 * Let's say a week.
	 */
	protected function maxAge() {
		return 86400 * 7;
	}
	
	function getJsOutput( $par ) {
		$this->setLanguage( $par );
		return
			'wgNotice="' .
			strtr(
				Xml::escapeJsString( $this->getHtmlNotice() ),
				array_merge(
					array_map(
						array( $this, 'interpolateScroller' ),
						array(
							'$quote' => $this->getQuotes(),
						)
					),
					array_map(
						array( $this, 'interpolateStrings' ),
						array(
							'$headline' => $this->getHeadlines(),
							'$meter' => $this->getMeter(),
							'$progress' => $this->getMessage( 'centralnotice-progress' ),
							'$target' => $this->getTarget(),
							'$media' => $this->getMessage( 'centralnotice-media' ),
							'$show' => $this->getMessage( 'centralnotice-show' ),
							'$hide' => $this->getMessage( 'centralnotice-hide' ),
							'$donate' => $this->getMessage( 'centralnotice-donate' ),
							'$counter' => $this->getMessage( 'centralnotice-counter',
								array( $this->formatNum( $this->getDonorCount() ) ) ),
							'$blog' => $this->getBlog(),
							'$subheading' => $this->getSubheading(),
							'$thanks' => $this->getThanks(),
						)
					)
				)
			) .
			'";' .
			$this->getScripts();
	}
	
	function getScripts() {
		$showStyle = <<<END
<style type="text/css">#siteNoticeSmall{display:none;}</style>
END;
		$hideStyle = <<<END
<style type="text/css">#siteNoticeBig{display:none;}</style>
END;
		$hideToggleStyle = <<<END
<style type="text/css">.siteNoticeToggle{display:none;}</style>
END;
		$encShowStyle = Xml::encodeJsVar( $showStyle );
		$encHideStyle = Xml::encodeJsVar( $hideStyle );
		$encHideToggleStyle = Xml::encodeJsVar( $hideToggleStyle );
		$script = <<<END
		var wgNoticeToggleState = (document.cookie.indexOf("hidesnmessage=1")==-1);
		document.writeln(
			wgNoticeToggleState
			? $encShowStyle
			: $encHideStyle);
		if(wgUserName == null) {
			document.writeln($encHideToggleStyle);
		}
		function toggleNotice() {
			var big = document.getElementById('siteNoticeBig');
			var small = document.getElementById('siteNoticeSmall');
			if (!wgNoticeToggleState) {
				if(big) big.style.display = 'block';
				if(small) small.style.display = 'none';
				toggleNoticeCookie("0");
			} else {
				if(big) big.style.display = 'none';
				if(small) small.style.display = 'block';
				toggleNoticeCookie("1");
			}
			wgNoticeToggleState = !wgNoticeToggleState;
		}
		function toggleNoticeCookie(state) {
			var e = new Date();
			e.setTime( e.getTime() + (7*24*60*60*1000) ); // one week
			var work="hidesnmessage="+state+"; expires=" + e.toGMTString() + "; path=/";
			document.cookie = work;
		}
END;
		return $script;
	}
	
	private function formatNum( $num ) {
		$lang = Language::factory( $this->language );
		return $lang->formatNum( $num );
	}
	
	private function setLanguage( $par ) {
		// Strip extra ? bits if they've gotten in. Sigh.
		$bits = explode( '?', $par, 2 );
		$par = $bits[0];
		
		// Special:NoticeText/project/language
		$bits = explode( '/', $par );
		if( count( $bits ) == 2 ) {
			$this->project = $bits[0];
			$this->language = $bits[1];
		}
	}
	
	private function interpolateStrings( $data ) {
		if( is_array( $data ) ) {
			if( count( $data ) == 1 ) {
				return Xml::escapeJsString( $data[0] );
			} else {
				return $this->interpolateRandomSelector( $data );
			}
		} else {
			return Xml::escapeJsString( $data );
		}
	}
	
	private function interpolateRandomSelector( $strings ) {
		return '"+' . $this->randomSelector( $strings ) . '+"';
	}
	
	private function randomSelector( $strings ) {
		return
			'function(){' .
				'var s=' . Xml::encodeJsVar( $strings ) . ';' .
				'return s[Math.floor(Math.random()*s.length)];' .
			'}()';
	}
	
	private function interpolateScroller( $strings ) {
		global $wgNoticeScroll;
		if( $wgNoticeScroll ) {
			return
				Xml::escapeJsString( '<marquee scrolldelay="20" scrollamount="2" width="384">' ) .
				'"+' .
				$this->shuffleStrings( $strings ) .
				'+"' .
				Xml::escapeJsString( '</marquee>' );
		} else {
			return $this->interpolateStrings( $strings );
		}
	}
	
	private function shuffleStrings( $strings ) {
		return
			'function(){' .
				'var s=' . Xml::encodeJsVar( $strings ) . ';' .
				# Get a random array of orderings... (array_index,random)
				'var o=[];' .
				'for(var i=0;i<s.length;i++){' .
					'o.push([i,Math.random()]);' .
				'}' .
				'o.sort(function(x,y){return y[1]-x[1];});' .
				# Reorder the array...
				'var r=[];' .
				'for(var i=0;i<o.length;i++){' .
					'r.push(s[o[i][0]]);' .
				'}' .
				# And return a joined string
				'return r.join(" ");' .
			'}()';
	}
	
	function getHtmlNotice() {
		return $this->getMessage( 'centralnotice-template' );
	}
	
	private function getHeadlines() {
		return $this->splitListMessage( 'centralnotice-headlines' );
	}
	
	private function getQuotes() {
		return $this->splitListMessage( 'centralnotice-quotes',
		 	array( $this, 'wrapQuote' ) );
	}
	
	private function getMeter() {
		return $this->getMessage( 'centralnotice-meter' );
		// return "<img src=\"http://upload.wikimedia.org/fundraising/2007/meter.png\" width='407' height='14' />";
	}
	
	private function getTarget() {
		return $this->getMessage( 'centralnotice-target' );
	}
	
	private function splitListMessage( $msg, $callback=false ) {
		$text = $this->getMessage( $msg );
		return $this->splitList( $text, $callback );
	}
	
	private function getMessage( $msg, $params=array() ) {
		$guard = array();
		for( $lang = $this->language; $lang; $lang = $this->safeLangFallback( $lang ) ) {
			if( isset( $guard[$lang] ) )
				break; // avoid loops...
			$guard[$lang] = true;
			if( $text = $this->getRawMessage( "$msg/$lang", $params ) ) {
				return $text;
			}
		}
		return $this->getRawMessage( $msg, $params );
	}
	
	private function safeLangFallback( $lang ) {
		$fallback = Language::getFallbackFor( $lang );
		if( $fallback == 'en' ) {
			// We want to be able to special-case English
			// This lets us put _regular_ English in 'blah' and special-case in 'blah/en'
			return false;
		} else {
			return $fallback;
		}
	}
	
	private function getRawMessage( $msg, $params ) {
		$searchPath = array(
			"$msg/{$this->project}",
			"$msg" );
		foreach( $searchPath as $rawMsg ) {
			wfDebug( __METHOD__ . ": $rawMsg\n" );
			$xparams = array_merge( array( $rawMsg ), $params );
			wfDebug( __METHOD__ . ': ' . str_replace( "\n", " ", var_export( $xparams, true ) ) . "\n" );
			$text = call_user_func_array( 'wfMsgForContentNoTrans',
				$xparams );
			if( !wfEmptyMsg( $rawMsg, $text ) ) {
				return $text;
			}
		}
		return false;
	}
	
	private function splitList( $text, $callback=false ) {
		$list = array_filter(
			array_map(
				array( $this, 'filterListLine' ),
				explode( "\n", $text ) ) );
		if( is_callable( $callback ) ) {
			return array_map( $callback, $list );
		} else {
			return $list;
		}
	}
	
	private function filterListLine( $line ) {
		if( substr( $line, 0, 1 ) == '#' ) {
			return '';
		} else {
			return $this->parse( trim( ltrim( $line, '*' ) ) );
		}
	}
	
	private function parse( $text ) {
		global $wgOut, $wgSitename;
		
		// A god-damned dirty hack!
		$old = array();
		$old['wgSitename'] = $wgSitename;
		$wgSitename = $this->projectName();
		
		$out = preg_replace(
			'/^<p>(.*)\n?<\/p>\n?$/sU',
			'$1',
		 	$wgOut->parse( $text ) );
		
		// Restore globals
		$wgSitename = $old['wgSitename'];
		return $out;
	}
	
	private function projectName() {
		global $wgConf, $IP;

		// This is a damn dirty hack
		if( file_exists( "$IP/InitialiseSettings.php" ) ) {
			require_once "$IP/InitialiseSettings.php";
		}

		// Special cases for commons and meta who have no lang
		if ( $this->project == 'commons' )
			return "Commons";
		else if ( $this->project == 'meta' )
			return "Wikimedia";

		// Guess dbname since we don't have it atm
		$dbname = $this->language . 
			(($this->project == 'wikipedia') ? "wiki" : $this->project );
		$name = $wgConf->get( 'wgSitename', $dbname, $this->project,
			array( 'lang' => $this->language, 'site' => $this->project ) );
		
		if( $name ) {
			return $name;
		} else {
			global $wgLang;
			return $wgLang->ucfirst( $this->project );
		}
	}
	
	function wrapQuote( $text ) {
		return "<span class='fundquote'>" .
			$this->getMessage(
				'centralnotice-quotes-format',
				array( $text ) ) .
			"</span>";
	}

	private function getDonorCount() {
		global $wgNoticeCounterSource, $wgMemc;
		$count = intval( $wgMemc->get( 'centralnotice:counter' ) );
		if( !$count ) {
			$count = intval( @file_get_contents( $wgNoticeCounterSource ) );
			if( !$count ) {
				// nooooo
				return $this->getFallbackDonorCount();
			}
			
			$wgMemc->set( 'centralnotice:counter', $count, 60 );
			$wgMemc->set( 'centralnotice:counter:fallback', $count ); // no expiry
		}

		return $count;
	}
	
	private function getFallbackDonorCount() {
		global $wgMemc;
		$count = intval( $wgMemc->get( 'centralnotice:counter:fallback' ) );
		if( !$count ) {
			return 16672; // number last i saw... dirty hack ;)
		}
		return $count;
	}
	
	private function getBlog() {
		$url = $this->getMessage( 'centralnotice-blog-url' );
		$entry = $this->getCachedRssEntry( $url );
		if( $entry ) {
			list( $link, $title ) = $entry;
			return $this->parse(
				$this->getMessage( 'centralnotice-blog',
					array( $link, wfEscapeWikiText( $title ) ) ) );
		} else {
			return '';
		}
	}
	
	private function getSubheading() {
		// Sigh... hack in another one real quick
		return $this->parse(
			$this->getMessage( 'centralnotice-subheading' ) );
	}
	
	private function getThanks() {
		// Sigh... hack in another one real quick
		return $this->parse(
			$this->getMessage( 'centralnotice-thanks' ) );
	}
	
	private function getCachedRssEntry( $url ) {
		global $wgMemc;
		$key = 'centralnotice:rss:' . md5( $url );
		$cached = $wgMemc->get( $key );
		if( !is_string( $cached ) ) {
			$title = $this->getFirstRssEntry( $url );
			if( $title ) {
				$wgMemc->set( $key, $title, 600 ); // 10-minute
			} else {
				$wgMemc->set( $key, array(), 30 ); // negative cache for a little bit...
			}
		}
		return $title;
	}
	/**
	 * Fetch the first link and title from an RSS feed
	 * @return array
	 */
	private function getFirstRssEntry( $url ) {
		wfSuppressWarnings();
		$feed = simplexml_load_file( $url );
		$title = $feed->channel[0]->item[0]->title;
		$link = $feed->channel[0]->item[0]->link;
		wfRestoreWarnings();

		if( is_object( $title ) && is_object( $link ) ) {
			return array( (string)$link, (string)$title );
		} else {
			return array();
		}
	}
	
}
