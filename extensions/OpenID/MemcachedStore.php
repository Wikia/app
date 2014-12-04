<?php

require_once( 'Auth/OpenID/MemcachedStore.php' );

class MediaWikiOpenIDMemcachedStore extends Auth_OpenID_MemcachedStore {

	function __construct( $connection ) {
		$this->connection = $connection;
	}

	function storeAssociation( $server_url, $association ) {
		$associationKey = $this->associationKey( $server_url,
			$association->handle );
		$serverKey = $this->associationServerKey( $server_url );

		$serverAssociations = $this->connection->get( $serverKey );

		if ( !$serverAssociations ) {
			$serverAssociations = array();
		}

		$serverAssociations[$association->issued] = $associationKey;

		$this->connection->set( $serverKey, $serverAssociations );

		$this->connection->set( $associationKey, $association,
			$association->issued + $association->lifetime );
	}

	function getAssociation( $server_url, $handle = null ) {
		if ( $handle !== null ) {
			$association = $this->connection->get(
				$this->associationKey( $server_url, $handle ) );
			return $association ? $association : null;
		}

		$serverKey = $this->associationServerKey( $server_url );

		$serverAssociations = $this->connection->get( $serverKey );
		if ( !$serverAssociations ) {
			return null;
		}

		$keys = array_keys( $serverAssociations );
		sort( $keys );
		$lastKey = $serverAssociations[array_pop( $keys )];

		$association = $this->connection->get( $lastKey );
		return $association ? $association : null;
	}

	function removeAssociation( $server_url, $handle ) {
		$serverKey = $this->associationServerKey( $server_url );
		$associationKey = $this->associationKey( $server_url,
			$handle );

		$serverAssociations = $this->connection->get( $serverKey );
		if ( !$serverAssociations ) {
			return false;
		}

		$serverAssociations = array_flip( $serverAssociations );
		if ( !array_key_exists( $associationKey, $serverAssociations ) ) {
			return false;
		}

		unset( $serverAssociations[$associationKey] );
		$serverAssociations = array_flip( $serverAssociations );

		$this->connection->set( $serverKey, $serverAssociations );

		return $this->connection->delete( $associationKey );
	}

	function useNonce( $server_url, $timestamp, $salt ) {
		global $Auth_OpenID_SKEW;

		if ( abs( $timestamp - time() ) > $Auth_OpenID_SKEW ) {
			return false;
		}

		return $this->connection->add(
			'openid_nonce_' . sha1( $server_url ) . '_' . sha1( $salt ),
			1, $Auth_OpenID_SKEW );
    }

}
