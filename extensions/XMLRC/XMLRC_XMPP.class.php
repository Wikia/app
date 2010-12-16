<?php
if (!defined('MEDIAWIKI')) {
	echo "XMLRC extension";
	exit(1);
}

class XMLRC_XMPP extends XMLRC_Transport {
  function __construct( $config ) {

    if (!isset($config['library_path'])) {
      include( "XMPP.php" );
    } else {
      include("{$config['library_path']}/XMPP.php");
    }


    if (!isset($config['server']) || is_null($config['server'])) {
      $config['server'] = $config['host'];
    }

    if (!isset($config['nickname']) || is_null($config['nickname'])) {
      $config['nickname'] = $config['user'];
    }

    $this->conn = null;

    $this->channel = $config['channel'];
    $this->nickname = $config['nickname'];
    $this->resource = $config['resource'];

    $this->host = $config['host'];
    $this->port = $config['port'];
    $this->user = $config['user'];
    $this->password = $config['password'];
    $this->server = $config['server'];

    $this->loglevel = -1;
  }

  public function connect() {
    if ( $this->conn ) return;

     $this->conn = new XMPP( $this->host, $this->port, $this->user, $this->password, 
	      $this->resource, $this->server, 
	      $this->loglevel <= LEVEL_VERBOSE && $this->loglevel >= 0, $this->loglevel );

    $this->conn->connect();
    $this->conn->processUntil( 'session_start' );

    $conn->presence(null, "available", $this->channel . '/' . $this->nickname, "available" );
  }

  public function disconnect() {
    if ( !$this->conn ) return;

    $conn->presence(null, "unavailable", $this->channel . '/' . $this->nickname, "unavailable" );

    $this->conn->disconnect();
    $this->conn = null;
  }

  public function send( $xml ) {
    $do_disconnect = !$this->conn;
    $this->connect();
    $conn->message( $this->channel, $xml, 'groupchat' ); //TODO: use send to send XML content directly
    if ( $do_disconnect ) $this->disconnect();
  }
}
