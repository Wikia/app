<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------------+
// | File_Ogg PEAR Package for Accessing Ogg Bitstreams                         |
// | Copyright (c) 2005-2007                                                    |
// | David Grant <david@grant.org.uk>                                           |
// | Tim Starling <tstarling@wikimedia.org>                                     |
// +----------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or              |
// | modify it under the terms of the GNU Lesser General Public                 |
// | License as published by the Free Software Foundation; either               |
// | version 2.1 of the License, or (at your option) any later version.         |
// |                                                                            |
// | This library is distributed in the hope that it will be useful,            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of             |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU          |
// | Lesser General Public License for more details.                            |
// |                                                                            |
// | You should have received a copy of the GNU Lesser General Public           |
// | License along with this library; if not, write to the Free Software        |
// | Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA |
// +----------------------------------------------------------------------------+

require_once('File/Ogg/Bitstream.php');

/**
 * Parent class for media bitstreams
 * Contains some functions common to various media formats
 */
abstract class File_Ogg_Media extends File_Ogg_Bitstream
{
    /**
     * Array to hold each of the comments.
     *
     * @access  private
     * @var     array
     */
    var $_comments = array();
    /**
     * Vendor string for the stream.
     *
     * @access  private
     * @var     string
     */
    var $_vendor;

    /**
     * Length of the stream in seconds
     */
    var $_streamLength;
	
    /* Start offset of the stream in seconds */
    var $_startOffset = 0;

    /**
     * Get a short string describing the type of the stream
     * @return string
     */
    abstract function getType();

    /**
     * Get the 6-byte identification string expected in the common header
     * @return string
     */
    function getIdentificationString()
    {
        return '';
    }

    /**
     * @access  private
     * @param   int     $packetType
     * @param   int     $pageOffset
     */
    function _decodeCommonHeader($packetType, $pageOffset)
    {
        fseek($this->_filePointer, $this->_streamData['pages'][$pageOffset]['body_offset'], SEEK_SET);
        if ($packetType !== false) {
            // Check if this is the correct header.
            $packet = unpack("Cdata", fread($this->_filePointer, 1));
            if ($packet['data'] != $packetType)
                throw new PEAR_Exception("Stream Undecodable", OGG_ERROR_UNDECODABLE);
        
            // The following six characters should be equal to getIdentificationString()
            $id = $this->getIdentificationString();
            if ($id !== '' && fread($this->_filePointer, strlen($id)) !== $id)
                throw new PEAR_Exception("Stream is undecodable due to a malformed header.", OGG_ERROR_UNDECODABLE);
        } // else seek only, no common header
    }

    /**
     * Parse a Vorbis-style comments header.
     *
     * This function parses the comments header.  The comments header contains a series of
     * UTF-8 comments related to the audio encoded in the stream.  This header also contains
     * a string to identify the encoding software.  More details on the comments header can
     * be found at the following location: http://xiph.org/vorbis/doc/v-comment.html
     *
     * @access  private
     */
    function _decodeBareCommentsHeader()
    {
        // Decode the vendor string length as a 32-bit unsigned integer.
        $vendor_len = unpack("Vdata", fread($this->_filePointer, 4));
        if ( $vendor_len['data'] > 0 ) {
            // Retrieve the vendor string from the stream.
            $this->_vendor  = fread($this->_filePointer, $vendor_len['data']);
        } else {
            $this->_vendor = '';
        }
        // Decode the size of the comments list as a 32-bit unsigned integer.
        $comment_list_length = unpack("Vdata", fread($this->_filePointer, 4));
        // Iterate through the comments list.
        for ($i = 0; $i < $comment_list_length['data']; ++$i) {
            // Unpack the length of this comment.
            $comment_length = unpack("Vdata", fread($this->_filePointer, 4));
            // Comments are in the format 'ARTIST=Super Furry Animals', so split it on the equals character.
            // NOTE: Equals characters are strictly prohibited in either the COMMENT or DATA parts.
            $comment        = explode("=", fread($this->_filePointer, $comment_length['data']));
            $comment_title  = (string) $comment[0];
            $comment_value  = (string) utf8_decode($comment[1]);
    
            // Check if the comment type (e.g. ARTIST) already exists.  If it does,
            // take the new value, and the existing value (or array) and insert it
            // into a new array.  This is important, since each comment type may have
            // multiple instances (e.g. ARTIST for a collaboration) and we should not
            // overwrite the previous value.
            if (isset($this->_comments[$comment_title])) {
                if (is_array($this->_comments[$comment_title]))
                    $this->_comments[$comment_title][] = $comment_value;
                else
                    $this->_comments[$comment_title] = array($this->_comments[$comment_title], $comment_value);
            } else
                $this->_comments[$comment_title] = $comment_value;
        }
    }
    
    /**
     * Provides a list of the comments extracted from the Vorbis stream.
     *
     * It is recommended that the user fully inspect the array returned by this function
     * rather than blindly requesting a comment in false belief that it will always
     * be present.  Whilst the Vorbis specification dictates a number of popular
     * comments (e.g. TITLE, ARTIST, etc.) for use in Vorbis streams, they are not
     * guaranteed to appear.
     *
     * @access  public
     * @return  array
     */
    function getCommentList()
    {
        return (array_keys($this->_comments));
    }

    /**
     * Provides an interface to the numerous comments located with a Vorbis stream.
     *
     * A Vorbis stream may contain one or more instances of each comment, so the user
     * should check the variable type before printing out the result of this method.
     * The situation in which multiple instances of a comment occurring are not as
     * rare as one might think, since they are conceivable at least for ARTIST comments
     * in the situation where a track is a duet.
     *
     * @access  public
     * @param   string  $commentTitle   Comment title to search for, e.g. TITLE.
     * @param   string  $separator      String to separate multiple values.
     * @return  string
     */
    function getField($commentTitle, $separator = ", ")
    {
    if (isset($this->_comments[$commentTitle])) {
        if (is_array($this->_comments[$commentTitle]))
            return (implode($separator, $this->_comments[$commentTitle]));
        else
            return ($this->_comments[$commentTitle]);
    } else
        // The comment doesn't exist in this file.  The user should've called getCommentList first.
        return ("");
    }
    
    /**
     * Get the entire comments array.
     * May return an empty array if the bitstream does not support comments.
     *
     * @access  public
     * @return  array
     */
    function getComments() {
        return $this->_comments;
    }

    /**
     * Vendor of software used to encode this stream.
     *
     * Gives the vendor string for the software used to encode this stream.
     * It is common to find libVorbis here.  The majority of encoders appear
     * to use libvorbis from Xiph.org.
     *
     * @access  public
     * @return  string
     */
    function getVendor()
    {
        return ($this->_vendor);
    }

    /**
     * Get an associative array containing header information about the stream
     * @access  public
     * @return  array
     */
    function getHeader() 
    {
        return array();
    }

    /**
     * Get the length of the stream in seconds
     * @return float
     */
    function getLength()
    {
        return $this->_streamLength;
    }
    /**
     * Get the start offset of the stream in seconds
     *
     * @return float
     */
    function getStartOffset(){
    	return $this->_startOffset;
    }
}
