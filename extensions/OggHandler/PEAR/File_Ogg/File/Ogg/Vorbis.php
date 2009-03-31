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
 * Check number for the first header in a Vorbis stream.
 * 
 * @access  private
 */
define("OGG_VORBIS_IDENTIFICATION_HEADER",  1);
/**
 * Check number for the second header in a Vorbis stream.
 * 
 * @access  private
 */
define("OGG_VORBIS_COMMENTS_HEADER",        3);
/**
 * Check number for the third header in a Vorbis stream.
 * 
 * @access  private
 */
define("OGG_VORBIS_SETUP_HEADER",           5);
/**
 * Error thrown if the stream appears to be corrupted.
 * 
 * @access  private
 */
define("OGG_VORBIS_ERROR_UNDECODABLE",      OGG_ERROR_UNDECODABLE);
/**
 * Error thrown if the user attempts to extract a comment using a comment key
 * that does not exist.
 * 
 * @access  private
 */
define("OGG_VORBIS_ERROR_INVALID_COMMENT",  2);

define("OGG_VORBIS_IDENTIFICATION_PAGE_OFFSET", 0);
define("OGG_VORBIS_COMMENTS_PAGE_OFFSET",       1);

/**
 * Error thrown if the user attempts to write a comment containing an illegal
 * character
 * 
 * @access  private
 */
define("OGG_VORBIS_ERROR_ILLEGAL_COMMENT",  3);

/**
 * Extract the contents of a Vorbis logical stream.
 *
 * This class provides an interface to a Vorbis logical stream found within
 * a Ogg stream.  A variety of information may be extracted, including comment
 * tags, running time, and bitrate.  For more information, please see the following
 * links.
 *
 * @author      David Grant <david@grant.org.uk>, Tim Starling <tstarling@wikimedia.org>
 * @category    File
 * @copyright   David Grant <david@grant.org.uk>, Tim Starling <tstarling@wikimedia.org>
 * @license     http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link        http://pear.php.net/package/File_Ogg
 * @link        http://www.xiph.org/vorbis/doc/
 * @package     File_Ogg
 * @version     CVS: $Id: Vorbis.php,v 1.13 2005/11/19 09:06:32 djg Exp $
 */
class File_Ogg_Vorbis extends File_Ogg_Media
{

    /**
     * Version of vorbis specification used.
     *
     * @access  private
     * @var     int
     */
    var $_version;

    /**
     * Number of channels in the vorbis stream.
     *
     * @access  private
     * @var     int
     */
    var $_channels;

    /**
     * Number of samples per second in the vorbis stream.
     *
     * @access  private
     * @var     int
     */
    var $_sampleRate;

    /**
     * Minimum bitrate for the vorbis stream.
     *
     * @access  private
     * @var     int
     */
    var $_minBitrate;

    /**
     * Maximum bitrate for the vorbis stream.
     *
     * @access  private
     * @var     int
     */
    var $_maxBitrate;

    /**
     * Nominal bitrate for the vorbis stream.
     *
     * @access  private
     * @var     int
     */
    var $_nomBitrate;

    /**
     * Average bitrate for the vorbis stream.
     *
     * @access  private
     * @var     float
     */
    var $_avgBitrate;

    /**
     * The length of this stream in seconds.
     *
     * @access  private
     * @var     int
     */
    var $_streamLength;
    

