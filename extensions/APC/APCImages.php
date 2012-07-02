<?php

class APCImages {
	const IMG_NONE = 0;
	const IMG_MEM_USAGE = 1;
	const IMG_HITS = 2;
	const IMG_FRAGMENTATION = 3;

	const GRAPH_SIZE = 200;

	// create graphics
	//
	public static function graphics_avail() {
		return extension_loaded( 'gd' );
	}

	public static function fill_arc( $im, $centerX, $centerY, $diameter, $start, $end, $color1, $color2, $text = '', $placeindex = 0 ) {
		$r = $diameter / 2;
		$w = deg2rad( ( 360 + $start + ( $end - $start ) / 2 ) % 360 );

		if ( function_exists( "imagefilledarc" ) ) {
			// exists only if GD 2.0.1 is avaliable
			imagefilledarc( $im, $centerX + 1, $centerY + 1, $diameter, $diameter, $start, $end, $color1, IMG_ARC_PIE );
			imagefilledarc( $im, $centerX, $centerY, $diameter, $diameter, $start, $end, $color2, IMG_ARC_PIE );
			imagefilledarc( $im, $centerX, $centerY, $diameter, $diameter, $start, $end, $color1, IMG_ARC_NOFILL | IMG_ARC_EDGED );
		} else {
			imagearc( $im, $centerX, $centerY, $diameter, $diameter, $start, $end, $color2 );
			imageline( $im, $centerX, $centerY, $centerX + cos( deg2rad( $start ) ) * $r, $centerY + sin( deg2rad( $start ) ) * $r, $color2 );
			imageline( $im, $centerX, $centerY, $centerX + cos( deg2rad( $start + 1 ) ) * $r, $centerY + sin( deg2rad( $start ) ) * $r, $color2 );
			imageline( $im, $centerX, $centerY, $centerX + cos( deg2rad( $end - 1 ) )   * $r, $centerY + sin( deg2rad( $end ) )   * $r, $color2 );
			imageline( $im, $centerX, $centerY, $centerX + cos( deg2rad( $end ) )   * $r, $centerY + sin( deg2rad( $end ) )   * $r, $color2 );
			imagefill( $im, $centerX + $r * cos( $w ) / 2, $centerY + $r * sin( $w ) / 2, $color2 );
		}
		if ( $text ) {
			if ( $placeindex > 0 ) {
				imageline( $im, $centerX + $r * cos( $w ) / 2, $centerY + $r * sin( $w ) / 2, $diameter, $placeindex * 12, $color1 );
				imagestring( $im, 4, $diameter, $placeindex * 12, $text, $color1 );

			} else {
				imagestring( $im, 4, $centerX + $r * cos( $w ) / 2, $centerY + $r * sin( $w ) / 2, $text, $color1 );
			}
		}
	}

	public static function text_arc( $im, $centerX, $centerY, $diameter, $start, $end, $color1, $text, $placeindex = 0 ) {
		$r = $diameter / 2;
		$w = deg2rad( ( 360 + $start + ( $end - $start ) / 2 ) % 360 );

		if ( $placeindex > 0 ) {
			imageline( $im, $centerX + $r * cos( $w ) / 2, $centerY + $r * sin( $w ) / 2, $diameter, $placeindex * 12, $color1 );
			imagestring( $im, 4, $diameter, $placeindex * 12, $text, $color1 );

		} else {
			imagestring( $im, 4, $centerX + $r * cos( $w ) / 2, $centerY + $r * sin( $w ) / 2, $text, $color1 );
		}
	}

