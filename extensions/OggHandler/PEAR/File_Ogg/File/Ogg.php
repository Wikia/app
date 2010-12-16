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
 * @version     CVS: $Id: Ogg.php,v 1.14 2005/11/19 09:06:30 djg Exp $
 */

/**
 * @access  public
 */
define("OGG_STREAM_VORBIS",     1);
/**
 * @access  public
 */
define("OGG_STREAM_THEORA",     2);
/**
 * @access  public
 */
define("OGG_STREAM_SPEEX",      3);
/**
 * @access  public
 */
define("OGG_STREAM_FLAC",       4);

/**
 * Capture pattern to determine if a file is an Ogg physical stream.
 *
 * @access  private
 */
define("OGG_CAPTURE_PATTERN", "OggS");
/**
 * Maximum size of an Ogg stream page plus four.  This value is specified to allow
 * efficient parsing of the physical stream.  The extra four is a paranoid measure
 * to make sure a capture pattern is not split into two parts accidentally.
 *
 * @access  private
 */
define("OGG_MAXIMUM_PAGE_SIZE", 65311);
/**
 * Capture pattern for an Ogg Vorbis logical stream.
 *
 * @access  private
 */
define("OGG_STREAM_CAPTURE_VORBIS", "vorbis");
/**
 * Capture pattern for an Ogg Speex logical stream.
 * @access  private
 */
define("OGG_STREAM_CAPTURE_SPEEX",  "Speex   ");
/**
 * Capture pattern for an Ogg FLAC logical stream.
 *
 * @access  private
 */
define("OGG_STREAM_CAPTURE_FLAC",   "FLAC");
/**
 * Capture pattern for an Ogg Theora logical stream.
 *
 * @access  private
 */
define("OGG_STREAM_CAPTURE_THEORA", "theora");
/**
 * Error thrown if the file location passed is nonexistant or unreadable.
 *
 * @access  private
 */
define("OGG_ERROR_INVALID_FILE", 1);
/**
 * Error thrown if the user attempts to extract an unsupported logical stream.
 *
 * @access  private
 */
define("OGG_ERROR_UNSUPPORTED",  2);
/**
 * Error thrown if the user attempts to extract an logical stream with no
 * corresponding serial number.
 *
 * @access  private
 */
define("OGG_ERROR_BAD_SERIAL",   3);
/**
 * Error thrown if the stream appears to be corrupted.
 *
 * @access  private
 */
define("OGG_ERROR_UNDECODABLE",      4);

require_once('PEAR.php');
require_once('PEAR/Exception.php');
require_once('File/Ogg/Bitstream.php');
require_once("File/Ogg/Flac.php");
require_once("File/Ogg/Speex.php");
require_once("File/Ogg/Theora.php");
require_once("File/Ogg/Vorbis.php");


/**
 * Class for parsing a ogg bitstream.
 *
 * This class provides a means to access several types of logical bitstreams (e.g. Vorbis)
 * within a Ogg physical bitstream.
 *
 * @link    http://www.xiph.org/ogg/doc/
 * @package File_Ogg
 */
class File_Ogg
{
    /**
     * File pointer to Ogg container.
     *
     * This is the file pointer used for extracting data from the Ogg stream.  It is
     * the result of a standard fopen call.
     *
     * @var     pointer
     * @access  private
     */
    var $_filePointer;

    /**
     * The container for all logical streams.
     *
     * List of all of the unique streams in the Ogg physical stream.  The key
     * used is the unique serial number assigned to the logical stream by the
     * encoding application.
     *
     * @var     array
     * @access  private
     */
    var $_streamList = array();
    var $_streams = array();

    /**
     * Length in seconds of each stream group
     */
    var $_groupLengths = array();

    /**
     * Total length in seconds of the entire file
     */
    var $_totalLength;
    var $_startOffset = false;

    /**
     * Maximum number of pages to store detailed metadata for, per stream.
     * We can't store every page because there could be millions, causing an OOM.
     * This must be big enough so that all the codecs can get the metadata they
     * need without re-reading the file.
     */
    var $_maxPageCacheSize = 4;

