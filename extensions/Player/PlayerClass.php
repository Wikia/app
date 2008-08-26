<?php
/**
 * Player class
 *
 * @addtogroup SpecialPage
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "not a valid entry point.\n" );
	die( 1 );
}

/**
 *
 */
class Player {

	var $image;
	var $title;
	var $options;
	var $mimetype;
	var $mediatype;
	var $width;
	var $height;
	var $uniq;
	var $playerTitle;

	function __construct( $image, $options, $sizeDefault = 'imagesize' ) {
		wfLoadExtensionMessages( 'Player' );

		if ( is_null( $options ) ) $options = array();
		if ( is_string( $options ) ) $options = urldecodeMap( $options );

		static $uniq = 0;
		$uniq += 1;
		$this->uniq = 'player-' . $uniq . '-' . mt_rand( 1, 100000 );

		$this->options = $options;
		$this->image = $image;
		$this->title = $image->getTitle();

		$this->setType( $image );
		$this->setSize( @$options['width'], @$options['height'], $sizeDefault );
	}

	static function newFromTitle( $title, $options, $sizeDefault = 'imagesize' ) {
		wfLoadExtensionMessages( 'Player' );

		$image = Image::newFromTitle( $title );
		if ( !$image->exists() ) {
			throw new PlayerException(wfMsg("player-not-found"), 404);
		}

		return new Player( $image, $options, $sizeDefault );
	}

	static function newFromName( $name, $options, $sizeDefault = 'imagesize' ) {
		wfLoadExtensionMessages( 'Player' );

		$title = Title::makeTitleSafe(NS_IMAGE, $name);
		if (!$title) throw new PlayerException(wfMsg("player-invalid-title"), 400);

		return Player::newFromTitle( $title, $options, $sizeDefault );
	}

	function assertAllowedType() {
		global $wgPlayerTemplates;
		if (!isset($wgPlayerTemplates[$this->mimetype]) || !$wgPlayerTemplates[$this->mimetype])
			throw new PlayerException(wfMsg("player-not-allowed"), 403);
	}

	function setType( $image ) {
		$this->mimetype = $image->getMimeType();
		$this->mediatype = $image->getMediaType();

		#FIXME: ugly hack! do this on upload!
		if ( $this->mimetype == 'unknown/unknown' ) {
			$mime = MimeMagic::singleton();
			$ext = preg_replace('!^.*\.([^.]+)$!', '\1', $image->getName());
			$this->mimetype = $mime->guessTypesForExtension($ext);
			$this->mediatype = $mime->getMediaType(NULL, $this->mimetype);
		}

		if ( preg_match('!/(x-)?ogg$!', $this->mimetype) ) {

			if ( $this->mediatype == MEDIATYPE_AUDIO ) $this->mimetype = 'audio/ogg';
			else if ( $this->mediatype == MEDIATYPE_VIDEO ) $this->mimetype = 'video/ogg';
			else $this->mimetype = 'application/ogg';
		}
	}