    /**
     * Constructor for accessing a Vorbis logical stream.
     *
     * This method is the constructor for the native-PHP interface to a Vorbis logical
     * stream, embedded within an Ogg physical stream.
     *
     * @param   int     $streamSerial   Serial number of the logical stream.
     * @param   array   $streamData     Data for the requested logical stream.
     * @param   string  $filePath       Location of a file on the filesystem.
     * @param   pointer $filePointer    File pointer for the current physical stream.
     * @access  private
     */
    function File_Ogg_Vorbis($streamSerial, $streamData, $filePointer)
    {
        File_Ogg_Bitstream::File_Ogg_Bitstream($streamSerial, $streamData, $filePointer);
        $this->_decodeIdentificationHeader();
        $this->_decodeCommentsHeader(OGG_VORBIS_COMMENTS_HEADER, OGG_VORBIS_COMMENTS_PAGE_OFFSET);
        $endSec = (( '0x' . substr( $this->_lastGranulePos, 0, 8 ) ) * pow(2, 32) 
            + ( '0x' . substr( $this->_lastGranulePos, 8, 8 ) ))
            / $this->_idHeader['audio_sample_rate'];
            
			
	    $startSec =  (( '0x' . substr( $this->_firstGranulePos, 0, 8 ) ) * pow(2, 32) 
            + ( '0x' . substr( $this->_firstGranulePos, 8, 8 ) ))
            / $this->_idHeader['audio_sample_rate'];  
            
        $this->_streamLength  = $stream_endLength - $stream_startLength;	   
             
		//make sure the offset is worth taking into account oggz_chop related hack
	    if( $startSec > 1)
            $this->_streamLength = $endSec - $startSec;
        else
            $this->_streamLength = $endSec;
            
        $this->_avgBitrate      = $this->_streamLength ? ($this->_streamSize * 8) / $this->_streamLength : 0;
    }

    /**
     * Get a short string describing the type of the stream
     */
    function getType() 
    {
        return 'Vorbis'; 
    }

    /**
     * Parse the identification header (the first of three headers) in a Vorbis stream.
     *
     * This function parses the identification header.  The identification header
     * contains simple audio characteristics, such as sample rate and number of
     * channels.  There are a number of error-checking provisions laid down in the Vorbis
     * specification to ensure the stream is pure.
     *
     * @access  private
     */
    function _decodeIdentificationHeader()
    {
        $this->_decodeCommonHeader(OGG_VORBIS_IDENTIFICATION_HEADER, OGG_VORBIS_IDENTIFICATION_PAGE_OFFSET);

        $h = File_Ogg::_readLittleEndian($this->_filePointer, array(
            'vorbis_version'        => 32,
            'audio_channels'        => 8,
            'audio_sample_rate'     => 32,
            'bitrate_maximum'       => 32,
            'bitrate_nominal'       => 32,
            'bitrate_minimum'       => 32,
            'blocksize_0'           => 4,
            'blocksize_1'           => 4,
            'framing_flag'          => 1
        ));

        // The Vorbis stream version must be 0.
        if ($h['vorbis_version'] == 0)
            $this->_version = $h['vorbis_version'];
        else
            throw new PEAR_Exception("Stream is undecodable due to an invalid vorbis stream version.", OGG_VORBIS_ERROR_UNDECODABLE);
    
        // The number of channels MUST be greater than 0.
        if ($h['audio_channels'] == 0)
            throw new PEAR_Exception("Stream is undecodable due to zero channels.", OGG_VORBIS_ERROR_UNDECODABLE);
        else
            $this->_channels = $h['audio_channels'];
    
        // The sample rate MUST be greater than 0.
        if ($h['audio_sample_rate'] == 0)
            throw new PEAR_Exception("Stream is undecodable due to a zero sample rate.", OGG_VORBIS_ERROR_UNDECODABLE);
        else
            $this->_sampleRate = $h['audio_sample_rate'];
    
        // Extract the various bitrates
        $this->_maxBitrate  = $h['bitrate_maximum'];
        $this->_nomBitrate  = $h['bitrate_nominal'];
        $this->_minBitrate  = $h['bitrate_minimum'];
    
        // Powers of two between 6 and 13 inclusive.
        $valid_block_sizes = array(64, 128, 256, 512, 1024, 2048, 4096, 8192);
    
        // blocksize_0 MUST be a valid blocksize.
        $blocksize_0 = pow(2, $h['blocksize_0']);
        if (FALSE == in_array($blocksize_0, $valid_block_sizes))
            throw new PEAR_Exception("Stream is undecodable because blocksize_0 is $blocksize_0, which is not a valid size.", OGG_VORBIS_ERROR_UNDECODABLE);
    
        // Extract bits 5 to 8 from the character data.
        // blocksize_1 MUST be a valid blocksize.
        $blocksize_1 = pow(2, $h['blocksize_1']);
        if (FALSE == in_array($blocksize_1, $valid_block_sizes))
            throw new PEAR_Exception("Stream is undecodable because blocksize_1 is not a valid size.", OGG_VORBIS_ERROR_UNDECODABLE);
    
        // blocksize 0 MUST be less than or equal to blocksize 1.
        if ($blocksize_0 > $blocksize_1)
            throw new PEAR_Exception("Stream is undecodable because blocksize_0 is not less than or equal to blocksize_1.", OGG_VORBIS_ERROR_UNDECODABLE);
    
        // The framing bit MUST be set to mark the end of the identification header.
        // Some encoders are broken though -- TS
        /*
        if ($h['framing_flag'] == 0)
            throw new PEAR_Exception("Stream in undecodable because the framing bit is not non-zero.", OGG_VORBIS_ERROR_UNDECODABLE);
         */

        $this->_idHeader = $h;
    }

