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


/**
 * @author      David Grant <david@grant.org.uk>, Tim Starling <tstarling@wikimedia.org>
 * @category    File
 * @copyright   David Grant <david@grant.org.uk>, Tim Starling <tstarling@wikimedia.org>
 * @license     http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link        http://pear.php.net/package/File_Ogg
 * @package     File_Ogg
 * @version     CVS: $Id: Bitstream.php,v 1.3 2005/11/08 19:36:18 djg Exp $
 */
class File_Ogg_Bitstream
{
    /**
     * The serial number of this logical stream.
     *
     * @var     int
     * @access  private
     */
    var $_streamSerial;
    /**
     * @access  private
     */
    var $_streamList;
    /**
     * @access  private
     */
    var $_filePointer;
    /**
     * The number of bits used in this stream.
     *
     * @var     int
     * @access  private
     */
    var $_streamSize;

    /**
     * The last granule position in the stream
     * @var     int
     * @access  private
     */
    var $_lastGranulePos;    

    /**
     * Constructor for a generic logical stream.
     *
     * @param   int     $streamSerial   Serial number of the logical stream.
     * @param   array   $streamData     Data for the requested logical stream.
     * @param   string  $filePath       Location of a file on the filesystem.
     * @param   pointer $filePointer    File pointer for the current physical stream.
     * @access  private
     */
    function File_Ogg_Bitstream($streamSerial, $streamData, $filePointer)
    {
        $this->_streamSerial    = $streamSerial;
        $this->_streamList      = $streamData;
        $this->_filePointer     = $filePointer;
        $this->_lastGranulePos  = 0;
        $this->_firstGranulePos = 0;
        // This gives an accuracy of approximately 99.7% to the streamsize of ogginfo.
        foreach ( $streamData as $packet ) {
            $this->_streamSize += $packet['data_length'];
            # Reject -1 as a granule pos, that means no segment finished in the packet
            if ( $packet['abs_granule_pos'] != 'ffffffffffffffff' ) {            	
				$currentPos = $packet['abs_granule_pos'];            	
                $this->_lastGranulePos = max($this->_lastGranulePos, $currentPos);
                //set the _firstGranulePos
                if( hexdec( $this->_firstGranulePos ) === 0){
                    //print "on stream: $streamSerial set first gran:". $currentPos.": ". hexdec( $currentPos ) ."\n";
                    $this->_firstGranulePos = $currentPos;
                }
            }
        }
        $this->_group = $streamData[0]['group'];
    }

    /**
     * Gives the serial number of this stream.
     *
     * The stream serial number is of fairly academic importance, as it makes little
     * difference to the end user.  The serial number is used by the Ogg physical
     * stream to distinguish between concurrent logical streams.
     *
     * @return  int
     * @access  public
     */
    function getSerial()
    {
        return ($this->_streamSerial);
    }
    
    /**
     * Gives the size (in bits) of this stream.
     *
     * This function returns the size of the Vorbis stream within the Ogg
     * physical stream.
     *
     * @return  int
     * @access  public
     */
    function getSize()
    {
        return ($this->_streamSize);
    }

    /**
     * Get the multiplexed group ID
     */
    function getGroup()
    {
        return $this->_group;
    }

}

?>
