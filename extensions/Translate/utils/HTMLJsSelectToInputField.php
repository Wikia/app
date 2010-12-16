<?php

class HTMLJsSelectToInputField extends HTMLTextField {
	function getInputHTML( $value ) {
		$input = parent::getInputHTML( $value );
		if ( isset( $this->mParams['select'] ) ) {
			$input .= ' ' . $this->mParams['select']->getHtmlAndPrepareJs();
		}
		return $input;
	}

	function tidy( $value ) {
		$value = array_map( 'trim', explode( ',', $value ) );
		$value = array_unique( array_filter( $value ) );
		return $value;
	}

	function validate( $value, $alldata ) {
		$p = parent::validate( $value, $alldata );
		if ( $p !== true ) return $p;

		if ( !isset( $this->mParams['valid-values'] ) ) return true;

		if ( $value === 'default' ) return true;

		$codes = $this->tidy( $value );
		$valid = array_flip( $this->mParams['valid-values'] );
		foreach ( $codes as $code ) {
			if ( !isset( $valid[$code] ) )
				return wfMsgExt( 'translate-pref-editassistlang-bad', 'parse', $code );
		}
		return true;
	}

	function filter( $value, $alldata ) {
		$value = parent::filter( $value, $alldata );
		return implode( ', ', $this->tidy( $value ) );
	}
}