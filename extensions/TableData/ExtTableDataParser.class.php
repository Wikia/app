<?php
/**
 * ExtTableData class for extension TableData.
 *
 * @file
 * @ingroup Extensions
 */

abstract class ExtTableDataParser {
	
	protected $mFormat;
	
	public function __construct( $format ) {
		$this->mFormat = $format;
	}
	
	public function getFormat() {
		return $this->mFormat;
	}
	
	/**
	 * This method must take the $content and parse it according to the format
	 * (you can support multiple formats in one class by looking at getFormat()
	 * to see what format name created this instance.
	 * The return value must be an array containing an array of headers/keys
	 * in the "headers" key, and in the "rows" key an array of associative arrays
	 * of data.
	 * For example this CSV:
	 * A,B,C
	 * 1,2,3
	 * A CSV parser should turn into the following array:
	 * array(
	 *   "headers" => array( "A", "B", "C" ),
	 *   "rows" => array(
	 *     array(
	 *       "A" => "1",
	 *       "B" => "2",
	 *       "C" => "3",
	 *     ),
	 *   ),
	 * );
	 * The method is also passed the attributes used in the tag, this can be useful
	 * if you ABSOLUTELY NEED to add some formatter specific arguments. However
	 * please be sparing in the arguments you take. And understand that the arguments
	 * you use could conflict with ones that are being used for other purposes
	 * in the tag itself. The best practice is to prefix any argument you use
	 * with either the formatter name or "formatter.".
	 * You also may return an array with they key "error" pointing to a message name
	 * that will be prefixed with "datatable-error-" and printed out to the user.
	 */
	abstract public function parse( $content, $attributes );
	
}

