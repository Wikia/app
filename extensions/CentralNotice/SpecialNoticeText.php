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

                // Quick short circuit to be able to show preferred notices
                $templates = array();
                
                if ( $this->language == 'en' && $this->project != null ) {
                    // See if we have any preferred notices for all of en
                    $notices = CentralNoticeDB::getNotices( '', 'en', '', '', 1 );

                    if ( $notices ) {
                        // Pull out values
                        foreach( $notices as $notice => $val ) {
                            // Either match against ALL project or a specific project 
                            if ( $val['project'] == '' || $val['project'] == $this->project ) {
                                $templates = CentralNoticeDB::selectTemplatesAssigned( $notice );
                                break;
                            }
                        }
                    }
                }
                // Didn't find any preferred matches so do an old style lookup
                if ( !$templates ) 
                    $templates = CentralNotice::selectNoticeTemplates( $this->project, $this->language );

		$templateNames = array_keys( $templates );

		$templateTexts = array_map(
			array( $this, 'getHtmlNotice' ),
			$templateNames );
		$weights = array_values( $templates );
		
		return
			$this->getScriptFunctions() .
			$this->getToggleScripts() .
			'wgNotice=pickTemplate(' .
				Xml::encodeJsVar( $templateTexts ) .
				"," .
				Xml::encodeJsVar( $weights ) .
				");\n" .
			"if (wgNotice != '')\n" .
			"wgNotice='<div id=\"centralNotice\" class=\"' + " .
			"(wgNoticeToggleState ? 'expanded' : 'collapsed') + " .
			"' ' + " .
			"(wgUserName ? 'usernotice' : 'anonnotice' ) + " .
			"'\">' + wgNotice+'</div>';\n";
	}

	function getHtmlNotice( $noticeName ) {
		$this->noticeName = $noticeName;
		return preg_replace_callback(
			'/{{{(.*?)}}}/',
			array( $this, 'getNoticeField' ),
			$this->getNoticeTemplate() );
	}

	function getToggleScripts() {
		$showStyle = <<<END
<style type="text/css">
#centralNotice .siteNoticeSmall{display:none;}
#centralNotice .siteNoticeSmallAnon{display:none;}
#centralNotice .siteNoticeSmallUser{display:none;}
#centralNotice.collapsed .siteNoticeBig{display:none;}
#centralNotice.collapsed .siteNoticeSmall{display:block;}
#centralNotice.collapsed .siteNoticeSmallUser{display:block;}
#centralNotice.collapsed .siteNoticeSmallAnon{display:block;}
#centralNotice.anonnotice .siteNoticeSmallUser{display:none !important;}
#centralNotice.usernotice .siteNoticeSmallAnon{display:none !important;}
</style>
END;
		$encShowStyle = Xml::encodeJsVar( $showStyle );

		$script = "
var wgNoticeToggleState = (document.cookie.indexOf('hidesnmessage=1')==-1);
document.writeln($encShowStyle);\n\n";
		return $script;
	}

	function getScriptFunctions() {
		$script = "
function toggleNotice() {
	var notice = document.getElementById('centralNotice');
	if (!wgNoticeToggleState) {
		notice.className = notice.className.replace('collapsed', 'expanded');
		toggleNoticeCookie('0');
	} else {
		notice.className = notice.className.replace('expanded', 'collapsed');
		toggleNoticeCookie('1');
	}
	wgNoticeToggleState = !wgNoticeToggleState;
}
function toggleNoticeStyle(elems, display) {
	if(elems)
		for(var i=0;i<elems.length;i++)
			elems[i].style.display = display;
}
function toggleNoticeCookie(state) {
	var e = new Date();
	e.setTime( e.getTime() + (7*24*60*60*1000) ); // one week
	var work='hidesnmessage='+state+'; expires=' + e.toGMTString() + '; path=/';
	document.cookie = work;
}
function pickTemplate(templates, weights) {
	var weightedTemplates = new Array();
	var currentTemplate = 0;
	var totalWeight = 0;

	if (templates.length == 0)
		return '';

	while (currentTemplate < templates.length) {
		totalWeight += weights[currentTemplate];
		for (i=0; i<weights[currentTemplate]; i++) {
			weightedTemplates[weightedTemplates.length] = templates[currentTemplate];
		}
		currentTemplate++;
	}
	
	if (totalWeight == 0)
		return '';

	var randomnumber=Math.floor(Math.random()*totalWeight);
	return weightedTemplates[randomnumber];
}\n\n";
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
		if ( count( $bits ) >= 2 ) {
			$this->project = $bits[0];
			$this->language = $bits[1];
		}
	}

	function getNoticeTemplate() {
		return $this->getMessage( "centralnotice-template-{$this->noticeName}" );
	}

	function getNoticeField( $matches ) {
		$field = $matches[1];
		$params = array();
		if ( $field == 'amount' ) {
			$params = array( $this->formatNum( $this->getDonationAmount() ) );
		}
		$message = "centralnotice-{$this->noticeName}-$field";
		$source = $this->getMessage( $message, $params );
		return $source;
	}

	private function getMessage( $msg, $params = array() ) {
		// A god-damned dirty hack! :D
		$old = array();
		$old['wgSitename'] = $GLOBALS['wgSitename'];
		$old['wgLang'] = $GLOBALS['wgLang'];
		
		$GLOBALS['wgSitename'] = $this->projectName();
		$GLOBALS['wgLang'] = Language::factory( $this->language ); // hack for {{int:...}}

		$options = array(
			'language' => $this->language,
			'parsemag',
		);
		array_unshift( $params, $options );
		array_unshift( $params, $msg );
		$out = call_user_func_array( 'wfMsgExt', $params );

		// Restore globals
		$GLOBALS['wgSitename'] = $old['wgSitename'];
		$GLOBALS['wgLang'] = $old['wgLang'];

		return $out;
	}

	private function projectName() {
		global $wgConf, $IP;

		// This is a damn dirty hack
		if ( file_exists( "$IP/InitialiseSettings.php" ) ) {
			require_once "$IP/InitialiseSettings.php";
		}

		// Special cases for commons and meta who have no lang
		if ( $this->project == 'commons' )
			return "Commons";
		else if ( $this->project == 'meta' )
			return "Wikimedia";

		// Guess dbname since we don't have it atm
		$dbname = $this->language .
			( ( $this->project == 'wikipedia' ) ? "wiki" : $this->project );
		$name = $wgConf->get( 'wgSitename', $dbname, $this->project,
			array( 'lang' => $this->language, 'site' => $this->project ) );

		if ( $name ) {
			return $name;
		} else {
			global $wgLang;
			return $wgLang->ucfirst( $this->project );
		}
	}

	private function getDonationAmount() {
		global $wgNoticeCounterSource, $wgMemc;
		$count = intval( $wgMemc->get( 'centralnotice:counter' ) );
		if ( !$count ) {
			$count = intval( @file_get_contents( $wgNoticeCounterSource ) );
			if ( !$count ) {
				// nooooo
				return $this->getFallbackDonationAmount();
			}

			$wgMemc->set( 'centralnotice:counter', $count, 60 );
			$wgMemc->set( 'centralnotice:counter:fallback', $count ); // no expiry
		}

		return $count;
	}

	private function getFallbackDonationAmount() {
		global $wgMemc;
		$count = intval( $wgMemc->get( 'centralnotice:counter:fallback' ) );
		if ( !$count ) {
			return 16672; // number last i saw... dirty hack ;)
		}
		return $count;
	}
}
