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
 * Exception thrown when is not possible to operate on a file
 *
 */
class FLV_FileException extends Exception { }


/**
 * Exception thrown when the file is not of the propper type
 *
 */
class FLV_NotValidFileException extends FLV_FileException { }

/**
 * Exception thrown when an error or mismatch is found while processing a FLV file
 *
 */
class FLV_CorruptedFileException extends FLV_FileException { }

/**
 * Exception thrown when an unknown datatype is found when unserializing an AMF stream
 *
 */
class FLV_UnknownAMFTypeException extends Exception { }
