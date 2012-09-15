<?php
/*
 Defines a subset of parser functions that operate with arrays.
 verion: 1.2.2
 authors: Li Ding (lidingpku@gmail.com) and Jie Bao
 update: 16 July 2009
 homepage: http://www.mediawiki.org/wiki/Extension:ArrayExtension

todo
    - add experimental table (2 dimension array)  data structure
       * table  = header, row+  (1,1....)
       * sort_table_by_header (header)
       * sort_table_by_col (col)
       * print_table (format)   e.g. csv, ul, ol,
       * add_table_row (array)
       * get_table_row (row) to an array
       * add_table_col(array)
       * get_table_col (col) to an array
       * get_table_header () to an array
       * get_total_row
       * get_total_col

 changelog
 * July 16, 2009 version 1.2.2
    - update arrayunique,  fixed bug (zero mistakenly eliminated in array after arrayunique)
    - rename key=>arrayid, should not affect any existing users
    - rename validate_array_by_name to validate_array_by_arrayid
    - add "asc" as option of arraysort

 * May 03, 2009 version 1.2.1
   - update arraydefine by adding options:  "unique";  sort= ( "desc","asce", "random","reverse"), and print= ("list").   options are diliminated by comma, e.g. "unique, sort=desc,print=list".
   - fixed bug in arrayslice (offset can be greater than array size): if offset is no less than array size, empty array will be returned, if offset if no greater than negative array size, a new array with all elements will be returned
   - update arrayindex by adding print option when (i) the array is not defined; (ii) the index is not valid in the specified array: e.g. "default=bad array"
 * April 24, 2009 version 1.2
   - fixed a bug in  arrayslice,   (offset=0)
   - clean up code, added two private functions, validate_array_index, validate_array_offset, validate_array_by_arrayid; rename some parameters key=> new_key,  differentiate offset and index
 * April 18, 2009 version 1.1.6
   - fixed a bug in arraymerge and arrayslice,
 * Mar 17, 2009 version 1.1.5
   - update #arraysort, add "reverse" option, http://us3.php.net/manual/en/function.array-reverse.php
   - update #arrayreset, add option to reset a selection of arrays
 * Feb 23, 2009 version 1.1.4
   - fixed #arraysearch, better recognize perl patterns identified by starting with "/", http://www.perl.com/doc/manual/html/pod/perlre.html
 * Feb 23, 2009 version 1.1.3
   - fixed #arraysearch, "Warning: Missing argument 4..."
 * Feb 9, 2009 version 1.1.2
    - update #arraysearch, now support offset and preg regular expression
 * Feb 8, 2009 version 1.1.1
    - update #arrayprint, now wiki links, parser functions and templates properly parsed. This enables foreach loop call.
    - update #arraysearch, now allows customized output upon found/non-found by specifying additional parameters
 * Feb 5, 2009 version 1.1
    - update #arraydefine: replacing  'explode' by 'preg_split',
           and we now allow delimitors to  be (i) a string; or (ii) a perl regular expressnion pattern, sourrounded by '/', e.g. '/..blah.../'
    - update #arrayprint, change parameters from "prefix","suffix" to a "template",
           and users can replace a substring in the template with array value, similar to arraymap in semantic forms
    - update #arrayunique,  empty elements will be removed
    - update #arraysort: adding "random" option to make the array of values in random order
    - add #arrayreset to free all defined arrays for memory saving
    - add #arrayslice to return an array bounded by start_index and length.
    - add  #arraysearch. now we can return the index of the first occurence of an element, return -1 if not found
    - remove #arraymember,  obsoleted by #arraysearch
    - remove #arraypush, obsoleted by #arraydefine and #arraymerge
    - remove #arraypop, obsoleted by  #arrayslice
    - add safty check code to avoid unset parameters

 * Feb 1, 2009 version 1.0.3
    - fixed bug on arrayunique,   php array_unique only make values unique, but the array index was not updated.  (arraydefine is also affected)
 * Jan 28, 2009 version 1.0.2
    - changed arraypop  (add one parameter to support multiple pop)
    - added arrayindex (return an array element at index)
 * Jan 27, 2009  version 1.0.1
    - changed arraydefine (allow defining empty array)


 -------------------------------------------
 the following fuctions are obsoleted
    #arraypush  (replaced by arraymerge)
    #arraypop  (replaced by arrayslice)
    #arraymember (replaced by arraysearch)
 -------------------------------------------


The  MIT License

 Copyright (c) 2008

 Permission is hereby granted, free of charge, to any person
 obtaining a copy of this software and associated documentation
 files (the "Software"), to deal in the Software without
 restriction, including without limitation the rights to use,
 copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the
 Software is furnished to do so, subject to the following
 conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 OTHER DEALINGS IN THE SOFTWARE.

*/

