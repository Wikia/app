<?php
/**
 * Class to hook the TrustedMath extension into MediaWiki
 * @author Bryan
 *
 */
class TrustedMathHooks {
	/**
	 * TODO fix
	 */
	public static function onParserAfterStrip( $parser, &$text, &$stripState ) {
		if ( $parser->getTitle()->getNamespace() == NS_TRUSTEDMATH ) {
			if ( strpos( $text, '<math>' ) === false ) {
				$text = "<math>$text</math>";
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Initialize globals to their default values. Hooked by $wgExtensionFunctions.
	 */
	public static function initGlobals() {
		global $wgTrustedMathDirectory, $wgTrustedMathPath;
		global $wgUploadDirectory, $wgUploadPath;
		
		// Use the MediaWiki default path
		if ( is_null( $wgTrustedMathDirectory ) ) {
			$wgTrustedMathDirectory = "$wgUploadDirectory/math";
		}
		if ( is_null( $wgTrustedMathPath ) ) {
			$wgTrustedMathPath = "$wgUploadPath/math";
		}
		
		// Initialize the namespace for TrustedMath
		global $wgVersion, $wgExtraNamespaces;
		if ( version_compare( $wgVersion, '1.17alpha', '<' ) ) {
			self::initNamespace( $wgExtraNamespaces );
		}
		
	}
	
	/**
	 * TODO: check, fix, etc.
	 */
	public static function initNamespace( &$list ) {
		global $wgNamespaceProtection;
		
		$list[NS_TRUSTEDMATH] = 'Math';
		$list[NS_TRUSTEDMATH_TALK] = 'Math_talk';

		if ( !isset( $wgNamespaceProtection[NS_TRUSTEDMATH] ) ) {
			$wgNamespaceProtection[NS_TRUSTEDMATH] = array( 'editmath' );
		}
		
		return true;
	}
	
	/**
	 * Add the math tag as parser hook
	 * @param Parser $parser
	 */
	public static function onParserFirstCallInit( $parser ) {
		$parser->setHook( 'math',  __CLASS__ . '::mathTag' );
		return true;
	}
	
	/**
	 * Render a <math> tag
	 * 
	 * @param string $input
	 * @param array $args
	 * @param Parser $parser
	 * @param mixed $frame
	 */
	public static function mathTag( $input, $args, $parser, $frame ) {
		if ( isset( $args['name'] ) ) {
			// Safe mode
			
			$title = Title::newFromText( $args['name'], NS_TRUSTEDMATH );
			if ( !$title->exists() ) {
				return $parser->recursiveTagParse( '<span class="error">' . 
					wfMsg( 'trustedmath-not-found', $title->getPrefixedText() ) . 
					'</span>' );
			}
			if ( !self::validateSafeMode( $title ) ) {
				// Requested title was not in the math namespace
				return self::getPermissionError( $parser );
			}
			
			$math = TrustedMath::newFromTitle( $title );
		} else {
			// Raw math mode
			
			if ( !self::validateSafeMode( $parser->getTitle() ) ) {
				// Raw math mode not allowed
				return self::getPermissionError( $parser );
			}
			
			$math = TrustedMath::newFromText( $input );
		}
		
		// Setup and render
		self::setupMathRenderer( $math );
		$status = $math->render();
		
		if ( $status->isOk() ) {
			global $wgTrustedMathPath;
			
			// Wrap a the rendered image in an <img> tag
			return Html::element( 'img', array( 
				'src' => "{$wgTrustedMathPath}/{$status->value}",
				'class' => 'tex',
				'alt' => $math->getText(),
			) );
		} else {
			
			// Return the error to the user
			return $parser->recursiveTagParse( '<span class="error">' . 
				$status->getWikiText() . '</span>', $frame );
		}
	}
	
	/**
	 * Check if the content of $title is considered safe
	 * @param Title $title
	 * @return bool True if safe
	 */
	protected static function validateSafeMode( $title ) {
		return !( self::safeMode() && 
			$title->getNamespace() != NS_TRUSTEDMATH );
	}
	/**
	 * Check if unsafe math is allowed
	 * @return bool True if unsafe math is disallowed
	 */
	protected static function safeMode() {
		global $wgTrustedMathUnsafeMode;
		return !$wgTrustedMathUnsafeMode;
	}
	
	/**
	 * Return an HTML fragment to indicate that the user is doing something disallowed
	 * @param Parser $parser
	 */
	protected static function getPermissionError( $parser ) {
		return $parser->recursiveTagParse( '<span class="error">' . 
			wfMsg( 'trustedmath-permission-error' ) . '</span>' );
	}
	
	/**
	 * Initialize the math renderer
	 * @param TrustedMath $math
	 */
	protected static function setupMathRenderer( $math ) {
		global $wgTrustedMathLatexPath, $wgTrustedMathDviPngPath,
			$wgTrustedMathEnvironment, $wgTrustedMathDirectory;
			
		$math->setRenderers( $wgTrustedMathLatexPath, $wgTrustedMathDviPngPath );
		$math->setEnvironment( $wgTrustedMathEnvironment );
		$math->setBasePath( $wgTrustedMathDirectory );				
	}
}

