<?php

/**
 * @package MediaWiki
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: Classes.php 6127 2007-10-11 11:10:32Z eloy $
 */


/**
 * This class have only static methods so they can be used anywhere
 *
 */

class Wikia {

	/**
	 * @author inez@wikia.com
	 */
	function getThemesOfSkin($skinname = 'quartz') {
		global $wgSkinTheme;

		$themes = array();

		if(isset($wgSkinTheme) && is_array($wgSkinTheme) && isset($wgSkinTheme[$skinname])) {
			foreach($wgSkinTheme[$skinname] as $val) {
				if( $val != 'custom' && ! (isset($wgSkipThemes) && is_array($wgSkipThemes) && isset($wgSkipThemes[$skinname]) && in_array($wgSkipThemes[$skinname],$val))) {
					$themes[] = $val;
				}
			}
		}

		return $themes;
	}



    /**
     * successbox
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $what message for user
     *
     * @return string composed HTML/XML code
     */
    static public function successbox($what)
    {
        return Xml::element("div", array( "class"=> "successbox", "style" => "margin: 0;"), $what).
            Xml::element("hr", array( "style" => "clear: both;margin:0;margin-top: 10pt;"));
    }

    /**
     * errorbox
     *
     * return div with error message
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $what message for user
     *
     * @return string composed HTML/XML code
     */
    static public function errorbox($what)
    {
        return Xml::element("div", array( "class"=> "errorbox"), $what).
            Xml::element("hr", array( "style" => "clear: both;margin:0;margin-top: 10pt;"));
    }

    /**
     * errormsg
     *
     * return span for error message
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $what message for user
     *
     * @return string composed HTML/XML code
     */
    static public function errormsg($what)
    {
        return Xml::element("span", array( "style"=> "color: #fe0000; font-weight: bold;"), $what);
    }

    /**
     * link
     *
     * return XML/HTML code with link
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $url: message for user
     * @param string $title: link body
     * @param mixed $attribs default null: attribbs for tag
     *
     * @todo safety checking
     *
     * @return string composed HTML/XML code
     */
    static public function link($url, $title, $attribs = null )
    {
        return XML::element("a", array( "href"=> $url), $title);
    }

    /**
     * successmsg
     *
     * return span for success message
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $what message for user
     *
     * @return string composed HTML/XML code
     */
    static public function successmsg($what)
    {
        return Xml::element("span", array( "style"=> "color: darkgreen; font-weight: bold;"), $what);
    }

    /**
     * fixDomainName
     *
     * It takes domain name as param, then checks if it contains more than one
     * dot, then depending on that information adds .wikia.com domain or not.
     * Additionally it lowercase name
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $name Domain Name
     * @param string $language default null - choosen language
     *
     * @return string fixed domain name
     */
    static public function fixDomainName( $name, $language = null )
    {
        if (empty( $name )) {
            return $name;
        }

        $name = strtolower($name);

        if ( !is_null($language) && $language != "en" ) {
            $name = $language.".".$name;
        }

        $aParts = explode(".", trim($name));

        if (is_array( $aParts )) {
            if (count( $aParts ) <= 2) {
                $name = $name.".wikia.com";
            }
        }
        return $name;
    }


