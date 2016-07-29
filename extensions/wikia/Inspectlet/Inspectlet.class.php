<?php
/**
 * Inspectlet
 *
 * @author Diana Falkowska
 *
 */
class Inspectlet {
	private static $experimentId = 0;

	public static function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		global $wgNoExternals;

		if ( !$wgNoExternals && self::$experimentId > 0 ) {
			$scripts .= (new Wikia\Template\MustacheEngine)->clearData()
				->setPrefix( dirname( __FILE__ ) . '/templates' )
				->setData( [ 'experiment_id' => self::$experimentId ] )
				->render( '/Inspectlet.mustache' );
		}

		return true;
	}

	public static function addExperiment( $expetimentId ) {
		self::$experimentId = $expetimentId;
	}
}
