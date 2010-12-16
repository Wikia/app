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
 * @link        http://flac.sourceforge.net/documentation.html
 * @package     File_Ogg
 * @version     CVS: $Id: Flac.php,v 1.9 2005/11/16 20:43:27 djg Exp $
 */
class File_Ogg_Flac extends File_Ogg_Media
{
    /**
     * @access  private
     */
	function __construct($streamSerial, $streamData, $filePointer)
    {
        parent::__construct($streamSerial, $streamData, $filePointer);
        $this->_decodeHeader();
        $this->_decodeCommentsHeader();
        $this->_streamLength    = $this->_streamInfo['total_samples']
            / $this->_streamInfo['sample_rate'];
    }

    /**
     * Get a short string describing the type of the stream
     * @return string
     */
    function getType() {
        return 'FLAC';
    }

    /**
     * @access  private
     * @param   int     $packetType
     * @param   int     $pageOffset
     */
    function _decodeHeader()
    {
        fseek($this->_filePointer, $this->_streamData['pages'][0]['body_offset'], SEEK_SET);
        // Check if this is the correct header.
        $packet = unpack("Cdata", fread($this->_filePointer, 1));
        if ($packet['data'] != 0x7f)
            throw new PEAR_Exception("Stream Undecodable", OGG_ERROR_UNDECODABLE);
    
        // The following four characters should be "FLAC".
        if (fread($this->_filePointer, 4) != 'FLAC')
            throw new PEAR_Exception("Stream is undecodable due to a malformed header.", OGG_ERROR_UNDECODABLE);

        $version = unpack("Cmajor/Cminor", fread($this->_filePointer, 2));
        $this->_version = "{$version['major']}.{$version['minor']}";
        if ($version['major'] > 1) {
            throw new PEAR_Exception("Cannot decode a version {$version['major']} FLAC stream", OGG_ERROR_UNDECODABLE);
        }
        $h = File_Ogg::_readBigEndian( $this->_filePointer, 
            array(
                // Ogg-specific
                'num_headers'       => 16,
                'flac_native_sig'   => 32,
                // METADATA_BLOCK_HEADER
                'is_last'           => 1,
                'type'              => 7,
                'length'            => 24,
            ));

        // METADATA_BLOCK_STREAMINFO
        // The variable names are canonical, and come from the FLAC source (format.h)
        $this->_streamInfo = File_Ogg::_readBigEndian( $this->_filePointer,
            array(
                'min_blocksize'     => 16,
                'max_blocksize'     => 16,
                'min_framesize'     => 24,
                'max_framesize'     => 24,
                'sample_rate'       => 20,
                'channels'          => 3,
                'bits_per_sample'   => 5,
                'total_samples'     => 36,
           ));
        $this->_streamInfo['md5sum'] = bin2hex(fread($this->_filePointer, 16));
    }

    /**
     * Get an associative array containing header information about the stream
     * @access  public
     * @return  array
     */
    function getHeader()
    {
        return $this->_streamInfo;
    }

    function _decodeCommentsHeader()
    {
        fseek($this->_filePointer, $this->_streamData['pages'][1]['body_offset'], SEEK_SET);
        $blockHeader = File_Ogg::_readBigEndian( $this->_filePointer,
            array(
                'last_block' => 1,
                'block_type' => 7,
                'length' => 24
            )
        );
        if ($blockHeader['block_type'] != 4) {
            throw new PEAR_Exception("Stream Undecodable", OGG_ERROR_UNDECODABLE);
        }
        
        $this->_decodeBareCommentsHeader();
    }
}
?>