    /**
     * Decode the comments header
     * @access  private
     * @param   int     $packetType
     * @param   int     $pageOffset
     */
    function _decodeCommentsHeader($packetType, $pageOffset)
    {
        $this->_decodeCommonHeader($packetType, $pageOffset);
        $this->_decodeBareCommentsHeader();
        // The framing bit MUST be set to mark the end of the comments header.
        $framing_bit = unpack("Cdata", fread($this->_filePointer, 1));
        if ($framing_bit['data'] != 1)
            throw new PEAR_Exception("Stream Undecodable", OGG_VORBIS_ERROR_UNDECODABLE);
    }

    /**
     * Get the 6-byte identification string expected in the common header
     */
    function getIdentificationString() {
        return OGG_STREAM_CAPTURE_VORBIS;
    }
    
    /**
     * Version of the Vorbis specification referred to in the encoding of this stream.
     *
     * This method returns the version of the Vorbis specification (currently 0 (ZERO))
     * referred to by the encoder of this stream.  The Vorbis specification is well-
     * defined, and thus one does not expect this value to change on a frequent basis.
     *
     * @access  public
     * @return  int
     */
    function getEncoderVersion()
    {
        return ($this->_version);
    }

    /**
     * Number of channels used in this stream
     *
     * This function returns the number of channels used in this stream.  This
     * can range from 1 to 255, but will likely be 2 (stereo) or 1 (mono).
     *
     * @access  public
     * @return  int
     * @see     File_Ogg_Vorbis::isMono()
     * @see     File_Ogg_Vorbis::isStereo()
     * @see     File_Ogg_Vorbis::isQuadrophonic()
     */
    function getChannels()
    {
        return ($this->_channels);
    }

    /**
     * Samples per second.
     *
     * This function returns the number of samples used per second in this
     * recording.  Probably the most common value here is 44,100.
     *
     * @return  int
     * @access  public
     */
    function getSampleRate()
    {
        return ($this->_sampleRate);
    }

    /**
     * Various bitrate measurements
     *
     * Gives an array of the values of four different types of bitrates for this
     * stream. The nominal, maximum and minimum values are found within the file,
     * whereas the average value is computed.
     *
     * @access  public
     * @return  array
     */
    function getBitrates()
    {
        return (array("nom" => $this->_nomBitrate, "max" => $this->_maxBitrate, "min" => $this->_minBitrate, "avg" => $this->_avgBitrate));
    }

    /**
     * Gives the most accurate bitrate measurement from this stream.
     *
     * This function returns the most accurate bitrate measurement for this
     * recording, depending on values set in the stream header.
     *
     * @access  public
     * @return  float
     */
    function getBitrate()
    {
        if ($this->_avgBitrate != 0)
            return ($this->_avgBitrate);
        elseif ($this->_nomBitrate != 0)
            return ($this->_nomBitrate);
        else
            return (($this->_minBitrate + $this->_maxBitrate) / 2);
    }

    /**
     * Gives the length (in seconds) of this stream.
     *
     * @access  public
     * @return  int
     */
    function getLength()
    {
        return ($this->_streamLength);
    }
    
