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
 * A simple streamer class to work with bit sequences and extract integers
 *
 */
class FLV_Util_BitStreamReader {

    private $data;
    private $bits;
    private $pos;
    private $ofs;

    /**
     * Class constructor which can initilaze the stream
     *
     * @param string $data  An optional binary string
     */
    function __construct( $data = '' )
    {
        $this->setPayload( $data );
    }

    /**
     * Sets the binary stream to use
     *
     * @param string $data  The binary string
     */
    function setPayload( $data )
    {
        $this->data = $data;
        $this->pos = 0;
        $this->bits = '';
        $this->ofs = 0;
     }

    /**
     * Makes sure we have the requested number of bits in the working buffer
     *
     * @access private
     * @param int $cnt  The number of bits needed
     */
    private function fetch( $cnt )
    {
        // Either we already have the needed bits in the buffer or we rebuild it
        if ( $this->pos < $this->ofs * 8 ||
            $this->pos + $cnt > $this->ofs * 8 + strlen( $this->bits ) )
        {
            $this->bits = '';
            $this->ofs = FLOOR( $this->pos / 8 );
            for ( $i = $this->ofs; $i <= $this->ofs + CEIL( $cnt / 8 ); $i++ )
            {
                $this->bits .= str_pad( decbin( ord( $this->data[$i] ) ), 8, '0', STR_PAD_LEFT );
            }
        }
    }

    /**
     * Consume an integer from an arbitrary number of bits in the stream
     *
     * @param int $cnt  Length in bits of the integer
     */
    function getInt( $cnt )
    {
        $this->fetch( $cnt );

        $ret = bindec( substr( $this->bits, $this->pos - ( $this->ofs << 3 ), $cnt ) );
        $this->pos += $cnt;
        return $ret;
    }

    /**
     * Seeks into the bit stream in a similar way to fseek()
     *
     * @param int $cnt  Number of bits to seek
     * @param int $whence Either SEEK_SET (default), SEEK_CUR or SEEK_END
     */
    function seek( $ofs, $whence = SEEK_SET )
    {
        switch ( $whence )
        {
            case SEEK_SET:
                $this->pos = $ofs;
            break;
            case SEEK_CUR:
                $this->pos += $ofs;
            break;
            case SEEK_END:
                $this->pos = strlen( $this->data ) * 8 + $ofs;
            break;
        }

        if ( $this->pos < 0 )
            $this->pos = 0;
        elseif ( $this->pos > strlen( $this->data ) * 8 )
            $this->pos = strlen( $this->data ) * 8;
    }
}
