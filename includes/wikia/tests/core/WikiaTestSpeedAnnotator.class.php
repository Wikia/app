<?php

class WikiaTestSpeedAnnotator {

	const SLOW_TEST_THRESHOLD = 0.002; // ms

	private static $methods = [ ];
	private static $timerResolution = null;

	const REGEX_SLOW_GROUP     = '/^\s*\*\s*@group\s+Slow\s*\n/m';
	const REGEX_SLOW_EXEC_TIME = '/^\s*\*\s*@slowExecutionTime\s+([0-9\.]+\s*(ms?)\s*\n)/m';

	public static function initialize() {
		self::setTimerResolution();

		self::$methods = [ ];
	}

	public static function add( $className, $methodName, $executionTime, $annotations ) {
		if ( empty( self::$methods[$methodName] ) ) {
			// normalize time
			$executionTime = round( $executionTime, self::$timerResolution );

			$classReflector  = new ReflectionClass( $className );
			$methodReflector = new ReflectionMethod( $className, $methodName );

			$lineNumber          = $methodReflector->getStartLine();
			$docComment          = $methodReflector->getDocComment();
			$filePath            = $classReflector->getFileName();
			$alreadyMarkedAsSlow = self::isMarkedAsSlow( $annotations );

			self::$methods[$methodName] = [ $filePath, $lineNumber, $docComment, $alreadyMarkedAsSlow, $executionTime ];
		}
	}

	public static function execute() {
		if ( empty( self::$methods ) ) {
			return;
		}

		$affectedFiles = [ ];

		self::sortMethods();

		foreach ( self::$methods as $methodName => $array ) {
			list( $filePath, $lineNumber, $docComment, $alreadyMarkedAsSlow, $executionTime ) = $array;

			if ( ( $isSlow = ( $executionTime > self::SLOW_TEST_THRESHOLD ) ) xor $alreadyMarkedAsSlow ) {
				if ( $isSlow ) {
					self::addSlowAnnotation( $filePath, $methodName, $docComment, $executionTime );
				} else {
					self::removeSlowAnnotation( $filePath, $methodName, $docComment );
				}
			}
		}

		// cleanup docblocks from all affected files
		foreach ( $affectedFiles as $filePath ) {
			self::cleanupEmptyDocComments( $filePath );
		}
	}

	private static function isDocCommentEmpty( $docComment ) {
		return 0 !== preg_match( '/^\s*\/\*\*[\s|\*]*\//', $docComment );
	}

	private static function cleanupEmptyDocComments( $filePath ) {
		$fileContents = file_get_contents( $filePath );
		$fileContents = preg_replace( '/^\s*\/\*\*[\s|\*]*\//', '', $fileContents );
		file_put_contents( $filePath, $fileContents );
	}

	private static function setTimerResolution() {
		// resolution is equal to number of significant characters plus two.
		self::$timerResolution = strlen( substr( strrchr( self::SLOW_TEST_THRESHOLD, "." ), 1 ) ) + 2;
	}

	private static function isMarkedAsSlow( $annotations ) {
		return !empty( $annotations['method'] ) && !empty( $annotations['method']['group'] )
		&& in_array( 'Slow', $annotations['method']['group'] );
	}

	private static function sortMethods() {
		uasort( self::$methods, function ( $a, $b ) {
			return $a[0] == $b[0] ? ( ( $a[1] > $b[1] ) ? -1 : 1 ) : strcasecmp( $a[0], $b[0] );
		} );
	}

	private static function removeSlowAnnotationFromDocComment( $docComment ) {
		$docComment = preg_replace( self::REGEX_SLOW_EXEC_TIME, '', $docComment );
		$docComment = preg_replace( self::REGEX_SLOW_GROUP, '', $docComment );

		return $docComment;
	}

	private static function removeSlowAnnotation( $filePath, $methodName, $docComment ) {
		$newDocComment = self::removeSlowAnnotationFromDocComment( $docComment );

		$fileContents = file_get_contents( $filePath );
		$fileContents = str_replace( $docComment, $newDocComment, $fileContents );
		file_put_contents( $filePath, $fileContents );
	}

	private static function addSlowAnnotation( $filePath, $methodName, $docComment, $executionTime ) {
		$newDocComment = empty( $docComment ) ? self::createDocComment( $executionTime )
			: self::updateDocComment( $docComment, $executionTime );

		$functionStartRegex = '/\s*(\/[^\/]*\/)?(' . "\n" . '\s*.*function\s+' . $methodName . '\s*\()/';

		$fileContents = file_get_contents( $filePath );

		// replace old doccomment and method declaration with new doccomment and method declaration

		$fileContents = preg_replace( $functionStartRegex, "\n\n" . $newDocComment . "\\2", $fileContents );

		file_put_contents( $filePath, $fileContents );
	}

	private static function createDocComment( $executionTime ) {
		return "/**\n * @group Slow\n * @slowExecutionTime " . $executionTime . " ms\n */\n";
	}

	private static function updateDocComment( $docComment, $executionTime ) {
		$docComment = self::removeSlowAnnotationFromDocComment( $docComment );

		$slowGroupAnnotation = '@group Slow';
		$slowTimeAnnotation  = '@slowExecutionTime ' . $executionTime . ' ms';

		$docComment = str_replace( '/**', "/**\n * " . $slowTimeAnnotation, $docComment );
		$docComment = str_replace( '/**', "/**\n * " . $slowGroupAnnotation, $docComment );

		return $docComment;
	}
}
