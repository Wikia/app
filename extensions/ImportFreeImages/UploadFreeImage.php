<?php
/**
 * Upload handler for ImportFreeImages. Uses UploadFromUrl magic.
 */
class UploadFreeImage extends UploadFromUrl {
	/**
	 * Hook to UploadCreateOnRequest.
	 *
	 * This class processes wpSourceType=IFI
	 */
	public static function onUploadCreateFromRequest( $type, &$className ) {
		if ( $type == 'IFI' ) {
			$className = 'UploadFreeImage';
			// Stop processing
			return false;
		}
		return true;
	}

	/**
	 * By installing this extension it is unconditionally enabled
	 */
	public static function isEnabled() { return true; }

	/**
	 * A valid request requires wpFlickrId to be set
	 */
	public static function isValidRequest( $request ) {
		return (bool)$request->getVal( 'wpFlickrId' );
	}

	/**
	 * Extract wpDestFile and construct the url from wpFlickrId and wpSize and
	 * pass it to the parent.
	 */
	public function initializeFromRequest( &$request ) {
		return $this->initialize(
			$request->getText( 'wpDestFile' ),
	 		self::getUrl( $request->getText( 'wpFlickrId' ), $request->getText( 'Size' ) ),
			false
		);
	}

	/**
	 * Get the source URL for an image
	 *
	 * @param $flickrId Integer: Flickr photo ID
	 * @param $requestedSize String: label of the requested size
	 * @return mixed URL or false
	 */
	public static function getUrl( $flickrId, $requestedSize ) {
		if ( !$requestedSize )
			return false;

		$ifi = new ImportFreeImages();
		$sizes = $ifi->getSizes( $flickrId );

		foreach ( $sizes as $size ) {
			if ( $size['label'] === $requestedSize ) {
				return $size['source'];
			}
		}

		return false;
	}

	/**
	 * UI hook to remove all source input selections and replace them by a set
	 * of radio buttons allowing the user to select the requested size
	 */
	public static function onUploadFormSourceDescriptors( &$descriptor, &$radio, $selectedSourceType ) {
		global $wgRequest;
		if ( $wgRequest->getVal( 'wpSourceType' ) != 'IFI' || !$wgRequest->getCheck( 'wpFlickrId' ) )
		{
			return true;
		}

		// We entered here from Special:ImportFreeImages, so kill all other source selections
		foreach ( $descriptor as $name => $value ) {
			if ( isset( $value['section'] ) && $value['section'] == 'source' ) {
				unset( $descriptor[$name] );
			}
		}

		$ifi = new ImportFreeImages();
		$sizes = $ifi->getSizes( $wgRequest->getText( 'wpFlickrId' ) );

		// Create radio buttons. TODO: Show resolution; Make largest size default
		$options = array();
		foreach ( $sizes as $size ) {
			$label = wfMsgExt( 'importfreeimages_size_' . strtolower( $size['label'] ), 'parseinline' );
			$options[$label] = $size['label'];
		}

		$descriptor['Size'] = array(
			'type' => 'radio',
			'section' => 'source',
			'name' => 'Size',
			'options' => $options
		);
		$descriptor['wpFlickrId'] = array(
			'type' => 'hidden',
			'name' => 'wpFlickrId',
			'default' => $wgRequest->getText( 'wpFlickrId' ),
		);
		$descriptor['wpSourceType'] = array(
			'type' => 'hidden',
			'name' => 'wpSourceType',
			'default' => 'IFI',
		);

		// Stop running further hooks
		return false;
	}

	public static function onUploadFormInitDescriptor( &$descriptor ) {
		global $wgRequest;
		if ( $wgRequest->getVal( 'wpSourceType' ) != 'IFI' || !$wgRequest->getCheck( 'wpFlickrId' ) )
		{
			return true;
		}

		$ifi = new ImportFreeImages();
		$id = $wgRequest->getVal( 'wpFlickrId', 0 );
		$info = $ifi->getPhotoInfo( $id );

		$name_wiki = wfEscapeWikiText( $info['owner']['username'] );
		if ( $ifi->creditsTemplate ) {
			$owner_wiki = wfEscapeWikiText( $info['owner']['realname'] );
			$id_wiki = wfEscapeWikiText( $id );
			$caption = "{{" . $ifi->creditsTemplate . intval( $info['license'] ) .
				"|1=$id_wiki|2=$owner_wiki|3=$name_wiki}}";
		} else {
			// TODO: this is totally wrong: The whole message should be configurable, we shouldn't include arbitrary templates
			// additionally, the license information is not correct (we are not guaranteed to get "CC by 2.0" images only)
			$caption = wfMsgForContent( 'importfreeimages_filefromflickr',
				$info['title'],
				'http://www.flickr.com/people/' . urlencode( $info['owner']['username'] ) . ' ' . $name_wiki
			) . ' {{CC by 2.0}} ';
			$caption = trim( $caption );
		}
		$descriptor['UploadDescription']['default'] = $caption;

		return true;
	}

}