	public static function fill_box( $im, $x, $y, $w, $h, $color1, $color2, $text = '', $placeindex = '' ) {
		global $col_black;
		$x1 = $x + $w - 1;
		$y1 = $y + $h - 1;

		imagerectangle( $im, $x, $y1, $x1 + 1, $y + 1, $col_black );
		if ( $y1 > $y ) imagefilledrectangle( $im, $x, $y, $x1, $y1, $color2 );
		else imagefilledrectangle( $im, $x, $y1, $x1, $y, $color2 );
		imagerectangle( $im, $x, $y1, $x1, $y, $color1 );
		if ( $text ) {
			if ( $placeindex > 0 ) {

				if ( $placeindex < 16 )
				{
					$px = 5;
					$py = $placeindex * 12 + 6;
					imagefilledrectangle( $im, $px + 90, $py + 3, $px + 90 - 4, $py - 3, $color2 );
					imageline( $im, $x, $y + $h / 2, $px + 90, $py, $color2 );
					imagestring( $im, 2, $px, $py - 6, $text, $color1 );

				} else {
					if ( $placeindex < 31 ) {
						$px = $x + 40 * 2;
						$py = ( $placeindex - 15 ) * 12 + 6;
					} else {
						$px = $x + 40 * 2 + 100 * intval( ( $placeindex - 15 ) / 15 );
						$py = ( $placeindex % 15 ) * 12 + 6;
					}
					imagefilledrectangle( $im, $px, $py + 3, $px - 4, $py - 3, $color2 );
					imageline( $im, $x + $w, $y + $h / 2, $px, $py, $color2 );
					imagestring( $im, 2, $px + 2, $py - 6, $text, $color1 );
				}
			} else {
				imagestring( $im, 4, $x + 5, $y1 - 16, $text, $color1 );
			}
		}
	}