	function setSize( $width, $height, $sizeDefault = 'imagesize' ) {
		global $wgUser;

		#print "[WHq: $width, $height]";

		if ($height) $height = (int)$height;
		if ($width) $width = (int)$width;

		if ($height<=0) $height = NULL;
		if ($width<=0) $width = NULL;

		if ( $this->mediatype == MEDIATYPE_AUDIO ) {
			//HACK! this actually depends on the player used, and thus on the mime type.
			$imgwidth = 250;
			$imgheight = 140;

			if (!$width) $width = $imgwidth;
			if (!$height) $height = $height;
		}
		else {
			$imgwidth  = $this->image->getWidth();
			$imgheight = $this->image->getHeight();

			if ( $this->mediatype == MEDIATYPE_VIDEO && (!$imgwidth || !$imgheight) ) {
				$dim = Player::detectVideoResolution( $this->image, $this->mimetype );
				if ($dim) {
					list( $imgwidth, $imgheight ) = $dim;
					//TODO: store in DataBase!
				}
			}
		}

		$imgratio  = $imgheight && $imgwidth ? (float)$imgwidth / (float)$imgheight : 1;

		#print "[WH0: $width, $height; $imgwidth, $imgheight ~$imgratio]";
		if (!$width && !$height) {
			$wopt = @$this->options['playersize'];
			if ($wopt) {
				if (preg_match('/([it])?(\d+)/i', $wopt, $m)) {
					$sz = @$m[1];
					if ($sz && strtolower($sz) == 't') $sizeDefault = 'thumbsize';
					else $sizeDefault = 'imagesize';

					$wopt = (int)$m[2];
				}
				else $wopt = false;
			}

			if (!$wopt) $wopt = $wgUser->getOption( $sizeDefault );

			if ( $sizeDefault == 'thumbsize' ) $limits = $GLOBALS['wgThumbLimits'];
			else $limits = $GLOBALS['wgImageLimits'];

			if( !isset( $limits[$wopt] ) ) {
					$wopt = User::getDefaultOption( $sizeDefault );
			}

			list($width, $height) = $limits[$wopt];
			if (!$width) $width = $sizeDefault == 'thumbsize' ? 180 : 600;
		}

		#print "[WH1: $width, $height]";

		if ($imgwidth && $width > $imgwidth) {
			if ($height) $height = ceil($height * ((float)$imgwidth / $width));
			$width = $imgwidth;
		}

		if ($imgheight && $height > $imgheight) {
			if ($width) $width = ceil($width * ((float)$imgheight / $height));
			$height = $imgheight;
		}

		#print "[WH2: $width, $height]";

		if (!$width) $width = ceil($height * $imgratio);
		else if (!$height) $height = ceil($width / $imgratio);

		#print "[WH3: $width, $height]";

		$this->width = $width;
		$this->height = $height;
	}

	static function detectVideoResolution( $image, $mimetype = NULL ) {
		global $wgPlayerVideoResolutionDetector;
		if (!$wgPlayerVideoResolutionDetector) return false;

		$file = $image->getImagePath();
		if (!$file) return false;

		if (!$mimetype) $mimetype = $image->getMimeType();

		if (!is_array($wgPlayerVideoResolutionDetector)) $detector = $wgPlayerVideoResolutionDetector;
		else if (isset($wgPlayerVideoResolutionDetector[$mimetype])) $detector = $wgPlayerVideoResolutionDetector[$mimetype];
		else $detector = $wgPlayerVideoResolutionDetector['*'];

		if (!$detector) return false;

		if (is_array($detector)) extract($detector);
		else $command = $detector;

		$command = str_replace('$file', wfEscapeShellArg($file), $command);
		$command = str_replace('$type', wfEscapeShellArg($mimetype), $command);

		wfProfileIn( 'detectVideoResolution' );
		wfDebug( "detectVideoResolution: $command\n" );
		$retval = 0;
		$out = wfShellExec( $command, $retval );
		wfProfileOut( 'detectVideoResolution' );

		if ($retval != 0) return false; //TODO: log!
		if (!$out) return false;

		$out = trim($out);
		if (!$out) return false;

		if (isset($outpattern) && isset($outreplace)) $out = preg_replace($outpattern, $outreplace, $out);

		if (!preg_match('!(\d+)x(\d+)!', $out, $m)) return false;
		array_shift($m);

		return $m; // array( $width, $height )
	}

