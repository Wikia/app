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

include_once FLV_INCLUDE_PATH . 'Tag/Generic.php';
include_once FLV_INCLUDE_PATH . 'Util/BitStreamReader.php';

class FLV_Tag_Audio extends FLV_Tag_Generic {

    const CODEC_UNCOMPRESSED = 0x00;
    const CODEC_ADPCM = 0x01;
    const CODEC_MP3 = 0x02;
    const CODEC_NELLYMOSER_8K = 0x05;
    const CODEC_NELLYMOSER = 0x06;

    const FREQ_5KHZ = 0x00;
    const FREQ_11KHZ = 0x01;
    const FREQ_22KHZ = 0x02;
    const FREQ_44KHZ = 0x05;

    const DEPTH_8BITS = 0x00;
    const DEPTH_16BITS = 0x01;

    const MODE_MONO = 0x00;
    const MODE_STEREO = 0x01;

    public $codec;
    public $frequency;
    public $depth;
    public $mode;


    function analyze()
    {
        $bits = new FLV_Util_BitStreamReader( $this->body );

        $this->codec = $bits->getInt( 4 );
        $this->frequency = $bits->getInt( 2 );
        $this->depth = $bits->getInt( 1 );
        $this->mode = $bits->getInt( 1 );
    }
}
