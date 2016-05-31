<?php

class AdEngine2Resource {
	const RESOURCE_DATE_FORMAT = 'Y-m-d';

	static public function register( $name, $class ) {
		global $wgResourceModules;

		$keys = [
			new \DateTime( 'yesterday' ),
			new \DateTime( 'now' ),
			new \DateTime( 'tomorrow' )
		];

		foreach ( $keys as $date ) {
			$key = self::getKey( $name, $date );
			$wgResourceModules[$key] = [
				'class' => $class
			];
		}
	}

	static public function getKey( $name, \DateTime $date = null ) {
		if ( $date === null ) {
			$date = new \DateTime( 'now' );
		}

		return md5( $date->format( self::RESOURCE_DATE_FORMAT ) . $name );
	}
}
