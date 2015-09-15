<?php
class WikiaTagBuilderHelper {

	public function buildTagSourceQueryParams( array $allowedParams, array $userParams, $overrideParams = [] ) {
		$params = [];
		foreach ( array_keys( $allowedParams ) as $name ) {
			if ( array_key_exists( $name, $userParams ) && !empty( $userParams[$name] ) ) {
				$params[$name] = $userParams[$name];
			} else if ( array_key_exists( $name, $allowedParams ) && !empty( $allowedParams[$name] ) ) {
				$params[$name] = $allowedParams[$name];
			}
		}

		if ( is_array( $overrideParams ) && !empty( $overrideParams ) ) {
			$params = array_merge( $params, $overrideParams );
		}

		return http_build_query( $params );
	}

	public function buildTagAttributes( array $allowedAttrs, array $userAttrs, $prefix = '' ) {
		$attributes = [];

		if ( !empty( $prefix ) ) {
			$prefix .= '-';
		}

		foreach ( $allowedAttrs as $attributeName ) {
			if ( isset( $userAttrs[$attributeName] ) ) {
				if ( $attributeName === 'style' ) {
					$attributes['style'] = Sanitizer::checkCss( $userAttrs['style'] );
				} else {
					$attributes[$prefix . $attributeName] = $userAttrs[$attributeName];
				}
			}
		}

		return $attributes;
	}

	public function isMobileSkin( ) {
		return F::app()->checkSkin( 'wikiamobile' );
	}
}
