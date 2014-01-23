<?php

class WikiaTestSpeedAnnotator {

	const SLOW_TEST_THRESHOLD = 0.002; // 0.002s = 2ms

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

			$classReflector = new ReflectionClass( $className );
			$methodReflector = new ReflectionMethod( $className, $methodName );

			$lineNumber = $methodReflector->getStartLine();
			$docComment = $methodReflector->getDocComment();
			$filePath = $classReflector->getFileName();
			$alreadyMarkedAsSlow = self::isMarkedAsSlow( $annotations );

			self::$methods[$methodName] = [ 'filePath' => $filePath, 'lineNumber' => $lineNumber, 'docComment' => $docComment,
				'alreadyMarkedAsSlow' => $alreadyMarkedAsSlow, 'executionTime' => $executionTime ];
		}
	}

	public static function execute() {
		if ( empty( self::$methods ) ) {
			return;
		}

		$affectedFiles = [ ];

		self::sortMethods();

		foreach ( self::$methods as $methodName => $array ) {
			if ( ( $isSlow = ( $array['executionTime'] > self::SLOW_TEST_THRESHOLD ) ) xor $array['alreadyMarkedAsSlow'] ) {
				$affectedFiles[] = $array['filePath'];
				if ( $isSlow ) {
					self::addSlowAnnotation( $array['filePath'], $array['methodName'], $array['docComment'],
						$array['executionTime'] );
				} else {
					self::removeSlowAnnotation( $array['filePath'], $array['methodName'], $array['docComment'] );
				}
			}
		}

		// cleanup DocComments from all affected files
		foreach ( $affectedFiles as $filePath ) {
			self::cleanupEmptyDocComments( $filePath );
		}

		self::$methods = [];
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
			return $a['filePath'] == $b['filePath'] ? ( ( $a['lineNumber'] > $b['lineNumber'] ) ? -1 : 1 )
				: strcasecmp( $a['filePath'], $b['filePath'] );
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

		$fileContents = self::replaceDocCommentForMethod($fileContents, $methodName, $newDocComment);

		file_put_contents( $filePath, $fileContents );
	}

	private static function addSlowAnnotation( $filePath, $methodName, $docComment, $executionTime ) {
		$fileContents = file_get_contents( $filePath );

		$indentation = self::getIndentation($fileContents, $methodName);

		$newDocComment = empty( $docComment ) ? self::createDocComment( $indentation, $executionTime )
			: self::updateDocComment( $indentation, $docComment, $executionTime );

		$fileContents = self::replaceDocCommentForMethod($fileContents, $methodName, $newDocComment);

		file_put_contents( $filePath, $fileContents );
	}

	private static function replaceDocCommentForMethod($sourceCode, $methodName, $newDocComment) {
		$functionStartRegex = '/(\s*/\*(.*?)\*/)?(' . "\n" . '\s*.*function\s+' . $methodName . '\s*\()/sm';

		// replace old DocComments and method declaration with new DocComments and method declaration
		return preg_replace( $functionStartRegex, "\n\n" . $newDocComment . "\\2", $sourceCode );
	}

	private static function createDocComment( $indentation, $executionTime ) {
		$docComment = [
			"/**\n",
			" * @group Slow\n",
			" * @slowExecutionTime " . $executionTime . " ms\n */\n"
		];

		return $indentation . implode( $indentation, $docComment );
	}

	private static function updateDocComment( $indentation, $docComment, $executionTime ) {
		$docComment = self::removeSlowAnnotationFromDocComment( $docComment );

		$slowGroupAnnotation = '@group Slow';
		$slowTimeAnnotation  = '@slowExecutionTime ' . $executionTime . ' ms';

		$docComment = str_replace( '/**', "/**\n" . $indentation . " * " . $slowTimeAnnotation, $docComment );
		$docComment = str_replace( '/**', "/**\n" . $indentation . " * " . $slowGroupAnnotation, $docComment );

		return $docComment;
	}

	private static function getIndentation($sourceCode, $methodName) {
		$matches = null;

		if (preg_match_all('/^(\s*).*function ' . $methodName . '\(/m', $sourceCode, $matches) > 0) {
			return $matches[0][1];
		} else {
			return '';
		}
	}
}
