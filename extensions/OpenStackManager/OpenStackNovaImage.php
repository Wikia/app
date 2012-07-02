<?php

# TODO: Make this an abstract class, and make the EC2 API a subclass
class OpenStackNovaImage {

	var $image;

	/**
	 * @param  $apiInstanceResponse
	 */
	function __construct( $apiInstanceResponse ) {
		$this->image = $apiInstanceResponse;
	}

	/**
	 * Return the name of this image
	 *
	 * @return string
	 */
	function getImageName() {
		return (string)$this->image->displayName;
	}

	/**
	 * Return the ID of this image
	 *
	 * @return string
	 */
	function getImageId() {
		return (string)$this->image->imageId;
	}

	/**
	 * Return the availability state of this image
	 *
	 * @return string
	 */
	function getImageState() {
		return (string)$this->image->imageState;
	}

	/**
	 * Return the image type
	 *
	 * @return string
	 */
	function getImageType() {
		return (string)$this->image->imageType;
	}

	/**
	 * Return the image architecture
	 *
	 * @return string
	 */
	function getImageArchitecture() {
		return (string)$this->image->architecture;
	}

	/**
	 * Return whether or not this image is public
	 *
	 * @return bool
	 */
	function imageIsPublic() {
		return (bool)$this->image->isPublic;
	}

}
