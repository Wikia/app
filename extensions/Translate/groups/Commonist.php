<?php

class CommonistMessageGroup extends MessageGroup {
	protected $label = 'Commonist';
	protected $id    = 'out-commonist';
	#protected $type  = '';

	protected   $fileDir  = '__BUG__';

	public function getPath() { return $this->fileDir; }
	public function setPath( $value ) { $this->fileDir = $value; }


	protected $optional = array(
	);

	protected $ignored = array(
	);

	public function getMessageFile( $code ) {
		if ( $code == 'en' ) {
			return 'messages.properties';
		} else {
			if ( isset( $this->codeMap[$code] ) ) {
				$code = $this->codeMap[$code];
			}
			return "messages_$code.properties";
		}
	}

	protected function getFileLocation( $code ) {
		return $this->fileDir . '/' . $this->getMessageFile( $code );
	}

	public function getReader( $code ) {
		return new JavaFormatReader( $this->getFileLocation( $code ) );
	}

	public function getWriter() {
		return new JavaFormatWriter( $this );
	}
}
