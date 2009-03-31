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
include_once FLV_INCLUDE_PATH . 'Tag/Video.php';
include_once FLV_INCLUDE_PATH . 'Tag/Audio.php';
include_once FLV_INCLUDE_PATH . 'Tag/Data.php';


class FLV_Tag {
    
    const TYPE_AUDIO = 0x08;
    const TYPE_VIDEO = 0x09;
    const TYPE_DATA = 0x12;

    
    /**
     * Static Factory method to return the correct tag object
     *
     * @param string $hdr   The tag header
     * @return FLV_Tag      A FLV_Tag object or a descendant of it
     */
    static function getTag( $hdr )
    {
        switch ( ord( $hdr[0] ) )
        {
            case self::TYPE_AUDIO:
                return new FLV_Tag_Audio( $hdr );
            case self::TYPE_VIDEO:
                return new FLV_Tag_Video( $hdr );
            case self::TYPE_DATA:
                return new FLV_Tag_Data( $hdr );
            default:
                return new FLV_Tag_Generic( $hdr );
        }
        return null;
    }

}