	/**
	 * Set the script tags in an OutputPage object
	 * @param OutputPage $outputPage
	 */
	static function setHeaders( &$outputPage ) {
		global $wgJsMimeType, $wgPlayerExtensionPath, $wgContLang;
		wfLoadExtensionMessages( 'Player' );

		# Register css file for Player
		/*$outputPage->addLink(
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => $wgPlayerExtensionPath . '/Player.css'
			)
		);*/

		# Register css RTL file for Player
		/*if( $wgContLang->isRTL() ) {
			$outputPage->addLink(
				array(
					'rel' => 'stylesheet',
					'type' => 'text/css',
					'href' => $wgPlayerExtensionPath . '/Player.rtl.css'
				)
			);
		}*/

		# Register main js file for Player
		$outputPage->addScript(
			"<script type=\"{$wgJsMimeType}\" src=\"{$wgPlayerExtensionPath}/Player.js\">" .
			"</script>\n"
		);

			//var playerLoadingMsg = \"".Xml::escapeJsString(wfMsg('player-loading'))."\";
			//var playerErrorMsg = \"".Xml::escapeJsString(wfMsg('player-error'))."\";

		# Add messages
		$outputPage->addScript(
		"	<script type=\"{$wgJsMimeType}\">
			var wgPlayerExtensionPath = \"".$wgPlayerExtensionPath."\";
			</script>\n"
		);
	}

	static function processTemplate( $template, $options ) {
		$html = $template;
		#$html = preg_replace("!\\\\(.)!", "\1\\1\1", $html);

		#print "\nH <pre>".htmlspecialchars($html)."</pre>\n";

		foreach ($options as $k => $v) {
			$html = preg_replace('@\{\{\{'.$k.'(\|([^\}]*?))?\}\}\}@sm', $v, $html);
			$html = preg_replace('@\{\{\{#attr:'.$k.'\}\}\}@sm', $k.'="'.$v.'"', $html);
			$html = preg_replace('@\{\{\{#attr:'.$k.'\|([^\}]*?)\}\}\}@sm', '\1="'.$v.'"', $html);
			$html = preg_replace('@\{\{\{#param:'.$k.'\}\}\}@sm', '<param name="'.$v.'" value="'.$v.'"/>', $html);
			$html = preg_replace('@\{\{\{#param:'.$k.'\|([^\}]*?)\}\}\}@sm', '<param name="\1" value="'.$v.'"/>', $html);
			$html = preg_replace('@\{\{\{#ifset:'.$k.'\|([^\}]*?)\}\}\}@sm', '\1', $html);
			$html = preg_replace('@\{\{\{#ifunset:'.$k.'\|([^\}]*?)\}\}\}@sm', '', $html);
		}

		#print "\nK <pre>".htmlspecialchars($html)."</pre>\n";

		$html = preg_replace('@\{\{\{#env:(\w[-.\w\d]*)\}\}\}@sme', '$GLOBALS["\1"]', $html);

		$html = preg_replace('@\{\{\{\w[-.\w\d]*\}\}\}@sm', '', $html);
		$html = preg_replace('@\{\{\{\w[-.\w\d]*\|([^\}]*)\}\}\}@sm', '\1', $html);
		$html = preg_replace('@\{\{\{#(attr|param):\w[-.\w\d]*(\|[^\}]*)?\}\}\}@sm', '', $html);
		$html = preg_replace('@\{\{\{#ifunset:\w[-.\w\d]*\|([^\}]*?)\}\}\}@sm', '\1', $html);
		$html = preg_replace('@\{\{\{#ifset:\w[-.\w\d]*(\|[^\}]*)?\}\}\}@sm', '', $html);
		$html = preg_replace('@\{\{\{.*?\}\}\}@sm', '', $html);

		#$html = preg_replace("!\1(.)\1!", "\\1", $html);

		$html = trim( preg_replace('@[\r\n\t ]+@', ' ', $html) );
		return $html;
	}

