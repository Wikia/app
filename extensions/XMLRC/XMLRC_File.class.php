<?php
if (!defined('MEDIAWIKI')) {
	echo "XMLRC extension";
	exit(1);
}

class XMLRC_File extends XMLRC_Transport {
  function __construct( $config ) {
    $this->handle = null;

    $this->file = $config['file'];
  }

  public function open() {
    if ( $this->handle ) return;

    $this->handle = fopen( $this->file, 'a' );
    if ( !$this->handle ) wfDebug("XMLRC_File: failed to open {$this->file}\n");
    else wfDebug("XMLRC_File: opened {$this->file}\n");
  }

  public function close() {
    if ( !$this->handle ) return;

    fclose( $this->handle );
    $this->handle = null;

    wfDebug("XMLRC_File: closed {$this->file}\n");
  }

  public function send( $xml ) {
    $do_close = !$this->handle;
    $this->open();
    
    $ok = fwrite( $this->handle, $xml . "\n" );
    if ( $ok ) $ok = fflush( $this->handle );
    if ( !$ok ) wfDebug("XMLRC_File: failed to write to {$this->file}\n");

    if ( $do_close ) $this->close();
  }
}