if ( !defined( 'MEDIAWIKI' ) ) {
    die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgHooks['ParserFirstCallInit'][] = 'wfSetupArrayExtension';

$wgExtensionCredits['parserhook'][] = array(
        'name' => 'ArrayExtension',
        'url' => 'http://www.mediawiki.org/wiki/Extension:ArrayExtension',
        'author' => array ('Li Ding','Jie Bao'),
        'description' => 'store and compute named arrays',
        'version' => '1.2.2',
);

$wgHooks['LanguageGetMagic'][]       = 'wfArrayExtensionLanguageGetMagic';


/**
   *  named arrays    - an array has a list of values, and could be set to a SET
 */
class ArrayExtension {
    var $mArrayExtension;

///////////////////////////////////////////////////////////
// PART 1. constructor
///////////////////////////////////////////////////////////

/**
* Define an array by a list of 'values' deliminated by 'delimiter',
* the delimiter should be perl regular expression pattern
*      {{#arraydefine:arrayid|values|delimiter|options}}
*
* http://us2.php.net/manual/en/book.pcre.php
* see also: http://us2.php.net/manual/en/function.preg-split.php
*/
    function arraydefine( &$parser, $arrayid, $value='', $delimiter = '/\s*,\s*/', $options = '') {
        if (!isset($arrayid))
	   return '';

        //normalize
	$value = trim($value);
	$delimiter = trim($delimiter);

	if (!$this->is_non_empty ($value) ){
	    $this->mArrayExtension[$arrayid] = array();
	}else if (!$this->is_non_empty($delimiter)){
	    $this->mArrayExtension[$arrayid] = array( $value );
	}else{
	    if (0!==strpos($delimiter,'/') || (strlen($delimiter)-1)!==strrpos($delimiter,'/')){
		$delimiter='/\s*'.$delimiter.'\s*/';
	    }

	    $this->mArrayExtension[$arrayid] = preg_split ($delimiter, $value);

	    // validate if the array has been successfully created
	    $ret = $this->validate_array_by_arrayid($arrayid);
	    if (true!==$ret){
	       return '';
	    }

	    // now parse the options, and do posterior process on the created array
	    $ary_option = $this->parse_options($options);

	    // make it unique if option is set
	    if (FALSE !== array_key_exists('unique', $ary_option)){
		   $this->arrayunique($parser, $arrayid);
	    }

	    // sort array if the option is set
	    $this->arraysort($parser, $arrayid, $this->get_array_value($ary_option,"sort"));

	    // print the array upon request
	    if (strcmp("list", $this->get_array_value($ary_option,"print"))===0){
		return $this->arrayprint($parser, $arrayid);
	    }
	}

	return '';
    }

///////////////////////////////////////////////////////////
// PART 2. print
///////////////////////////////////////////////////////////

/**
* print an array.
* foreach element of the array, print 'subject' where  all occurrences of 'search' is replaced with the element,
* and each element print-out is deliminated by 'delimiter'
* The subject can embed parser functions; wiki links; and templates.
* usage
*      {{#arrayprint:arrayid|delimiter|search|subject}}
* examples:
*    {{#arrayprint:b}}    -- simple
*    {{#arrayprint:b|<br/>}}    -- add change line
*    {{#arrayprint:b|<br/>|@@@|[[@@@]]}}    -- embed wiki links
*    {{#arrayprint:b|<br/>|@@@|{{#set:prop=@@@}} }}   -- embed parser function
*    {{#arrayprint:b|<br/>|@@@|{{f.tag{{f.print.vbar}}prop{{f.print.vbar}}@@@}} }}   -- embed template function
*    {{#arrayprint:b|<br/>|@@@|[[name::@@@]]}}   -- make SMW links
*/
    function arrayprint( &$parser, $arrayid , $delimiter = ', ', $search='@@@@', $subject='@@@@', $frame=null) {
	$ret = $this->validate_array_by_arrayid($arrayid);
	if (true!==$ret){
	   return $ret;
	}

	$values=$this->mArrayExtension[$arrayid];
	$rendered_values= array();
	foreach($values as $v){
		$temp_result_value  = str_replace($search, $v, $subject);
		if (isset($frame)){
			$temp_result_value = $parser->preprocessToDom($temp_result_value, $frame->isTemplate() ? Parser::PTD_FOR_INCLUSION : 0);
			$temp_result_value = trim($frame->expand($temp_result_value));
                }
		$rendered_values[] = $temp_result_value ;
	}
	return array(implode( $delimiter, $rendered_values) , 'noparse' => false, 'isHTML' => false);
    }

    function arrayprintObj(  &$parser, $frame, $args ) {
		// Set variables
	$arrayid = isset($args[0]) ? trim($frame->expand($args[0])) : '';
	$delimiter = isset($args[1]) ? trim($frame->expand($args[1])) : ', ';
	$search = isset($args[2]) ? trim($frame->expand($args[2], PPFrame::NO_ARGS | PPFrame::NO_TEMPLATES)) : '@@@@';
	$subject = isset($args[3]) ? trim($frame->expand($args[3], PPFrame::NO_ARGS | PPFrame::NO_TEMPLATES)) : '@@@@';

	return $this->arrayprint($parser, $arrayid, $delimiter, $search, $subject, $frame);
    }

/**
* print the value of an array (identified by arrayid)  by the index, invalid index results in the default value  being printed. note the index is 0-based.
* usage
*   {{#arrayindex:arrayid|index}}
*/
    function arrayindex( &$parser, $arrayid , $index , $options='') {
	// now parse the options, and do posterior process on the created array
	$ary_option = $this->parse_options($options);

        $ret = $this->validate_array_by_arrayid($arrayid);
	if (true!==$ret){
	    return $this->get_array_value($ary_option,"default");
	}

	$ret = $this->validate_array_index($index, $this->mArrayExtension[$arrayid]);
	if (true!==$ret){
	    return $this->get_array_value($ary_option,"default");
	}

	return $this->mArrayExtension[$arrayid][$index];
    }

/**
* return size of array.
* Print the size (number of elements) in the specified array
* usage
*   {{#arraysize:arrayid}}
*
*  See: http://www.php.net/manual/en/function.count.php
*/
    function arraysize( &$parser, $arrayid) {
 	$ret = $this->validate_array_by_arrayid($arrayid);
	if (true!==$ret){
	   return '';
	}

        return count ($this->mArrayExtension[$arrayid]);
    }



/**
* locate the index of the first occurence of an element starting from the 'index'
*   - print "-1" (not found) or index (found) to show the index of the first occurence of 'value' in the array identified by arrayid
*    - if 'yes' and 'no' are set, print value of them when found or not-found
*   - index is 0-based , it must be non-negative and less than lenth
* usage
*   {{#arraysearch:arrayid|value|index|yes|no}}
*
*   See: http://www.php.net/manual/en/function.array-search.php
*   note it is extended to support regular expression match and index
*/
    function arraysearch( &$parser, $arrayid, $needle, $index=0, $yes=null, $no=null) {
 	$ret = $this->validate_array_by_arrayid($arrayid);
	if (true!==$ret){
		$ret = -1;
	        if (isset($no))
		  $ret=$no;
		return $ret;
	}


        if (!$this->is_non_empty($needle) ){
		$ret = -1;
	        if (isset($no))
		  $ret=$no;
		return $ret;
	}

	$ret = $this->validate_array_index($index, $this->mArrayExtension[$arrayid]);
	if (true!==$ret){
		$ret = -1;
	        if (isset($no))
		  $ret=$no;
		return $ret;
	}

	//TODO we need a better way to decide perl expresion.
	$bIsPreg= (0===strpos($needle,'/') );
	$ret = false;
	for ($i=$index; $i< count($this->mArrayExtension[$arrayid]) ;$i++){
		$value = $this->mArrayExtension[$arrayid][$i];
		if ($bIsPreg){
			// check if the needle is preg regular expression (require '/.../')
			if (preg_match($needle, $value)){
			   $ret = $i;
			   break;
			}
		}else{
			if (strcmp($needle, $value)===0){
			   $ret = $i;
			   break;
			}
		}
	}

	if (false !== $ret ){
		if (isset($yes))
		  $ret=$yes;
		return $ret;
	}

	$ret = -1;
        if (isset($no))
	  $ret=$no;
	return $ret;
    }



///////////////////////////////////////////////////////////
// PART 3. alter an array
///////////////////////////////////////////////////////////

/**
* reset some or all defined arrayes
* usage
*    {{#arrayreset:}}
*    {{#arrayreset:arrayid1,arrayid2,...arrayidn}}
*/
   function arrayreset( &$parser, $arrayids) {
        if (!$this->is_non_empty($arrayids)){
	    //reset all
	    $this->mArrayExtension = array();
	}else{
	    $arykeys = explode(',', $arrayids);
	    foreach ($arykeys as $arrayid){
		$arrayid = trim($arrayid);
		if ( array_key_exists($arrayid,$this->mArrayExtension) && is_array($this->mArrayExtension[$arrayid]) ){
		    unset($this->mArrayExtension[$arrayid]);
		}
	    }
	}
	return '';
    }


/**
* convert an array to set
* convert the array identified by arrayid into a set (all elements are unique)
* usage
*   {{#arrayunique:arrayid}}
*
*   see: http://www.php.net/manual/en/function.array-unique.php
*/
    function arrayunique( &$parser, $arrayid ) {
	$ret = $this->validate_array_by_arrayid($arrayid);
	if (true!==$ret){
	   return '';
	}

	    $this->mArrayExtension[$arrayid]= array_unique ($this->mArrayExtension[$arrayid]);
	    $values= array();
	    foreach ($this->mArrayExtension[$arrayid] as $v){
		//if (!isset($v))
		   $values[]=$v;
	    }
	    $this->mArrayExtension[$arrayid] = $values;
    }

/**
* sort an array
*   sort specified array in the following order:
*   * none (default)  - no sort
*   *  desc - in descending order, large to small
*   *  asce - in ascending order, small to large
*   * random - shuffle the arrry in random order
*   * reverse - Return an array with elements in reverse order
* usage
*   {{#arraysort:arrayid|order}}
*
*   see: http://www.php.net/manual/en/function.sort.php
*          http://www.php.net/manual/en/function.rsort.php
*          http://www.php.net/manual/en/function.shuffle.php
*          http://us3.php.net/manual/en/function.array-reverse.php
*/
    function arraysort( &$parser, $arrayid , $sort = 'none') {
	$ret = $this->validate_array_by_arrayid($arrayid);
	if (true!==$ret){
	   return '';
	}

	switch ($sort){
		case 'asc':
		case 'asce':
		case 'ascending': sort($this->mArrayExtension[$arrayid]); break;

		case 'desc':
		case 'descending': rsort($this->mArrayExtension[$arrayid]); break;

		case 'random': shuffle($this->mArrayExtension[$arrayid]); break;

		case 'reverse': $this->mArrayExtension[$arrayid]= array_reverse($this->mArrayExtension[$arrayid]); break;
	    };
    }

///////////////////////////////////////////////////////////
// PART 4. create an array
///////////////////////////////////////////////////////////
/**
* merge two arrays,  keep duplicated values
* usage
*   {{#arraymerge:arrayid_new|arrayid1|arrayid2}}
*
*  merge values two arrayes identified by arrayid1 and arrayid2 into a new array identified by arrayid_new.
*  this merge differs from array_merge of php because it merges values.
*/
    function arraymerge( &$parser, $arrayid_new, $arrayid1, $arrayid2='' ) {
        if (!isset($arrayid_new) )
	   return '';

	$ret = $this->validate_array_by_arrayid($arrayid1);
	if (true!==$ret){
	   return '';
	}


	$temp_array = array();
	foreach ($this->mArrayExtension[$arrayid1] as $entry){
	   array_push ($temp_array, $entry);
	}

	if ( isset($arrayid2) && strlen($arrayid2)>0){
		$ret = $this->validate_array_by_arrayid($arrayid1);
		if (true===$ret){
			foreach ($this->mArrayExtension[$arrayid2] as $entry){
			   array_push ($temp_array, $entry);
			}
		}
	}

	$this->mArrayExtension[$arrayid_new] = $temp_array;
	return '';
    }

   function is_non_empty($var){
	return isset($var) && strlen($var)>0;
   }
/**
* extract a slice from an array
* usage
*     {{#arrayslice:arrayid_new|arrayid|offset|length}}
*
*    extract a slice from an  array
*    see: http://www.php.net/manual/en/function.array-slice.php
*/
    function arrayslice( &$parser, $arrayid_new , $arrayid , $offset, $length='') {
        if (!isset($arrayid_new) )
	   return '';

	$ret = $this->validate_array_by_arrayid($arrayid);
	if (true!==$ret){
	   return '';
	}

	//$ret = $this->validate_array_offset($offset, $this->mArrayExtension[$arrayid]);
	//if (true!==$ret){
	 //  return '';
	//}

	$temp_array = array();
	if (is_numeric($offset)){
		if ($this->is_non_empty($length) &&  is_numeric($length)){
			$temp = array_slice($this->mArrayExtension[$arrayid], $offset, $length);
		}else{
			$temp = array_slice($this->mArrayExtension[$arrayid], $offset);
		}

		if (!empty($temp) && is_array($temp))
			$temp_array = array_values($temp);
	}
	$this->mArrayExtension[$arrayid_new] = $temp_array;
	return '';
    }

//////////////////////////////////////////////////
// SET OPERATIONS:    a set does not have duplicated element

/**
*  set operation,    {red} = {red, white} intersect {red,black}
* usage
*    {{#arrayintersect:arrayid_new|arrayid1|arrayid2}}
*   See: http://www.php.net/manual/en/function.array-intersect.php
*/
    function arrayintersect( &$parser, $arrayid_new , $arrayid1 , $arrayid2 ) {
        if (!isset($arrayid_new) )
	   return '';

	$ret = $this->validate_array_by_arrayid($arrayid1);
	if (true!==$ret){
	   return '';
	}

	$ret = $this->validate_array_by_arrayid($arrayid2);
	if (true!==$ret){
	   return '';
	}

 	$this->mArrayExtension[$arrayid_new] = array_intersect( array_unique($this->mArrayExtension[$arrayid1]), array_unique($this->mArrayExtension[$arrayid2]) );

	return '';
    }


/**
*    set operation,    {red, white} = {red, white} union {red}
* usage
*    {{#arrayunion:arrayid_new|arrayid1|arrayid2}}

*    similar to arraymerge, this union works on values.
*/

    function arrayunion( &$parser, $arrayid_new , $arrayid1 , $arrayid2 ) {
        if (!isset($arrayid_new) )
	   return '';

	$ret = $this->validate_array_by_arrayid($arrayid1);
	if (true!==$ret){
	   return '';
	}

	$ret = $this->validate_array_by_arrayid($arrayid2);
	if (true!==$ret){
	   return '';
	}

    	$this->arraymerge($parser, $arrayid_new, $arrayid1, $arrayid2);
	$this->mArrayExtension[$arrayid_new] = array_unique ($this->mArrayExtension[$arrayid_new]);

	return '';
    }
/**
*
* usage
*    {{#arraydiff:arrayid_new|arrayid1|arrayid2}}

*    set operation,    {white} = {red, white}  -  {red}
*    see: http://www.php.net/manual/en/function.array-diff.php
*/

    function arraydiff( &$parser, $arrayid_new , $arrayid1 , $arrayid2 ) {
        if (!isset($arrayid_new) )
	   return '';

	$ret = $this->validate_array_by_arrayid($arrayid1);
	if (true!==$ret){
	   return '';
	}

	$ret = $this->validate_array_by_arrayid($arrayid2);
	if (true!==$ret){
	   return '';
	}

	$this->mArrayExtension[$arrayid_new] = array_diff( array_unique($this->mArrayExtension[$arrayid1]),array_unique($this->mArrayExtension[$arrayid2]));

	return '';
    }


//////////////////////////////////////////////////
// private functions

    // private functions for validating the index of an array
    function validate_array_index($index, $array){
        if (!isset($index))
		return false;

	if (!is_numeric($index))
		return false;

	if (!isset($array) || !is_array($array))
		return false;

	if ( $index<0 || $index>=count($array))
		return false;

	return true;
    }

    // private functions for validating the index of an array
    function validate_array_offset($offset, $array){
        if (!isset($offset))
		return false;

	if (!is_numeric($offset))
		return false;

	if (!isset($array) || !is_array($array))
		return false;

	if ( $offset>=count($array))
		return false;

	return true;
    }


    //private function for validating array by name
    function validate_array_by_arrayid($array_name){
	if (!isset($array_name))
	   return '';

	if (!isset($this->mArrayExtension))
 	   return "undefined array: $array_name";

        if (!array_key_exists($array_name,$this->mArrayExtension) || !is_array($this->mArrayExtension[$array_name]))
 	   return "undefined array: $array_name";

	return true;
    }

    function get_array_value($array, $field){
	    if (is_array($array) && FALSE !== array_key_exists($field, $array))
		return $array[$field];
	    else
	        return '';
    }

    function parse_options($options){
	if (isset($options)){
	    // now parse the options, and do posterior process on the created array
	    $ary_option = preg_split ('/\s*[,]\s*/', strtolower($options));
	}

	$ret = array();
	if (isset($ary_option) && is_array($ary_option) && sizeof($ary_option)>0){
		foreach ($ary_option as $option){
			$ary_pair = explode('=', $option,2);
			if (sizeof($ary_pair)==1){
				$ret[$ary_pair[0]] = true;
			}else{
				$ret[$ary_pair[0]] = $ary_pair[1];
			}
		}
	}

	return $ret;
    }

}

function wfSetupArrayExtension( $parser ) {
    global $wgArrayExtension, $wgHooks;

    if (empty($wgArrayExtension)) {
    	$wgArrayExtension = new ArrayExtension;
    }

    $parser->setFunctionHook( 'arraydefine', array( &$wgArrayExtension, 'arraydefine' ) );

    if( defined( get_class( $parser) . '::SFH_OBJECT_ARGS' ) ) {
		$parser->setFunctionHook( 'arrayprint', array( &$wgArrayExtension, 'arrayprintObj' ), SFH_OBJECT_ARGS);
    } else {
		$parser->setFunctionHook( 'arrayprint', array( &$wgArrayExtension, 'arrayprint' ) );
    }

    $parser->setFunctionHook( 'arraysize', array( &$wgArrayExtension, 'arraysize' ) );
    $parser->setFunctionHook( 'arrayindex', array( &$wgArrayExtension, 'arrayindex' ) );
    $parser->setFunctionHook( 'arraysearch', array( &$wgArrayExtension, 'arraysearch' ) );

    $parser->setFunctionHook( 'arraysort', array( &$wgArrayExtension, 'arraysort' ) );
    $parser->setFunctionHook( 'arrayunique', array( &$wgArrayExtension, 'arrayunique' ) );
    $parser->setFunctionHook( 'arrayreset', array( &$wgArrayExtension, 'arrayreset' ) );

    $parser->setFunctionHook( 'arraymerge', array( &$wgArrayExtension, 'arraymerge' ) );
    $parser->setFunctionHook( 'arrayslice', array( &$wgArrayExtension, 'arrayslice' ) );

    $parser->setFunctionHook( 'arrayunion', array( &$wgArrayExtension, 'arrayunion' ) );
    $parser->setFunctionHook( 'arrayintersect', array( &$wgArrayExtension, 'arrayintersect' ) );
    $parser->setFunctionHook( 'arraydiff', array( &$wgArrayExtension, 'arraydiff' ) );
    return true;
}

function wfArrayExtensionLanguageGetMagic( &$magicWords, $langCode ) {
        require_once( dirname( __FILE__ ) . '/ArrayExtension.i18n.php' );
        foreach( efArrayExtensionWords( $langCode ) as $word => $trans )
                $magicWords[$word] = $trans;
        return true;
}

