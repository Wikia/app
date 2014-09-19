<?php

class LilyPond {
	/**
	 * @param $lilypond_code string
	 * @return string
	 */
	public static function renderMidiFragment( $lilypond_code ) {
		return self::renderFragment( $lilypond_code, true );
	}

	/**
	 * @param $lilypond_code string
	 * @param $midi bool
	 * @return string
	 */
	public static function renderFragment( $lilypond_code, $midi = false ) {
		return self::render( "\\header {\n"
			. "\ttagline = ##f\n"
			. "}\n"
			. "\\paper {\n"
			. "\traggedright = ##t\n"
			. "\traggedbottom = ##t\n"
			. "\tindent = 0\mm\n"
			. "}\n"
			. "\\score {\n"
			. $lilypond_code
			. "\t\\layout { }\n"
			. ( $midi ? "\t\\midi { }\n":"" )
			. "}\n", $lilypond_code );
	}

	/**
	 * @param $lilypond_code
	 * @param $short_code bool
	 * @return string
	 */
	public static function render( $lilypond_code, $short_code = false ) {
		global $wgMathPath, $wgMathDirectory, $wgTmpDirectory, $wgLilypond, $wgLilypondPreMidi,
			$wgLilypondPostMidi, $wgLilypondTrim, $wgLilypondBorderX, $wgLilypondBorderY;

		wfProfileIn( __METHOD__ );
		$mf = wfMsg( "math_failure" );

		$md5 = md5( $lilypond_code );

		if ( file_exists( $wgMathDirectory . "/" . $md5 . ".midi" ) ) {
			$pre = "<a href=\"" . $wgMathPath . "/" . $md5 . ".midi\"> " . $wgLilypondPreMidi;
			$post = $wgLilypondPostMidi . " </a>";
		} else {
			$pre = "";
			$post = "";
		}

		$link = '';
		# if short_code is supplied, this is a fragment
		if ( $short_code ) {
			$link = "<img src=\"" . $wgMathPath . "/" . $md5 . ".png\" alt=\""
				. htmlspecialchars( $short_code ) . "\">";

			if ( file_exists( "$wgMathDirectory/$md5.png" ) ) {
				wfProfileOut( __METHOD__ );
				return $pre . $link . $post;
			}
		} else {
			if ( file_exists( "$wgMathDirectory/$md5-1.png" ) ) {
				for ( $i = 1; file_exists( $wgMathDirectory . "/" .
						$md5 . "-" . $i . ".png" );
					  $i++ ) {

					$link .= "<img src=\"" . $wgMathPath . "/" .
						$md5 . "-" . $i . ".png\" alt=\"" .
						htmlspecialchars( "page " . $i ) . "\">";
				}
				wfProfileOut( __METHOD__ );
				return $pre . $link . $post;
			}
		}

		# Ensure that the temp and output dirs are available before continuing.
		if ( !file_exists( $wgMathDirectory ) ) {
			wfSuppressWarnings();
			$res = mkdir( $wgMathDirectory );
			wfRestoreWarnings();
			if ( !$res ) {
				wfDebug( 'Unable to create directory ' . $wgMathDirectory );
				wfProfileOut( __METHOD__ );
				return "<b>$mf (" . wfMsg( "math_bad_output" ) .
					$wgMathDirectory . ")</b>";
			}
		} elseif ( !is_dir( $wgMathDirectory ) ||
			!is_writable( $wgMathDirectory ) ) {
			wfDebug( 'Unable to write to directory ' . $wgMathDirectory );
			wfProfileOut( __METHOD__ );
			return "<b>$mf (" . wfMsg( "math_bad_output" ) . ")</b>";
		}
		if ( !file_exists( $wgTmpDirectory ) ) {
			wfSuppressWarnings();
			$res = mkdir( $wgTmpDirectory );
			wfRestoreWarnings();
			if ( !$res ) {
				wfDebug( 'Unable to create temporary directory ' . $wgTmpDirectory );
				wfProfileOut( __METHOD__ );
				return "<b>$mf (" . wfMsg( "math_bad_tmpdir" )
					. ")</b>";
			}
		} elseif ( !is_dir( $wgTmpDirectory ) ||
			!is_writable( $wgTmpDirectory ) ) {
			wfDebug( 'Unable to write to temporary directory ' . $wgTmpDirectory );
			wfProfileOut( __METHOD__ );
			return "<b>$mf (" . wfMsg( "math_bad_tmpdir" ) . ")</b>";
		}

		$lyFile = $md5 . ".ly";
		$out = fopen( $wgTmpDirectory . "/" . $lyFile, "w" );
		if ( $out === false ) {
			wfDebug( 'Unable to write to temporary directory ' . $wgTmpDirectory . "/" . $lyFile );
			wfProfileOut( __METHOD__ );
			return "<b>$mf (" . wfMsg( "math_bad_tmpdir" ) . ")</b>";
		}
		fwrite( $out, $lilypond_code );
		fclose( $out );

		$cmd = $wgLilypond .
			" -dsafe='#t' -dbackend=eps --png --header=texidoc " .
			escapeshellarg( $lyFile ) . " 2>&1";

		wfDebug( "Lilypond: $cmd\n" );
		$oldcwd = getcwd();
		chdir( $wgTmpDirectory );
		exec( $cmd, $output, $ret );
		chdir( $oldcwd );

		if ( $ret != 0 ) {
			wfProfileOut( __METHOD__ );
			return "<br><b>LilyPond error:</b><br><i>"
				. str_replace( array( $md5, " " ),
					array( "<b>your code</b>", "&nbsp;" ),
					nl2br( htmlentities( join( "\n", $output ) ) ) )
				. "</i><br>";
		}

		if ( $short_code ) {
			$outputFile = $wgTmpDirectory . "/" . $md5 . ".png";

			if ( !file_exists( $outputFile ) ) {
				wfDebug( 'Output file doesn\'t exist ' . $outputFile );
				wfProfileOut( __METHOD__ );
				return "<b>$mf (" . wfMsg( "math_image_error" )
					. ")</b>";
			}

			rename( $outputFile, $wgMathDirectory . "/" . $md5 . ".png" );
		}

		# remove all temporary files
		$files = opendir( $wgTmpDirectory );
		$last_page = 0;

		while ( false !== ( $file = readdir( $files ) ) ) {
			if ( substr( $file, 0, 32 ) != $md5 ) {
				continue;
			}

			$file_absolute = $wgTmpDirectory . "/" . $file;
			if ( !$short_code && preg_match( '/-page(\d+)\.png$/',
					$file, $matches ) ) {
				if ( $matches[1] > $last_page ) {
					$last_page = $matches[1];
				}
				rename( $file_absolute, $wgMathDirectory . "/" .
					$md5 . "-" . $matches[1] . ".png" );
				continue;
			}

			if ( preg_match( '/.png$/', $file ) ) {
				rename( $file_absolute, $wgMathDirectory . "/" . $md5 . ".png" );
				continue;
			}

			if ( preg_match( '/.midi$/', $file ) ) {
				rename( $file_absolute, $wgMathDirectory . "/" .
					$md5 . ".midi" );
				$pre = "<a href=\"" . $wgMathPath . "/" . $md5 . ".midi\"> " . $wgLilypondPreMidi;
				$post = $wgLilypondPostMidi . " </a>";
				continue;
			}

			if ( !is_file( $file_absolute ) ) {
				continue;
			}
			unlink( $file_absolute );
		}
		closedir( $files );

		if ( $short_code ) {
			if ( !file_exists( $wgMathDirectory . "/" . $md5 . ".png" ) ) {
				$errmsg = wfMsg( "math_image_error" );
				wfProfileOut( __METHOD__ );
				return "<h3>$mf ($errmsg): " .
					htmlspecialchars( $lilypond_code ) . "</h3>";
			}
		} else {
			$link .= "<img src=\"" . $wgMathPath . "/" . $md5 . ".png\" alt=\""
				. htmlspecialchars( "page " ) . "\">";
		}

		if ( $wgLilypondTrim ) {
			$imgFile = $wgMathDirectory . "/" . $md5 . ".png";
			self::trimImage( $imgFile, $imgFile, 0xFFFFFF );
		}

		if ( $wgLilypondBorderX > 0 || $wgLilypondBorderY > 0 ) {
			$imgFile = $wgMathDirectory . "/" . $md5 . ".png";
			self::frameImage( $imgFile, $imgFile, 0xFFFFFF, $wgLilypondBorderX, $wgLilypondBorderY );
		}

		wfProfileOut( __METHOD__ );
		return $pre . $link . $post;
	}

