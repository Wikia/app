<?php

# TODO: Make this an abstract class, and make the EC2 API a subclass
class OpenStackNovaVolume {

	var $volume;

	/**
	 * @param  $apiInstanceResponse
	 */
	function __construct( $apiInstanceResponse ) {
		$this->volume = $apiInstanceResponse;
	}

	/**
	 * Return the assigned display name of this volume
	 *
	 * @return string
	 */
	function getVolumeName() {
		return (string)$this->volume->displayName;
	}

	/**
	 * Return the assigned description of this volume
	 *
	 * @return string
	 */
	function getVolumeDescription() {
		return (string)$this->volume->displayDescription;
	}

	/**
	 * Return the ID of this volume
	 *
	 * @return string
	 */
	function getVolumeId() {
		return (string)$this->volume->volumeId;
	}

	/**
	 * Return the status of this volume
	 *
	 * @return string
	 */
	function getVolumeStatus() {
		$status = (string)$this->volume->status;
		$status = explode( ' ', $status );
		
		return $status[0];
	}

	/**
	 * Returns the instance ID this volume is attached to, or an empty string if
	 * not attached
	 *
	 * @return string
	 */
	function getAttachedInstanceId() {
		return (string)$this->volume->attachmentSet->item->instanceId;
	}

	/**
	 * Returns the attachment status of this volume
	 *
	 * @return string
	 */
	function getAttachmentStatus() {
		return (string)$this->volume->attachmentSet->item->status;
	}

	/**
	 * Returns the attachment time of this volume
	 *
	 * @return string
	 */
	function getAttachmentTime() {
		return (string)$this->volume->attachmentSet->item->attachTime;
	}

	/**
	 * Will this volume be deleted when the instance it is attached to is deleted?
	 *
	 * @return bool
	 */
	function deleteOnInstanceDeletion() {
		return (bool)$this->volume->attachmentSet->item->deleteOnTermination;
	}

	/**
	 * Return the device used when attached to an instance
	 *
	 * @return string
	 */
	function getAttachedDevice() {
		return (string)$this->volume->attachmentSet->item->device;
	}

	/**
	 * Return the size, in GB, of this volume
	 *
	 * @return int
	 */
	function getVolumeSize() {
		return (string)$this->volume->size;
	}

	/**
	 * Return the creation date of this volume
	 *
	 * @return string
	 */
	function getVolumeCreationTime() {
		return (string)$this->volume->creationTime;
	}

	/**
	 * Return the volume's availability zone
	 *
	 * @return string
	 */
	function getVolumeAvailabilityZone() {
		return (string)$this->volume->availabilityZone;
	}

	/**
	 * Return the project that owns this instance
	 *
	 * @return string
	 */
	function getOwner() {
		$status = (string)$this->volume->status;
		$status = explode( ' ', $status );
		
		return str_replace( array('(',','), '', $status[1] );
	}

	/**
	 * Return the volume node that this volume exists on
	 *
	 * @return string
	 */
	function getVolumeNode() {
		$status = (string)$this->volume->status;
		$status = explode( ' ', $status );
		
		return str_replace( array(','), '', $status[2] );
	}

}
