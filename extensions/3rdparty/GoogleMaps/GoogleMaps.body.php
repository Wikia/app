<?php

// if we're not in the mediawiki framework just die
if( !defined( 'MEDIAWIKI' ) ) {
	die( );
}

define('GOOGLE_MAPS_PARSE_INCLUDES', 0);
define('GOOGLE_MAPS_PARSE_ADD_MARKER', 1);
define('GOOGLE_MAPS_PARSE_POINTS', 2);
/**
 * This is a class for adding Google maps to Mediawiki articles.  The class
 * takes care of all hook registration and output of both the map editing
 * interface and the map display within the article.
 *
 * To use this class, create an instance and add the 'install' function of
 * the instantiated object as an extension function:
 *
 * $wgGoogleMapExtension = new GoogleMaps( ... );
 * $wgExtensionFunctions[] = array( $wgGoogleMapExtension, 'install' );
 **/
class GoogleMaps {

	//----------------------------------------------
	// MEMBER FIELDS
	//----------------------------------------------

	// the Google API key (obtained from
	// http://www.google.com/apis/maps/signup.html)
	var $mApiKey = null;

	// if true, paths will be enabled on the maps
	var $mEnablePaths = false;

	// the map language message structure
	var $mMessages = null;

	// custom messages.  these override the values in $mMessages, if present
	var $mCustomMessages = null;

	// the MediaWiki language code (used to key messgaes)
	var $mLanguageCode = null;

	// a local count of how many maps	have been rendered on the current page
	var $mGoogleMapsOnThisPage = 0;

	// the mime type to use for javascript
	var $mJsMimeType = null;

	// the map default settings
	var $mMapDefaults = null;

	// the template variables to process
	var $mProcessTemplateVariables  = null;

	// an array of valid values for map settings. The keys are the setting names
	// and the values are arrays of valid values for that setting.
	var $mApprovedValues = null;

	// a dictionary of tokens	mapped to their	end	values for different settings.
	// the keys to the array are the setting names, the values are hashes	of
	// key/value pairs where the key is the token	and	the	value is the full
	// value.
	var $mOptionDictionary = null;

	// whether the current language is read right-to-left
	var $mLanguage = null;

	// a secret key used in parsing
	var $wgProxyKey = null;

	// the current page
	var $mTitle  = null;

	//----------------------------------------------
	// CONSTRUCTOR
	//----------------------------------------------

	/**
	 * Instantiates a new GoogleMaps object. The constructor simply captures all
	 * of the values passed as member fields. Since the constructor is called on
	 * every page load, we want to keep this as light as possible.  That's why
	 * any of the start up logic is moved to the 'install' function. Granted,
	 * the install function is called on almost every single MW page, but if MW
	 * changes how extensions are loaded to be more intelligent somehow, then this
	 * would benefit from it automatically.
	 *
	 * All of the values are passed by reference (even if not technically needed)
	 * and stored as references to keep from making copies of the various MW
	 * globals unnecessarily.
	 *
	 * @param $pApiKey string - the default Google API key
	 * @param $pUrlPath string - the URL path to the GoogleMaps extension
	 * @param $pEnablePaths boolean - whether or not to allow paths on maps
	 * @param $pMapDefaults array - an array of map setting defaults
	 * @param $pMessages array - the message data structure
	 * @param $pCustomMessages array - message overrides
	 * @param $pProcessTemplateVariables boolean - whether or not to process
	 *          template variables
	 * @param $pJsMimeType string - the Javascript mime type
	 * @param $pLanguageCode string - the language identifier ('en', 'fr', etc.)
	 **/
	function __construct (
		&$pApiKey,
		&$pUrlPath,
		&$pEnablePaths,
		&$pMapDefaults,
		&$pMessages,
		&$pCustomMessages,
		&$pProcessTemplateVariables,
		&$pJsMimeType,
		&$pContLang,
		&$pProxyKey,
		&$pTitle ) {

		$this->mApiKey	 =& $pApiKey;
		$this->mEnablePaths =& $pEnablePaths;
		$this->mMapDefaults =& $pMapDefaults;
		$this->mJsMimeType =& $pJsMimeType;
		$this->mUrlPath	 =& $pUrlPath;
		$this->mMessages =& $pMessages;
		$this->mCustomMessages			  =& $pCustomMessages;
		$this->mProcessTemplateVariables  =& $pProcessTemplateVariables;
		$this->mLanguage =& $pContLang;
		$this->mProxyKey =& $pProxyKey;
		$this->mTitle =& $pTitle;
	}


