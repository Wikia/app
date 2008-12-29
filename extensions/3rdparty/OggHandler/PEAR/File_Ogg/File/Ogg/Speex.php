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

require_once('File/Ogg/Media.php');

/**
 * @author      David Grant <david@grant.org.uk>, Tim Starling <tstarling@wikimedia.org>
 * @category    File
 * @copyright   David Grant <david@grant.org.uk>, Tim Starling <tstarling@wikimedia.org>
 * @license     http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link        http://pear.php.net/package/File_Ogg
 * @link        http://www.speex.org/docs.html
 * @package     File_Ogg
 * @version     CVS: $Id: Speex.php,v 1.10 2005/11/16 20:43:27 djg Exp $
 */
class File_Ogg_Speex extends File_Ogg_Media
{
    /**
     * @access  private
     */
    function File_Ogg_Speex($streamSerial, $streamData, $filePointer)
    {
        parent::__construct($streamSerial, $streamData, $filePointer);
        $this->_decodeHeader();
        $this->_decodeCommentsHeader();
        $endSec =
            (( '0x' . substr( $this->_lastGranulePos, 0, 8 ) ) * pow(2, 32) 
            + ( '0x' . substr( $this->_lastGranulePos, 8, 8 ) ))
            / $this->_header['rate'];
     
         $startSec	 =        
            (( '0x' . substr( $this->_firstGranulePos, 0, 8 ) ) * pow(2, 32) 
            + ( '0x' . substr( $this->_firstGranulePos, 8, 8 ) ))
            / $this->_header['rate'];
            
         //make sure the offset is worth taking into account oggz_chop related hack
	    if( $startSec > 1)
            $this->_streamLength = $endSec - $startSec;
        else
            $this->_streamLength = $endSec;
      }

    /**
     * Get a short string describing the type of the stream
     * @return string
     */
    function getType() 
    {
        return 'Speex';
    }

    /**
     * Decode the stream header
     * @access  private
     */
    function _decodeHeader()
    {
        fseek($this->_filePointer, $this->_streamList[0]['body_offset'], SEEK_SET);
        // The first 8 characters should be "Speex   ".
        if (fread($this->_filePointer, 8) != 'Speex   ')
            throw new PEAR_Exception("Stream is undecodable due to a malformed header.", OGG_ERROR_UNDECODABLE);

        $this->_version = fread($this->_filePointer, 20);
        $this->_header = File_Ogg::_readLittleEndian($this->_filePointer, array(
            'speex_version_id'      => 32,
            'header_size'           => 32,
            'rate'                  => 32,
            'mode'                  => 32,
            'mode_bitstream_version'=> 32,
            'nb_channels'           => 32,
            'bitrate'               => 32,
            'frame_size'            => 32,
            'vbr'                   => 32,
            'frames_per_packet'     => 32,
            'extra_headers'         => 32,
            'reserved1'             => 32,
            'reserved2'             => 32
        ));
        $this->_header['speex_version'] = $this->_version;
    }

    /**
     * Get an associative array containing header information about the stream
     * @access  public
     * @return  array
     */
    function getHeader() {
        return $this->_header;
    }

    /**
     * Decode the comments header
     * @access  private
     */
    function _decodeCommentsHeader()
    {
        fseek($this->_filePointer, $this->_streamList[1]['body_offset'], SEEK_SET);
        $this->_decodeBareCommentsHeader();
    }
}
?>