    /**
     * States whether this logical stream was encoded in mono.
     *
     * @access  public
     * @return  boolean
     */
    function isMono()
    {
        return ($this->_channels == 1);
    }
    
    /**
     * States whether this logical stream was encoded in stereo.
     *
     * @access  public
     * @return  boolean
     */
    function isStereo()
    {
        return ($this->_channels == 2);
    }
    
    /**
     * States whether this logical stream was encoded in quadrophonic sound.
     *
     * @access  public
     * @return  boolean
     */
    function isQuadrophonic()
    {
        return ($this->_channels == 4);
    }
    
    /**
     * The title of this track, e.g. "What's Up Pussycat?".
     *
     * @access  public
     * @return  string
     */
    function getTitle()
    {
        return ($this->getField("TITLE"));
    }
    
    /**
     * Set the title of this track.
     *
     * @access  public
     * @param   string  $title
     * @param   boolean $replace
     */
    function setTitle($title, $replace = true)
    {
        $this->setField("TITLE", $title, $replace);
    }
    
    /**
     * The version of the track, such as a remix.
     *
     * @access  public
     * @return  string
     */
    function getVersion()
    {
        return $this->getField("VERSION");
    }
    
    /**
     * Set the version of this track.
     *
     * @access  public
     * @param   string  $version
     * @param   boolean $replace
     */
    function setVersion($version, $replace = true)
    {
        $this->setField("VERSION", $version, $replace);
    }
    
    /**
     * The album or collection from which this track comes.
     *
     * @access  public
     * @return  string
     */
    function getAlbum()
    {
        return ($this->getField("ALBUM"));
    }
    
    /**
     * Set the album or collection for this track.
     *
     * @access  public
     * @param   string  $album
     * @param   boolean $replace
     */
    function setAlbum($album, $replace = true)
    {
        $this->setField("ALBUM", $album, $replace);
    }
    
    /**
     * The number of this track if it is part of a larger collection.
     *
     * @access  public
     * @return  string
     */
    function getTrackNumber()
    {
        return ($this->getField("TRACKNUMBER"));
    }
    
    /**
     * Set the number of this relative to the collection.
     *
     * @access  public
     * @param   int     $number
     * @param   boolean $replace
     */
    function setTrackNumber($number, $replace = true)
    {
        $this->setField("TRACKNUMBER", $number, $replace);
    }
    
    /**
     * The artist responsible for this track.
     *
     * This function returns the name of the artist responsible for this
     * recording, which may be either a solo-artist, duet or group.
     *
     * @access  public
     * @return  string
     */
    function getArtist()
    {
        return ($this->getField("ARTIST"));
    }
    
    /**
     * Set the artist of this track.
     *
     * @access  public
     * @param   string  $artist
     * @param   boolean $replace
     */
    function setArtist($artist, $replace = true)
    {
        $this->setField("ARTIST", $artist, $replace = true);
    }
    
    /**
     * The performer of this track, such as an orchestra
     *
     * @access  public
     * @return  string
     */
    function getPerformer()
    {
        return ($this->getField("PERFORMER"));
    }
    
    /**
     * Set the performer of this track.
     *
     * @access  public
     * @param   string  $performer
     * @param   boolean $replace
     */
    function setPerformer($performer, $replace = true)
    {
        $this->setField("PERFORMER", $performer, $replace);
    }
    
    /**
     * The copyright attribution for this track.
     *
     * @access  public
     * @return  string
     */
    function getCopyright()
    {
        return ($this->getField("COPYRIGHT"));
    }
    
    /**
     * Set the copyright attribution for this track.
     *
     * @access  public
     * @param   string  $copyright
     * @param   boolean $replace
     */
    function setCopyright($copyright, $replace = true)
    {
        $this->setField("COPYRIGHT", $copyright, $replace);
    }
    
    /**
     * The rights of distribution for this track.
     *
     * This funtion returns the license for this track, and may include
     * copyright information, or a creative commons statement.
     *
     * @access  public
     * @return  string
     */
    function getLicense()
    {
        return ($this->getField("LICENSE"));
    }
    
