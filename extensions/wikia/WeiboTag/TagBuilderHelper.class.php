<?php
class TagBuilderHelper {

	public function buildTagSourceQueryParams( array $allowedParams, array $userParams ) {
		foreach ( array_keys( $allowedParams ) as $name ) {
			if ( isset( $userParams[$name] ) ) {
				$allowedParams[$name] = $userParams[$name];
			}
		}
		return http_build_query( $allowedParams );
	}

	public function buildTagAttributes(array $allowedAttrs, array $userAttrs) {
		$attributes = [];

		foreach ( $allowedAttrs as $attributeName ) {
			if ( isset( $userAttrs[$attributeName] ) ) {
				if ($attributeName === 'style') {
					$attributes['style'] = Sanitizer::checkCss( $userAttrs['style'] );
				} else {
					$attributes[$attributeName] = $userAttrs[$attributeName];
				}
			}
		}

		return $attributes;
	}
}
