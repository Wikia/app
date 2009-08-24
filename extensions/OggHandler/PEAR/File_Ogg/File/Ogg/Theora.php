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

define( 'OGG_THEORA_IDENTIFICATION_HEADER', 0x80 );
define( 'OGG_THEORA_COMMENTS_HEADER', 0x81 );
define( 'OGG_THEORA_IDENTIFICATION_PAGE_OFFSET', 0 );
define( 'OGG_THEORA_COMMENTS_PAGE_OFFSET', 1 );


/**
 * @author      David Grant <david@grant.org.uk>, Tim Starling <tstarling@wikimedia.org>
 * @category    File
 * @copyright   David Grant <david@grant.org.uk>, Tim Starling <tstarling@wikimedia.org>
 * @license     http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link        http://pear.php.net/package/File_Ogg
 * @link        http://www.xiph.org/theora/
 * @package     File_Ogg
 * @version     CVS: $Id: Theora.php,v 1.9 2005/11/16 20:43:27 djg Exp $
 */
class File_Ogg_Theora extends File_Ogg_Media
{
    /**
     * @access  private
     */
    function File_Ogg_Theora($streamSerial, $streamData, $filePointer)
    {
        File_Ogg_Media::File_Ogg_Media($streamSerial, $streamData, $filePointer);
        $this->_decodeIdentificationHeader();
        $this->_decodeCommentsHeader();
      	$endSec = $this->getSecondsFromGranulePos( $this->_lastGranulePos );
      	   
        $startSec =  $this->getSecondsFromGranulePos( $this->_firstGranulePos );
        
        //make sure the offset is worth taking into account oggz_chop related hack
	    if( $startSec > 1)
            $this->_streamLength = $endSec - $startSec;
        else
            $this->_streamLength = $endSec;
        				
        /*print "last gran: $this->_lastGranulePos  =  $endSec \n
first gran: $this->_firstGranulePos  = $startSec \n
stream len: $this->_streamLength;";*/

        $this->_avgBitrate = $this->_streamLength ? ($this->_streamSize * 8) / $this->_streamLength : 0;
    }
	function getSecondsFromGranulePos($granulePos){
		// Calculate GranulePos seconds
        // First make some "numeric strings"
        // These might not fit into PHP's integer type, but they will fit into 
        // the 53-bit mantissa of a double-precision number
        $topWord = floatval( base_convert( substr( $granulePos, 0, 8 ), 16, 10 ) );
        $bottomWord = floatval( base_convert( substr( $granulePos, 8, 8 ), 16, 10 ) );
        // Calculate the keyframe position by shifting right by KFGSHIFT
        // We don't use PHP's shift operators because they're terribly broken
        // This is made slightly simpler by the fact that KFGSHIFT < 32
        $keyFramePos = $topWord / pow(2, $this->_kfgShift - 32) + 
            floor( $bottomWord / pow(2, $this->_kfgShift) );
        // Calculate the frame offset by masking off the top 64-KFGSHIFT bits
        // This requires a bit of floating point trickery
        $offset = fmod( $bottomWord, pow(2, $this->_kfgShift) );
        // They didn't teach you that one at school did they?
        // Now put it together with the frame rate to calculate time in seconds
       	return  ( $keyFramePos + $offset ) / $this->_frameRate;        
	}
    /**
     * Get the 6-byte identification string expected in the common header
     */
    function getIdentificationString()
    {
        return OGG_STREAM_CAPTURE_THEORA;
    }