    /**
     * addCredits
     *
     * add html with credits to xml dump
     *
     * @access public
     * @static
     * @author eloy@wikia
     * @author emil@wikia
     *
     * @param object $row: Database Row with page object
     *
     * @return string: HTML string with credits line
     */
    static public function addCredits( $row )
    {
		global $wgIwPrefix, $wgSharedDB, $wgAddFromLink;

        $text = "";

		if ( $wgAddFromLink && ($row->page_namespace != 8) && ($row->page_namespace != 10) ) {
			if (isset($wgIwPrefix)){
				$text .= '<div id="wikia-credits"><br /><br /><small>' . wfMsg('tagline-url-interwiki',$wgIwPrefix) . '</small></div>';
			}
            elseif (isset($wgSharedDB)){
				global $wgServer,$wgArticlePath,$wgSitename;
				$dbr = wfGetDB( DB_SLAVE );
				$oRow = $dbr->selectRow(
                    wfSharedTable("interwiki"),
                    array( 'iw_prefix' ),
                    array( 'iw_url' => $wgServer.$wgArticlePath ),
                    __METHOD__
                );
				if ($oRow) {
					$text .= '<div id="wikia-credits"><br /><br /><small>' . wfMsg('tagline-url-interwiki',$oRow->iw_prefix) . '</small></div>';
				}
				else {
					$text .= '<div id="wikia-credits"><br /><br /><small>' . wfMsg('tagline-url') . '</small></div>';
				}
			}
            else {
				$text .= '<div id="wikia-credits"><br /><br /><small>' . wfMsg('tagline-url') . '</small></div>';
			}
		}

        return $text;
    }

    /**
     * ImageProgress
     *
     * hmtl code with progress image
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $type: type of progress image, default bar
     *
     * @return string: HTML string with progress image
     */
    static public function ImageProgress( $type = "bar" )
    {
        $sImagesCommonPath = wfGetImagesCommon();
        switch ( $type ) {
            default:
                return wfElement( 'img', array(
                    "src"    => "{$sImagesCommonPath}/skins/quartz/images/progress_bar.gif",
                    "width"  => 100,
                    "height" => 9,
                    "alt"    => ".....",
                    "border" => 0
                ));
        }
    }

    /**
     * json_encode
     *
     * json encoding function
     *
     * @access public
     * @static
     * author eloy@wikia
     *
     * @param mixed $what: structure for encoding
     *
     * @return string: encoded string
     */
    static public function json_encode( $what )
    {
        wfProfileIn( __METHOD__ );

        $sResponse = "";

        if (!function_exists('json_encode'))  { #--- php < 5.2
            $oJson = new Services_JSON();
            $sResponse = $oJson->encode( $what );
        }
        else {
            $sResponse = json_encode( $what );
        }
        wfProfileOut( __METHOD__ );

        return $sResponse;
    }

    /**
     * json_decode
     *
     * json decoding function
     *
     * @access public
     * @static
     * author eloy@wikia
     *
     * @param string $what: json string for decoding
     * @param boolean $assoc: returned object will be converted into associative array
     *
     * @return mixed: decoded structure
     */
    static public function json_decode( $what, $assoc = false )
    {
		wfProfileIn( __METHOD__ );

		$mResponse = null;

		if (!function_exists('json_decode'))  { #--- php < 5.2
		    $oJson = new Services_JSON();
		    $mResponse = $oJson->decode( $what );
		}
		else {
		    $mResponse = json_decode( $what, $assoc );
		}

		wfProfileOut( __METHOD__ );

		return $mResponse;
    }

    /**
     * binphp
     *
     * full path to php binary used in background scripts. wikia uses
     * /opt/wikia/php/bin/php, fp & localhost could use others. Write here Your
     * additional conditions to check
     *
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
     * @access public
     * @static
     *
     * @return string: path to php binary
     */
    static public function binphp() {
		wfProfileIn( __METHOD__ );

        $path = ( file_exists( "/opt/wikia/php/bin/php" )
            && is_executable( "/opt/wikia/php/bin/php" ) )
            ? "/opt/wikia/php/bin/php"
            : "/usr/bin/php";

		wfProfileOut( __METHOD__ );

        return $path;
    }

	/**
	 * simple logger which log message to STDERR if devel environment is set
	 *
	 * @example Wikia::log( __METHOD__, "1", "checking" );
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 * @param String $method  -- use __METHOD__
	 * @param String $sub     -- if more in one method default false
	 * @param String $message -- additional message default false
	 *
	 */
	static public function log( $method, $sub = false, $message = false ) {
		global $wgDevelEnvironment;

		$method = $sub ? $method . "-" . $sub : $method;
		if( $wgDevelEnvironment ) {
			error_log( $method . ": ", $message );
		}
	}
}
