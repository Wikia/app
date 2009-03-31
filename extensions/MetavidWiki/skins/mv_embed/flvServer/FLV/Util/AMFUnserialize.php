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


/**
 * Unserializes an AMF stream into a PHP variable
 *
 */
class FLV_Util_AMFUnserialize {

    private $data;
    private $pos;
    private $isLittleEndian;

    /**
     * Class constructor
     *
     * @param string $payload   The AMF byte stream
     */
    function __construct( $payload = '' )
    {
        // calculate endianness of the CPU
        $this->isLittleEndian = ( pack( 's', 1 ) == pack( 'v', 1 ) );

        $this->setPayload( $payload );
    }

    /**
     * Set a new AMF byte stream to process
     *
     * @param string $payload   The AMF byte stream
     */
    function setPayload( $payload )
    {
      $this->data = $payload;
      $this->pos = 0;
    }

    /**
     * Seeks into an specified offset in the AMF byte stream. It supports
     * the same seeking modes as PHP's native fseek()
     *
     * @param int $offset   Offset in bytes
     * @param int $whence   Seeking mode: SEEK_SET, SEEK_CUR, SEEK_END
     * @return position from the start of the stream or false on failure
     */
    function seek( $offset, $whence = SEEK_SET )
    {
      switch ( $whence ) {
        case SEEK_SET:
          if ( $offset < strlen( $this->data ) && $offset >= 0 )
          {
            $this->pos = $offset;
            return $this->pos;
          }
        break;

        case SEEK_CUR:
          if ( $offset >= 0 && $this->pos + $offset < strlen( $this->data ) )
          {
            $this->pos += $offset;
            return $this->pos;
          }
        break;

        case SEEK_END:
          if ( $offset <= 0 && strlen( $this->data ) + $offset >= 0 ) {
            $this->pos = strlen( $this->data ) + $offset;
            return $this->pos;
          }
        break;
      }

      return false;
    }

    /**
     * Unserializes a boolean value
     *
     * @return true or false
     */
    function getBoolean()
    {
        return $this->data[$this->pos++] > 0;
    }

    /**
     * Unserializes an UTF string which size is already known
     *
     * @param int $size The string size in bytes
     * @return the string
     * @access private
     */
    private function getSizedString( $size )
    {
        if ( $size > 0 )
        {
            $val = substr( $this->data, $this->pos, $size );
            $this->pos += $size;
            return $val;
        } else {
            return '';
        }
    }

    /**
     * Unserializes an UTF string
     *
     * @return the string
     */
    function getString()
    {
        // get string length
        $size = ( ord( $this->data[$this->pos++] ) << 8 ) +
                ord( $this->data[$this->pos++] );

        return $this->getSizedString( $size );
    }

    /**
     * Unserializes an UTF string which can exceed the 64Kb length
     *
     * @return the string
     */
    function getLongString()
    {
        $size = ( ord( $this->data[$this->pos++] ) << 24 ) +
                ( ord( $this->data[$this->pos++] ) << 16 ) +
                ( ord( $this->data[$this->pos++] ) << 8 ) +
                ord( $this->data[$this->pos++] );

        return $this->getSizedString( $size );
    }

    /**
     * Unserializes a number (always a double)
     *
     * @return the number
     */
    function getNumber()
    {
        // read the number
        $number = substr( $this->data, $this->pos, 8 );
        $this->pos += 8;

        // reverse bytes if we are in little-endian harware
        if ( $this->isLittleEndian )
        {
          $number = strrev( $number );
        }

        $tmp = unpack( 'dnum', $number );

        return $tmp['num'];
    }

    /**
     * Unserializes a numeric array
     *
     * @return the numeric array
     */
    function getArray()
    {
        // item count
        $cnt  = ( ord( $this->data[$this->pos++] ) << 24 ) +
                ( ord( $this->data[$this->pos++] ) << 16 ) +
                ( ord( $this->data[$this->pos++] ) << 8 ) +
                ord( $this->data[$this->pos++] );

        $arr = array();
        for ( $i = 0; $i < $cnt; $i++ )
        {
          $arr[] = $this->getItem();
        }

        return $arr;
    }

    /**
     * Unserializes an Ecma compatible array, which is actually hash table
     *
     * @return the hash array
     */
    function getEcmaArray()
    {
        // skip the item count, we'll use the terminator
        $this->pos += 4;

        return $this->getObject();
    }


    /**
     * Unserializes an object as a hashed array
     *
     * @return the hash array
     */
    function getObject()
    {
        $arr = array();
        do {
            // fetch the key and cast it to a number if it's numeric
            $key = $this->getString();
            if ( is_numeric( $key ) )
                $key = (float)$key;

            // check for the end of sequence mark
            if ( ord( $this->data[$this->pos] ) == 0x09 )
            {
                $this->pos++;
                break;
            }

            $arr[$key] = $this->getItem();

        } while ( $this->pos < strlen( $this->data ) );

        return $arr;
    }

    /**
     * Unserializes a date
     *
     * @return a string with the date in ISO 8601 format
     */
    function getDate()
    {
        // 64bit unsigned int with ms since 1/Jan/1970
        $ms = $this->getNumber();

        // 16bit signed int with local time offset in minuttes from UTC
        $ofs = ( ord( $this->data[$this->pos++] ) << 8 ) + ord( $this->data[$this->pos++] );
        if ( $ofs > 720 )
          $ofs = - ( 65536 - $ofs );
        $ofs = - $ofs;

        $date = date( 'Y-m-d\TH:i:s', floor( $ms / 1000 ) ) . '.' . str_pad( $ms % 1000, 3, '0', STR_PAD_RIGHT );
        if ( $ofs > 0 )
            return $date . '+' . str_pad( floor( $ofs / 60 ), 2, '0', STR_PAD_LEFT ) . ':' . str_pad( $ofs % 60, 2, '0', STR_PAD_LEFT );
        else if ( $ofs < 0 )
            return $date . '-' . str_pad( floor( $ofs / 60 ), 2, '0', STR_PAD_LEFT ) . ':' . str_pad( $ofs % 60, 2, '0', STR_PAD_LEFT );
        else
            return $date . 'Z';
    }

    /**
     * Utility method which finds out the type of data to unserialize
     *
     * @throws FLV_UnknownAMFTypeException
     *
     * @return the unserialized variable
     */
    function getItem()
    {
        switch ( ord( $this->data[$this->pos++] ) )
        {
            case 0x00:
                return $this->getNumber();
            break;
            case 0x01:
                return $this->getBoolean();
            break;
            case 0x02:
                return $this->getString();
            break;
            case 0x03:
                return $this->getObject();
            break;
            case 0x05:
                return NULL;
            break;
            case 0x08:
                return $this->getEcmaArray();
            break;
            case 0x0A:
                return $this->getArray();
            break;
            case 0x0B: // 11 Date
                return $this->getDate();
            break;
            case 0x0C: // 12
                return $this->getLongString();
            default:
                throw( new FLV_UnknownAMFTypeException( 'Unknown AMF datatype ' . ord( $this->data[$this->pos - 1] ) ) );
        }
    }
}
