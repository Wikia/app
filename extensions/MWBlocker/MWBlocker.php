<?php

// Requires PEAR XML_RPC module

// todo: combine shared code from MWSearchUpdater into a base module

require_once( 'PEAR.php' );
require_once( 'XML/RPC.php' );

$mwBlockerHost = 'localhost';
$mwBlockerPort = 8126;
$mwBlockerDebug = false;

class MWBlocker {
	/**
	 * Queue a request to update a page in the search index.
	 *
	 * @param string $dbname
	 * @param Title $title
	 * @param string $text
	 * @return bool
	 * @static
	 */
	function queueCheck( $ip, $note ) {
		return MWBlocker::sendRPC( 'blocker.queueCheck',
			array( $ip, $note ) );
	}

	/**
	 * Get a brief bit of status info on the update daemon.
	 * @return string
	 * @static
	 */
	function getStatus() {
		return MWBlocker::sendRPC( 'blocker.getStatus' );
	}
		
	/**
	 * @access private
	 * @static
	 */
	function outParam( $param ) {
		if( is_object( $param ) && is_a( $param, 'Title' ) ) {
			return new XML_RPC_Value(
				array(
					'Namespace' => new XML_RPC_Value( $param->getNamespace(), 'int' ),
					'Text'      => new XML_RPC_Value( $param->getText(), 'string' ) ),
				'struct' );
		} elseif( is_string( $param ) ) {
			return new XML_RPC_Value( $param, 'string' );
		} elseif( is_array( $param ) ) {
			$type = 'array';
			if( count( $param ) ) {
				$keys = array_keys( $param );
				if( $keys[0] !== 0 ) {
					$type = 'struct';
				}
			}
			$translated = array_map( array( 'MWBlocker', 'outParam' ), $param );
			return new XML_RPC_Value( $translated, $type );
		} else {
			return new WikiError( 'MWBlocker::sendRPC given bogus parameter' );
		}
	}
	
	/**
	 * @access private
	 * @static
	 */
	function sendRPC( $method, $params=array() ) {
		global $mwBlockerHost, $mwBlockerPort, $mwBlockerDebug;
		$client = new XML_RPC_Client( '/Blocker', $mwBlockerHost, $mwBlockerPort );
		if( $mwBlockerDebug ) {
			$client->debug = true;
		}
		
		$rpcParams = array_map( array( 'MWBlocker', 'outParam' ), $params );
		
		$message = new XML_RPC_Message( $method, $rpcParams );
		wfSuppressWarnings();
		$start = wfTime();
		$result = $client->send( $message );
		$delta = wfTime() - $start;
		wfRestoreWarnings();
		
		$debug = sprintf( "MWBlocker::sendRPC for %s took %0.2fms\n",
			$method, $delta * 1000.0 );
		wfDebug( $debug );
		if( $mwBlockerDebug ) {
			echo $debug;
		}
		
		if( !is_object( $result ) ) {
			return new WikiError( "Unknown XML-RPC error" );
		} elseif( $result->faultCode() ) {
			return new WikiError( $result->faultCode() . ': ' . $result->faultString() );
		} else {
			$value = $result->value();
			return $value->getval();
		}
	}
}



