<?php

class AchImageUploadService {

	/**
	 * PNG ALPHA CHANNEL SUPPORT for imagecopymerge();
	 * This is a function like imagecopymerge but it handle alpha channel well!!!
	 **/

	// A fix to get a function like imagecopymerge WITH ALPHA SUPPORT
	// Main script by aiden dot mail at freemail dot hu
	// Transformed to imagecopymerge_alpha() by rodrigo dot polo at gmail dot com
	private static function imagecopymerge_alpha( $dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct ) {
		if( !isset( $pct ) ) {
			return false;
		}
		$pct /= 100;
		// Get image width and height
		$w = imagesx( $src_im );
		$h = imagesy( $src_im );
		// Turn alpha blending off
		imagealphablending( $src_im, false );
		// Find the most opaque pixel in the image (the one with the smallest alpha value)
		$minalpha = 127;
		for( $x = 0; $x < $w; $x++ )
			for( $y = 0; $y < $h; $y++ ) {
				$alpha = ( imagecolorat( $src_im, $x, $y ) >> 24 ) & 0xFF;
				if( $alpha < $minalpha ) {
					$minalpha = $alpha;
				}
			}
		//loop through image pixels and modify alpha for each
		for( $x = 0; $x < $w; $x++ ) {
			for( $y = 0; $y < $h; $y++ ) {
				//get current alpha value (represents the TANSPARENCY!)
				$colorxy = imagecolorat( $src_im, $x, $y );
				$alpha = ( $colorxy >> 24 ) & 0xFF;
				//calculate new alpha
				if( $minalpha !== 127 ) {
					$alpha = 127 + 127 * $pct * ( $alpha - 127 ) / ( 127 - $minalpha );
				} else {
					$alpha += 127 * $pct;
				}
				//get the color index with new alpha
				$alphacolorxy = imagecolorallocatealpha( $src_im, ( $colorxy >> 16 ) & 0xFF, ( $colorxy >> 8 ) & 0xFF, $colorxy & 0xFF, $alpha );
				//set pixel with the new color + opacity
				if( !imagesetpixel( $src_im, $x, $y, $alphacolorxy ) ) {
					return false;
				}
			}
		}
		// The image copy
		imagecopy( $dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h );
	}

	private static function merge_images( $dest, $src ) {
		self::imagecopymerge_alpha( $dest, $src, 0, 0, 0, 0, 128, 128, 100 );
	}

	private static function merge_alphamask( $dest, $mask1, $mask2 ) {
		imagesavealpha( $dest, true );
		imagealphablending( $dest, false );

		$w = imagesx( $dest );
		$h = imagesy( $dest );

		//loop through mask pixels and modify alpha for each pixel of dest image
		for( $x = 0; $x < $w; $x++ ) {
			for( $y = 0; $y < $h; $y++ ) {
				// get alpha value from both masks
				$colorxy = imagecolorat( $mask1, $x, $y );
				$alpha1 = ( $colorxy >> 24 ) & 0xFF;

				$colorxy = imagecolorat( $mask2, $x, $y );
				$alpha2 = ( $colorxy >> 24 ) & 0xFF;

				$alpha = min( $alpha1, $alpha2 );

				// get color from dest image
				$colorxy = imagecolorat( $dest, $x, $y );

				//get the color index with new alpha
				$alphacolorxy = imagecolorallocatealpha( $dest, ( $colorxy >> 16 ) & 0xFF, ( $colorxy >> 8 ) & 0xFF, $colorxy & 0xFF, $alpha );
				//set pixel with the new color + opacity
				imagesetpixel( $dest, $x, $y, $alphacolorxy );
			}
		}
	}