    /**
     * Returns an interface to an Ogg physical stream.
     *
     * This method takes the path to a local file and examines it for a physical
     * ogg bitsream.  After instantiation, the user should query the object for
     * the logical bitstreams held within the ogg container.
     *
     * @access  public
     * @param   string  $fileLocation   The path of the file to be examined.
     */
    function __construct($fileLocation)
    {
        clearstatcache();
        if (! file_exists($fileLocation)) {
            throw new PEAR_Exception("Couldn't Open File.  Check File Path.", OGG_ERROR_INVALID_FILE);
        }

        // Open this file as a binary, and split the file into streams.
        $this->_filePointer = fopen($fileLocation, "rb");
        if (!is_resource($this->_filePointer))
            throw new PEAR_Exception("Couldn't Open File.  Check File Permissions.", OGG_ERROR_INVALID_FILE);

        // Check for a stream at the start
        $magic = fread($this->_filePointer, strlen(OGG_CAPTURE_PATTERN));
        if ($magic !== OGG_CAPTURE_PATTERN) {
            throw new PEAR_Exception("Couldn't read file: Incorrect magic number.", OGG_ERROR_UNDECODABLE);
        }
        fseek($this->_filePointer, 0, SEEK_SET);

        $this->_splitStreams();
        fclose($this->_filePointer);
    }

    /**
     * Little-endian equivalent for bin2hex
     * @static
     */
    static function _littleEndianBin2Hex( $bin ) {
        $bigEndian = bin2hex( $bin );
        // Reverse entire string
        $reversed = strrev( $bigEndian );
        // Swap nibbles back
        for ( $i = 0; $i < strlen( $bigEndian ); $i += 2 ) {
            $temp = $reversed[$i];
            $reversed[$i] = $reversed[$i+1];
            $reversed[$i+1] = $temp;
        }
        return $reversed;
    }


    /**
     * Read a binary structure from a file. An array of unsigned integers are read.
     * Large integers are upgraded to floating point on overflow.
     *
     * Format is big-endian as per Theora bit packing convention, this function
     * won't work for Vorbis.
     *
     * @param   resource    $file
     * @param   array       $fields Associative array mapping name to length in bits
     */
    static function _readBigEndian($file, $fields)
    {
        $bufferLength = ceil(array_sum($fields) / 8);
        $buffer = fread($file, $bufferLength);
        if (strlen($buffer) != $bufferLength) {
            throw new PEAR_Exception('Unexpected end of file', OGG_ERROR_UNDECODABLE);
        }
        $bytePos = 0;
        $bitPos = 0;
        $byteValue = ord($buffer[0]);
        $output = array();
        foreach ($fields as $name => $width) {
            if ($width % 8 == 0 && $bitPos == 0) {
                // Byte aligned case
                $bytes = $width / 8;
                $endBytePos = $bytePos + $bytes;
                $value = 0;
                while ($bytePos < $endBytePos) {
                    $value = ($value * 256) + ord($buffer[$bytePos]);
                    $bytePos++;
                }
                if ($bytePos < strlen($buffer)) {
                    $byteValue = ord($buffer[$bytePos]);
                }
            } else {
                // General case
                $bitsRemaining = $width;
                $value = 0;
                while ($bitsRemaining > 0) {
                    $bitsToRead = min($bitsRemaining, 8 - $bitPos);
                    $byteValue <<= $bitsToRead;
                    $overflow = ($byteValue & 0xff00) >> 8;
                    $byteValue &= $byteValue & 0xff;

                    $bitPos += $bitsToRead;
                    $bitsRemaining -= $bitsToRead;
                    $value += $overflow * pow(2, $bitsRemaining);

                    if ($bitPos >= 8) {
                        $bitPos = 0;
                        $bytePos++;
                        if ($bitsRemaining <= 0) {
                            break;
                        }
                        $byteValue = ord($buffer[$bytePos]);
                    }
                }
            }
            $output[$name] = $value;
            assert($bytePos <= $bufferLength);
        }
        return $output;
    }

