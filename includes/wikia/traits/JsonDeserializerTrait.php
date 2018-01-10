<?php

/**
 * This trait provides JSON de-serializing feature to objects.
 * Given an associative array, it will attempt to map keys in the array to the object's properties.
 */
trait JsonDeserializerTrait {
	public static function newFromJson( $jsonInput ) {
		$jsonData = (array) $jsonInput;
		$instance = new static();

		foreach ( get_object_vars( $instance ) as $propName => $value ) {
			if ( isset( $jsonData[$propName] ) ) {
				$instance->$propName = $jsonData[$propName];
			}
		}

		return $instance;
	}
}