	/**
	 * @param $source
	 * @param $dest
	 * @param $bgColour
	 */
	private static function trimImage( $source, $dest, $bgColour ) {
		$srcImage = imagecreatefrompng( $source );
		$width = imagesx( $srcImage );
		$height = imagesy( $srcImage );

		$xmin = self::findMin( $width, $height, $srcImage, $bgColour );
		$xmax = self::findMax( $width, $height, $xmin, $srcImage, $bgColour );

		$ymin = self::findMin( $height, $width, $srcImage, $bgColour );
		$ymax = self::findMax( $height, $width, $ymin, $srcImage, $bgColour );

		$newWidth  = $xmax - $xmin + 1;
		$newHeight = $ymax - $ymin + 1;

		$dstImage = imagecreatetruecolor( $newWidth, $newHeight );
		imagecopy( $dstImage, $srcImage, 0, 0, $xmin, $ymin, $newWidth, $newHeight );
		imagepng( $dstImage, $dest );
	}

	/**
	 * @param $outer int
	 * @param $inner int
	 * @param $srcImage
	 * @param $bgColour
	 * @return int
	 */
	static function findMin( $outer, $inner, $srcImage, $bgColour ) {
		for ( $x = 0; $x < $outer; $x++ ) {
			for ( $y = 0; $y < $inner; $y++ ) {
				$rgb = imagecolorat( $srcImage, $x, $y );
				if ( $rgb != $bgColour ) {
					return $x;
				}
			}
		}
		return 0;
	}

