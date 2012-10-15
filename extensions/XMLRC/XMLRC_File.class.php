<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "XMLRC extension";
	exit( 1 );
}

/**
 * Implementation if XMLRC_Transport that "sends" messages to a file.
 */
class XMLRC_File extends XMLRC_Transport {

	/**
	 * Creates a new instance of XMLRC_File. $config['file'] determines which file to write to.
	 *
	 * @param $config Array: the configuration array.
	 */
	function __construct( $config ) {
		$this->handle = null;

		$this->file = $config['file'];
	}

	/**
	 * Opens the file specified as $config['file'] in the constructur, in 'append' mode.
	 */
	public function open() {
		if ( $this->handle ) {
			return;
		}

		$this->handle = fopen( $this->file, 'a' );
		if ( !$this->handle ) {
			wfDebugLog( 'XMLRC', "failed to open {$this->file}\n" );
		} else {
			wfDebugLog( 'XMLRC', "opened {$this->file}\n" );
		}
	}

	/**
	 * Closes the underlying file.
	 */
	public function close() {
		if ( !$this->handle ) {
			return;
		}

		fclose( $this->handle );
		$this->handle = null;

		wfDebugLog( 'XMLRC', "closed {$this->file}\n" );
	}

	/**
	 * Writes $xml to the underlying file. The file is automatically opened if
	 * it is not yet open.
	 */
	public function send( $xml ) {
		$do_close = !$this->handle;
		$this->open();

		$ok = fwrite( $this->handle, $xml . "\n" );
		if ( $ok ) {
			$ok = fflush( $this->handle );
		}
		if ( !$ok ) {
			wfDebugLog( 'XMLRC', "failed to write to {$this->file}\n" );
		}

		if ( $do_close ) {
			$this->close();
		}
	}
}
