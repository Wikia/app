<?php
/**
 * Description of TiffReader
 *
 * @author Sebastian Ulbricht <sebastian.ulbricht@gmx.de>
 */

 // This is still experimental
class TiffReader {
	protected $time		 = null;
	protected $file		 = null;
	protected $file_handle  = null;
	protected $order		= null;
	protected $the_answer   = null;
	protected $embed_files  = 0;
	protected $ifd_offsets  = array();
	protected $real_eof	 = 0;
	protected $highest_addr = 0;

	protected $unknown_fields = false;

	protected $hex   = null;
	protected $short = null;
	protected $long  = null;

	public function __construct( $file ) {
		$this->time = microtime( true );
		$this->file = $file;
		// set file-pointer
		$this->file_handle = fopen( $this->file, 'rb' );
		// read the tiff-header
		$this->order = ( fread( $this->file_handle, 2 ) == 'II' );
		if ( $this->order ) {
			$this->hex   = 'h*';
			$this->short = 'v*';
			$this->long  = 'V*';
		} else {
			$this->hex   = 'H*';
			$this->short = 'n*';
			$this->long  = 'N*';
		}
		$this->the_answer = unpack( $this->short, fread( $this->file_handle, 2 ) );
		// set the offset of the first ifd
		$offset = unpack( $this->long, fread( $this->file_handle, 4 ) );
		$this->ifd_offsets[]['offset'] = $offset[1];
		fseek( $this->file_handle, 0, SEEK_END );
		$this->real_eof = ftell( $this->file_handle );
	}

	public function checkScriptAtEnd( $size = 1 ) {
		$size = $size * 1024 * 1024;
		if ( $size > $this->real_eof ) {
			fseek( $this->file_handle, 0, SEEK_SET );
			$chunk = fread( $this->file_handle, $this->real_eof );
		} else {
			fseek( $this->file_handle, ( $this->real_eof - $size ), SEEK_SET );
			$chunk = fread( $this->file_handle, $size );
		}
		# check for HTML doctype
		if ( preg_match( '/<!DOCTYPE *X?HTML/', $chunk ) ) {
			return true;
		}

		$tags = array( '<a href',
			'<body',
			'<head',
			'<html',
			'<img',
			'<pre',
			'<script',
			'<table',
			'<title' );
		foreach ( $tags as $tag ) {
			if ( false !== strpos( $chunk, $tag ) ) {
				return true;
			}
		}
		# look for script-types
		if ( preg_match( '!type\s*=\s*[\'"]?\s*(?:\w*/)?(?:ecma|java)!sim', $chunk ) ) {
			return true;
		}

		# look for HTML-style script-urls
		if ( preg_match( '!(?:href|src|data)\s*=\s*[\'"]?\s*(?:ecma|java)script:!sim', $chunk ) ) {
			return true;
		}

		# look for CSS-style script-urls
		if ( preg_match( '!url\s*\(\s*[\'"]?\s*(?:ecma|java)script:!sim', $chunk ) ) {
			return true;
		}
	}

	public function checkSize() {
		$diff = $this->real_eof - $this->highest_addr;
		if ( $diff ) {
			if ( $diff < 0 ) {
				return true;
			}
			fseek( $this->file_handle, $this->highest_addr, SEEK_SET );
			$diffstr = fread( $this->file_handle, $diff );
			if ( preg_match( '/^\0+$/', $diffstr ) ) {
				return true;
			}
			return false;
		}
		return true;
	}

	public function isValidTiff() {
		return $this->the_answer[1] == 42;
	}

