<?php

class FCKeditorSkin
{
	private $skin;

	/**
	 * Create image link in MediaWiki 1.10
	 *
	 * @param Title $nt
	 * @param string $label label text
	 * @param string $alt alt text
	 * @param string $align horizontal alignment: none, left, center, right)
	 * @param array $params Parameters to be passed to the media handler
	 * @param boolean $framed shows image in original size in a frame
	 * @param boolean $thumb shows image as thumbnail in a frame
	 * @param string $manual_thumb image name for the manual thumbnail
	 * @param string $valign vertical alignment: baseline, sub, super, top, text-top, middle, bottom, text-bottom
	 * @return string     * 
	 */
	function makeImageLinkObj( $nt, $label, $alt, $align = '', $params = array(), $framed = false,
	$thumb = false, $manual_thumb = '', $valign = '' ) {
		$orginal = $nt->getText();
		$img   = new Image( $nt );
		$imgName = $img->getName();
		$found = $img->getURL();

		if ($found) {
			//trick to get real Url for image:
			$originalLink = strip_tags(Linker::makeImageLinkObj($nt, $label, $alt, $align , $params , $framed , $thumb , $manual_thumb , $valign ), "<img>");
			$srcPart = substr($originalLink, strpos($originalLink, "src=")+ 5);
			$url = strtok($srcPart, '"');
		}

		$ret = "<img ";

		if ($found) {
			$ret .= "src=\"{$url}\" ";
		}
		else {
			$ret .= "_fck_mw_valid=\"false"."\" ";
		}
		$ret .= "_fck_mw_filename=\"{$orginal}\" ";

		if ($align) {
			$ret .= "_fck_mw_location=\"".strtolower($align)."\" ";
		}
		if (!empty($params)) {
			if (isset($params['width'])) {
				$ret .= "_fck_mw_width=\"".$params['width']."\" ";
			}
			if (isset($params['height'])) {
				$ret .= "_fck_mw_height=\"".$params['height']."\" ";
			}
		}
		$class = "";
		if ($thumb) {
			$ret .= "_fck_mw_type=\"thumb"."\" ";
			$class .= "fck_mw_frame";
		}
		else if ($framed) {
			$ret .= "_fck_mw_type=\"frame"."\" ";
			$class .= "fck_mw_frame";
		}

		if ($align == "right") {
			$class .= ($class?" ":"") . "fck_mw_right";
		}
		else if($align == "center") {
			$class .= ($class?" ":"") . "fck_mw_center";
		}
		else if($align == "left") {
			$class .= ($class?" ":"") . "fck_mw_left";
		}
		else if($framed || $thumb) {
			$class .= ($class?" ":"") . "fck_mw_right";
		}

		if (!$found) {
			$class .= ($class?" ":"") . "fck_mw_notfound";
		}

		if (!is_null($alt) && !empty($alt) && false !== strpos(FCKeditorParser::$fkc_mw_makeImage_options, $alt) && $alt != "Image:" . $orginal) {
			$ret .= "alt=\"".htmlspecialchars($alt)."\" ";
		}
		else {
			$ret .= "alt=\"\" ";
		}

		if ($class) {
			$ret .= "class=\"$class\" ";
		}

		$ret .= "/>";

		return $ret;
	}

