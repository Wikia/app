<?php
/*
 Copyright 2006 Iván Montes

 This file is part of FLV tools for PHP (FLV4PHP from now on).

 FLV4PHP is free software; you can redistribute it and/or modify it under the 
 terms of the GNU General Public License as published by the Free Software 
 Foundation; either version 2 of the License, or (at your option) any later 
 version.

 FLV4PHP is distributed in the hope that it will be useful, but WITHOUT ANY 
 WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
 A PARTICULAR PURPOSE. See the GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along with 
 FLV4PHP; if not, write to the Free Software Foundation, Inc., 51 Franklin 
 Street, Fifth Floor, Boston, MA 02110-1301, USA
*/

define( 'FLV_INCLUDE_PATH', dirname( __FILE__ ) . '/' );

include_once FLV_INCLUDE_PATH . 'Tag.php';
include_once FLV_INCLUDE_PATH . 'Exceptions.php';

/**
 * Parse a .flv file to extract all the 'tag' information
 *
 */
class FLV {
    /** The FLV header signature */
    const FLV_HEADER_SIGNATURE = 'FLV';
    
    /** The FLV main header size */
    const FLV_HEADER_SIZE = 9;
    
    /** The FLV tag header size */
    const TAG_HEADER_SIZE = 15;
    
    /** 
     *  Maximun number of bytes to process as tag body. This is a safety meassure against
     *  corrupted FLV files.
     */
    const MAX_TAG_BODY_SIZE = 16386;
    
    protected $fp;
    private $lastTagSize = 0;
    var $fname;
    /**
     * Opens a FLV video file to process its information
     *
     * @throws FLV_FileException, FLV_NotValidFileException
     * 
     * @param string $fname The filename to open
     * @return true on success
     */
    function open( $fname )
    {
    	$this->fname = $fname;
        $this->fp = @fopen( $fname, 'r' );
        if ( ! $this->fp )
            throw( new FLV_FileException( 'Unable to open the file' ) );
        
        $hdr = fread( $this->fp, self::FLV_HEADER_SIZE );
        
        // check file header signature
        if ( substr( $hdr, 0, 3 ) !== self::FLV_HEADER_SIGNATURE )
            throw( new FLV_NotValidFileException( 'The header signature does not match' ) );
            

        $this->version = ord( $hdr[3] );
        $this->hasVideo = (bool)( ord( $hdr[4] ) & 0x01 );
        $this->hasAudio = (bool)( ord( $hdr[4] ) & 0x04 );
        
        $this->bodyOfs =    ( ord( $hdr[5] ) << 24 ) +
                            ( ord( $hdr[6] ) << 16 ) +
                            ( ord( $hdr[7] ) << 8 ) +
                            ( ord( $hdr[8] ) );

        fseek( $this->fp, $this->bodyOfs );
        
        $this->eof = false;
        
        return true;
    }
    
    /**
     * Close a previously open FLV file
     *
     */
    function close()
    {
        fclose( $this->fp );
    }
    
    
    /**
     * Returns the next tag from the open file
     *
     * @throws FLV_CorruptedFileException
     * 
     * @param array $skipTagTypes   The tag types contained in this array won't be examined
     * @return FLV_Tag_Generic or one of its descendants
     */
    function getTag( $skipTagTypes = false )
    {
        static $cnt = 0;
        
        if ( $this->eof ) return null;

        
        $hdr = fread( $this->fp, self::TAG_HEADER_SIZE );
        if ( strlen( $hdr ) < self::TAG_HEADER_SIZE )
        {
            $this->eof = true;
            return null;
        }
        
        /*
        //DEV: Some files seem to don't store this value!
        // check against corrupted files
        $prevTagSize = unpack( 'Nprev', $hdr );     
        if ($prevTagSize['prev'] != $this->lastTagSize)
        {
            throw( 
                new FLV_CorruptedFileException(  
                    sprintf(    "Previous tag size check failed. Actual size is %d but defined size is %d",
                                $this->lastTagSize,
                                $prevTagSize['prev']
                    )
                )
            );
        }
		*/
        
        // Get the tag object by skiping the first 4 bytes which tell the previous tag size
        $tag = FLV_Tag::getTag( substr( $hdr, 4 ) );

        
        // Read at most MAX_TAG_BODY_SIZE bytes of the body
        $bytesToRead = min( self::MAX_TAG_BODY_SIZE, $tag->size );
        $tag->setBody( fread( $this->fp, $bytesToRead ) );
        
        // Check if the tag body has to be processed
        if ( is_array( $skipTagTypes ) && !in_array( $tag->type, $skipTagTypes ) )
        {
            $tag->analyze();
        }
            
        // If the tag was skipped or the body size was larger than MAX_TAG_BODY_SIZE
        if ( $tag->size > $bytesToRead )
        {
            fseek( $this->fp, $tag->size - $bytesToRead, SEEK_CUR );
        }

        $this->lastTagSize = $tag->size + self::TAG_HEADER_SIZE - 4;
            
        return $tag;
    }
    
    
    /**
     * Returns the offset from the start of the file of the last processed tag
     *
     * @return the offset
     */
    function getTagOffset()
    {
        return ftell( $this->fp ) - $this->lastTagSize;
    }
}
