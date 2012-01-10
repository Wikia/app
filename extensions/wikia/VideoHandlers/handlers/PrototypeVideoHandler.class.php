<?php

class PrototypeVideoHandler extends VideoHandler {

	protected $apiName = 'PrototypeApiWrapper';

	/* Digg through that */
//	function getMetadata( $image, $filename ) {
//		global $wgShowEXIF;
//		if( $wgShowEXIF && file_exists( $filename ) ) {
//			$exif = new Exif( $filename );
//			$data = $exif->getFilteredData();
//			if ( $data ) {
//				$data['MEDIAWIKI_EXIF_VERSION'] = Exif::version();
//				return serialize( $data );
//			} else {
//				return '0';
//			}
//		} else {
//			return '';
//		}
//	}
//
//	function getMetadataType( $image ) {
//		return 'exif';
//	}
//
//	function isMetadataValid( $image, $metadata ) {
//		global $wgShowEXIF;
//		if ( !$wgShowEXIF ) {
//			# Metadata disabled and so an empty field is expected
//			return true;
//		}
//		if ( $metadata === '0' ) {
//			# Special value indicating that there is no EXIF data in the file
//			return true;
//		}
//		$exif = @unserialize( $metadata );
//		if ( !isset( $exif['MEDIAWIKI_EXIF_VERSION'] ) ||
//			$exif['MEDIAWIKI_EXIF_VERSION'] != Exif::version() )
//		{
//			# Wrong version
//			wfDebug( __METHOD__.": wrong version\n" );
//			return false;
//		}
//		return true;
//	}
//
//	/**
//	 * Get a list of EXIF metadata items which should be displayed when
//	 * the metadata table is collapsed.
//	 *
//	 * @return array of strings
//	 * @access private
//	 */
//	function visibleMetadataFields() {
//		$fields = array();
//		$lines = explode( "\n", wfMsgForContent( 'metadata-fields' ) );
//		foreach( $lines as $line ) {
//			$matches = array();
//			if( preg_match( '/^\\*\s*(.*?)\s*$/', $line, $matches ) ) {
//				$fields[] = $matches[1];
//			}
//		}
//		$fields = array_map( 'strtolower', $fields );
//		return $fields;
//	}
//
//	function formatMetadata( $image ) {
//		$result = array(
//			'visible' => array(),
//			'collapsed' => array()
//		);
//		$metadata = $image->getMetadata();
//		if ( !$metadata ) {
//			return false;
//		}
//		$exif = unserialize( $metadata );
//		if ( !$exif ) {
//			return false;
//		}
//		unset( $exif['MEDIAWIKI_EXIF_VERSION'] );
//		$format = new FormatExif( $exif );
//
//		$formatted = $format->getFormattedData();
//		// Sort fields into visible and collapsed
//		$visibleFields = $this->visibleMetadataFields();
//		foreach ( $formatted as $name => $value ) {
//			$tag = strtolower( $name );
//			self::addMeta( $result,
//				in_array( $tag, $visibleFields ) ? 'visible' : 'collapsed',
//				'exif',
//				$tag,
//				$value
//			);
//		}
//		return $result;
//	}

	/* StopDigging */

	/**
	 * Get the thumbnail extension and MIME type for a given source MIME type
	 * @return array thumbnail extension and MIME type
	 */

	function getThumbType( $ext, $mime, $params = null ) {
		return array( 'jpg', 'image/jpeg' );
	}

	function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ) {

		$oThumbnailImage = parent::doTransform( $image, $dstPath, $dstUrl, $params, $flags );

		return new ThumbnailVideo(
			$oThumbnailImage->file,
			$oThumbnailImage->url,
			$oThumbnailImage->width,
			$oThumbnailImage->height,
			$oThumbnailImage->path,
			$oThumbnailImage->page
		);
	}

	function getEmbed(){

		// hardcoden but this is only a prototype. In future it will be handled in a better way
		
		return '<div class="embedHtml">
				<object id="rg_player_ac330d90-cb46-012e-f91c-12313d18e962" name="rg_player_ac330d90-cb46-012e-f91c-12313d18e962" type="application/x-shockwave-flash" width="660" height="371" classid="clsid:ac330d90-cb46-012e-f91c-12313d18e962" style="visibility: visible;" data="http://anomaly.realgravity.com/flash/player.swf">
				<param name="allowscriptaccess" value="always">
				<param name="allowNetworking" value="all">
				<param name="menu" value="false">
				<param name="wmode" value="transparent">
				<param name="allowFullScreen" value="true">
				<param name="flashvars" value="&amp;config=http://mediacast.realgravity.com/vs/api/playerxml/ac330d90-cb46-012e-f91c-12313d18e962">
				<embed id="ac330d90-cb46-012e-f91c-12313d18e962" name="ac330d90-cb46-012e-f91c-12313d18e962" width="660" height="371" allownetworking="all" allowscriptaccess="always" allowfullscreen="true" wmode="transparent" flashvars="config=http://mediacast.realgravity.com/vs/api/playerxml/ac330d90-cb46-012e-f91c-12313d18e962?video_guid=6fb1e3829bb6915446d08368cd8b1a2300f0" src="http://anomaly.realgravity.com/flash/player.swf">
			</object></div>';
	}
	
}