	/**
	 * Make an image link in Mediawiki 1.11
	 * @param Title $title Title object
	 * @param File $file File object, or false if it doesn't exist
	 *
	 * @param array $frameParams Associative array of parameters external to the media handler.
	 *     Boolean parameters are indicated by presence or absence, the value is arbitrary and 
	 *     will often be false.
	 *          thumbnail       If present, downscale and frame
	 *          manualthumb     Image name to use as a thumbnail, instead of automatic scaling
	 *          framed          Shows image in original size in a frame
	 *          frameless       Downscale but don't frame
	 *          upright         If present, tweak default sizes for portrait orientation
	 *          upright_factor  Fudge factor for "upright" tweak (default 0.75)
	 *          border          If present, show a border around the image
	 *          align           Horizontal alignment (left, right, center, none)
	 *          valign          Vertical alignment (baseline, sub, super, top, text-top, middle, 
	 *                          bottom, text-bottom)
	 *          alt             Alternate text for image (i.e. alt attribute). Plain text.
	 *          caption         HTML for image caption.
	 *
	 * @param array $handlerParams Associative array of media handler parameters, to be passed 
	 *       to transform(). Typical keys are "width" and "page". 
	 */
	function makeImageLink2( Title $nt, $file, $frameParams = array(), $handlerParams = array() ) {
		$orginal = $nt->getText();
		$img   = new Image( $nt );
		$imgName = $img->getName();
		$found = $img->getURL();

		if ($found) {
			$linker = new Linker();
			$originalLink = $linker->makeImageLink2( $nt, $file, $frameParams, $handlerParams);

			if (false !== strpos($originalLink, "src=\"")) {
				$srcPart = substr($originalLink, strpos($originalLink, "src=")+ 5);
				$url = strtok($srcPart, '"');
			}
			$srcPart = substr($originalLink, strpos($originalLink, "src=")+ 5);
			$url = strtok($srcPart, '"');
		}

		// Shortcuts
		$fp =& $frameParams;
		$hp =& $handlerParams;

		if (!isset($fp['align'])) {
			$fp['align'] = '';
		}

		$ret = "<img ";

		if ($found) {
			$ret .= "src=\"{$url}\" ";
		}
		else {
			$ret .= "_fck_mw_valid=\"false"."\" ";
		}
		$ret .= "_fck_mw_filename=\"{$orginal}\" ";

		if ($fp['align']) {
			$ret .= "_fck_mw_location=\"".strtolower($fp['align'])."\" ";
		}
		if (!empty($hp)) {
			if (isset($hp['width'])) {
				$ret .= "_fck_mw_width=\"".$hp['width']."\" ";
			}
			if (isset($hp['height'])) {
				$ret .= "_fck_mw_height=\"".$hp['height']."\" ";
			}
		}
		$class = "";
		if (isset($fp['thumbnail'])) {
			$ret .= "_fck_mw_type=\"thumb"."\" ";
			$class .= "fck_mw_frame";
		}
		else if (isset($fp['border'])) {
			$ret .= "_fck_mw_type=\"border"."\" ";
			$class .= "fck_mw_border";
		}
		else if (isset($fp['framed'])) {
			$ret .= "_fck_mw_type=\"frame"."\" ";
			$class .= "fck_mw_frame";
		}

		if ($fp['align'] == "right") {
			$class .= ($class?" ":"") . "fck_mw_right";
		}
		else if($fp['align'] == "center") {
			$class .= ($class?" ":"") . "fck_mw_center";
		}
		else if($fp['align'] == "left") {
			$class .= ($class?" ":"") . "fck_mw_left";
		}
		else if(isset($fp['framed']) || isset($fp['thumbnail'])) {
			$class .= ($class?" ":"") . "fck_mw_right";
		}

		if (!$found) {
			$class .= ($class?" ":"") . "fck_mw_notfound";
		}

		if (isset($fp['alt']) && !empty($fp['alt']) && false !== strpos(FCKeditorParser::$fkc_mw_makeImage_options, $fp['alt']) && $fp['alt'] != "Image:" . $orginal) {
			$ret .= "alt=\"".htmlspecialchars($fp['alt'])."\" ";
		}
		else {
			$ret .= "alt=\"\" ";
		}

		if ($class) {
			$ret .= "class=\"$class\" ";
		}

		$ret .= "/>";

		return $ret;
	}

