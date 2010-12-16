<?php
if (!defined('MEDIAWIKI')) {
	echo "XMLRC extension";
	exit(1);
}

class XMLRC_UDP extends XMLRC_Transport {
  function __construct( $config ) {
    $this->conn = null;

    $this->address = $config['address'];
    $this->port = $config['port'];
  }

  public function connect() {
    if ( $this->conn ) return;

    $this->conn = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
    if ( !$this->handle ) wfDebug("XMLRC_UDP: failed to create UDP socket\n");
    else wfDebug("XMLRC_UDP: created UDP socket\n");
  }

  public function disconnect() {
    if ( !$this->conn ) return;

    socket_close( $this->conn );
    $this->conn = null;
    wfDebug("XMLRC_UDP: closed UDP socket\n");
  }

  public function send( $xml ) {
    $do_disconnect = !$this->conn;
    $this->connect();

    $ok = socket_sendto( $this->conn, $xml, strlen($xml), 0, $this->address, $this->port );
    if ( !$ok ) wfDebug("XMLRC_UDP: failed to send UDP packet to {$this->address}:{$this->port}\n");

    if ( $do_disconnect ) $this->disconnect();
  }
}
