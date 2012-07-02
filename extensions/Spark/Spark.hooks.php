<?php

/**
 * Static class for hooks handled by the Spark extension.
 *
 * @since 0.1
 *
 * @file Spark.hooks.php
 * @ingroup Spark
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SparkHooks {

	/**
	 * Register the spark tag extension when the parser initializes.
	 *
	 * @since 0.1
	 *
	 * @param Parser $parser
	 *
	 * @return true
	 */
	public static function onParserFirstCallInit( Parser &$parser ) {
		$parser->setHook( 'spark', __CLASS__ . '::onSparkRender' );
		return true;
	}

	/**
	 * @since 0.1
	 *
	 * @param mixed $input
	 * @param array $args
	 * @param Parser $parser
	 * @param PPFrame $frame
	 */
	public static function onSparkRender( $input, array $args, Parser $parser, $frame = null) {
		global $wgVersion;
		global $wgOut;
		global $egSparkScriptJquery;
		global $egSparkScriptJquerySpark;

		static $loadedJs = false;

		if ( version_compare( $wgVersion, '1.17', '<' ) ) {
			// We do not have resource loader
			if ( !$loadedJs ) {
				$wgOut->addScript('<script src="'.$egSparkScriptJquery.'" type="text/javascript"></script>');
				wfDebugLog( 'spark', "AddScript:".' <script src="'.$egSparkScriptJquery.'" type="text/javascript"></script>' );
				//echo "AddScript:".' <script src="'.$egSparkScriptJquery.'" type="text/javascript"></script>';
				$wgOut->addScript('<script src="'.$egSparkScriptJquerySpark.'" type="text/javascript"></script>');
				wfDebugLog( 'spark', "AddScript:".' <script src="'.$egSparkScriptJquerySpark.'" type="text/javascript"></script>' );
				//echo "AddScript:".' <script src="'.$egSparkScriptJquerySpark.'" type="text/javascript"></script>';
				$loadedJs = true;
			}

		} else {
			// We have resource loader
			// If we have resource loader
			if ( !$loadedJs ) {
				$parser->getOutput()->addModules( 'ext.spark' );
				$loadedJs = true;
			}
		}
		$tag = new SparkTag( $args, $input );

		// PPFrame maybe not existing
		return $tag->render( $parser, $frame );

	}

}