	//----------------------------------------------
	// PUBLIC METHODS
	//----------------------------------------------

	/**
	 * This function renders the control for opening the interactive map editor
	 * as well as some base javascript utilities needed by the map editing
	 * script (messages, settings, JS includes, etc.).  Most of the actual
	 * interactive editing code is in the EditorsMap.js file.
	 *
	 * @param &$toolbarHtml String - toolbar HTML
	 *
	 * @return boolean - true if successful
	 **/
	function editForm ( &$toolbarHtml ) {

		$this->mLanguageCode = $this->mLanguage->getCode();

		// get the current map settings
		$o = self::getMapSettings( $this->mTitle, $this->mMapDefaults );

		$extensionVersion = GOOGLE_MAPS_EXTENSION_VERSION;

		$output = '';

		// output the necessary styles, script includes, and global variables
		$output .= '
<style type="text/css">
	@import "' . $this->mUrlPath . '/css/color_select.css?v=' . $extensionVersion  . '";
	textarea.balloon_textarea {
		width: 220px;
		height: 52px;
	}
</style>
<!--[if IE]>
<style type="text/css">
	@import "' . $this->mUrlPath . '/css/color_select_ie.css?v=' . $extensionVersion  . '";
</style><![endif]-->
<!--[if lt IE 7]>
<style type="text/css">
	@import "' . $this->mUrlPath . '/css/color_select_ie6.css?v=' . $extensionVersion  . '";
</style><![endif]-->
<script type="' . $this->mJsMimeType . '">
//<![CDATA[
';

		$output .= <<<JAVASCRIPT
	var GME_SMALL_ICON;

JAVASCRIPT;

		// format options
		$options = array_merge(array(
			'container' => 'toolbar',
			'textbox' => 'wpTextbox1',
			'toggle' => 'google_maps_toggle_link',
		), $o);

        if ($o['icondir'] && is_dir($o['icondir'])) {
            $labels = array();
            if ($dh = opendir($o['icondir'])) {
                while (($file = readdir($dh)) !== false) {
                    if (substr($file, 0, 1) != "." && substr($file, -4) == ".png") {
                        $labels[] = substr($file, 0, -4);
                    }
                }
            }
            $options['iconlabels'] = implode(",", $labels);
        }

		// output the 'rtl' setting
		$options['rtl'] = $this->mLanguage->isRTL();

		// add JSON encoded options
		$optionsEncoded = json_encode($options);
		$output .= "var editors_options = {$optionsEncoded};";

		// output the base utility JS (addLoadEvent function, etc.)
		$output .= $this->getEssentialJS( );

		// output the messages as the '_' variable
		$output .= $this->getMessageJS( );

		// output the paths supported setting
		$output .= "var GME_PATHS_SUPPORTED = " . ( $this->mEnablePaths ? "true" : "false" ) . "; ";

		// output the function to add the google map link to the editors toolbar
		$output .= <<<JAVASCRIPT


	function loadGoogleMapsJavascript() {
		mw.loader.load('http://maps.google.com/maps?file=api&v={$o['api']}&key={$this->mApiKey}&hl={$this->mLanguageCode}&async=2&callback=initEditorsMap');
	}

	function loadEditorsMapJavascript() {
		mw.loader.load('{$this->mUrlPath}/color_select.js?v={$extensionVersion}');
		mw.loader.load('{$this->mUrlPath}/EditorsMap.js?v={$extensionVersion}');

		window.setTimeout(tryLoadingEditorsMap, 100);
	}

	function tryLoadingEditorsMap() {
		if (typeof(EditorsMap) != "undefined") {
			loadGoogleMapsJavascript();
		} else {
			window.setTimeout(tryLoadingEditorsMap, 100);
		}
	}

	function initEditorsMap() {
		GME_SMALL_ICON = new GIcon();
		GME_SMALL_ICON.image = "http://labs.google.com/ridefinder/images/mm_20_yellow.png";
		GME_SMALL_ICON.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
		GME_SMALL_ICON.iconSize = new GSize(12, 20);
		GME_SMALL_ICON.shadowSize = new GSize(22, 20);
		GME_SMALL_ICON.iconAnchor = new GPoint(6, 20);
		GME_SMALL_ICON.infoWindowAnchor = new GPoint(5, 1);

		window.emap = new EditorsMap(editors_options);
	}

	function insertGoogleMapLinks() {
		window.mwEditButtons && window.mwEditButtons.push({
			imageId: 'mw-editbutton-googlemaps',
			imageFile: '{$this->mUrlPath}/images/button_map_open.gif?v={$extensionVersion}',
			speedTip: _['gm-make-map'],
			onclick: function(ev) {
				// use proper place to insert editor's wrapper
				var containerId = this.parentNode && this.parentNode.id;
				if (containerId) {
					window.editors_options.container = containerId;
				}

				if( typeof EditorsMap == "undefined" ) {
					loadEditorsMapJavascript();
				} else {
					emap.toggleGoogleMap();
				}
				if( this.buttonOn ) {
					this.src = this.src.replace(/_close/,"_open");
					this.alt = _['gm-make-map'];
					this.title = _['gm-make-map'];
					this.buttonOn = false;
				} else {
					this.src = this.src.replace(/_open/,"_close");
					this.alt = _['gm-hide-map'];
					this.title = _['gm-hide-map'];
					this.buttonOn = true;
				}

				ev.preventDefault();

				// fix for reskinned editor
				\$(window).trigger('resize');
			}
		});
	}

	window.unload = function() { GUnload() };

	insertGoogleMapLinks();
//]]>
</script>
JAVASCRIPT;

		// add the output string after the edit toolbar (BugId:5449)
		$toolbarHtml .= $output;

		// return true so other hooks can execute
		return true;
	}