    /**
     * Set the distribution rights for this track.
     *
     * @access  public
     * @param   string  $license
     * @param   boolean $replace
     */
    function setLicense($license, $replace = true)
    {
        $this->setField("LICENSE", $license, $replace);
    }
    
    /**
     * The organisation responsible for this track.
     *
     * This function returns the name of the organisation responsible for 
     * the production of this track, such as the record label.
     *
     * @access  public
     * @return  string
     */
    function getOrganization()
    {
        return ($this->getField("ORGANIZATION"));
    }
    
    /**
     * Set the organisation responsible for this track.
     *
     * @access  public
     * @param   string  $organization
     * @param   boolean $replace
     */
    function setOrganziation($organization, $replace = true)
    {
        $this->setField("ORGANIZATION", $organization, $replace);
    }
    
    /**
     * A short description of the contents of this track.
     *
     * This function returns a short description of this track, which might
     * contain extra information that doesn't fit anywhere else.
     *
     * @access  public
     * @return  string
     */
    function getDescription()
    {
        return ($this->getField("DESCRIPTION"));
    }
    
    /**
     * Set the description of this track.
     *
     * @access  public
     * @param   string  $description
     * @param   boolean $replace
     */
    function setDescription($description, $replace = true)
    {
        $this->setField("DESCRIPTION", $replace);
    }
    
    /**
     * The genre of this recording (e.g. Rock)
     *
     * This function returns the genre of this recording.  There are no pre-
     * defined genres, so this is completely up to the tagging software.
     *
     * @access  public
     * @return  string
     */
    function getGenre()
    {
        return ($this->getField("GENRE"));
    }
    
    /**
     * Set the genre of this track.
     *
     * @access  public
     * @param   string  $genre
     * @param   boolean $replace
     */
    function setGenre($genre, $replace = true)
    {
        $this->setField("GENRE", $genre, $replace);
    }
    
    /**
     * The date of the recording of this track.
     *
     * This function returns the date on which this recording was made.  There
     * is no specification for the format of this date.
     *
     * @access  public
     * @return  string
     */
    function getDate()
    {
        return ($this->getField("DATE"));
    }
    
    /**
     * Set the date of recording for this track.
     *
     * @access  public
     * @param   string  $date
     * @param   boolean $replace
     */
    function setDate($date, $replace = true)
    {
        $this->setField("DATE", $date, $replace);
    }
    
    /**
     * Where this recording was made.
     *
     * This function returns where this recording was made, such as a recording
     * studio, or concert venue.
     *
     * @access  public
     * @return  string
     */
    function getLocation()
    {
        return ($this->getField("LOCATION"));
    }
    
    /**
     * Set the location of the recording of this track.
     *
     * @access  public
     * @param   string  $location
     * @param   boolean $replace
     */
    function setLocation($location, $replace = true)
    {
        $this->setField("LOCATION", $location, $replace);
    }
    
    /**
     * @access  public
     * @return  string
     */
    function getContact()
    {
        return ($this->getField("CONTACT"));
    }
    
    /**
     * Set the contact information for this track.
     *
     * @access  public
     * @param   string  $contact
     * @param   boolean $replace
     */
    function setContact($contact, $replace = true)
    {
        $this->setField("CONTACT", $contact, $replace);
    }
    
    /**
     * International Standard Recording Code.
     *
     * Returns the International Standard Recording Code.  This code can be
     * validated using the Validate_ISPN package.
     *
     * @access  public
     * @return  string
     */
    function getIsrc()
    {
        return ($this->getField("ISRC"));
    }
    
    /**
     *  Set the ISRC for this track.
     *
     * @access  public
     * @param   string  $isrc
     * @param   boolean $replace
     */
    function setIsrc($isrc, $replace = true)
    {
        $this->setField("ISRC", $isrc, $replace);
    }

    /**
     * Get an associative array containing header information about the stream
     * @access  public
     * @return  array
     */
    function getHeader() {
        return $this->_idHeader;
    }
}
?>
