<?php

/**
 * WikiHiero - A PHP convert from text using "Manual for the encoding of
 * hieroglyphic texts for computer input" syntax to HTML entities (table and
 * images).
 *
 * Copyright (C) 2004 Guillaume Blanchard (Aoineko)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point' );
}

class WikiHiero {
	const IMAGE_EXT = 'png';
	const IMAGE_PREFIX = 'hiero_';

	const DEFAULT_SCALE = -1; // use default scale
	const CARTOUCHE_WIDTH = 2;
	const IMAGE_MARGIN = 1;
	const MAX_HEIGHT = 44;

	const TABLE_START = '<table class="mw-hiero-table">';

	private $scale = 100;

	private static $phonemes, $prefabs, $files;

	public function __construct() {
		self::loadData();
	}

	/**
	 * Loads hieroglyph information
	 */
	private static function loadData() {
		if ( self::$phonemes ) {
			return;
		}
		if ( MWInit::isHipHop() ) {
			require_once( MWInit::extCompiledPath( 'wikihiero/data/tables.php' ) );
			self::$phonemes = $wh_phonemes;
			self::$prefabs = $wh_prefabs;
			self::$files = $wh_files;
		} else {
			$fileName = dirname( __FILE__ ) . '/data/tables.ser';
			$stream = file_get_contents( $fileName );
			if ( !$stream ) {
				throw new MWException( "Cannot open serialized hieroglyph data file $fileName!" );
			}
			$data = unserialize( $stream );
			self::$phonemes = $data['wh_phonemes'];
			self::$prefabs = $data['wh_prefabs'];
			self::$files = $data['wh_files'];
		}
	}

	/**
	 *
	 */
	public static function parserHook( $input ) {
		$hiero = new WikiHiero();
		// Strip newlines to avoid breakage in the wiki parser block pass
		return str_replace( "\n", " ", $hiero->render( $input ) );
	}

	public function getScale() {
		return $this->scale;
	}

	public function setScale( $scale ) {
		$this->scale = $scale;
	}

	/**
	 * Renders a glyph
	 *
	 * @param $glyph string: glyph's code to render
	 * @param $option string: option to add into <img> tag (use for height)
	 * @return string: a string to add to the stream
	 */
	private function renderGlyph( $glyph, $option = '' ) {
		$imageClass = '';
		if ( $this->isMirrored( $glyph ) ) {
			$imageClass = 'class="mw-mirrored" ';
		}
		$glyph = $this->extractCode( $glyph );
		if ( $glyph == '..' ) { // Render void block
			$width = self::MAX_HEIGHT;
			return "<table class=\"mw-hiero-table\" style=\"width: {$width}px;\"><tr><td>&#160;</td></tr></table>";
		}
		elseif ( $glyph == '.' ) { // Render half-width void block
			$width = self::MAX_HEIGHT / 2;
			return "<table class=\"mw-hiero-table\" style=\"width: {$width}px;\"><tr><td>&#160;</td></tr></table>";
		}
		elseif ( $glyph == '<' ) { // Render open cartouche
			$height = intval( self::MAX_HEIGHT * $this->scale / 100 );
			$code = self::$phonemes[$glyph];
			return "<img src='" . htmlspecialchars( self::getImagePath() . self::IMAGE_PREFIX . "{$code}." . self::IMAGE_EXT ) . "' height='{$height}' title='" . htmlspecialchars( $glyph ) . "' alt='" . htmlspecialchars( $glyph ) . "' />";
		}
		elseif ( $glyph == '>' ) { // Render close cartouche
			$height = intval( self::MAX_HEIGHT * $this->scale / 100 );
			$code = self::$phonemes[$glyph];
			return "<img src='" . htmlspecialchars( self::getImagePath() . self::IMAGE_PREFIX . "{$code}." . self::IMAGE_EXT ) . "' height='{$height}' title='" . htmlspecialchars( $glyph ) . "' alt='" . htmlspecialchars( $glyph ) . "' />";
		}

		if ( array_key_exists( $glyph, self::$phonemes ) ) {
			$code = self::$phonemes[$glyph];
			if ( array_key_exists( $code, self::$files ) ) {
				return "<img {$imageClass}style='margin: " . self::IMAGE_MARGIN . "px; $option' src='" . htmlspecialchars( self::getImagePath() . self::IMAGE_PREFIX . "{$code}." . self::IMAGE_EXT ) . "' title='" . htmlspecialchars( "{$code} [{$glyph}]" ) . "' alt='" . htmlspecialchars( $glyph ) . "' />";
			} else {
				return htmlspecialchars( $glyph );
			}
		} elseif ( array_key_exists( $glyph, self::$files ) ) {
			return "<img {$imageClass}style='margin: " . self::IMAGE_MARGIN . "px; $option' src='" . htmlspecialchars( self::getImagePath() . self::IMAGE_PREFIX . "{$glyph}." . self::IMAGE_EXT ) . "' title='" . htmlspecialchars( $glyph ) . "' alt='" . htmlspecialchars( $glyph ) . "' />";
		} else {
			return htmlspecialchars( $glyph );
		}
	}

	private function isMirrored( $glyph ) {
		return substr( $glyph, -1 ) == '\\';
	}

	/**
	 * Extracts hieroglyph code from glyph, e.g. A1\ --> A1
	 */
	private function extractCode( $glyph ) {
		return preg_replace( '/\\\\.*$/', '', $glyph );
	}

	/**
	 * Resize a glyph
	 *
	 * @param $item string: glyph code
	 * @param $is_cartouche bool: true if glyph is inside a cartouche
	 * @param $total int: total size of a group for multi-glyph block
	 * @return size
	 */
	private function resizeGlyph( $item, $is_cartouche = false, $total = 0 ) {
		$item = $this->extractCode( $item );
		if ( array_key_exists( $item, self::$phonemes ) ) {
			$glyph = self::$phonemes[$item];
		} else {
			$glyph = $item;
		}

		$margin = 2 * self::IMAGE_MARGIN;
		if ( $is_cartouche ) {
			$margin += 2 * intval( self::CARTOUCHE_WIDTH * $this->scale / 100 );
		}

		if ( array_key_exists( $glyph, self::$files ) ) {
			$height = $margin + self::$files[$glyph][1];
			if ( $total ) {
				if ( $total > self::MAX_HEIGHT ) {
					return ( intval( $height * self::MAX_HEIGHT / $total ) - $margin ) * $this->scale / 100;
				} else {
					return ( $height - $margin ) * $this->scale / 100;
				}
			} else {
				if ( $height > self::MAX_HEIGHT ) {
					return ( intval( self::MAX_HEIGHT * self::MAX_HEIGHT / $height ) - $margin ) * $this->scale / 100;
				} else {
					return ( $height - $margin ) * $this->scale / 100;
				}
			}
		}

		return ( self::MAX_HEIGHT - $margin ) * $this->scale / 100;
	}

	/**
	 * Render hieroglyph text
	 *
	 * @param $hiero string: text to convert
	 * @param $scale int: global scale in percentage (default = 100%)
	 * @param $line bool: use line (default = false)
	 * @return string: converted code
	*/
	public function render( $hiero, $scale = self::DEFAULT_SCALE, $line = false ) {
		if ( $scale != self::DEFAULT_SCALE ) {
			$this->setScale( $scale );
		}

		$html = "";

		if ( $line ) {
			$html .= "<hr />\n";
		}

		$tokenizer = new HieroTokenizer( $hiero );
		$blocks = $tokenizer->tokenize();
		$contentHtml = $tableHtml = $tableContentHtml = "";
		$is_cartouche = false;

		// ------------------------------------------------------------------------
		// Loop into all blocks
		foreach ( $blocks as $code ) {

			// simplest case, the block contain only 1 code -> render
			if ( count( $code ) == 1 )
			{
				if ( $code[0] == '!' ) { // end of line
					$tableHtml = '</tr></table>' . self::TABLE_START . "<tr>\n";
					if ( $line ) {
						$contentHtml .= "<hr />\n";
					}

				} elseif ( strchr( $code[0], '<' ) ) { // start cartouche
					$contentHtml .= '<td>' . $this->renderGlyph( $code[0] ) . '</td>';
					$is_cartouche = true;
					$contentHtml .= '<td>' . self::TABLE_START . "<tr><td class='mw-hiero-box' style='height: "
						. intval( self::CARTOUCHE_WIDTH * $this->scale / 100 ) . "px;'></td></tr><tr><td>" . self::TABLE_START . "<tr>";

				} elseif ( strchr( $code[0], '>' ) ) { // end cartouche
					$contentHtml .= "</tr></table></td></tr><tr><td class='mw-hiero-box' style='height: "
						. intval( self::CARTOUCHE_WIDTH * $this->scale / 100 )
						. "px;'></td></tr>" . '</table></td>';
					$is_cartouche = false;
					$contentHtml .= '<td>' . $this->renderGlyph( $code[0] ) . '</td>';

				} elseif ( $code[0] != "" ) { // assume it's a glyph or '..' or '.'
					$option = "height: " . $this->resizeGlyph( $code[0], $is_cartouche ) . "px;";

					$contentHtml .= '<td>' . $this->renderGlyph( $code[0], $option ) . '</td>';
				}

			// block contains more than 1 glyph
			} else {
				// convert all codes into '&' to test prefabs glyph
				$temp = "";
				foreach ( $code as $t ) {
					if ( preg_match( "/[*:!()]/", $t[0] ) ) {
						$temp .= "&";
					} else {
						$temp .= $t;
					}
				}

				// test if block exists in the prefabs list
				if ( in_array( $temp, self::$prefabs ) ) {
					$option = "height: " . $this->resizeGlyph( $temp, $is_cartouche ) . "px;";

					$contentHtml .= '<td>' . $this->renderGlyph( $temp, $option ) . '</td>';

				// block must be manually computed
				} else {
					// get block total height
					$line_max = 0;
					$total    = 0;
					$height   = 0;

					foreach ( $code as $t ) {
						if ( $t == ":" ) {
							if ( $height > $line_max ) {
								$line_max = $height;
							}
							$total += $line_max;
							$line_max = 0;

						} elseif ( $t == "*" ) {
							if ( $height > $line_max ) {
								$line_max = $height;
							}
						} else {
							if ( array_key_exists( $t, self::$phonemes ) ) {
								$glyph = self::$phonemes[$t];
							} else {
								$glyph = $t;
							}
							if ( array_key_exists( $glyph, self::$files ) ) {
								$height = 2 + self::$files[$glyph][1];
							}
						}
					} // end foreach

					if ( $height > $line_max ) {
						$line_max = $height;
					}

					$total += $line_max;

					// render all glyph into the block
					$temp = "";
					foreach ( $code as $t ) {

						if ( $t == ":" ) {
							$temp .= "<br />";

						} elseif ( $t == "*" ) {
							$temp .= " ";

						} else {
							// resize the glyph according to the block total height
							$option = "height: " . $this->resizeGlyph( $t, $is_cartouche, $total ) . "px;";
							$temp .= $this->renderGlyph( $t, $option );
						}
					} // end foreach

					$contentHtml .= '<td>' . $temp . '</td>';
				}
				$contentHtml .= "\n";
			}

			if ( strlen( $contentHtml ) > 0 ) {
				$tableContentHtml .= $tableHtml . $contentHtml;
				$contentHtml = $tableHtml = "";
			}
		}

		if ( strlen( $tableContentHtml ) > 0 ) {
			$html .= self::TABLE_START . "<tr>\n" . $tableContentHtml . '</tr></table>';
		}

		return "<table class='mw-hiero-table mw-hiero-outer' dir='ltr'><tr><td>\n$html\n</td></tr></table>";
	}

	/**
	 * Returns a list of image files used by this extension
	 *
	 * @return array: list of files in format 'file' => array( width, height )
	 */
	public function getFiles() {
		return self::$files;
	}

	/**
	 * @return string: URL of images directory
	 */
	public static function getImagePath() {
		global $wgExtensionAssetsPath;
		return "$wgExtensionAssetsPath/wikihiero/img/";
	}

	/**
	 * Get glyph code from file name
	 *
	 * @param $file string: file name
	 * @return string: converted code
	 */
	public static function getCode( $file ) {
		return substr( $file, strlen( self::IMAGE_PREFIX ), -( 1 + strlen( self::IMAGE_EXT ) ) );
	}
}