	public function check( $debug = false ) {
		$offset = $this->ifd_offsets[$this->embed_files]['offset'];
		// loop over all ifd
		while ( $offset && $offset <= $this->real_eof ) {
			// save the offset if it is the highest one
			if ( $offset > $this->highest_addr ) {
				$this->highest_addr = $offset;
			}
			// set file-pointer to address with given offset
			fseek( $this->file_handle, $offset, SEEK_SET );
			// read amount of ifd-entries
			$entries = unpack( $this->short, fread( $this->file_handle, 2 ) );
			if ( !is_array( $entries ) || !isset( $entries[1] ) ) {
				$this->the_answer = 0;
				return false;
			}
			$entries = $entries[1];

			$address = $offset + 2 + ( $entries * 12 );
			if ( $address > $this->highest_addr ) {
				$this->highest_addr = $address;
			}

			// run through all entries of this ifd an read them out
			for ( $i = 0; $i < $entries; $i++ ) {
				$tmp = $this->readIFDEntry();
				if ( !$tmp ) {
					return false;
				}
				$this->ifd_offsets[$this->embed_files]['data'][$tmp['tag']] = $tmp;
			}

			// set the offset of the next ifd or null if this is the last one
			$offset = unpack( $this->long, fread( $this->file_handle, 4 ) );
			if ( !is_array( $offset ) || !isset( $offset[1] ) ) {
				$this->the_answer = 0;
				return false;
			}
			$offset = $offset[1];
			if ( $offset ) {
				$this->ifd_offsets[]['offset'] = $offset;
			}
			$this->embed_files++;
		}
		$this->calculateDataRange();

		if ( $debug ) {
			echo "<h2>TiffReader-Debug:</h2>\n";
			echo '<b>File: </b>' . $this->file . "<br />\n";
			if ( $this->order ) {
				echo "<b>Byte-Order: </b>little Endian<br />\n";
			} else {
				echo "<b>Byte-Order: </b>big Endian<br />\n";
			}
			echo '<b>Valid Tiff: </b>';
			if ( $this->the_answer[1] == 42 ) {
				echo "yes<br />\n";
			} else {
				echo "no<br />\n";
			}
			echo '<b>Physicaly Size: </b>' . $this->real_eof . " bytes<br />\n";
			echo '<b>Calculated Size: </b>' . $this->highest_addr . " bytes<br />\n";
			echo '<b>Difference in Size: </b>' . ( $this->real_eof - $this->highest_addr ) . " bytes<br />\n";
			echo '<b>Unknown Fields: </b>';
			if ( $this->unknown_fields ) {
				echo "yes<br />\n";
			} else {
				echo "no<br />\n";
			}
			echo "<b>Embed Files: </b>" . $this->embed_files . "<br />\n";
			echo "<b>Runtime: </b>" . round( ( microtime( true ) - $this->time ), 6 ) . " seconds<br />\n";
		}
	}

	protected function readIFDEntry() {
		$tag   = unpack( $this->short, fread( $this->file_handle, 2 ) );
		$type  = unpack( $this->short, fread( $this->file_handle, 2 ) );
		$count = unpack( $this->long, fread( $this->file_handle, 4 ) );
		$value = unpack( $this->long, fread( $this->file_handle, 4 ) );
		if ( !is_array( $tag ) || !is_array( $type ) || !is_array( $count ) || !is_array( $value ) ||
			!isset( $tag[1] ) || !isset( $type[1] ) || !isset( $count[1] ) || !isset( $value[1] ) ) {
			$this->the_answer = 0;
			return false;
		}
		return array(
			'tag'   => $tag[1],
			'type'  => $type[1],
			'count' => $count[1],
			'value' => $value[1]
		);
	}

