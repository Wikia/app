<?php

// Requires PEAR XML_RPC module

require_once( 'PEAR.php' );
require_once( 'XML/RPC.php' );

$mwSearchUpdateHost = 'localhost';
$mwSearchUpdatePort = 8124;
$mwSearchUpdateDebug = false;

class MWSearchUpdater {
	/**
	 * Queue a request to update a page in the search index.
	 *
	 * @param string $dbname
	 * @param Title $title
	 * @param string $text
	 * @return bool
	 * @static
	 */
	function updatePage( $dbname, $title, $text ) {
		return MWSearchUpdater::sendRPC( 'searchupdater.updatePage',
			array( $dbname, $title, $text ) );
	}

	/**
	 * Queue a request to update a page in the search index,
	 * including metadata fields.
	 *
	 * @param string $dbname
	 * @param Title $title
	 * @param string $text
	 * @param array $metadata
	 * @return bool
	 * @static
	 */
	function updatePageData( $dbname, $title, $text, $metadata ) {
		$translated = array();
		foreach( $metadata as $pair ) {
			list( $key, $value ) = explode( '=', $pair, 2 );
			$translated[] = array( 'Key' => $key, 'Value' => $value );
		}
		return MWSearchUpdater::sendRPC( 'searchupdater.updatePageData',
			array( $dbname, $title, $text, $translated ) );
	}

	/**
	 * Queue a request to delete a page from the search index.
	 *
	 * @param string $dbname
	 * @param Title $title
	 * @return bool
	 * @static
	 */
	function deletePage( $dbname, $title ) {
		return MWSearchUpdater::sendRPC( 'searchupdater.deletePage',
			array( $dbname, $title ) );
	}

	/**
	 * Get a brief bit of status info on the update daemon.
	 * @return string
	 * @static
	 */
	function getStatus() {
		return MWSearchUpdater::sendRPC( 'searchupdater.getStatus' );
	}
	
	/**
	 * Request that the daemon start applying updates if it's stopped.
	 * @return bool
	 * @static
	 */
	function start() {
		return MWSearchUpdater::sendRPC( 'searchupdater.start' );
	}
	
	/**
	 * Request that the daemon stop applying updates and close open indexes.
	 * @return bool
	 * @static
	 */
	function stop() {
		return MWSearchUpdater::sendRPC( 'searchupdater.stop' );
	}
	
	/**
	 * Request that the daemon stop applying updates and close open indexes.
	 * @return bool
	 * @static
	 */
	function quit() {
		return MWSearchUpdater::sendRPC( 'searchupdater.quit' );
	}

	/**
	 * Request that the daemon flush and reopen all indexes, without changing
	 * the global is-running state.
	 * @return bool
	 * @static
	 */
	function flushAll() {
		return MWSearchUpdater::sendRPC( 'searchupdater.flushAll' );
	}
	
	/**
	 * Request that the daemon flush and reopen all indexes, without changing
	 * the global is-running state, and that indexes should be optimized when
	 * closed.
	 * @return bool
	 * @static
	 */
	function optimize() {
		return MWSearchUpdater::sendRPC( 'searchupdater.optimize' );
	}
	
	/**
	 * Request that the daemon flush and reopen a given index, without changing
	 * the global is-running state.
	 * @return bool
	 * @static
	 */
	function flush( $dbname ) {
		return MWSearchUpdater::sendRPC( 'searchupdater.flush',
			array( $dbname ) );
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
			$translated = array_map( array( 'MWSearchUpdater', 'outParam' ), $param );
			return new XML_RPC_Value( $translated, $type );
		} else {
			return new WikiError( 'MWSearchUpdater::sendRPC given bogus parameter' );
		}
	}
	
	/**
	 * @access private
	 * @static
	 */
	function sendRPC( $method, $params=array() ) {
		global $mwSearchUpdateHost, $mwSearchUpdatePort, $mwSearchUpdateDebug;
		$client = new XML_RPC_Client( '/SearchUpdater', $mwSearchUpdateHost, $mwSearchUpdatePort );
		if( $mwSearchUpdateDebug ) {
			$client->debug = true;
		}
		
		$rpcParams = array_map( array( 'MWSearchUpdater', 'outParam' ), $params );
		
		$message = new XML_RPC_Message( $method, $rpcParams );
		wfSuppressWarnings();
		$start = wfTime();
		$result = $client->send( $message );
		$delta = wfTime() - $start;
		wfRestoreWarnings();
		
		$debug = sprintf( "MWSearchUpdater::sendRPC for %s took %0.2fms\n",
			$method, $delta * 1000.0 );
		wfDebug( $debug );
		if( $mwSearchUpdateDebug ) {
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