/**
 * Hieroglyphs tokenizer class
 */
/*private*/ class HieroTokenizer {
	private static $delimiters = false;
	private static $tokenDelimiters;
	private static $singleChars;

	private $text;
	private $blocks = false;
	private $currentBlock;
	private $token;

	/**
	 * Constructor
	 *
	 * @param $text string:
	 */
	public function __construct( $text ) {
		$this->text = $text;
		self::initStatic();
	}

	private static function initStatic() {
		if ( self::$delimiters ) {
			return;
		}

		self::$delimiters = array_flip( array( ' ', '-', "\t", "\n", "\r" ) );
		self::$tokenDelimiters = array_flip( array( '*', ':', '(', ')' ) );
		self::$singleChars = array_flip( array( '!' ) );
	}

	/**
	 * Split text into blocks, then split blocks into items
	 *
	 * @return array: tokenized text
	 */
	public function tokenize() {
		if ( $this->blocks !== false ) {
			return $this->blocks;
		}
		$this->blocks = array();
		$this->currentBlock = array();
		$this->token = '';

		$text = preg_replace( '/\\<!--.*?--\\>/s', '', $this->text ); // remove HTML comments

		for ( $i = 0; $i < strlen( $text ); $i++ ) {
			$char = $text[$i];

			if ( isset( self::$delimiters[$char] ) ) {
				$this->newBlock();
			} elseif ( isset( self::$singleChars[$char] ) ) {
				$this->singleCharBlock( $char );
			} elseif ( $char == '.' ) {
				$this->dot();
			} elseif ( isset( self::$tokenDelimiters[$char] ) ) {
				$this->newToken( $char );
			} else {
				$this->char( $char );
			}
		}

		$this->newBlock(); // flush stuff being processed

		return $this->blocks;
	}

	/**
	 * Handles a block delimiter
	 */
	private function newBlock() {
		$this->newToken();
		if ( $this->currentBlock ) {
			$this->blocks[] = $this->currentBlock;
			$this->currentBlock = array();
		}
	}

	/**
	 * Flushes current token, optionally adds another one
	 *
	 * @param $token Mixed: token to add or false
	 */
	private function newToken( $token = false ) {
		if ( $this->token !== '' ) {
			$this->currentBlock[] = $this->token;
			$this->token = '';
		}
		if ( $token !== false ) {
			$this->currentBlock[] = $token;
		}
	}

	/**
	 * Adds a block consisting of one character
	 *
	 * @param $char string: block character
	 */
	private function singleCharBlock( $char ) {
		$this->newBlock();
		$this->blocks[] = array( $char );
	}

	/**
	 * Handles void blocks represented by dots
	 */
	private function dot() {
		if ( $this->token == '.' ) {
			$this->token = '..';
			$this->newBlock();
		} else {
			$this->newBlock();
			$this->token = '.';
		}
	}

	/**
	 * Adds a miscellaneous character to current token
	 *
	 * @param $char string: character to add
	 */
	private function char( $char ) {
		if ( $this->token == '.' ) {
			$this->newBlock();
			$this->token = $char;
		} else {
			$this->token .= $char;
		}
	}
}
