<?php

/**
 * Parse external images white-list addresses
 * use
 * 	- $wgExtImagesWhitelistFiles - to define files with regexes file
 * 	- $wgWhiteListCacheTime - to define memcache expiry time
 *
 * @author Piotr Molski <moli@wikia.com>
 */

if ( ! defined( 'MEDIAWIKI' ) ) {
	die();
}

define ('REGEX_PARSE_IMAGE_WHITELIST', '#%s\s*?=\s*?([\'"]?)((?(1)[^\'>"]*|[^\'>" ]*))(\b)%s(\b)((?(1)[^\'>"]*|[^\'>" ]*))[\'"]?#i');
define ('CLASS_PARSE_IMAGE_WHITELIST', '/class\s*?=\s*?"%s\s*?(%s)"/');
define ('REGEX_IMG_TEXT_IMAGE_WHITELIST', '#<a.*?>(%s)</a>#i');

// Register hooks
$wgHooks['outputMakeExternalImage'][] = 'wfParserExternalImagesWhiteList' ;
function wfParserExternalImagesWhiteList( &$url ) {
    global $wgAllowExternalWhitelistImages;
    wfProfileIn( __METHOD__ );

    if (empty($wgAllowExternalWhitelistImages)) {
        wfProfileOut( __METHOD__ );
        return false;
    }

	$res = wfExtImageLinksToImage($url);
    $is_allowed = (empty($res)) ? false : ($res == $url) ? true : false;

    wfProfileOut( __METHOD__ );
    return $is_allowed;
}

// other functions
function wfExtImagesWhiteListSetup() {
    global $wgExtImagesWhitelistFiles, $wgWhiteListCacheTime;
    $whiteListSetupImage = array();
    if ( empty($wgExtImagesWhitelistFiles) ) { # default values
        $whiteListSetupImage['files'] = null;
    } else {
        $whiteListSetupImage['files'] = $wgExtImagesWhitelistFiles;
    }
    if ( empty($wgWhiteListCacheTime) ) { # default values
        $whiteListSetupImage['expiryTime'] = 900;
    } else {
        $whiteListSetupImage['expiryTime'] = $wgWhiteListCacheTime;
    }
    return $whiteListSetupImage;
}

function wfExtImagesWhiteListParse($text) {
	if (preg_match('#http://(.*?).(jpg|jpeg|png|gif)#i', $text, $captures)) {
	    $lhref = $captures[0];
	    if (preg_match('#^\s*http://[^\/\s]#', $lhref)) {
	        //---
	        $lparsed = parse_url($lhref);
	        $lschema = (!empty($lparsed['scheme'])) ? $lparsed['scheme'] : "http";
			//---
	        if ( empty($lparsed['host']) ) {
	            return false;
            } else {
                $host = (isset($lparsed['host'])) ? $lparsed['host'] : "";
                $path = ""; if ( isset($lparsed['path']) ) $path = (substr($lparsed['path'], 0, 1) == '/') ? $lparsed['path'] : ('/'.$lparsed['path']);
                $lurl = $lschema . "://" . $host . $path;
            }
            #---
            $setup = wfExtImagesWhiteListSetup();
            $wgWhiteListImages = array();
            $whiteList = WikiaExtImagesWhitelist::Instance($setup);
			if (is_object($whiteList)) {
                $wgWhiteListImages = $whiteList->getRegexes();
                # check edited page title -> if page with regexes just clear memcache.
                $whiteList->getSpamList()->clearListMemCache();
            }
			#---
			if (!empty($wgWhiteListImages) && is_array($wgWhiteListImages)) {
			    foreach ($wgWhiteListImages as $id => $regex) {
			        $m = array();
					if (preg_match($regex, $lurl, $m) === false) {
			            return false;
                    } elseif (count($m) > 0) {
                        return $lhref;
                    }
                }
            }
        }
    }

    return false;
}

function wfExtImageLinksToImage(&$str) {
    return preg_replace_callback('#http://(.*?).(jpg|jpeg|png|gif)#i', create_function('$matches', 'return wfExtImagesWhiteListParse($matches[0]);'), $str);
}

#----
#
#
class WikiaExtImagesWhitelist
{
    private $spamList = null;
    private $settings = array();
    private static $_oInstance = null;

    function __construct( $settings ) {
        global $wgDBname;
        $use_prefix = 0;

        foreach ( $settings as $name => $value ) {
            $this->$name = $value;
        }
		wfDebug ("build whitelist image list \n");
		if (empty($settings['regexes'])) {
		    $settings['regexes'] = false;
        }
		if (empty($settings['previousFilter'])) {
		    $settings['previousFilter'] = false;
        }
		if (empty($settings['files'])) {
		    $settings['files'] = array("DB: wikia Mediawiki:External_image_whitelist");
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
		    $settings['memcache_file']  = 'whitelist_image_file'.(($use_prefix == 1) ? '_'.$wgDBname : "");
        }
		if (empty($settings['memcache_regexes'])) {
		    $settings['memcache_regexes'] = 'whitelist_image_regexes'.(($use_prefix == 1) ? '_'.$wgDBname : "");
        }

        $this->settings = $settings;
		$this->spamList = new WikiaSpamRegexBatch("whitelistimages", $this->settings);
		$this->regexes = $this->spamList->getRegexes();
    }

	/**
	 * @static
	 * @param array $settings
	 * @return WikiaExtImagesWhitelist
	 */
	public static function Instance($settings = array()) {
        if(!self::$_oInstance instanceof self) {
            wfDebug("New instance of WikiaExtImagesWhitelist class \n");
            self::$_oInstance = new self($settings);
        }
        return self::$_oInstance;
    }

	public function getSettings() { return $this->settings; }
	public function getSpamList() { return $this->spamList; }
	public function getRegexes()  { return $this->regexes; }
}
