<?php
/**
 * Wrapper class for encapsulating EmbedVideo related parser methods
 *
 * @file
 * @ingroup Extensions
 */

abstract class EmbedVideo {
	protected static $initialized = false;

	/**
	 * Sets up parser functions.
	 */
	public static function setup( $parser ) {
		# Setup parser hooks. ev is the primary hook, evp is supported for
		# legacy purposes
		EmbedVideo::addMagicWord("ev", "EmbedVideo::parserFunction_ev");
		EmbedVideo::addMagicWord("evp", "EmbedVideo::parserFunction_evp");

		return true;
	}

	private static function addMagicWord($word, $function) {
		global $wgParser;
		$wgParser->setFunctionHook($word, $function);
	}

	/**
	 * Embeds video of the chosen service, legacy support for 'evp' version of
	 * the tag
	 * @param Parser $parser Instance of running Parser.
	 * @param String $service Which online service has the video.
	 * @param String $id Identifier of the chosen service
	 * @param String $width Width of video (optional)
	 * @return String Encoded representation of input params (to be processed later)
	 */
	public static function parserFunction_evp($parser, $service = null, $id = null, $desc = null,
		$align = null, $width = null) {
		return EmbedVideo::parserFunction_ev($parser, $service, $id, $width, $align, $desc);
	}

	/**
	 * Embeds video of the chosen service
	 * @param Parser $parser Instance of running Parser.
	 * @param String $service Which online service has the video.
	 * @param String $id Identifier of the chosen service
	 * @param String $width Width of video (optional)
	 * @param String $desc description to show (optional, unused)
	 * @param String $align alignment of the video (optional, unused)
	 * @return String Encoded representation of input params (to be processed later)
	 */
	public static function parserFunction_ev($parser, $service = null, $id = null, $width = null,
		$align = null, $desc = null) {
		global $wgScriptPath;

		# Initialize things once
		if (!EmbedVideo::$initialized) {
			EmbedVideo::VerifyWidthMinAndMax();
			$parser->disableCache();
			EmbedVideo::$initialized = true;
		}

		# Get the name of the host
		if ( $service === null || $id === null ) {
			return EmbedVideo::errMissingParams( $service, $id );
		}

		$service = trim($service);
		$id = trim($id);
		$desc = $parser->recursiveTagParse($desc);

		$entry = EmbedVideo::getServiceEntry( $service );
		if ( !$entry ) {
			return EmbedVideo::errBadService( $service );
		}

		if ( !EmbedVideo::sanitizeWidth( $entry, $width ) ) {
			return EmbedVideo::errBadWidth( $width );
		}
		$height = EmbedVideo::getHeight( $entry, $width );

		$hasalign = ( $align !== null );
		if ( $hasalign ) {
			$desc = EmbedVideo::getDescriptionMarkup( $desc );
		}

		# If the service has an ID pattern specified, verify the id number
		if ( !EmbedVideo::verifyID( $entry, $id ) ) {
			return EmbedVideo::errBadID( $service, $id );
		}

		# if the service has it's own custom extern declaration, use that instead
		if ( array_key_exists ( 'extern', $entry ) && ( $clause = $entry['extern'] ) != null ) {
			$clause = wfMsgReplaceArgs( $clause, array( $wgScriptPath, $id, $width, $height ) );
			if ( $hasalign ) {
				$clause = EmbedVideo::generateAlignExternClause( $clause, $align, $desc, $width, $height );
			}

			return array( $clause, 'noparse' => true, 'isHTML' => true );
		}

		# Build URL and output embedded flash object
		$url = wfMsgReplaceArgs( $entry['url'], array( $id, $width, $height ) );
		$clause = "";
		if ( $hasalign ) {
			$clause = EmbedVideo::generateAlignClause( $url, $width, $height, $align, $desc );
		} else {
			$clause = EmbedVideo::generateNormalClause( $url, $width, $height );
		}

		return array( $clause, 'noparse' => true, 'isHTML' => true );
	}

	# Return the HTML necessary to embed the video normally.
	private static function generateNormalClause( $url, $width, $height ) {
		return Hmtl::rawElement(
			'object',
			array( 'width' => $width, 'height' => $height ),
			Html::element( 'param', array( 'name' => 'movie', 'value' => $url ) )
				. Html::element( 'param', array( 'name' => 'wmode', 'value' => 'transparent' ) )
				. Html::element( 'embed', array(
					'type' => 'application/x-shockwave-flash',
					'wmode' => 'transparent',
					'width' => $width,
					'height' => $height,
					'src' => $url,
				))
		);
	}

	# The HTML necessary to embed the video with a custom embedding clause,
	# specified align and description text
	private static function generateAlignExternClause( $clause, $align, $desc, $width, $height ) {
		$clause =
			Html::openElement( 'div', array( 'class' => "thumb t{$align}" ) ) .
			Html::openElement( 'div', array( 'class' => 'thumbinner', 'width' => "{$width}px" ) ) .
			$clause .
			"<div class=\"thumbcaption\">" .
			$desc .
			"</div></div></div>";

		return $clause;
	}