	/**
	 * This function post processes the raw parser output.  It first prepends the output with some
	 * CSS and the main google JS include.  It then replaces the proxy key token with opening and
	 * closing <script> tags. The proxy key is used to prevent people from injecting javascript in
	 * a page by simply using 'BEGINJAVASCRIPT' and 'ENDJAVASCRIPT'.
	 *
	 * @param $pParser Parser - the MW Parser for the page
	 * @param $pValue string - the raw parsed page output
	 *
	 * @return boolean - true if successful
	 **/
	function commentJS ( &$pParser, &$pValue ) {

		$this->mLanguageCode = $this->mLanguage->getCode();

		// check to see if the proxy token appears in the page output (if not, we don't have a map so
		// no need to output our stuff)
		if( isset( $this->mGoogleMapsOnThisPage ) && strstr( $pValue, "%%BEGINJAVASCRIPT" . $this->mProxyKey . "%%" ) ) {
			$o = self::getMapSettings( $this->mTitle, $this->mMapDefaults );

		// output our standard css and script include
		$prefix = '
			<!--[if IE]>
			<style type="text/css">
			v\:* {
				behavior:url(#default#VML);
			}
			</style>
			<![endif]-->
			<script src="http://maps.google.com/maps?file=api&amp;v=' . $o['api'] . '&amp;key=' . $this->mApiKey . '&amp;hl=' . $this->mLanguageCode . '" type="' . $this->mJsMimeType . '"></script>
			%%BEGINJAVASCRIPT' . $this->mProxyKey . '%%
		';

		// concatenate the prefix and essential JS to the passed in value
		$pValue = $prefix . $this->getEssentialJS( ) . "%%ENDJAVASCRIPT" . $this->mProxyKey . "%%" . $pValue;

		// replace the proxy tokens with actual script tags
		$pValue =	str_replace( "%%BEGINJAVASCRIPT" . $this->mProxyKey	. "%%",	"<script type=\"" .	$this->mJsMimeType . "\">\n//<![CDATA[\n", $pValue );
		$pValue =	str_replace( "%%ENDJAVASCRIPT" . $this->mProxyKey .	"%%", "\n//]]>\n</script>\n", $pValue );
		}

		// return true so other	hooks can run
		return true;
	}

	//----------------------------------------------
	// PRIVATE METHODS
	//----------------------------------------------

	/**
	 * This function is for rendering a <googlemap> tag on MW 1.6+.
	 *
	 * @param $pContent string - the content of the <googlemap> tag
	 * @param $pArgv array - an array of attribute name/value pairs for the
	 *   tag
	 * @param $pParser Parser - the MW Parser object for the page being
	 *   rendered
	 *
	 * @return string - the HTML string to output for the <googlemap> tag
	 **/
	function render16 ( $pContent, $pArgv, $pParser ) {
		global $wgGoogleMaps;
		// pass through to the main render function, creating a new parser
		// for parsing the local content
                return $wgGoogleMaps->render( $pContent, $pArgv, $pParser, new Parser() );
	}

	/**
	 * This function processes a single <googlemap> tag and produces the HTML and
	 * Javascript output for rendering the map represented by the tag.
	 *
	 * @param $pContent string - the content of the <googlemap> tag
	 * @param $pArgv array - the array of attribute name/value pairs for the tag
	 * @param $pParser Parser - the MW Parser object for the current page
	 * @param $pLocalParser Parser - the parser for parsing local content
	 *
	 * @return string - the html for rendering the map
	 **/
	function render ( $pContent, $pArgv, &$pParser, &$pLocalParser ) {
            $pLocalParser->mTitle = $this->mTitle;
            $pLocalParser->mOptions = $pParser->mOptions;
			$this->mLanguageCode = $this->mLanguage->getCode();

            // Keep a count of how many <googlemap> tags were used for unique ids
            if( !isset( $this->mGoogleMapsOnThisPage ) ) {
                $this->mGoogleMapsOnThisPage = 1;
            } else {
                $this->mGoogleMapsOnThisPage++;
            }

            if( $this->mProcessTemplateVariables ) { // experimental, see MW bug #2257
                foreach( array_keys( $pArgv ) as $key ) {
                    $pArgv[$key] = $pParser->replaceTemplateVariables( $pArgv[$key] );
                }
                $pContent = $pParser->replaceTemplateVariables( $pContent );
            }

            // a dictionary for validating and interpreting some options.
            $o = self::getMapSettings( $this->mTitle, $this->mMapDefaults );
            $o = $this->getThisMapSettings( $o, $pArgv );

            $o = array_merge($o, array('number_of_maps' => $this->mGoogleMapsOnThisPage,
                'incompatible_message' => $this->translateMessage( 'gm-incompatible-browser' ),
                'incompatible_message_link' => $this->translateMessage( 'gm-incompatible-browser-link' )));
            $img_exporter = new GoogleMapsImgExporter($this->mApiKey, $this->mLanguageCode);
            $img_exporter->addHeader($o);
            self::renderContent($pContent, $pParser, $pLocalParser, $img_exporter, $o);
            $img_exporter->addTrailer();

            $js_exporter = new GoogleMapsJsExporter($this->mLanguage, $this->mProxyKey, $this->mEnablePaths);
            $js_exporter->addHeader($o, $img_exporter->render());
            self::renderContent($pContent, $pParser, $pLocalParser, $js_exporter, $o);
            $js_exporter->addTrailer($o);
            return $js_exporter->render();
        }

	function renderKmlLink($pContent, $pArgv) {
		global $wgTitle;
		$article = isset($pArgv['article']) && $pArgv['article'] ? $pArgv['article'] : $wgTitle->getText();
		$title = Title::newFromText($article);
		$specialTitle = Title::makeTitle( NS_SPECIAL, 'GoogleMapsKML' );
		return '<a href="'.$specialTitle->escapeLocalUrl('article='.$title->getPartialURL()).'">'.$pContent.'</a>';
	}

	static function renderContent($pContent, &$pParser, &$pLocalParser, &$exporter, $o) {
            $lines        = preg_split( "/[\r\n]/", $pContent );
            $tabs         = array( ); // the tabs for the current marker
            $polyline     = array( ); // points in a polyline
            $icons        = array( ); // keeps track of which icons we've made in the JS
            $lineColor    = null;
            $lineOpacity  = null;
            $fillColor    = null;
            $fillOpacity  = null;
            $state        = GOOGLE_MAPS_PARSE_INCLUDES;

            $icon    = null;
            $lat     = null;
            $lon     = null;
            $caption = '';
            $title   = null;
            $stroke  = null;
            $syntax  = $o['version'];

            // The meat of the extension. Translate the content of the tag
            // into JS that produces a set of points, lines, and markers
            foreach( $lines as $line ) {
                // if the line is a hex code, it's the start of a path
                if( preg_match( "/^(\d+)?#([0-9a-fA-F]{2})?([0-9a-fA-F]{6})(?: \(#([0-9a-fA-F]{2})?([0-9a-fA-F]{6})\))?$/", $line, $matches ) ) {

                    // if the color is already set, we were just rendering a path so finish it and start
                    // a new one
                    if( isset( $lineColor ) ) {
                        $exporter->addPolyline( $polyline, $lineColor, $lineOpacity, $stroke, $fillColor, $fillOpacity );
                        $polyline = array( );
                    }

                    if( $state == GOOGLE_MAPS_PARSE_ADD_MARKER ) {
                        self::addMarker($exporter, $pParser, $pLocalParser, $lat, $lon,
                            $icon, $title, $tabs, $caption, isset($lineColor));

                        $tabs    = array( );
                        $caption = '';
                        $title   = null;
                    }

                    $state = GOOGLE_MAPS_PARSE_POINTS;

                    $stroke      = isset($matches[1]) && $matches[1] ? $matches[1] : $o['stroke'];
                    $lineOpacity = isset($matches[2]) && $matches[2] ? $matches[2] : "ff";
                    $lineColor   = isset($matches[3]) && $matches[3] ? $matches[3] : null;
                    $fillOpacity = isset($matches[4]) && $matches[4] ? $matches[4] : "ff";
                    $fillColor   = isset($matches[5]) && $matches[5] ? $matches[5] : null;
                }

                // if the line matches the tab format, add the tabs
                else if( $syntax == "0" && preg_match( '/^\/([^\\\\]+)\\\\ *(.*)$/', $line, $matches ) ) {
                    $parsed = self::parseWikiText($pParser, $pLocalParser, $matches[2], $pParser->mTitle, $pParser->mOptions);
                    $tabs[] = array( 'title' => $matches[1], 'gm-caption' => $parsed);
                    $state = GOOGLE_MAPS_PARSE_ADD_MARKER;
                }
                else if ($syntax != "0" && preg_match( '/^\/([^\\\\]+)\\\\ *$/', $line, $matches ) ) {
                    if (count($tabs)) {
                        $parsed = self::parseWikiText($pParser, $pLocalParser, $caption, $pParser->mTitle, $pParser->mOptions);
                        $tabs[count($tabs)-1]['gm-caption'] = $parsed;
                        $caption = '';
                    }
                    $tabs[] = array( 'title' => $matches[1] );
                }
                else if( $state == GOOGLE_MAPS_PARSE_INCLUDES && preg_match( "/^http:\/\//", $line ) ) {
                    $exporter->addXmlSource($line);
                }
                // the line is a regular point
                else if( preg_match( "/^(?:\(([.a-zA-Z0-9_-]*?)\))? *([0-9.-]+), *([0-9.-]+)(?:, ?(.+))?/", $line, $matches ) ) {
                    // first create the previous marker, now that we have all the tab/caption info
                    if( $state == GOOGLE_MAPS_PARSE_ADD_MARKER ) {
                        self::addMarker($exporter, $pParser, $pLocalParser, $lat, $lon,
                            $icon, $title, $tabs, $caption, isset($lineColor));

                        $tabs    = array( );
                        $caption = '';
                        $title   = null;
                    }

                    $state = GOOGLE_MAPS_PARSE_POINTS;

                    // extract the individual fields from the regex match
                    $icon = isset( $matches[1] ) ? $matches[1] : null;
                    $lat  = isset( $matches[2] ) ? $matches[2] : null;
                    $lon  = isset( $matches[3] ) ? $matches[3] : null;
                    if ($syntax == "0") {
                        $caption = isset( $matches[4] ) ? $matches[4] : '';
                    } else {
                        $title = isset( $matches[4] ) ? $matches[4] : null;
                    }

                    // need to create this icon, since we haven't already
                    if( $icon && !isset($icons[$icon]) ) {
                        $exporter->addIcon($icon, $o);
                        $icons[$icon] = true;
                    }

                    // if we have numeric latitude and longitude, process the point
                    if( is_numeric( $lat ) && is_numeric( $lon ) ) {

                        // if it has an icon override, a caption, or is not in a path, add the marker
                        if ( $icon || count($tabs) > 0 || $caption || $title || !isset( $lineColor ) ) {
                            $state = GOOGLE_MAPS_PARSE_ADD_MARKER;
                        }

                        // If we're making a path, record the location and move on.
                        if( isset( $lineColor ) ) {
                            $polyline[] = array( 'lat' => $lat, 'lon' => $lon );
                        }
                    }
                }

                else if (($state == GOOGLE_MAPS_PARSE_POINTS || $state == GOOGLE_MAPS_PARSE_ADD_MARKER) && $syntax != "0") { // a caption line
                    if ($line != '') {
                        $caption .= $line . "\r\n";
                        $state = GOOGLE_MAPS_PARSE_ADD_MARKER;
                    }
                }
            }

                // if the last iteration was to add a marker, add it
                if( $state == GOOGLE_MAPS_PARSE_ADD_MARKER ) {
                    self::addMarker($exporter, $pParser, $pLocalParser, $lat, $lon, $icon,
                        $title, $tabs, $caption, isset($lineColor));
                }

                // if the last iteration was to	add	a polyline,	add	it
                if(	isset( $lineColor )	) {
                    $exporter->addPolyline( $polyline,	$lineColor,	$lineOpacity, $stroke, $fillColor, $fillOpacity	);
                }
        }

        static function addMarker(&$pExporter, &$pParser, &$pLocalParser, $pLat, $pLon,
            $pIcon, $pTitle, $pTabs, $pCaption, $pLineColorSet) {
            global $wgUser, $wgVersion;
            $parsed = self::parseWikiText($pParser, $pLocalParser, preg_replace('/\r\n/', '<br />', $pCaption), $pParser->mTitle, $pParser->mOptions);
            $title = Title::newFromText($pTitle);

			/* Wikia change begin - @author: macbre */
			/* BugId:8524 */
			// GoogleMaps extension allows user to provide title of the page to be included as
			// a marker description. This check here is to prevent recursive parsing if the provided title
			// is the same as the current page.
			if ($title instanceof Title && $pLocalParser->mTitle instanceof Title) {
				if ($title->equals($pLocalParser->getTitle())) {
					$title = null;
				}
			}
			/* Wikia change end */

            $revision = is_null($title) ? null :
                Revision::newFromTitle($title);
            $parsedArticleText = is_null($revision) ? null :
                self::parseWikiText($pParser, $pLocalParser, $revision->getText(), $revision->getTitle(), $pParser->mOptions);
            $titleMaybeNonexistent = is_null($title) ? Title::makeTitleSafe(NS_MAIN, $pTitle) : $title;
            $skin = $wgUser->getSkin();
            $titleLink = is_null($titleMaybeNonexistent) ? '' : $skin->makeLinkObj($titleMaybeNonexistent);
            if (count($pTabs)) {
                $pTabs[count($pTabs)-1]['gm-caption'] = $parsed;
                $pExporter->addMarker( $pLat, $pLon, $pIcon, $pTitle, $titleLink,
                    $pTabs, $parsedArticleText, $pLineColorSet );
            } else {
                $pExporter->addMarker( $pLat, $pLon, $pIcon, $pTitle, $titleLink,
                    $parsed, $parsedArticleText, $pLineColorSet);
            }
        }

        static function parseWikiText(&$pParser, &$pLocalParser, $pText, $pTitle, &$pOptions) {
            // recursiveTagParse seems broken, so do it the old-fashioned way.
            $parsed = $pLocalParser->parse( $pText, $pTitle, $pOptions, false );
            $html = $parsed->getText();
            return preg_replace('/<script.*?<\/script>/', '', $html);
        }

	//----------------------------------------------
	// UTILITIES
	//----------------------------------------------

	/**
	 * This function returns the array of	approved values	for	the	various	map
	 * settings.
	 *
	 * @return array - an	array whose	keys are setting names and whose values
	 *   are arrays containing the valid values for that setting
	 **/
	static function getApprovedValues	( )	{
		return array(
			'type' => array(
				'map',
				'normal',
				'hybrid',
				'terrain',
                                'satellite',
                                'elevation',
                                'infrared'
			),
			'controls' => array(
				'small',
				'medium',
				'large',
				'none'
			),
			'units'  => array(
				'kilometers',
				'meters',
				'miles'
			),
			'scale' => array(
				'yes',
				'no'
			),
			'selector' => array(
				'yes',
				'no'
			),
			'zoomstyle' => array(
				'smooth',
				'fast'
			),
                        'world' => array(
                            'earth',
                            'moon',
                            'mars'
                        ),
			'scrollwheel' => array(
				'zoom',
				'nothing'
			),
			'doubleclick' => array(
				'recenter',
				'zoom'
			),
			'version' => array(
				'0',
				'0.9'
			),
		);
	}

	/**
	 * This function returns the array of dictionary mapping for the various map
	 * settings. If the member field hasn't yet been initialized, it will be.
	 * The only reason this initialization lives here and not in the member
	 * field declaration itself is only to keep from initializing this array
	 * on every page request.  It's such a trivial amount of data but it still
	 * rubs me the wrong way to initialize data structures when they're only
	 * needed on a very small number of page requests.
	 *
	 * @return array - an array whose keys are setting names and whose values
	 *   are dictionaries containing the mappings for that setting
	 **/
	function &getOptionDictionary ( ) {
		if( empty( $this->mOptionDictionary ) ) {
			$this->mOptionDictionary = array(
				'controls' => array(
					'small'  => 'GSmallZoomControl',
					'medium' => 'GSmallMapControl',
					'large'  => 'GLargeMapControl',
					'none'   => 'none'
				),
			);
		}

		return $this->mOptionDictionary;
	}

	/**
	 * Gets the array of map settings by combining a set of defaults with the current set of
	 * configured options.
	 *
	 * @return array - a hash of setting name/value pairs
	 **/
	static function getMapSettings ( $pTitle = null, $pDefaults =	null) {

		// our defaults, in	case $wgGoogleMapsDefaults isn't specified.
		$o = array(
			'api'         => '2.140',
			'color'       => '#758bc5',
			'controls'    => 'medium',
			'doubleclick' => 'recenter',
			'geocoder'    => true,
			'height'      => 400,
			'icon'        => 'http://www.google.com/mapfiles/marker.png',
			'icons'       => 'http://maps.google.com/mapfiles/marker{label}.png',
                        'iconlabels'  => 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z',
                        'icondir'     => false,
			'shadow'      => 'http://maps.google.com/intl/en_us/mapfiles/shadow50.png',
                        'shadowsize'  => '37x34',
                        'windowanchor'=> '9x2',
                        'iconsize'    => '20x34',
                        'iconanchor'  => '9x34',
			'lat'         => 42.711618,
			'localsearch' => true,
			'lon'         => -73.205112,
			'opacity'     => 0.7,
			'overview'    => 'no',
                        'world'      => 'earth',
			'precision'   => 6,
			'scale'       => 'no',
			'scrollwheel' => 'nothing',
			'selector'    => 'yes',
			'stroke'      => 6,
                        'style'       => '',
			'type'        => 'hybrid',
			'units'       => 'kilometers',
			'version'     => 0,
			'width'       => 600,
			'zoom'        => 12,
			'zoomstyle'   => 'fast',
		);

		// if no map defaults are specified, just return the base set of defaults
		if( !is_array( $pDefaults ) ) {
			return $o;
		}

		$title = $pTitle->getText( );

		// Go through the options and set it to the value in $pDefaults if present and a
		// valid option
		foreach( array_keys( $o ) as $key ) {
			// use the same tests for all numeric options
			if( isset( $o[$key] ) && is_numeric( $o[$key] ) ) {
				if( isset( $pDefaults[$title] ) && is_array( $pDefaults[$title] ) &&
				isset( $pDefaults[$title][$key] ) && is_numeric( $pDefaults[$title][$key] ) ) {
					$o[$key] = $pDefaults[$title][$key];
				} elseif( isset( $pDefaults[$key] ) && is_numeric( $pDefaults[$key] ) ) {
					$o[$key] = $pDefaults[$key];
				}
			}
			else {
				if( isset( $pDefaults[$title] ) && is_array( $pDefaults[$title] ) &&
				  isset( $pDefaults[$title][$key] ) && self::isOptionLegal( $key, $pDefaults[$title][$key] ) ) {
					$o[$key] = $pDefaults[$title][$key];
				} elseif( isset( $pDefaults[$key] ) && self::isOptionLegal( $key, $pDefaults[$key] ) ) {
					$o[$key] = $pDefaults[$key];
				}
			}
		}
		return $o;
	}

        function getThisMapSettings($o, $pArgv) {
            // Override the defaults with what the user specified.
            foreach( array_keys( $o ) as $key ) {
                if( is_numeric( $o[$key] ) && isset( $pArgv[$key] ) && is_numeric( $pArgv[$key] ) ) {
                    $o[$key] = $pArgv[$key];
                } elseif( isset($pArgv[$key] ) && self::isOptionLegal( $key, $pArgv[$key] ) ) {
                    $o[$key] = $this->translateOption( $key, $pArgv[$key] );
                } else { // and translate
                    $o[$key] = $this->translateOption( $key, $o[$key] );
                }
            }
            return $o;
        }


	/**
	 * Check to see if the value of the specified setting is a valid value.
	 *
	 * @param $pKey string - the setting name
	 * @param $pValue mixed - the value to test
	 **/
	static function isOptionLegal ( $pKey, $pValue ) {

		// get the set of approved values to check
		$approvedValues = self::getApprovedValues( );

		// if it's in the approved list, explicitly check the value against the approved values
		if( isset( $approvedValues[$pKey] ) ) {
			foreach( $approvedValues[$pKey] as $value ) {
				// if we find the value in the approved list, return true
				if( $pValue == $value ) {
					return true;
				}
			}
			// if we didn't find the value in the approved list, return false
			return false;
		}

		// if this setting isn't listed in the approved value list, just return true for set values
		return isset( $pValue );
	}

	/**
	 * Translates a value token into the actual value
	 *
	 * @param $pKey string - the setting name
	 * @param $pValue string - the setting token
	 *
	 * @return mixed - the translated value
	 **/
	function translateOption ( $pKey, $pValue ) {

		// get the dictionary of setting options
		$optionDictionary = $this->getOptionDictionary( );

		// if the setting and token is in the dictionary, return its value
		if( isset( $optionDictionary[$pKey] ) ) {
			return isset( $optionDictionary[$pKey][$pValue] ) ? $optionDictionary[$pKey][$pValue] : null;
		}

		// if no translation was found, return the original value
		return $pValue;
	}

	/**
	 * Builds the string for javascript that should be included once per page with a map.
	 *
	 * @return string - the javascript string
	 **/
	function getEssentialJS ( ) {
		/**
		 * Wikia change start
		 */
		$js = <<<JAVASCRIPT
		var mapIcons = {};

		function addLoadEvent(func) {
			if ( window.skin === 'monaco' ) {
				wgAfterContentAndJS.push(function() {
					$(func);
				});
			} else {
				wgAfterContentAndJS.push(func);
			}
		}
JAVASCRIPT;

		/**
		 * Wikia change end
		 */

		// replace multiple spaces with a single space and strip newlines and tabs (make sure no tabs
		// are used within a line of code!)
		return preg_replace( '/  +/', ' ', preg_replace( '/[\n\t]+/', '', $js ) );
	}

	/**
	 * Puts the language file for the map extension into a javascript structure that can be used in
	 * the client side script.  The variable name is '_' for the javascript structure.  If
	 * translations for the messages are included in the language file, the translations are used.
	 * If not, the english message is used.  The '_' array is a 1 dimensional array whose keys are
	 * the message identifiers and whose values are the messages themselves.
	 *
	 * @return string - the javascript for initializing the '_' variable
	 **/
	function getMessageJS ( ) {
		$translation = "var _ = { ";
		foreach( array_keys( $this->mMessages["en"] ) as $key ) {
			$translation .= "'{$key}': " . Xml::encodeJsVar( $this->translateMessage( $key ) ) . ', ';
		}
		$translation = preg_replace( "/, $/", '', $translation );
		$translation .= " };";
		return $translation;
	}

	/**
	 * Looks up the message for a given key. If a translation of the message exists for the current
	 * language, that translation is returned.  Otherwise, the english value is returned.
	 *
	 * @param $pKey string - the message key
	 *
	 * @return string - the message
	 **/
	function translateMessage ( $pKey ) {

		$this->mLanguageCode = $this->mLanguage->getCode();

		// the current content language code
		$code = $this->mLanguageCode;

		// default to the english value
		$value = $this->mMessages['en'][$pKey];

		// if it's in the custom messages array, return that value
		if( is_array( $this->mCustomMessages ) && isset( $this->mCustomMessages[$pKey] ) ) {
			$value = $this->mCustomMessages[$pKey];
		}
		// if it's in the regular messages with the desired language, return that value
		else if( isset( $this->mMessages[$code] ) && is_array( $this->mMessages[$code] ) && isset( $this->mMessages[$code][$pKey] ) ) {
			$value = $this->mMessages[$code][$pKey];
		}

		return $value;
	}

	/**
	 * Tidy treats all input as a block, it will e.g. wrap most
	 * input in <p> if it isn't already, fix that and return the fixed text
	 *
	 * @static
	 *
	 * @param string $text The text to fix
	 * @return string The fixed text
	 */
	static function fixTidy( $text ) {
		global $wgUseTidy;

		if ( $wgUseTidy ) {
			$text = preg_replace( '~^<p>\s*~', '', $text );
			$text = preg_replace( '~\s*</p>\s*~', '', $text );
			$text = preg_replace( '~[\r\n]+~', '', $text );
			$text = preg_replace( '~<!-- Tidy found serious XHTML errors -->~', '', $text );
		}
		return $text;
	}

	static function hex2fraction ( $pHex ) {
		list($num) = sscanf( $pHex, "%2x" );
		return $num / 255;
	}

	static function fixBlockDirection( $text, $isRTL ) {
		if ($isRTL) {
			return '<div style="direction: rtl;">'.$text.'</div>';
		}
		return $text;
	}

	/**
	 * A string reversal that supports UTF-8 encoding but leaves numbers alone.
	 *
	 * @param $pString string - the string to reverse
	 *
	 * @return string - the reversed string
	 **/
	static function fixStringDirection ( $pString, $pIsRTL ) {
		if ($pIsRTL) {
			preg_match_all( '/(\d+)?./us', $pString, $ar );
			return join( '', array_reverse( $ar[0] ) );
		}
		return $pString;
	}
}
