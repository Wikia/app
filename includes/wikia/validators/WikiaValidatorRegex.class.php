<?php

class WikiaValidatorRegex extends WikiaValidator {

	protected function config( array $options = [] ) {
		$this->setOption( 'pattern', '\s*' );
	}

	protected function configMsgs( array $msgs = [] ) {
		$this->setMsg( 'empty', 'wikia-validator-regex-empty' );
		$this->setMsg( 'wrong', 'wikia-validator-regex-wrong' );
	}

	public function isValidInternal( $value = null ) {
		$pattern = $this->getOption( 'pattern' );

		if ( !preg_match( $pattern, $value ) ) {
			$this->createError( 'wrong' );
			return false;
		}

		if ( $this->getOption( 'required' ) === true && empty( $value ) ) {
			$this->createError( 'empty' );
			return false;
		}

		return true;
	}
}