	/**
	 * @param $outer int
	 * @param $inner int
	 * @param $min int
	 * @param $srcImage
	 * @param $bgColour
	 * @return int
	 */
	static function findMax( $outer, $inner, $min, $srcImage, $bgColour ) {
		for ( $x = $outer - 1; $x > $min; $x-- ) {
			for ( $y = 0; $y < $inner; $y++ ) {
				$rgb = imagecolorat( $srcImage, $x, $y );
				if ( $rgb != $bgColour ) {
					return $x;
				}
			}
		}
		return $min;
	}

	/**
	 * @param $source
	 * @param $dest
	 * @param $bgColour
	 * @param $borderWidth
	 * @param $borderHeight
	 */
	private static function frameImage( $source, $dest, $bgColour, $borderWidth, $borderHeight ) {
		$srcImage = imagecreatefrompng( $source );
		$width = imagesx( $srcImage );
		$height = imagesy( $srcImage );
		$dstImage = imagecreatetruecolor( $width + 2 * $borderWidth, $height + 2 * $borderHeight );
		$allocatedBgColour = imagecolorallocate( $dstImage, ( $bgColour >> 16 ) & 0xFF, ( $bgColour >> 8 ) & 0xFF, $bgColour & 0xFF );
		imagefill( $dstImage, 0, 0, $allocatedBgColour );
		imagecopy( $dstImage, $srcImage, $borderWidth, $borderHeight, 0, 0, $width, $height );
		imagepng( $dstImage, $dest );
	}
}