	protected function calculateDataRange() {
		foreach ( $this->ifd_offsets as $number => $ifd ) {
			foreach ( $ifd['data'] as $tag => $data ) {
				// ignore all entries with local values
				if ( ( $data['type'] == 1 && $data['count'] <= 4 ) ||
					( $data['type'] == 2 && $data['count'] <= 4 ) ||
					( $data['type'] == 3 && $data['count'] <= 2 ) ||
					( $data['type'] == 4 && $data['count'] <= 1 ) ||
					( $data['type'] == 6 && $data['count'] <= 4 ) ||
					( $data['type'] == 7 && $data['count'] <= 4 ) ||
					( $data['type'] == 8 && $data['count'] <= 2 ) ||
					( $data['type'] == 9 && $data['count'] <= 1 ) ) {
					continue;
				}
				// set value size
				switch( $data['type'] ) {
					case 1:
					case 2:
					case 6:
					case 7:
						$size = 1;
						break;
					case 3:
					case 8:
						$size = 2;
						break;
					case 4:
					case 9:
					case 11:
						$size = 4;
						break;
					case 5:
					case 10;
					case 12:
						$size = 8;
						break;
					default:
						$size = 4;
						$this->unknown_fields = true;
						break;
				}
				// calculate the range of memory, the data need
				$size = $data['value'] + ( $size * $data['count'] );
				if ( $size > $this->highest_addr ) {
					$this->highest_addr = $size;
				}
			}
			// check if more calculations needed
			if ( $this->highest_addr == $this->real_eof ) {
				break;
			}
			// check if image data have to calculate
			if ( isset( $ifd['data'][273] ) && isset( $ifd['data'][279] ) ) {
				// set file pointer to the offset for values from field 273
				fseek( $this->file_handle, $ifd['data'][273]['value'], SEEK_SET );
				// get all offsets of the ImageStripes
				$stripes = array();
				if ( $ifd['data'][273]['type'] == 3 ) {
					for ( $i = 0; $i < $ifd['data'][273]['count']; $i++ ) {
						$stripes[] = unpack( $this->short, fread( $this->file_handle, 2 ) );
					}
				} else {
					for ( $i = 0; $i < $ifd['data'][273]['count']; $i++ ) {
						$stripes[] = unpack( $this->long, fread( $this->file_handle, 4 ) );
					}
				}

				// set file pointer to the offset for values from field 279
				fseek( $this->file_handle, $ifd['data'][279]['value'], SEEK_SET );
				// get all offsets of the StripeByteCounts
				$stripebytes = array();
				if ( $ifd['data'][279]['type'] == 3 ) {
					for ( $i = 0; $i < $ifd['data'][279]['count']; $i++ ) {
						$stripebytes[] = unpack( $this->short, fread( $this->file_handle, 2 ) );
					}
				} else {
					for ( $i = 0; $i < $ifd['data'][279]['count']; $i++ ) {
						$stripebytes[] = unpack( $this->long, fread( $this->file_handle, 4 ) );
					}
				}
				// calculate the memory range of the image stripes
				for ( $i = 0; $i < count( $stripes ); $i++ ) {
					$size = $stripes[$i][1] + $stripebytes[$i][1];
					if ( $size > $this->highest_addr ) {
						$this->highest_addr = $size;
					}
				}
			}
			if ( isset( $ifd['data'][324] ) && isset( $ifd['data'][325] ) ) {
				// set file pointer to the offset for values from field 324
				fseek( $this->file_handle, $ifd['data'][324]['value'], SEEK_SET );
				// get all offsets of the ImageTiles
				$tiles = array();
				for ( $i = 0; $i < $ifd['data'][324]['count']; $i++ ) {
					$tiles[] = unpack( $this->long, fread( $this->file_handle, 4 ) );
				}

				// set file pointer to the offset for values from field 325
				fseek( $this->file_handle, $ifd['data'][325]['value'], SEEK_SET );
				// get all offsets of the TileByteCounts
				$tilebytes = array();
				if ( $ifd['data'][325]['type'] == 3 ) {
					for ( $i = 0; $i < $ifd['data'][325]['count']; $i++ ) {
						$tilebytes[] = unpack( $this->short, fread( $this->file_handle, 2 ) );
					}
				} else {
					for ( $i = 0; $i < $ifd['data'][325]['count']; $i++ ) {
						$tilebytes[] = unpack( $this->long, fread( $this->file_handle, 4 ) );
					}
				}
				// calculate the memory range of the image tiles
				for ( $i = 0; $i < count( $tiles ); $i++ ) {
					$size = $tiles[$i][1] + $tilebytes[$i][1];
					if ( $size > $this->highest_addr ) {
						$this->highest_addr = $size;
					}
				}
			}
			if ( isset( $ifd['data'][288] ) && isset( $ifd['data'][289] ) ) {
				// set file pointer to the offset for values from field 288
				fseek( $this->file_handle, $ifd['data'][288]['value'], SEEK_SET );
				// get all offsets of the ImageTiles
				$free = array();
				for ( $i = 0; $i < $ifd['data'][288]['count']; $i++ ) {
					$free[] = unpack( $this->long, fread( $this->file_handle, 4 ) );
				}

				// set file pointer to the offset for values from field 289
				fseek( $this->file_handle, $ifd['data'][289]['value'], SEEK_SET );
				// get all offsets of the TileByteCounts
				$freebytes = array();
				for ( $i = 0; $i < $ifd['data'][289]['count']; $i++ ) {
					$freebytes[] = unpack( $this->long, fread( $this->file_handle, 4 ) );
				}
				// calculate the memory range of the image tiles
				for ( $i = 0; $i < count( $tiles ); $i++ ) {
					$size = $free[$i][1] + $freebytes[$i][1];
					if ( $size > $this->highest_addr ) {
						$this->highest_addr = $size;
					}
				}
			}
		}
	}
}