    /**
     * Read a binary structure from a file. An array of unsigned integers are read.
     * Large integers are upgraded to floating point on overflow.
     *
     * Format is little-endian as per Vorbis bit packing convention.
     *
     * @param   resource    $file
     * @param   array       $fields Associative array mapping name to length in bits
     */
    static function _readLittleEndian( $file, $fields ) {
        $bufferLength = ceil(array_sum($fields) / 8);
        $buffer = fread($file, $bufferLength);
        if (strlen($buffer) != $bufferLength) {
            throw new PEAR_Exception('Unexpected end of file', OGG_ERROR_UNDECODABLE);
        }

        $bytePos = 0;
        $bitPos = 0;
        $byteValue = ord($buffer[0]) << 8;
        $output = array();
        foreach ($fields as $name => $width) {
            if ($width % 8 == 0 && $bitPos == 0) {
                // Byte aligned case
                $bytes = $width / 8;
                $value = 0;
                for ($i = 0; $i < $bytes; $i++, $bytePos++) {
                    $value += pow(256, $i) * ord($buffer[$bytePos]);
                }
                if ($bytePos < strlen($buffer)) {
                    $byteValue = ord($buffer[$bytePos]) << 8;
                }
            } else {
                // General case
                $bitsRemaining = $width;
                $value = 0;
                while ($bitsRemaining > 0) {
                    $bitsToRead = min($bitsRemaining, 8 - $bitPos);
                    $byteValue >>= $bitsToRead;
                    $overflow = ($byteValue & 0xff) >> (8 - $bitsToRead);
                    $byteValue &= 0xff00;

                    $value += $overflow * pow(2, $width - $bitsRemaining);
                    $bitPos += $bitsToRead;
                    $bitsRemaining -= $bitsToRead;

                    if ($bitPos >= 8) {
                        $bitPos = 0;
                        $bytePos++;
                        if ($bitsRemaining <= 0) {
                            break;
                        }
                        $byteValue = ord($buffer[$bytePos]) << 8;
                    }
                }
            }
            $output[$name] = $value;
            assert($bytePos <= $bufferLength);
        }
        return $output;
    }


    /**
     * @access  private
     */
    function _decodePageHeader($pageData, $pageOffset, $groupId)
    {
        // Extract the various bits and pieces found in each packet header.
        if (substr($pageData, 0, 4) != OGG_CAPTURE_PATTERN)
            return (false);

        $stream_version = unpack("C1data", substr($pageData, 4, 1));
        if ($stream_version['data'] != 0x00)
            return (false);

        $header_flag     = unpack("Cdata", substr($pageData, 5, 1));

        // Exact granule position
        $abs_granule_pos = self::_littleEndianBin2Hex( substr($pageData, 6, 8));

        // Approximate (floating point) granule position
        $pos = unpack("Va/Vb", substr($pageData, 6, 8));
        $approx_granule_pos = $pos['a'] + $pos['b'] * pow(2, 32);

        // Serial number for the current datastream.
        $stream_serial   = unpack("Vdata", substr($pageData, 14, 4));
        $page_sequence   = unpack("Vdata", substr($pageData, 18, 4));
        $checksum        = unpack("Vdata", substr($pageData, 22, 4));
        $page_segments   = unpack("Cdata", substr($pageData, 26, 1));
        $segments_total  = 0;
        for ($i = 0; $i < $page_segments['data']; ++$i) {
            $segment_length = unpack("Cdata", substr($pageData, 26 + ($i + 1), 1));
            $segments_total += $segment_length['data'];
        }
        $pageFinish = $pageOffset + 27 + $page_segments['data'] + $segments_total;
        $page = array(
            'stream_version'        => $stream_version['data'],
            'header_flag'           => $header_flag['data'],
            'abs_granule_pos'       => $abs_granule_pos,
            'approx_granule_pos'    => $approx_granule_pos,
            'checksum'              => sprintf("%u", $checksum['data']),
            'segments'              => $page_segments['data'],
            'head_offset'           => $pageOffset,
            'body_offset'           => $pageOffset + 27 + $page_segments['data'],
            'body_finish'           => $pageFinish,
            'data_length'           => $pageFinish - $pageOffset,
            'group'                 => $groupId,
        );
        if ( !isset( $this->_streamList[$stream_serial['data']] ) ) {
            $this->_streamList[$stream_serial['data']] = array(
                'pages' => array(),
                'data_length' => 0,
                'first_granule_pos' => null,
                'last_granule_pos' => null,
            );
        }
        $stream =& $this->_streamList[$stream_serial['data']];
        if ( count( $stream['pages'] ) < $this->_maxPageCacheSize ) {
            $stream['pages'][$page_sequence['data']] = $page;
        }
        $stream['last_page'] = $page;
        $stream['data_length'] += $page['data_length'];

        # Reject -1 as a granule pos, that means no segment finished in the packet
        if ( $abs_granule_pos !== 'ffffffffffffffff' ) {
            if ( $stream['first_granule_pos'] === null ) {
                $stream['first_granule_pos'] = $abs_granule_pos;
            }
            $stream['last_granule_pos'] = $abs_granule_pos;
        }

        $pageData = null;
        return $page;
    }

