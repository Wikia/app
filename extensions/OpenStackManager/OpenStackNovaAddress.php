<?php

# TODO: Make this an abstract class, and make the EC2 API a subclass
class OpenStackNovaAddress {

	var $address;

	/**
	 * @param  $apiInstanceResponse
	 */
	function __construct( $apiInstanceResponse ) {
		$this->address = $apiInstanceResponse;
	}

	/**
	 * Return the instance associated with this address, or an
	 * empty string if the address isn't associated
	 *
	 * @return string
	 */
	function getInstanceId() {
		# instanceId returns as: instanceid (project)
		$info = explode( ' ', $this->address->instanceId );
		if ( $info[0] == 'None' ) {
			return '';
		} else {
			return $info[0];
		}
	}

	/**
	 * Return the floating IP address from the EC2 response
	 *
	 * @return string
	 */
	function getPublicIP() {
		return (string)$this->address->publicIp;
	}

	/**
	 * Return the project associated with this address
	 *
	 * @return string
	 */
	function getProject() {
		# instanceId returns as: instanceid (project)
		$info = explode( ' ', $this->address->instanceId );
		return str_replace( array('(',')'), '', $info[1] );
	}

}
