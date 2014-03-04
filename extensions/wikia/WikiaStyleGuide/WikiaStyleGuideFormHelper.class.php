<?php
class WikiaStyleGuideFormHelper {
	private static $formSupportedTopLevelAttributes = array( 'action', 'class', 'id', 'method', 'name' );
	private static $inputSupportedTopLevelAttributes = array( 'class', 'id', 'name', 'value', 'tabindex' );
	private static $inputTypesToWrapWithLabel = array( 'checkbox', 'radio' );

	public static function getAttributes( $target, $source, $attributes ) {
		foreach( $attributes as $name ) {
			if ( isset( $source[ $name ] ) ) {
				$target[ $name ] = $source[ $name ];
			}
		}

		return $target;
	}

	public static function getAttributesString( $attributes ) {
		$attributesString = '';

		foreach( $attributes as $name => $value ) {
			$attributesString .= ' '. $name . '="' . Sanitizer::encodeAttribute( $value ) . '"';
		}

		return ltrim( $attributesString );
	}

	public static function getFormAttributes( $target, $source ) {
		return self::getAttributes( $target, $source, self::$formSupportedTopLevelAttributes );
	}

	public static function getInputAttributes( $target, $source ) {
		return self::getAttributes( $target, $source, self::$inputSupportedTopLevelAttributes );
	}

	public static function getClassNamesString( $classNames ) {
		$classNamesString = '';

		foreach( $classNames as $className ) {
			if ( !empty( $className ) ) {
				$classNamesString .= ' ' . $className;
			}
		}

		return ltrim( $classNamesString );
	}

	public static function isWrappedByLabel( $inputType ) {
		return in_array( $inputType, self::$inputTypesToWrapWithLabel );
	}

	public static function getLabelPosition( $input ) {

	}
}