    /**
     *  @access         private
     */
    function _splitStreams()
    {
        // Loop through the physical stream until there are no more pages to read.
        $groupId = 0;
        $openStreams = 0;
        $this_page_offset = 0;
        while (!feof($this->_filePointer)) {
            $pageData = fread($this->_filePointer, 282);
            if (strval($pageData) === '') {
                break;
            }
            $page = $this->_decodePageHeader($pageData, $this_page_offset, $groupId);
            if ($page === false) {
                throw new PEAR_Exception("Cannot decode Ogg file: Invalid page at offset $this_page_offset", OGG_ERROR_UNDECODABLE);
            }

            // Keep track of multiplexed groups
            if ($page['header_flag'] & 2/*bos*/) {
                $openStreams++;
            } elseif ($page['header_flag'] & 4/*eos*/) {
                $openStreams--;
                if (!$openStreams) {
                    // End of group
                    $groupId++;
                }
            }
            if ($openStreams < 0) {
                throw new PEAR_Exception("Unexpected end of stream", OGG_ERROR_UNDECODABLE);
            }

            $this_page_offset = $page['body_finish'];
            fseek( $this->_filePointer, $this_page_offset, SEEK_SET );
        }
        // Loop through the streams, and find out what type of stream is available.
        $groupLengths = array();
        foreach ($this->_streamList as $stream_serial => $streamData) {
            fseek($this->_filePointer, $streamData['pages'][0]['body_offset'], SEEK_SET);
            $pattern = fread($this->_filePointer, 8);
            if (preg_match("/" . OGG_STREAM_CAPTURE_VORBIS . "/", $pattern)) {
                $this->_streamList[$stream_serial]['stream_type'] = OGG_STREAM_VORBIS;
                $stream = new File_Ogg_Vorbis($stream_serial, $streamData, $this->_filePointer);
            } elseif (preg_match("/" . OGG_STREAM_CAPTURE_SPEEX . "/", $pattern)) {
                $this->_streamList[$stream_serial]['stream_type'] = OGG_STREAM_SPEEX;
                $stream = new File_Ogg_Speex($stream_serial, $streamData, $this->_filePointer);
            } elseif (preg_match("/" . OGG_STREAM_CAPTURE_FLAC . "/", $pattern)) {
                $this->_streamList[$stream_serial]['stream_type'] = OGG_STREAM_FLAC;
                $stream = new File_Ogg_Flac($stream_serial, $streamData, $this->_filePointer);
            } elseif (preg_match("/" . OGG_STREAM_CAPTURE_THEORA . "/", $pattern)) {
                $this->_streamList[$stream_serial]['stream_type'] = OGG_STREAM_THEORA;
                $stream = new File_Ogg_Theora($stream_serial, $streamData, $this->_filePointer);
            } else {
                $streamData['stream_type'] = "unknown";
                $stream = false;
            }

            if ($stream) {
                $this->_streams[$stream_serial] = $stream;
                $group = $streamData['pages'][0]['group'];
                if (isset($groupLengths[$group])) {
                    $groupLengths[$group] = max($groupLengths[$group], $stream->getLength());
                } else {
                    $groupLengths[$group] = $stream->getLength();
                }
                //just store the startOffset for the first stream:
                if( $this->_startOffset === false ){
                	$this->_startOffset = $stream->getStartOffset();
                }

            }
        }
        $this->_groupLengths = $groupLengths;
        $this->_totalLength = array_sum( $groupLengths );
        unset($this->_streamList);
    }