	public static function uploadBadge( $destinationFileName, $badgeLevel ) {
		global $wgRequest, $wgUser, $wgBadgeNoFrame;

		$upload = new UploadAchievementsFromFile();
		$upload->initialize( $destinationFileName, $wgRequest->getUpload( 'wpUploadFile' ) );

		$details = $upload->verifyUpload();

		//ignore warnings about existing files, they MUST be silently overwritten
		if( $details[ 'status' ] != UploadBase::OK ) {
			return false;
		} else {
			$warnings = $upload->checkWarnings();

			if( $warnings && (
					empty( $warnings[ 'exists' ] ) &&
					empty( $warnings[ 'duplicate' ] ) &&
					empty( $warnings[ 'duplicate-archive' ] )
				)
			) {
				return false;
			}
		}

		// badge data
		$badgeFile = $wgRequest->getUpload( 'wpUploadFile' )->getTempName();

		// validate image using GD
		$badgeImage = imagecreatefromstring( file_get_contents( $badgeFile ) );

		if( !is_resource( $badgeImage ) ) {
			return false;
		}

		// get dimensions of uploaded image
		$badgeWidth = imagesx( $badgeImage );
		$badgeHeight = imagesy( $badgeImage );

		// resize uploaded image if needed
		if( ( $badgeWidth > 128 ) || ( $badgeHeight > 128 ) ) {
			// calculate new badge dimensions
			$ratioWidth = $badgeWidth / 128;
			$ratioHeight = $badgeHeight / 128;

			$ratio = min( $ratioWidth, $ratioHeight );

			// don't scale up
			$ratio = max( $ratio, 1 );

			$newWidth = round( $badgeWidth / $ratio );
			$newHeight = round( $badgeHeight / $ratio );
		} else {
			$newWidth = $badgeWidth;
			$newHeight = $badgeHeight;

			$ratio = 1;
		}

		// resize and crop uploaded image / center inside a badge
		$tmp = imagecreatetruecolor( 128, 128 );

		// transparent background
		imagesavealpha( $tmp, true );
		imagealphablending( $tmp, false );

		$bgColor = imagecolorallocatealpha( $tmp, 0, 0, 0, 127 );
		imagefilledrectangle( $tmp, 0, 0, 127, 127, $bgColor );

		// calculate crop / resize
		$dstX = max( 0, ( 128 - $newWidth ) >> 1 );
		$dstY = max( 0, ( 128 - $newHeight ) >> 1 );

		$srcX = max( 0, ( $badgeWidth - 128 * $ratio ) >> 1 );
		$srcY = max( 0, ( $badgeHeight - 128 * $ratio ) >> 1 );

		imagecopyresampled( $tmp, $badgeImage, $dstX, $dstY, $srcX, $srcY, $newWidth, $newHeight, $badgeWidth, $badgeHeight );

		// use resized badge
		imagedestroy( $badgeImage );
		$badgeImage = $tmp;

		if( !empty( $wgBadgeNoFrame ) ) {
			// save badge as is
			imagepng( $badgeImage, $badgeFile, 9, PNG_ALL_FILTERS );
		} else {
			//load images
			$badgesFragments = dirname( __FILE__ ) . '/../images/badges/fragments';

			$badgeBottom = "{$badgesFragments}/{$badgeLevel}-bottom-128.png";
			$badgeTop = "{$badgesFragments}/{$badgeLevel}-top-128.png";

			$img = array(
				'bottom' => imagecreatefrompng( $badgeBottom ),
				'top' => imagecreatefrompng( $badgeTop ),
				'user' => $badgeImage,
			);

			// create image for badge
			$badge = imagecreatetruecolor( 128, 128 );

			// put bottom layer
			self::merge_images( $badge, $img[ 'bottom' ] );

			// put user's image
			self::merge_images( $badge, $img[ 'user' ] );

			// put top layer
			self::merge_images( $badge, $img[ 'top' ] );

			// now let's fix badge transparency
			self::merge_alphamask( $badge, $img[ 'top' ], $img[ 'bottom' ] );

			// save badge
			imagepng( $badge, $badgeFile, 9, PNG_ALL_FILTERS );

			wfDebug( __METHOD__ . ": generated badge saved as {$badgeFile}\n" );

			// collect garbage
			imagedestroy( $badge );
			foreach( $img as $i ) {
				imagedestroy( $i );
			}
		}

		// upload generated badge
		$file = new LocalFile(
			Title::newFromText( $destinationFileName, 6 ),
			RepoGroup::singleton()->getLocalRepo()
		);
		$file->upload( $badgeFile, '/* comment */', '/* page text */' );
		return $file;
	}

	public static function uploadHover( $destinationFileName ) {
		global $wgRequest, $wgUser;
		$upload = new UploadAchievementsFromFile();
		$upload->initialize( $destinationFileName, $wgRequest->getUpload( 'wpUploadFile' ) );

		$details = $upload->verifyUpload();

		//ignore warnings, existing files MUST be overwritten
		//check only status
		if( $details[ 'status' ] != UploadBase::OK ) {
			return false;
		} else {
			$warnings = $upload->checkWarnings();

			if( $warnings && (
					empty( $warnings[ 'exists' ] ) &&
					empty( $warnings[ 'duplicate' ] ) &&
					empty( $warnings[ 'duplicate-archive' ] )
				)
			) {
				return false;
			}
		}

		$status = $upload->performUpload( '/* comment */', '/* page text */', false, $wgUser );

		if( !$status->isGood() ) {
			return false;
		}

		return $upload->getLocalFile();
	}
}