	# Generate the HTML necessary to embed the video with the given alignment
	# and text description
	private static function generateAlignClause( $url, $width, $height, $align, $desc ) {
		return
			Html::openElement( 'div', array( 'class' => "thumb t{$align}" ) ) .
			Html::openElement( 'div', array( 'class' => 'thumbinner', 'width' => "{$width}px" ) ) .
			Hmtl::rawElement(
			'object',
			array( 'width' => $width, 'height' => $height ),
			Html::element( 'param', array( 'name' => 'movie', 'value' => $url ) )
				. Html::element( 'param', array( 'name' => 'wmode', 'value' => 'transparent' ) )
				. Html::element( 'embed', array(
					'type' => 'application/x-shockwave-flash',
					'wmode' => 'transparent',
					'width' => $width,
					'height' => $height,
					'src' => $url,
				))
			) .
			Html::rawElement( 'div', array(), $desc ) .
			Html::closeElement( 'div' ) . Html::closeElement( 'div' );
	}

	# Get the entry for the specified service, by name
	private static function getServiceEntry( $service ) {
		# Get the entry in the list of services
		global $wgEmbedVideoServiceList;

		return $wgEmbedVideoServiceList[$service];
	}

	# Get the width. If there is no width specified, try to find a default
	# width value for the service. If that isn't set, default to 425.
	# If a width value is provided, verify that it is numerical and that it
	# falls between the specified min and max size values. Return true if
	# the width is suitable, false otherwise.
	private static function sanitizeWidth( $entry, &$width ) {
		global $wgEmbedVideoMinWidth, $wgEmbedVideoMaxWidth;
		if ($width === null || $width == '*' || $width == '') {
			if ( isset( $entry['default_width'] ) ) {
				$width = $entry['default_width'];
			} else {
				$width = 425;
			}

			return true;
		}

		if ( !is_numeric( $width ) ) {
			return false;
		}

		return $width >= $wgEmbedVideoMinWidth && $width <= $wgEmbedVideoMaxWidth;
	}

	# Calculate the height from the given width. The default ratio is 450/350,
	# but that may be overridden for some sites.
	private static function getHeight( $entry, $width ) {
		$ratio = 425 / 350;
		if ( isset( $entry['default_ratio'] ) ) {
			$ratio = $entry['default_ratio'];
		}

		return round( $width / $ratio );
	}

	# If we have a textual description, get the markup necessary to display
	# it on the page.
	private static function getDescriptionMarkup( $desc ) {
		if ( $desc !== null ) {
			return "<div class=\"thumbcaption\">$desc</div>";
		}

		return "";
	}

	# Verify the id number of the video, if a pattern is provided.
	private static function verifyID( $entry, $id ) {
		$idhtml = htmlspecialchars( $id );
		// $idpattern = (isset($entry['id_pattern']) ? $entry['id_pattern'] : '%[^A-Za-z0-9_\\-]%');
		// if ($idhtml == null || preg_match($idpattern, $idhtml)) {

		return ( $idhtml != null );
	}

	# Get an error message for the case where the ID value is bad
	private static function errBadID( $service, $id ) {
		$idhtml = htmlspecialchars( $id );
		$msg = wfMsgForContent( 'embedvideo-bad-id', $idhtml, @htmlspecialchars( $service ) );

		return '<div class="errorbox">' . $msg . '</div>';
	}

	# Get an error message if the width is bad
	private static function errBadWidth( $width ) {
		$msg = wfMsgForContent( 'embedvideo-illegal-width', @htmlspecialchars( $width ) );

		return '<div class="errorbox">' . $msg . '</div>';
	}

	# Get an error message if there are missing parameters
	private static function errMissingParams( $service, $id ) {
		return '<div class="errorbox">' . wfMsg( 'embedvideo-missing-params' ) . '</div>';
	}

	# Get an error message if the service name is bad
	private static function errBadService( $service ) {
		$msg = wfMsg( 'embedvideo-unrecognized-service', @htmlspecialchars( $service ) );
		return '<div class="errorbox">' . $msg . '</div>';
	}

	# Verify that the min and max values for width are sane.
	private static function VerifyWidthMinAndMax() {
		global $wgEmbedVideoMinWidth, $wgEmbedVideoMaxWidth;
		if ( !is_numeric( $wgEmbedVideoMinWidth ) || $wgEmbedVideoMinWidth < 100 ) {
			$wgEmbedVideoMinWidth = 100;
		}

		if ( !is_numeric( $wgEmbedVideoMaxWidth ) || $wgEmbedVideoMaxWidth > 1024 ) {
			$wgEmbedVideoMaxWidth = 1024;
		}
	}
}