	function getTemplateParameters() {
		global $wgUser, $wgPlayerTemplates, $wgServer;
		static $uniq = 0;
		$uniq += 1;

		$parameters = array();

		$skin = $wgUser->getSkin();

		foreach ($this->options as $k => $v) {
			$parameters[$k] = htmlspecialchars($v, ENT_QUOTES);
		}

		$type = $this->mimetype;

		global $wgPlayerMimeOverride;
		if (isset($wgPlayerMimeOverride[$type])) $type = $wgPlayerMimeOverride[$type];

		$parameters['uniq'] = $this->uniq;
		$parameters['url'] = htmlspecialchars($this->image->getURL());
		$parameters['fullurl'] = htmlspecialchars($wgServer . $this->image->getURL());
		$parameters['type'] = $type;
		$parameters['pageurl'] = htmlspecialchars($this->title->getFullURL());
		$parameters['filename'] = htmlspecialchars($this->title->getText());
		$parameters['plainalt'] = htmlspecialchars($this->title->getText());
		$parameters['htmlalt'] = $skin->makeKnownLinkObj( $this->title );

		$parameters['width'] = $this->width;
		$parameters['height'] = $this->height;

		return $parameters;
	}

	function getTemplate() {
		global $wgPlayerTemplates;

		$template = @$wgPlayerTemplates[$this->mimetype];
		if (!$template) throw new PlayerException(wfMsg("player-not-allowed"), 403); //NOTE: fail *before* applying foregeneric!
		if (@$this->options['forcegeneric']) $template = @$wgPlayerTemplates['generic'];

		return trim( $template );
	}

	function getPlayerHTML( ) {
		$this->assertAllowedType();
		$template = $this->getTemplate();
		$parameters = $this->getTemplateParameters();
		$html = Player::processTemplate($template, $parameters);
		return $html;
	}


	function getPlayerTitle() {
		if (!@$this->playerTitle) $this->playerTitle = SpecialPage::getTitleFor('Player', $this->title->getDBkey());
		return $this->playerTitle;
	}

	function getAjaxPlaceholder( $attributes, $pageopt ) {
		global $wgUser, $wgPlayerExtensionPath, $wgUseAjax;
		$sk = $wgUser->getSkin();

		$this->assertAllowedType();

		if ($pageopt) $pagequery = "options=" . urlencode(urlencodeMap($pageopt)); //NOTE: double-encode!
		else $pagequery = '';

		$sptitle = $this->getPlayerTitle();
		$spurl = $sptitle->getLocalURL( $pagequery );

		$ajaxopt = $this->options;
		$ajaxopt['width'] = $this->width;
		$ajaxopt['height'] = $this->height;
		unset($ajaxopt['caption']);
		$ajaxopt = urlencodeMap($ajaxopt);

		if ( $wgUseAjax ) $js = ' this.href="javascript:void(0);"; loadPlayer("' . Xml::escapeJsString($this->title->getDBkey()) . '", "' . Xml::escapeJsString($ajaxopt) . '", "' . Xml::escapeJsString($this->uniq) . '");';
		else $js = '';

		$alt = htmlspecialchars(wfMsg('player-clicktoplay', $this->title->getText()));
		$blank = "<img src=\"$wgPlayerExtensionPath/blank.gif\" width=\"{$this->width}\" height=\"{$this->height}\" border=\"0\" alt=\"$alt\" class=\"thumbimage\" style=\"width:{$this->width} ! important; height:{$this->height} ! important;\"/>";

		$thumbstyle = '';
		$thumbimg = NULL;
		$thumbname = @$attributes['thumb'];
		if ($thumbname) $thumbimg = Image::newFromName( $thumbname );

		if ($thumbimg && $thumbimg->exists()) {
			$tni = $thumbimg->getThumbnail( $this->width, $this->height );
			if ($tni) $thumbstyle = 'background-image:url('.$tni->getUrl().'); background-position:center; background-repeat:no-repeat; text-decoration:none;';
		}

		$placeholder = '<a href="'.htmlspecialchars($spurl).'" onclick="'.htmlspecialchars($js).'" title="'.$alt.'" class="internal" style="display:block; '.$thumbstyle.'">' .
				$blank .
				'</a>';

		$overlay = "<a id=\"{$this->uniq}-overlay\" href=\"".htmlspecialchars($spurl)."\" onclick=\"".htmlspecialchars($js)."\" title=\"$alt\" class=\"internal\" style=\"display:block; position:absolute; top:0; left:0; width:{$this->width}; height:{$this->height}; background-image:url($wgPlayerExtensionPath/play.gif); background-position:center; background-repeat:no-repeat; text-decoration:none; \">" .
				$blank .
				"</a>";

		return "<div style='position:relative; width:{$this->width}; height:{$this->height};'>$placeholder $overlay</div>";
	}

