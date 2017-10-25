<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------------+
// | File_Ogg PEAR Package for Accessing Ogg Bitstreams                         |
// | Copyright (c) 2013                                                    |
// | Jan Gerber <jgerber@wikimedia.org>                                     |
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

define( 'OGG_OPUS_COMMENTS_PAGE_OFFSET', 1 );

/**
 * @author      Jan Gerber <jgerber@wikimedia.org>
 * @category    File
 * @copyright   Jan Gerber <jgerber@wikimedia.org>
 * @license     http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link        http://pear.php.net/package/File_Ogg
 * @link        http://www.opus-codec.org/
 * @package     File_Ogg
 * @version     1
 */
class File_Ogg_Opus extends File_Ogg_Media
{
    /**
     * @access  private
     */
    function __construct($streamSerial, $streamData, $filePointer)
    {
        parent::__construct($streamSerial, $streamData, $filePointer);
        $this->_decodeHeader();
        $this->_decodeCommentsHeader();

        $endSec =  $this->getSecondsFromGranulePos( $this->_lastGranulePos );
        $startSec = $this->getSecondsFromGranulePos( $this->_firstGranulePos );

        if( $startSec > 1){
            $this->_streamLength = $endSec - $startSec;
            $this->_startOffset = $startSec;
        }else{
            $this->_streamLength = $endSec;
        }
        $this->_avgBitrate = $this->_streamLength ? ($this->_streamSize * 8) / $this->_streamLength : 0;
    }

    function getSecondsFromGranulePos( $granulePos ){
        return (intval(substr( $granulePos, 0, 8 ), 16 ) * pow(2, 32)
            + intval(substr( $granulePos, 8, 8 ), 16 )
            - $this->_header['pre_skip'])
            / 48000;
    }

    /**
     * Get a short string describing the type of the stream
     * @return string
     */
    function getType()
    {
        return 'Opus';
    }

    /**
     * Decode the stream header
     * @access  private
     */
    function _decodeHeader()
    {
        fseek($this->_filePointer, $this->_streamData['pages'][0]['body_offset'], SEEK_SET);
        // The first 8 characters should be "OpusHead".
        if (fread($this->_filePointer, 8) != 'OpusHead')
            throw new OggException("Stream is undecodable due to a malformed header.", OGG_ERROR_UNDECODABLE);

        $this->_header = File_Ogg::_readLittleEndian($this->_filePointer, array(
            'opus_version'          => 8,
            'nb_channels'           => 8,
            'pre_skip'              => 16,
            'audio_sample_rate'     => 32,
            'output_gain'           => 16,
            'channel_mapping_family'=> 8,
        ));
        $this->_channels = $this->_header['nb_channels'];
    }

    /**
     * Get an associative array containing header information about the stream
     * @access  public
     * @return  array
     */
    function getHeader() {
        return $this->_header;
    }

    function getSampleRate()
    {
        //Opus always outputs 48kHz, the header only lists
        //the samplerate of the source as reference
        return 48000;
    }

    /**
     * Decode the comments header
     * @access private
     */
    function _decodeCommentsHeader()
    {
        $id = 'OpusTags';
        $this->_decodeCommonHeader(false, OGG_OPUS_COMMENTS_PAGE_OFFSET);
        if(fread($this->_filePointer, strlen($id)) !== $id)
            throw new OggException("Stream is undecodable due to a malformed header.", OGG_ERROR_UNDECODABLE);
        $this->_decodeBareCommentsHeader();
    }
}
?>
