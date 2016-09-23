<?php

/**
 * Parse white-list addresses
 * use 
 * 	- '$wgWhitelistFiles' - to define files with addresses
 * 	- $wgWhiteListCacheTime - to define memcache expiry time 
 *
 * @author Piotr Molski <moli@wikia.com>
 */

if ( ! defined( 'MEDIAWIKI' ) ) {
	die();
}


// defines
define ('REGEX_PARSE_WHITELIST', '#%s\s*?=\s*?([\'"]?)((?(1)[^\'>"]*|[^\'>" ]*))(\b)%s(\b)((?(1)[^\'>"]*|[^\'>" ]*))[\'"]?#i');
define ('CLASS_PARSE_WHITELIST', '/class\s*?=\s*?"%s\s*?(%s)"/');

// Register hooks
$wgHooks['ParserAfterTidy'][] = 'wfParserWhiteList' ;
function wfParserWhiteList ( &$out, &$text) { 
	$text = wfWhiteListRemoveNoFollowLinks($text);
	return true;
}

// other functions
function wfWhiteListParseSetup() {
	global $wgWhitelistFiles, $wgWhiteListCacheTime;

	$whiteListSetup = array();

	if ( empty($wgWhitelistFiles) ) # default values
		$whiteListSetup['files'] = null;
	else 
		$whiteListSetup['files'] = (is_array($wgWhitelistFiles)) ? $wgWhitelistFiles : array($wgWhitelistFiles);

	if ( empty($wgWhiteListCacheTime) ) # default values
		$whiteListSetup['expiryTime'] = 900;
	else 
		$whiteListSetup['expiryTime'] = $wgWhiteListCacheTime;
		
	return $whiteListSetup;	
}

function wfWhiteListParse($text) {
	global $wgWhiteListNoFollow;
	wfProfileIn( __METHOD__ );
	//---
	$whitelist = $wgWhiteListNoFollow;
	//---
	if (preg_match(sprintf(REGEX_PARSE_WHITELIST,'rel','nofollow'), $text)) {
	    //---
		preg_match('#href\s*?=\s*?[\'"]?([^\'" ]*)[\'"]?#i', $text, $captures);
		if ( is_array($captures) && isset($captures[1]) ) {
			$lhref = $captures[1];
			if (preg_match('#^\s*http://#', $lhref)) {
				$lparsed = @parse_url($lhref);
				#---
				if ( empty($lparsed) || (!is_array($lparsed)) ) {
					wfProfileOut( __METHOD__ );
					return $text;				
				}
				$lschema = (!empty($lparsed['scheme'])) ? $lparsed['scheme'] : "http";
				//---
				if ( empty($lparsed['host']) ) {
					wfProfileOut( __METHOD__ );
					return $text;
				} else  {
					$host = (isset($lparsed['host'])) ? $lparsed['host'] : "";
					$path = ""; if ( isset($lparsed['path']) ) $path = (substr($lparsed['path'], 0, 1) == '/') ? $lparsed['path'] : ('/'.$lparsed['path']);
					$lurl = $lschema . "://" . $host . $path;
				}
				//---
				$setup = wfWhiteListParseSetup();
				$wgWhiteListLinks = array();
				$whiteList = WikiaWhitelist::Instance($setup);
				if (is_object($whiteList)) {
					$wgWhiteListLinks = $whiteList->getRegexes();
					# check edited page title -> if page with regexes just clear memcache.
					$whiteList->getSpamList()->clearListMemCache();
				}

				//---
				if (!empty($wgWhiteListLinks) && is_array($wgWhiteListLinks)) {
					foreach ($wgWhiteListLinks as $id => $regex) {
						$m = array();
						if (preg_match($regex, $lurl, $m) === false) {
							wfProfileOut( __METHOD__ );
							return $text;
						} else {
							if (count($m) > 0) {
								$text = preg_replace(sprintf(REGEX_PARSE_WHITELIST,"rel","nofollow"), "", $text);
								$text = preg_replace(sprintf(CLASS_PARSE_WHITELIST,"external","(text|free|autonumber)"), "class=\"$1\"", $text);
							}
						}
					}
				}
			} else {
				wfProfileOut( __METHOD__ );
				return $text;
			}
		}
	} 
	
	wfProfileOut( __METHOD__ );
	return $text;
}
	
function wfWhiteListRemoveNoFollowLinks(&$str) {
	return preg_replace_callback("#(<a.*?>)#i", create_function('$matches', 'return wfWhiteListParse($matches[1]);'), $str);
}

#----
#
#
class WikiaWhitelist 
{
	private $spamList = null;
	private $settings = array();
    private static $_oInstance = null;

	function __construct( $settings = array() )
	{
		global $wgDBname;
		
		foreach ( $settings as $name => $value ) {
			$this->$name = $value;
		}

		wfDebug ("build whitelist link list \n");
		
		$use_prefix = 0;
		if (empty($settings['regexes'])) {
		    $settings['regexes'] = false;
        }
		if (empty($settings['previousFilter'])) {
		    $settings['previousFilter'] = false;
        }
		if (empty($settings['files'])) {
		    $settings['files'] = array("DB: wikia MediaWiki:External_links_whitelist");
        } else {
            $use_prefix = 1;
        }
		if (empty($settings['warningTime'])) {
		    $settings['warningTime'] = 600;
        }
		if (empty($settings['expiryTime'])) {
		    $settings['expiryTime'] = 900;
        }
		if (empty($settings['warningChance'])) {
		    $settings['warningChance'] = 100;
        }
        if (empty($settings['memcache_file'])) {
            $settings['memcache_file']  = 'whitelist_file'.(($use_prefix == 1) ? '_'.$wgDBname : "");
        }
		if (empty($settings['memcache_regexes'])) {
		    $settings['memcache_regexes'] = 'whitelist_regexes'.(($use_prefix == 1) ? '_'.$wgDBname : "");
        }

		$this->settings = $settings;
		$this->spamList = new WikiaSpamRegexBatch("whitelistlinks", $this->settings);
		$this->regexes = $this->spamList->getRegexes();
	}

    public static function Instance($settings = array()) {
        if(!self::$_oInstance instanceof self) {
            wfDebug("New instamce of WikiaWhitelist class \n");
            self::$_oInstance = new self($settings);
        }
        return self::$_oInstance;
    }

	public function getSettings() { return $this->settings; }
	public function getSpamList() { return $this->spamList; }
	public function getRegexes()  { return $this->regexes; }
}