	function makeKnownLinkObj( $nt, $text = '', $query = '', $trail = '', $prefix = '' , $aprops = '', $style = '' ) {
		$fname = 'FCKeditorSkin::makeKnownLinkObj';
		wfProfileIn( $fname );

		if ( !is_object( $nt ) ) {
			wfProfileOut( $fname );
			return $text;
		}

		//$u = $nt->escapeLocalURL( $query );
		$u = $nt->getFullText();

		if ( $nt->getFragment() != '' ) {
			if( $nt->getPrefixedDbkey() == '' ) {
				$u = '';
				if ( '' == $text ) {
					$text = htmlspecialchars( $nt->getFragment() );
				}
			}
			
			/*
			* See tickets 1386 and 1690 before changing anything
			*/
			if( $nt->getPartialUrl() == '' ) {
				$u .= $nt->getFragmentForURL();
			}
		}
		if ( $text == '' ) {
			$text = htmlspecialchars( $nt->getPrefixedText() );
		}

		if ($nt->getNamespace() == NS_CATEGORY) {
			$u = ':' . $u;
		}

		list( $inside, $trail ) = Linker::splitTrail( $trail );
		$r = "<a href=\"{$u}\">{$prefix}{$text}{$inside}</a>{$trail}";
		wfProfileOut( $fname );
		return $r;
	}

	function makeBrokenLinkObj( $nt, $text = '', $query = '', $trail = '', $prefix = '' ) {
		# Fail gracefully
		if ( ! isset($nt) ) {
			# throw new MWException();
			return "<!-- ERROR -->{$prefix}{$text}{$trail}";
		}

		$fname = 'FCKeditorSkin::makeBrokenLinkObj';
		wfProfileIn( $fname );

		$u = $nt->getFullText();

		if ( '' == $text ) {
			$text = htmlspecialchars( $nt->getPrefixedText() );
		}
		if ($nt->getNamespace() == NS_CATEGORY) {
			$u = ':' . $u;
		}

		list( $inside, $trail ) = Linker::splitTrail( $trail );
		$s = "<a href=\"{$u}\">{$prefix}{$text}{$inside}</a>{$trail}";

		wfProfileOut( $fname );
		return $s;
	}

	/**
	 * Create a direct link to a given uploaded file.
	 *
	 * @param $title Title object.
	 * @param $text  String: pre-sanitized HTML
	 * @return string HTML
	 *
	 * @public
	 * @todo Handle invalid or missing images better.
	 */
	function makeMediaLinkObj( $title, $text = '' ) {
		if( is_null( $title ) ) {
			### HOTFIX. Instead of breaking, return empty string.
			return $text;
		} else {
			$orginal = $title->getPartialURL();
			// Mediawiki 1.11
			if ( function_exists('wfFindFile') ) {
				$img  = wfFindFile( $title );
				if( $img ) {
					$url  = $img->getURL();
					$class = 'internal';
				} else {
					$upload = SpecialPage::getTitleFor( 'Upload' );
					$url = $upload->getLocalUrl( 'wpDestFile=' . urlencode( $title->getDbKey() ) );
					$class = 'new';
				}
			}
			// Mediawiki 1.10
			else {
				$img  = new Image( $title );
				if( $img->exists() ) {
					$url  = $img->getURL();
					$class = 'internal';
				} else {
					$upload = SpecialPage::getTitleFor( 'Upload' );
					$url = $upload->getLocalUrl( 'wpDestFile=' . urlencode( $img->getName() ) );
					$class = 'new';
				}
			}
			$alt = htmlspecialchars( $title->getText() );
			if( $text == '' ) {
				$text = $alt;
			}
			$u = htmlspecialchars( $url );
			return "<a href=\"{$orginal}\" class=\"$class\" _fck_mw_filename=\"{$orginal}\" _fck_mw_type=\"media\" title=\"{$alt}\">{$text}</a>";
		}
	}

	function makeExternalLink( $url, $text, $escape = true, $linktype = '', $ns = null ) {
		$url = htmlspecialchars( $url );
		if( $escape ) {
			$text = htmlspecialchars( $text );
		}
		if ($linktype == 'autonumber') {
			return '<a href="'.$url.'">[n]</a>';
		}
		return '<a href="'.$url.'">'.$text.'</a>';
	}

	function __call( $m, $a) {
		return call_user_func_array( array( $this->skin, $m ), $a );
	}

	function __construct( &$skin ) {
		$this->skin = $skin;
	}
}