	public static function generateImage( $type ) {
		global $wgLang;

		$mem = apc_sma_info();
		$cache = apc_cache_info( 'opcode' );

		$size = self::GRAPH_SIZE; // image size
		if ( $type == self::IMG_FRAGMENTATION )
			$image = imagecreate( 2 * $size + 150, $size + 10 );
		else
			$image = imagecreate( $size + 10, $size + 10 );

		$col_white = imagecolorallocate( $image, 0xFF, 0xFF, 0xFF );
		$col_red   = imagecolorallocate( $image, 0xD0, 0x60,  0x30 );
		$col_green = imagecolorallocate( $image, 0x60, 0xF0, 0x60 );
		$col_black = imagecolorallocate( $image,   0,   0,   0 );
		imagecolortransparent( $image, $col_white );

		switch ( $type ) {

		case 1:
			$s = $mem['num_seg'] * $mem['seg_size'];
			$a = $mem['avail_mem'];
			$x = $y = $size / 2;
			$fuzz = 0.000001;

			// This block of code creates the pie chart.  It is a lot more complex than you
			// would expect because we try to visualize any memory fragmentation as well.
			$angle_from = 0;
			$string_placement = array();
			for ( $i = 0; $i < $mem['num_seg']; $i++ ) {
				$ptr = 0;
				$free = $mem['block_lists'][$i];
				foreach ( $free as $block ) {
					if ( $block['offset'] != $ptr ) {       // Used block
						$angle_to = $angle_from + ( $block['offset'] - $ptr ) / $s;
						if ( ( $angle_to + $fuzz ) > 1 ) $angle_to = 1;
						self::fill_arc( $image, $x, $y, $size, $angle_from * 360, $angle_to * 360, $col_black, $col_red );
						if ( ( $angle_to - $angle_from ) > 0.05 ) {
							array_push( $string_placement, array( $angle_from, $angle_to ) );
						}
						$angle_from = $angle_to;
					}
					$angle_to = $angle_from + ( $block['size'] ) / $s;
					if ( ( $angle_to + $fuzz ) > 1 ) $angle_to = 1;
					self::fill_arc( $image, $x, $y, $size, $angle_from * 360, $angle_to * 360, $col_black, $col_green );
					if ( ( $angle_to - $angle_from ) > 0.05 ) {
						array_push( $string_placement, array( $angle_from, $angle_to ) );
					}
					$angle_from = $angle_to;
					$ptr = $block['offset'] + $block['size'];
				}
				if ( $ptr < $mem['seg_size'] ) { // memory at the end
					$angle_to = $angle_from + ( $mem['seg_size'] - $ptr ) / $s;
					if ( ( $angle_to + $fuzz ) > 1 ) $angle_to = 1;
					self::fill_arc( $image, $x, $y, $size, $angle_from * 360, $angle_to * 360, $col_black, $col_red );
					if ( ( $angle_to - $angle_from ) > 0.05 ) {
						array_push( $string_placement, array( $angle_from, $angle_to ) );
					}
				}
			}
			foreach ( $string_placement as $angle ) {
				self::text_arc( $image, $x, $y, $size, $angle[0] * 360, $angle[1] * 360, $col_black, $wgLang->formatSize( $s * ( $angle[1] - $angle[0] ) ) );
			}
			break;

		case 2:
			$s = $cache['num_hits'] + $cache['num_misses'];
			$a = $cache['num_hits'];

			self::fill_box( $image, 30, $size, 50, - $a * ( $size - 21 ) / $s, $col_black, $col_green, sprintf( "%.1f%%", $cache['num_hits'] * 100 / $s ) );
			self::fill_box( $image, 130, $size, 50, - max( 4, ( $s - $a ) * ( $size - 21 ) / $s ), $col_black, $col_red, sprintf( "%.1f%%", $cache['num_misses'] * 100 / $s ) );
			break;

		case 3:
			$s = $mem['num_seg'] * $mem['seg_size'];
			$a = $mem['avail_mem'];
			$x = 130;
			$y = 1;
			$j = 1;

			// This block of code creates the bar chart.  It is a lot more complex than you
			// would expect because we try to visualize any memory fragmentation as well.
			for ( $i = 0; $i < $mem['num_seg']; $i++ ) {
				$ptr = 0;
				$free = $mem['block_lists'][$i];
				foreach ( $free as $block ) {
					if ( $block['offset'] != $ptr ) {       // Used block
						$h = ( self::GRAPH_SIZE - 5 ) * ( $block['offset'] - $ptr ) / $s;
						if ( $h > 0 ) {
																									$j++;
							if ( $j < 75 ) self::fill_box( $image, $x, $y, 50, $h, $col_black, $col_red, $wgLang->formatSize( $block['offset'] - $ptr ), $j );
																									else self::fill_box( $image, $x, $y, 50, $h, $col_black, $col_red );
																					}
						$y += $h;
					}
					$h = ( self::GRAPH_SIZE - 5 ) * ( $block['size'] ) / $s;
					if ( $h > 0 ) {
																					$j++;
						if ( $j < 75 ) self::fill_box( $image, $x, $y, 50, $h, $col_black, $col_green, $wgLang->formatSize( $block['size'] ), $j );
						else self::fill_box( $image, $x, $y, 50, $h, $col_black, $col_green );
																	}
					$y += $h;
					$ptr = $block['offset'] + $block['size'];
				}
				if ( $ptr < $mem['seg_size'] ) { // memory at the end
					$h = ( self::GRAPH_SIZE - 5 ) * ( $mem['seg_size'] - $ptr ) / $s;
					if ( $h > 0 ) {
						self::fill_box( $image, $x, $y, 50, $h, $col_black, $col_red, $wgLang->formatSize( $mem['seg_size'] - $ptr ), $j++ );
					}
				}
			}
			break;
		case 4:
			$s = $cache['num_hits'] + $cache['num_misses'];
			$a = $cache['num_hits'];

			self::fill_box( $image, 30, $size, 50, - $a * ( $size - 21 ) / $s, $col_black, $col_green, sprintf( "%.1f%%", $cache['num_hits'] * 100 / $s ) );
			self::fill_box( $image, 130, $size, 50, - max( 4, ( $s - $a ) * ( $size - 21 ) / $s ), $col_black, $col_red, sprintf( "%.1f%%", $cache['num_misses'] * 100 / $s ) );
			break;

		}

		return imagepng( $image );
	}
}
