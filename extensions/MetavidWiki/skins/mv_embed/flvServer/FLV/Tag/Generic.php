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

class FLV_Tag_Generic {
    public $type;
    public $size;
    public $timestamp;
    public $streamId;

    public $body;

    function __construct( $hdr )
    {
        $p = 0;
        $this->type = ord( $hdr[$p++] );

        $this->size =       ( ord( $hdr[$p++] ) << 16 ) +
                            ( ord( $hdr[$p++] ) << 8 ) +
                            ( ord( $hdr[$p++] ) );

        $this->timestamp =  ( ord( $hdr[$p++] ) << 16 ) +
                            ( ord( $hdr[$p++] ) << 8 ) +
                            ( ord( $hdr[$p++] ) ) +
                            ( ord( $hdr[$p++] ) << 24 );

        $this->streamId =   ( ord( $hdr[$p++] ) << 16 ) +
                            ( ord( $hdr[$p++] ) << 8 ) +
                            ( ord( $hdr[$p++] ) );
    }

    function setBody( $body )
    {
        $this->body = $body;
    }

    function analyze()
    {
        // nothing to do for a generic tag
    }
}