    /**
     * Parse the identification header in a Theora stream.
     * @access  private
     */
    function _decodeIdentificationHeader()
    {
        $this->_decodeCommonHeader(OGG_THEORA_IDENTIFICATION_HEADER, OGG_THEORA_IDENTIFICATION_PAGE_OFFSET);
        $h = File_Ogg::_readBigEndian( $this->_filePointer, array(
            'VMAJ' => 8,
            'VMIN' => 8,
            'VREV' => 8,
            'FMBW' => 16,
            'FMBH' => 16,
            'PICW' => 24,
            'PICH' => 24,
            'PICX' => 8,
            'PICY' => 8,
            'FRN'  => 32,
            'FRD'  => 32,
            'PARN' => 24,
            'PARD' => 24,
            'CS'   => 8,
            'NOMBR' => 24,
            'QUAL' => 6,
            'KFGSHIFT' => 5,
            'PF' => 2));
        if ( !$h ) {
            throw new PEAR_Exception("Stream is undecodable due to a truncated header.", OGG_ERROR_UNDECODABLE);
        }

        // Theora version
        // Seems overly strict but this is what the spec says
        // VREV is for backwards-compatible changes, apparently
        if ( $h['VMAJ'] != 3 || $h['VMIN'] != 2 ) {
            throw new PEAR_Exception("Stream is undecodable due to an invalid theora version.", OGG_ERROR_UNDECODABLE);
        }
        $this->_theoraVersion = "{$h['VMAJ']}.{$h['VMIN']}.{$h['VREV']}";

        // Frame height/width
        if ( !$h['FMBW'] || !$h['FMBH'] ) {
            throw new PEAR_Exception("Stream is undecodable because it has frame size of zero.", OGG_ERROR_UNDECODABLE);
        }
        $this->_frameWidth = $h['FMBW'] * 16;
        $this->_frameHeight = $h['FMBH'] * 16;
        
        // Picture height/width
        if ( $h['PICW'] > $this->_frameWidth || $h['PICH'] > $this->_frameHeight ) {
            throw new PEAR_Exception("Stream is undecodable because the picture width is greater than the frame width.", OGG_ERROR_UNDECODABLE);
        }
        $this->_pictureWidth = $h['PICW'];
        $this->_pictureHeight = $h['PICH'];

        // Picture offset
        $this->_offsetX = $h['PICX'];
        $this->_offsetY = $h['PICY'];
        // Frame rate
        $this->_frameRate = $h['FRD'] == 0 ? 0 : $h['FRN'] / $h['FRD'];
        // Physical aspect ratio
        if ( !$h['PARN'] || !$h['PARD'] ) {
            $this->_physicalAspectRatio = 1;
        } else {
            $this->_physicalAspectRatio = $h['PARN'] / $h['PARD'];
        }

        // Color space
        $colorSpaces = array(
            0 => 'Undefined',
            1 => 'Rec. 470M',
            2 => 'Rec. 470BG',
        );
        if ( isset( $colorSpaces[$h['CS']] ) ) {
            $this->_colorSpace = $colorSpaces[$h['CS']];
        } else {
            $this->_colorSpace = 'Unknown (reserved)';
        }

        $this->_nomBitrate = $h['NOMBR'];

        $this->_quality = $h['QUAL'];
        $this->_kfgShift = $h['KFGSHIFT'];
        
        $pixelFormats = array(
            0 => '4:2:0',
            1 => 'Unknown (reserved)',
            2 => '4:2:2',
            3 => '4:4:4',
        );
        $this->_pixelFormat = $pixelFormats[$h['PF']];

        switch ( $h['PF'] ) {
            case 0: 
                $h['NSBS'] = 
                    floor( ($h['FMBW'] + 1) / 2 ) * 
                    floor( ($h['FMBH'] + 1) / 2 ) + 2 * 
                    floor( ($h['FMBW'] + 3) / 4 ) * 
                    floor( ($h['FMBH'] + 3) / 4 );
                $h['NBS'] = 6 * $h['FMBW'] * $h['FMBH'];
                break;
            case 2:
                $h['NSBS'] = 
                    floor( ($h['FMBW'] + 1) / 2 ) * 
                    floor( ($h['FMBH'] + 1) / 2 ) + 2 * 
                    floor( ($h['FMBW'] + 3) / 4 ) * 
                    floor( ($h['FMBH'] + 1) / 2 );
                $h['NBS'] = 8 * $h['FMBW'] * $h['FMBH'];
                break;
            case 3:
                $h['NSBS'] = 
                    3 * floor( ($h['FMBW'] + 1) / 2 ) * 
                        floor( ($h['FMBH'] + 1) / 2 );
                $h['NBS'] = 12 * $h['FMBW'] * $h['FMBH'];
                break;
            default:
                $h['NSBS'] = $h['NBS'] = 0;
        }
        $h['NMBS'] = $h['FMBW'] * $h['FMBH'];

        $this->_idHeader = $h;
    }

    /**
     * Get an associative array containing header information about the stream
     * @access  public
     * @return  array
     */
    function getHeader() {
        return $this->_idHeader;
    }

    /**
     * Get a short string describing the type of the stream
     * @return string
     */
    function getType() {
        return 'Theora';
    }

    /**
     * Decode the comments header
     * @access private
     */
    function _decodeCommentsHeader()
    {
        $this->_decodeCommonHeader(OGG_THEORA_COMMENTS_HEADER, OGG_THEORA_COMMENTS_PAGE_OFFSET);
        $this->_decodeBareCommentsHeader();
    }

}
?>