	function getThumbnailHTML( $attributes, $deferred = NULL ) {
		global $wgUser, $wgPlayerExtensionPath;
		$sk = $wgUser->getSkin();

		if ($deferred === NULL) {
			if ( $this->mediatype == MEDIATYPE_BITMAP
			   || $this->mediatype == MEDIATYPE_DRAWING ) $deferred = false;
			else $deferred = true;
		}

		$pageopt = $this->options;

		unset($pageopt['width']);
		unset($pageopt['height']);
		unset($pageopt['caption']);

		if ($pageopt) $pagequery = "options=" . urlencode(urlencodeMap($pageopt)); //NOTE: double-encode!
		else $pagequery = '';

		$sptitle = $this->getPlayerTitle();
		$splink = $sk->makeLinkObj( $sptitle, wfMsg('player-goto-player'), $pagequery );

		$iplink = $sk->makeLinkObj( $this->title, wfMsg('player-goto-page') );
		$iflink = '<a href="'.htmlspecialchars($this->image->getURL()).'" class="internal">'.wfMsg('player-goto-file').'</a>'; #FIXME: get path

		$caption = @$this->options['caption'];
		if (is_null($caption)) $caption = '';

		if ($deferred) {
			$html = $this->getAjaxPlaceholder($attributes, $pageopt);
		}
		else {
			$html = $this->getPlayerHTML();
		}

		if ($caption != '') $caption = htmlspecialchars($caption); //TODO: use parser to convert wikitext -> html!
		if ($caption != '') $caption .= ' <br /> ';
		if ($iplink != '') $iplink .= ' | ';
		if ($splink != '') $splink .= ' | ';

		$style = '';
		$attr = '';

		$align = @$attributes['align'];
		if (!$align) $align = 'none';

		if ($align == 'left') $aligncls = 'tleft';
		else if ($align == 'right') $aligncls = 'tright';
		else if ($align == 'center') $aligncls = 'tnone';
		else if ($align == 'none') $aligncls = 'tnone';
		else $aligncls = 'tnone'; //inlining complex boxes doesn't really work...

		$cls = 'playerbox thumb ' . $aligncls;
		$innercls = '';
		//$style = 'width:'.$this->width.'px;';

		if (isset($attributes['class'])) $cls.= ' ' . htmlspecialchars($attributes['class']);
		if (isset($attributes['style'])) $style.= ' ' . htmlspecialchars($attributes['style']);
		if (isset($attributes['id'])) $attr.= ' id="' . htmlspecialchars($attributes['id']) . '"';

		$html= '
		<div class="'.$cls.'" '.$attr.'>
		<div class="thumbinner '.$innercls.'" style="width: '.($this->width+2).'px; '.$style.'" id="' . $this->uniq . '-box">
			<div id="' . $this->uniq . '-container">
				'.$html.'
			</div>
			<p class="thumbcaption">
				'.$caption.'
				'.$iplink.'
				'.$splink.'
				'.$iflink.'
			</p>
		</div>
		</div>';

		if ($align == 'center') $html = '<div class="center">' . $html . '</div>';

		return $html;
	}

}

class PlayerException extends MWException {
	function getHTTPCode() {
		switch ($this->code) {
			case '400': $msg = 'Bad request'; break;
			case '403': $msg = 'Forbidden'; break;
			case '404': $msg = 'Not Found'; break;
			case '410': $msg = 'Gone'; break;
			case '500': $msg = 'Internal Server Error'; break;
			case '501': $msg = 'Not Implemented'; break;
			case '503': $msg = 'Service Unavailable'; break;
			default: $msg = '';
		}

		return trim("{$this->code} $msg");
	}
}