    /**
     * Returns the overead percentage used by the Ogg headers.
     *
     * This function returns the percentage of the total stream size
     * used for Ogg headers.
     *
     * @return float
     */
    function getOverhead() {
        $header_size    = 0;
        $stream_size    = 0;
        foreach ($this->_streams as $serial => $stream) {
            foreach ($stream->_streamList as $offset => $stream_data) {
                $header_size += $stream_data['body_offset'] - $stream_data['head_offset'];
                $stream_size  = $stream_data['body_finish'];
            }
        }
        return sprintf("%0.2f", ($header_size / $stream_size) * 100);
    }

    /**
     * Returns the appropriate logical bitstream that corresponds to the provided serial.
     *
     * This function returns a logical bitstream contained within the Ogg physical
     * stream, corresponding to the serial used as the offset for that bitstream.
     * The returned stream may be Vorbis, Speex, FLAC or Theora, although the only
     * usable bitstream is Vorbis.
     *
     * @return File_Ogg_Bitstream
     */
    function &getStream($streamSerial)
    {
        if (! array_key_exists($streamSerial, $this->_streams))
                throw new PEAR_Exception("The stream number is invalid.", OGG_ERROR_BAD_SERIAL);

        return $this->_streams[$streamSerial];
    }

    /**
     * This function returns true if a logical bitstream of the requested type can be found.
     *
     * This function checks the contents of this ogg physical bitstream for of logical
     * bitstream corresponding to the supplied type.  If one is found, the function returns
     * true, otherwise it return false.
     *
     * @param   int     $streamType
     * @return  boolean
     */
    function hasStream($streamType)
    {
        foreach ($this->_stream as $stream) {
            if ($stream['stream_type'] == $streamType)
                return (true);
        }
        return (false);
    }

    /**
     * Returns an array of logical streams inside this physical bitstream.
     *
     * This function returns an array of logical streams found within this physical
     * bitstream.  If a filter is provided, only logical streams of the requested type
     * are returned, as an array of serial numbers.  If no filter is provided, this
     * function returns a two-dimensional array, with the stream type as the primary key,
     * and a value consisting of an array of stream serial numbers.
     *
     * @param  int      $filter
     * @return array
     */
    function listStreams($filter = null)
    {
        $streams = array();
        // Loops through the streams and assign them to an appropriate index,
        // ready for filtering the second part of this function.
        foreach ($this->_streams as $serial => $stream) {
            $stream_type = 0;
            switch (get_class($stream)) {
                case "file_ogg_flac":
                    $stream_type = OGG_STREAM_FLAC;
                    break;
                case "file_ogg_speex":
                    $stream_type = OGG_STREAM_SPEEX;
                    break;
                case "file_ogg_theora":
                    $stream_type = OGG_STREAM_THEORA;
                    break;
                case "file_ogg_vorbis":
                    $stream_type = OGG_STREAM_VORBIS;
                    break;
            }
            if (! isset($streams[$stream_type]))
                // Initialise the result list for this stream type.
                $streams[$stream_type] = array();

            $streams[$stream_type][] = $serial;
        }

        // Perform filtering.
        if (is_null($filter))
            return ($streams);
        elseif (isset($streams[$filter]))
            return ($streams[$filter]);
        else
            return array();
    }
    /**
     * getStartOffset
     *
     * @return unknown
     */
	function getStartOffset(){
		if( $this->_startOffset === false)
			return 0;
		return $this->_startOffset;
	}
    /**
     * Get the total length of the group of streams
     */
    function getLength() {
        return $this->_totalLength;
    }
}
?>
