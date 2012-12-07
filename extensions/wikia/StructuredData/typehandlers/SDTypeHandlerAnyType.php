<?php
/**
 * @author: Jacek Jursza
 */
class SDTypeHandlerAnyType extends SDTypeHandler {

	public function handleSaveData( array $data ) {

		/*
		if ( empty( $data['schema:name'] ) ) {
			$this->addError( 'schema:name', wfMsg('structureddata-name-can-not-be-empty') );
		}
		 */
		return $data;
	}
}
