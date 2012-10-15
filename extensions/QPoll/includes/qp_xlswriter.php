<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of QPoll.
 * Uses parts of code from Quiz extension (c) 2007 Louis-Rémi BABE. All rights reserved.
 *
 * QPoll is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * QPoll is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with QPoll; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * QPoll is a poll tool for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named QPoll into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/QPoll/qp_user.php";
 *
 * @version 0.8.0a
 * @link http://www.mediawiki.org/wiki/Extension:QPoll
 * @author QuestPC <questpc@rambler.ru>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Generic Xls format wrapper / helper for Excel PEAR class.
 * It is used as base class for poll and for it's questions.
 */
class qp_XlsWriter {

	/**
	 * Static properties are shared across instances, including
	 * derived ones (ancestors). This prevents from writing multiple
	 * worksheets simultaneously, however currently we do not need it.
	 * Instead, question XLS writers are derived from poll XLS writer,
	 * sharing all the useful write*() methods, not having to build
	 * hierarchial XLS writers structure (with owner property in
	 * children constructor to access parents write*() methods ).
	 *
	 * Please keep all direct access to static properties here, not
	 * expanding to ancestors.
	 *
	 * Warning: watch out for "self" references in ancestors, PHP 5.2
	 * does not support late static binding (unfortunately). Let's wait
	 * for the time when PHP 5.3 will become minimal common standard.
	 *
	 */
	# an instance of XLS workbook (it contains worksheets and formats)
	static $wb;
	# an instance of XLS worksheet (only one currently is used)
	static $ws;
	# list of format definitions added to workbook
	static $fdef;
	# list of format instances added to workbook
	static $format;
	# current row number in a worksheet (pointer)
	static $rownum = 0;

	function __construct( $xls_fname = null ) {
		if ( is_string( $xls_fname ) ) {
			# create special "default" format key/val to avoid extra "if" logic:
			self::$format = array( 'null' => null );
			self::$wb = new Spreadsheet_Excel_Writer_Workbook( $xls_fname );
			self::$wb->setVersion( 8 );
			self::$ws = self::$wb->addworksheet();
			self::$ws->setInputEncoding( 'utf-8' );
			self::$ws->setPaper( 9 );
		}
	}

	function closeWorkbook() {
		self::$wb->close();
	}

	/**
	 * PEAR Excel class uses instances of Spreadsheet_Excel_Writer_Format
	 * for cell formatting; we store these instances in self::$format array
	 * and then address these by passing array keys (strings with format "name").
	 */
	function addFormats( array $formats ) {
		foreach ( $formats as $fkey => $fdef ) {
			self::$fdef[$fkey] = $fdef;
			self::$format[$fkey] = self::$wb->addformat( $fdef );
		}
	}

	function getFormatDefinition( $fkey ) {
		return self::$fdef[$fkey];
	}

	function getFormat( $fkey ) {
		return self::$format[$fkey];
	}

	/**
	 * This function is used to prevent text answer strings starting with '=' sign
	 * to be evaluated as Excel formula; In fact this function is used on every
	 * string type input in the write*() functions below; effectively disabling
	 * formulas at all, however the extension currently does not need formulas in
	 * XLS export and unlikely will to.
	 */
	function prepareXlsString( $s ) {
		if ( preg_match( '`^=.?`', $s ) ) {
			return "'" . $s;
		}
		return $s;
	}

	/**
	 * Write scalar value into selected column of the current row.
	 */
	function write( $col, $val, $fkey = 'null' ) {
		if ( is_string( $val ) ) {
			$val = $this->prepareXlsString( $val );
		}
		self::$ws->write( self::$rownum, $col, $val, self::$format[$fkey] );
	}

	/**
	 * Write scalar value into selected column of the current row.
	 * Advance row pointer to the next row ("line feed")
	 */
	function writeLn( $col, $val, $fkey = 'null' ) {
		$this->write( $col, $val, $fkey );
		self::$rownum++;
	}

	/**
	 * Write array of values into current row at the selected column.
	 */
	function writeRow( $col, $arr, $fkey = 'null' ) {
		foreach( $arr as &$val ) {
			if ( is_string( $val ) ) {
				$val = $this->prepareXlsString( $val );
			}
		}
		self::$ws->writerow( self::$rownum, $col, $arr, self::$format[$fkey] );
	}

	/**
	 * Write array of values into current row at the selected column.
	 * Advance row pointer to the next row ("line feed")
	 */
	function writeRowLn( $col, $arr, $fkey = 'null' ) {
		$this->writeRow( $col, $arr, $fkey );
		self::$rownum++;
	}

	/**
	 * Write array of values into selected column of the current row.
	 */
	function writeCol( $col, $arr, $fkey = 'null' ) {
		foreach( $arr as &$val ) {
			if ( is_string( $val ) ) {
				$val = $this->prepareXlsString( $val );
			}
		}
		self::$ws->writecol( self::$rownum, $arr, $val, self::$format[$fkey] );
	}

	/**
	 * Write 2d-table of data into selected column of the current row.
	 */
	function writeFormattedTable( $colnum, array &$table, $fkey = 'null' ) {
		$ws = self::$ws;
		foreach ( $table as $rnum => &$row ) {
			foreach ( $row as $cnum => &$cell ) {
				if ( is_array( $cell ) ) {
					$val = is_string( $cell[0] ) ? $this->prepareXlsString( $cell[0] ) : $cell[0];
					$curr_fkey = array_key_exists( 'format', $cell ) ? $cell['format'] : $fkey;
					$ws->write( self::$rownum + $rnum, $colnum + $cnum, $val, self::$format[$curr_fkey] );
				} else {
					$val = is_string( $cell ) ? $this->prepareXlsString( $cell ) : $cell;
					$ws->write( self::$rownum + $rnum, $colnum + $cnum, $val, self::$format[$fkey] );
				}
			}
		}
	}

	function nextRow() {
		self::$rownum ++;
	}

	function relRow( $delta ) {
		self::$rownum += $delta;
	}

} /* end of qp_XlsWriter class */
