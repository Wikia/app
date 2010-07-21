<?PHP
/**
* TARBALL Class
* 
* tar stuff is way over my head ( AWC's ) so i turned to other resouces for this.
* This file contains code from two different class, Authors comments are intact.
* - AWC
* @filepath /extensions/awc/forums/includes/tar_cls.php
* @package awcsForum
* @author Alban LOPEZ
* @copyright Copyright (c) 2007 Alban LOPEZ
* @license http://www.gnu.org/licenses/
* @link www.phpclasses.org/browse/package/4239.html
* 
*/

/**-------------------------------------------------
 | EasyArchive.class V0.8 -  by Alban LOPEZ
 | Copyright (c) 2007 Alban LOPEZ
 | Email bugs/suggestions to alban.lopez+eazyarchive@gmail.com
 +--------------------------------------------------
 | This file is part of EasyArchive.class V0.9.
 | EasyArchive is free software: you can redistribute it and/or modify
 | it under the terms of the GNU General Public License as published by
 | the Free Software Foundation, either version 3 of the License, or
 | (at your option) any later version.
 | EasyArchive is distributed in the hope that it will be useful,
 | but WITHOUT ANY WARRANTY; without even the implied warranty of
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 | See the GNU General Public License for more details on http://www.gnu.org/licenses/
 +-------------------------------------------------- *
 */
//www.phpclasses.org/browse/package/4239.html

    //require (dirname(__FILE__).'/EasyZip.class.php');
    require (dirname(__FILE__).'/EasyTar.class.php');
   // require (dirname(__FILE__).'/EasyGzip.class.php');
   // require (dirname(__FILE__).'/EasyBzip2.class.php');

   
/**
// You can use this class like that.
$arch = new archive;
$arch->make('./', './archive.tar.gzip');
var_export($arch->infos('./toto.bzip2'));
$arch->extract('./toto.zip', './my_dir/');
$arch->download('./my_dir/');
**/

class archive
{
    var $WathArchive = array (
        '.zip'        =>'zip',
        '.tar'        =>'tar',
        '.gz'        =>'gz',
        '.gzip'        =>'gz',
        '.bzip'        =>'bz',
        '.bz'        =>'bz',
        '.bzip2'    =>'bz',
        '.bz2'        =>'bz',
        '.tgz'        =>'gz',
        '.tgzip'    =>'gz',
        '.tbzip'    =>'bz',
        '.tbz'        =>'bz',
        '.tbzip2'    =>'bz',
        '.tbz2'        =>'bz',
    );
    
    
    
    function download ($src, $name)
    {
        header('Content-Type: application/force-download');
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: no-cache, must-revalidate, max-age=60");
        header("Expires: Sat, 01 Jan 2000 12:00:00 GMT");
        header('Content-Disposition: attachment;filename="'.$name."\"\n");
        $data = $this->make($src, $name, false);
        header("Content-Length: ".strlen($data));
        print($data);
    }
    
    
    
    
    function make ($src, $name="Archive.tgz", $returnFile=true)
    {
        $ext = '.'.pathinfo ($name, PATHINFO_EXTENSION);
        foreach ($this->WathArchive as $key=>$val)
            if (stripos($ext, $key)!==false) $comp=$val;
        if ($comp == 'zip')
        {
            $zip = new zip;
            if ($returnFile)
                $result = $zip->makeZip($src, $dest);
            else
            {
                $tmpZip = './'.md5(serialize($src)).'.zip';
                $result = $zip->makeZip($src, $tmpZip);
                $result = file_get_contents($tmpZip);
                unlink($tmpZip);
            }
            return $result;
        }
        elseif (strlen($comp)>1)
        {
            if (count($src)>1 || is_dir($src[0]) || $comp == 'tar')
            {
                $tar = new tar;
                $src = $tar->makeTar($src);
            }
            if ($comp == 'bz')
            {
                $bzip2 = new bzip2;
                $src = $bzip2->makeBzip2($src);
            }
            elseif ($comp == 'gz')
            {
                $gzip = new gzip;
                $src = $gzip->makeGzip($src);
            }
            if ($returnFile)
            {
                file_put_contents($dest, $src);
                return $dest;
            }
            return $src;
        }
        else return 'Specifie a valid format at the end of '.$name.' filename ! ';
    }
    
    
    
    
    function infos ($src, $data=false)
    {
        $ext = '.'.pathinfo ($src, PATHINFO_EXTENSION);
        foreach ($this->WathArchive as $key=>$val)
            if (stripos($ext, $key)!==false) $comp=$val;
        if ($comp == 'zip')
        {
            $zip = new zip;
            $zipresult = $zip->infosZip($src, $data);
            $result ['Items'] = count($zipresult);
            foreach($zipresult as $key=>$val)
                $result['UnCompSize'] += $zipresult[$key]['UnCompSize'];
            $result['Size']=filesize($src);
            $result['Ratio'] = $result['UnCompSize'] ? round(100 - $result['Size'] / $result['UnCompSize']*100, 1) : false;
        }
        elseif (strlen($comp)>1)
        {
            $tar = new tar;
            if ($comp == 'bz')
            {
                $bzip2 = new bzip2;
                $result = $bzip2->infosBzip2($src, true);
                $src=$result['Data'];
            }
            elseif ($comp == 'gz')
            {
                $gzip = new gzip;
                $result = $gzip->infosGzip($src, true);
                $src=$result['Data'];
            }
            if ($tar->is_tar($src) || is_file($src))
            {
                $tarresult = $tar->infosTar($src, false);
                $result ['Items'] = count($tarresult);
                $result ['UnCompSize'] = 0;
                if (empty($result['Size']))
                    $result['Size']=is_file($src)?filesize($src):strlen($src);
                foreach($tarresult as $key=>$val)
                    $result['UnCompSize'] += $tarresult[$key]['size'];
                $result['Ratio'] = $result['UnCompSize'] ? round(100 - $result['Size'] / $result['UnCompSize']*100, 1) : false;
                
            }
            if (!$data) unset($result['Data']);
        }
        else return false;
        return array('Items'=>$result['Items'], 'UnCompSize'=>$result['UnCompSize'], 'Size'=>$result['Size'], 'Ratio'=>$result['Ratio'],);
    }
    
    
    
    function extract ($src, $dest=false)
    {
        $path_parts = pathinfo ($src);
        if (!$dest)
            $dest = $path_parts['dirname'].'/';
        $ext = '.'.$path_parts['extension'];
        $name = $path_parts['filename'];
        foreach ($this->WathArchive as $key=>$val)
            if (stripos($ext, $key)!==false) $comp=$val;
        if ($comp == 'zip')
        {
            $zip = new zip;
            return $zip->extractZip($src, $dest);
        }
        elseif (strlen($comp)>1)
        {
            $tar = new tar;
            if ($comp == 'bz')
            {
                $bzip2 = new bzip2;
                $src = $bzip2->extractBzip2($src);
            }
            elseif ($comp == 'gz')
            {
                $gzip = new gzip;
                $src = $gzip->extractGzip($src);
            }
            if ($tar->is_tar($src) || is_file($src))
            {
                return $tar->extractTar($src, $dest);
            }
            else file_put_contents($dest.$name, $src);
            return $dest;
        }
        return false;
    }
}














/*
=======================================================================
Name:
	tar Class

Author:
	Josh Barger <joshb@npt.com>

Description:
	This class reads and writes Tape-Archive (TAR) Files and Gzip
	compressed TAR files, which are mainly used on UNIX systems.
	This class works on both windows AND unix systems, and does
	NOT rely on external applications!! Woohoo!

Usage:
	Copyright (C) 2002  Josh Barger

	This library is free software; you can redistribute it and/or
	modify it under the terms of the GNU Lesser General Public
	License as published by the Free Software Foundation; either
	version 2.1 of the License, or (at your option) any later version.

	This library is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	Lesser General Public License for more details at:
		http://www.gnu.org/copyleft/lesser.html

	If you use this script in your application/website, please
	send me an e-mail letting me know about it :)

Bugs:
	Please report any bugs you might find to my e-mail address
	at joshb@npt.com.  If you have already created a fix/patch
	for the bug, please do send it to me so I can incorporate it into my release.

Version History:
	1.0	04/10/2002	- InitialRelease

	2.0	04/11/2002	- Merged both tarReader and tarWriter
				  classes into one
				- Added support for gzipped tar files
				  Remember to name for .tar.gz or .tgz
				  if you use gzip compression!
				  :: THIS REQUIRES ZLIB EXTENSION ::
				- Added additional comments to
				  functions to help users
				- Added ability to remove files and
				  directories from archive
	2.1	04/12/2002	- Fixed serious bug in generating tar
				- Created another example file
				- Added check to make sure ZLIB is
				  installed before running GZIP
				  compression on TAR
	2.2	05/07/2002	- Added automatic detection of Gzipped
				  tar files (Thanks go to Jürgen Falch
				  for the idea)
				- Changed "private" functions to have
				  special function names beginning with
				  two underscores
=======================================================================
*/

class awcsforum_tar_compress_cls {
	// Unprocessed Archive Information
	var $filename;
	var $isGzipped;
	var $tar_file;

	// Processed Archive Information
	var $files;
	var $directories;
	var $numFiles;
	var $numDirectories;


	// Class Constructor -- Does nothing...
	function tar() {
		return true;
	}


	// Computes the unsigned Checksum of a file's header
	// to try to ensure valid file
	// PRIVATE ACCESS FUNCTION
	function __computeUnsignedChecksum($bytestring) {
		for($i=0; $i<512; $i++)
			$unsigned_chksum += ord($bytestring[$i]);
		for($i=0; $i<8; $i++)
			$unsigned_chksum -= ord($bytestring[148 + $i]);
		$unsigned_chksum += ord(" ") * 8;

		return $unsigned_chksum;
	}


	// Converts a NULL padded string to a non-NULL padded string
	// PRIVATE ACCESS FUNCTION
	function __parseNullPaddedString($string) {
		$position = strpos($string,chr(0));
		return substr($string,0,$position);
	}


	// This function parses the current TAR file
	// PRIVATE ACCESS FUNCTION
	function __parseTar() {
		// Read Files from archive
		$tar_length = strlen($this->tar_file);
		$main_offset = 0;
		while($main_offset < $tar_length) {
			// If we read a block of 512 nulls, we are at the end of the archive
			if(substr($this->tar_file,$main_offset,512) == str_repeat(chr(0),512))
				break;

			// Parse file name
			$file_name		= $this->__parseNullPaddedString(substr($this->tar_file,$main_offset,100));

			// Parse the file mode
			$file_mode		= substr($this->tar_file,$main_offset + 100,8);

			// Parse the file user ID
			$file_uid		= octdec(substr($this->tar_file,$main_offset + 108,8));

			// Parse the file group ID
			$file_gid		= octdec(substr($this->tar_file,$main_offset + 116,8));

			// Parse the file size
			$file_size		= octdec(substr($this->tar_file,$main_offset + 124,12));

			// Parse the file update time - unix timestamp format
			$file_time		= octdec(substr($this->tar_file,$main_offset + 136,12));

			// Parse Checksum
			$file_chksum		= octdec(substr($this->tar_file,$main_offset + 148,6));

			// Parse user name
			$file_uname		= $this->__parseNullPaddedString(substr($this->tar_file,$main_offset + 265,32));

			// Parse Group name
			$file_gname		= $this->__parseNullPaddedString(substr($this->tar_file,$main_offset + 297,32));

			// Make sure our file is valid
			if($this->__computeUnsignedChecksum(substr($this->tar_file,$main_offset,512)) != $file_chksum)
				return false;

			
       if(strstr($file_name, '.php') OR strstr($file_name, '.txt')){ // AWC
       	  // Parse File Contents
					$file_contents		= substr($this->tar_file,$main_offset + 512,$file_size); // Josh Barger
        } else{
        	$file_contents = '';
        }
          
			/*	### Unused Header Information ###
				$activeFile["typeflag"]		= substr($this->tar_file,$main_offset + 156,1);
				$activeFile["linkname"]		= substr($this->tar_file,$main_offset + 157,100);
				$activeFile["magic"]		= substr($this->tar_file,$main_offset + 257,6);
				$activeFile["version"]		= substr($this->tar_file,$main_offset + 263,2);
				$activeFile["devmajor"]		= substr($this->tar_file,$main_offset + 329,8);
				$activeFile["devminor"]		= substr($this->tar_file,$main_offset + 337,8);
				$activeFile["prefix"]		= substr($this->tar_file,$main_offset + 345,155);
				$activeFile["endheader"]	= substr($this->tar_file,$main_offset + 500,12);
			*/

			if($file_size > 0) {
				// Increment number of files
				$this->numFiles++;

				// Create us a new file in our array
				$activeFile = &$this->files[];

				// Asign Values
				$activeFile["name"]		= $file_name;
				$activeFile["mode"]		= $file_mode;
				$activeFile["size"]		= $file_size;
				$activeFile["time"]		= $file_time;
				$activeFile["user_id"]		= $file_uid;
				$activeFile["group_id"]		= $file_gid;
				$activeFile["user_name"]	= $file_uname;
				$activeFile["group_name"]	= $file_gname;
				$activeFile["checksum"]		= $file_chksum;
				$activeFile["file"]		= $file_contents;

			} else {
				// Increment number of directories
				$this->numDirectories++;

				// Create a new directory in our array
				$activeDir = &$this->directories[];

				// Assign values
				$activeDir["name"]		= $file_name;
				$activeDir["mode"]		= $file_mode;
				$activeDir["time"]		= $file_time;
				$activeDir["user_id"]		= $file_uid;
				$activeDir["group_id"]		= $file_gid;
				$activeDir["user_name"]		= $file_uname;
				$activeDir["group_name"]	= $file_gname;
				$activeDir["checksum"]		= $file_chksum;
			}

			// Move our offset the number of blocks we have processed
			$main_offset += 512 + (ceil($file_size / 512) * 512);
		}

		return true;
	}


	// Read a non gzipped tar file in for processing
	// PRIVATE ACCESS FUNCTION
	function __readTar($filename='') {
		// Set the filename to load
		if(!$filename)
			$filename = $this->filename;

		// Read in the TAR file
		$fp = fopen($filename,"rb");
		$this->tar_file = fread($fp,filesize($filename));
		fclose($fp);

		if($this->tar_file[0] == chr(31) && $this->tar_file[1] == chr(139) && $this->tar_file[2] == chr(8)) {
			if(!function_exists("gzinflate"))
				return false;

			$this->isGzipped = TRUE;

			$this->tar_file = gzinflate(substr($this->tar_file,10,-4));
		}

		// Parse the TAR file
		$this->__parseTar();

		return true;
	}


	// Generates a TAR file from the processed data
	// PRIVATE ACCESS FUNCTION
	function __generateTAR() {
		// Clear any data currently in $this->tar_file	
		unset($this->tar_file);

		// Generate Records for each directory, if we have directories
		if($this->numDirectories > 0) {
			foreach($this->directories as $key => $information) {
				unset($header);

				// Generate tar header for this directory
				// Filename, Permissions, UID, GID, size, Time, checksum, typeflag, linkname, magic, version, user name, group name, devmajor, devminor, prefix, end
				$header .= str_pad($information["name"],100,chr(0));
				$header .= str_pad(decoct($information["mode"]),7,"0",STR_PAD_LEFT) . chr(0);
				$header .= str_pad(decoct($information["user_id"]),7,"0",STR_PAD_LEFT) . chr(0);
				$header .= str_pad(decoct($information["group_id"]),7,"0",STR_PAD_LEFT) . chr(0);
				$header .= str_pad(decoct(0),11,"0",STR_PAD_LEFT) . chr(0);
				$header .= str_pad(decoct($information["time"]),11,"0",STR_PAD_LEFT) . chr(0);
				$header .= str_repeat(" ",8);
				$header .= "5";
				$header .= str_repeat(chr(0),100);
				$header .= str_pad("ustar",6,chr(32));
				$header .= chr(32) . chr(0);
				$header .= str_pad("",32,chr(0));
				$header .= str_pad("",32,chr(0));
				$header .= str_repeat(chr(0),8);
				$header .= str_repeat(chr(0),8);
				$header .= str_repeat(chr(0),155);
				$header .= str_repeat(chr(0),12);

				// Compute header checksum
				$checksum = str_pad(decoct($this->__computeUnsignedChecksum($header)),6,"0",STR_PAD_LEFT);
				for($i=0; $i<6; $i++) {
					$header[(148 + $i)] = substr($checksum,$i,1);
				}
				$header[154] = chr(0);
				$header[155] = chr(32);

				// Add new tar formatted data to tar file contents
				$this->tar_file .= $header;
			}
		}

		// Generate Records for each file, if we have files (We should...)
		if($this->numFiles > 0) {
			foreach($this->files as $key => $information) {
				unset($header);

				// Generate the TAR header for this file
				// Filename, Permissions, UID, GID, size, Time, checksum, typeflag, linkname, magic, version, user name, group name, devmajor, devminor, prefix, end
				$header .= str_pad($information["name"],100,chr(0));
				$header .= str_pad(decoct($information["mode"]),7,"0",STR_PAD_LEFT) . chr(0);
				$header .= str_pad(decoct($information["user_id"]),7,"0",STR_PAD_LEFT) . chr(0);
				$header .= str_pad(decoct($information["group_id"]),7,"0",STR_PAD_LEFT) . chr(0);
				$header .= str_pad(decoct($information["size"]),11,"0",STR_PAD_LEFT) . chr(0);
				$header .= str_pad(decoct($information["time"]),11,"0",STR_PAD_LEFT) . chr(0);
				$header .= str_repeat(" ",8);
				$header .= "0";
				$header .= str_repeat(chr(0),100);
				$header .= str_pad("ustar",6,chr(32));
				$header .= chr(32) . chr(0);
				$header .= str_pad($information["user_name"],32,chr(0));	// How do I get a file's user name from PHP?
				$header .= str_pad($information["group_name"],32,chr(0));	// How do I get a file's group name from PHP?
				$header .= str_repeat(chr(0),8);
				$header .= str_repeat(chr(0),8);
				$header .= str_repeat(chr(0),155);
				$header .= str_repeat(chr(0),12);

				// Compute header checksum
				$checksum = str_pad(decoct($this->__computeUnsignedChecksum($header)),6,"0",STR_PAD_LEFT);
				for($i=0; $i<6; $i++) {
					$header[(148 + $i)] = substr($checksum,$i,1);
				}
				$header[154] = chr(0);
				$header[155] = chr(32);

				// Pad file contents to byte count divisible by 512
				$file_contents = str_pad($information["file"],(ceil($information["size"] / 512) * 512),chr(0));

				// Add new tar formatted data to tar file contents
				$this->tar_file .= $header . $file_contents;
			}
		}

		// Add 512 bytes of NULLs to designate EOF
		$this->tar_file .= str_repeat(chr(0),512);

		return true;
	}


	// Open a TAR file
	function openTAR($filename) {
		// Clear any values from previous tar archives
		unset($this->filename);
		unset($this->isGzipped);
		unset($this->tar_file);
		unset($this->files);
		unset($this->directories);
		unset($this->numFiles);
		unset($this->numDirectories);

		// If the tar file doesn't exist...
		if(!file_exists($filename))
			return false;

		$this->filename = $filename;

		// Parse this file
		$this->__readTar();

		return true;
	}


	// Appends a tar file to the end of the currently opened tar file
	function appendTar($filename) {
		// If the tar file doesn't exist...
		if(!file_exists($filename))
			return false;

		$this->__readTar($filename);

		return true;
	}


	// Retrieves information about a file in the current tar archive
	function getFile($filename) {
		if($this->numFiles > 0) {
			foreach($this->files as $key => $information) {
				if($information["name"] == $filename)
					return $information;
			}
		}

		return false;
	}


	// Retrieves information about a directory in the current tar archive
	function getDirectory($dirname) {
		if($this->numDirectories > 0) {
			foreach($this->directories as $key => $information) {
				if($information["name"] == $dirname)
					return $information;
			}
		}

		return false;
	}


	// Check if this tar archive contains a specific file
	function containsFile($filename) {
		if($this->numFiles > 0) {
			foreach($this->files as $key => $information) {
				if($information["name"] == $filename)
					return true;
			}
		}

		return false;
	}


	// Check if this tar archive contains a specific directory
	function containsDirectory($dirname) {
		if($this->numDirectories > 0) {
			foreach($this->directories as $key => $information) {
				if($information["name"] == $dirname)
					return true;
			}
		}

		return false;
	}


	// Add a directory to this tar archive
	function addDirectory($dirname) {
		if(!file_exists($dirname))
			return false;

		// Get directory information
		$file_information = stat($dirname);

		// Add directory to processed data
		$this->numDirectories++;
		$activeDir		= &$this->directories[];
		$activeDir["name"]	= $dirname;
		$activeDir["mode"]	= $file_information["mode"];
		$activeDir["time"]	= $file_information["time"];
		$activeDir["user_id"]	= $file_information["uid"];
		$activeDir["group_id"]	= $file_information["gid"];
		$activeDir["checksum"]	= $checksum;

		return true;
	}


	// Add a file to the tar archive
	function addFile($filename) {
		// Make sure the file we are adding exists!
		if(!file_exists($filename))
			return false;

		// Make sure there are no other files in the archive that have this same filename
		if($this->containsFile($filename))
			return false;

		// Get file information
		$file_information = stat($filename);

		// Read in the file's contents
		$fp = fopen($filename,"rb");
		$file_contents = fread($fp,filesize($filename));
		fclose($fp);

		// Add file to processed data
		$this->numFiles++;
		$activeFile			= &$this->files[];
		$activeFile["name"]		= $filename;
		$activeFile["mode"]		= $file_information["mode"];
		$activeFile["user_id"]		= $file_information["uid"];
		$activeFile["group_id"]		= $file_information["gid"];
		$activeFile["size"]		= $file_information["size"];
		$activeFile["time"]		= $file_information["mtime"];
		$activeFile["checksum"]		= $checksum;
		$activeFile["user_name"]	= "";
		$activeFile["group_name"]	= "";
		$activeFile["file"]		= $file_contents;

		return true;
	}


	// Remove a file from the tar archive
	function removeFile($filename) {
		if($this->numFiles > 0) {
			foreach($this->files as $key => $information) {
				if($information["name"] == $filename) {
					$this->numFiles--;
					unset($this->files[$key]);
					return true;
				}
			}
		}

		return false;
	}


	// Remove a directory from the tar archive
	function removeDirectory($dirname) {
		if($this->numDirectories > 0) {
			foreach($this->directories as $key => $information) {
				if($information["name"] == $dirname) {
					$this->numDirectories--;
					unset($this->directories[$key]);
					return true;
				}
			}
		}

		return false;
	}


	// Write the currently loaded tar archive to disk
	function saveTar() {
		if(!$this->filename)
			return false;

		// Write tar to current file using specified gzip compression
		$this->toTar($this->filename,$this->isGzipped);

		return true;
	}


	// Saves tar archive to a different file than the current file
	function toTar($filename,$useGzip) {
		if(!$filename)
			return false;

		// Encode processed files into TAR file format
		$this->__generateTar();

		// GZ Compress the data if we need to
		if($useGzip) {
			// Make sure we have gzip support
			if(!function_exists("gzencode"))
				return false;

			$file = gzencode($this->tar_file);
		} else {
			$file = $this->tar_file;
		}

		// Write the TAR file
		$fp = fopen($filename,"wb");
		fwrite($fp,$file);
		fclose($fp);

		return true;
	}
	
	
	
	
/*
+--------------------------------------------------------------------------
|   Invision Power Board v1.3 Final
|   ========================================
|   by Matthew Mecham
|   (c) 2001 - 2003 Invision Power Services
|   http://www.invisionpower.com
|   ========================================
|   Web: http://www.invisionboard.com
|   Time: Fri, 21 Nov 2003 08:29:56 GMT
|   Release: 947ee4510a9b9e00dd31919718a9d4c4
|   Email: matt@invisionpower.com
|   Licence Info: http://www.invisionboard.com/?license
+---------------------------------------------------------------------------
|
|   > GNU Tar creation and extraction module
|   > Module written by Matt Mecham
|   > Usage style based on the C and Perl GNU modules
|   > Will only work with PHP 4+
|   
|   > Date started: 15th Feb 2002
|
|	> Module Version Number: 1.0.0
|   > Module Author: Matthew Mecham
+--------------------------------------------------------------------------
|
| QUOTE OF THE MODULE:
|  If you can't find a program the does what you want it to do, write your
|  own.
|
+--------------------------------------------------------------------------
|
| LICENCE OF USE (THIS MODULE ONLY)
|
| This module has been created and released under the GNU licence and may be
| freely used and distributed. If you find some space to credit us in your source
| code, it'll be appreciated.
|
| Report all bugs / improvements to matt@ibforums.com
|
| NOTE: This does not affect the current licence for the rest of the Invision
| board code. I just wanted to share this module as there is a lack of other
| decent tar proggies for PHP.
|
+--------------------------------------------------------------------------
*/	

    var $tar_header_length = '512';
    var $tar_unpack_header = 'a100filename/a8mode/a8uid/a8gid/a12size/a12mtime/a8chksum/a1typeflag/a100linkname/a6magic/a2version/a32uname/a32gname/a8devmajor/a8devminor/a155/prefix';
    var $tar_pack_header   = 'A100 A8 A8 A8 A12 A12 A8 A1 A100 A6 A2 A32 A32 A8 A8 A155';
    
    
	//+--------------------------------------------------------------------------
	// Extract the tarball
	// $tar->extract_files( str(TO DIRECTORY), [ array( FILENAMES )  ] )
	//    Can be used in the following methods.
	//	  $tar->extract( "/foo/bar" , $files );
	// 	  This will seek out the files in the user array and extract them
	//    $tar->extract( "/foo/bar" );
	//    Will extract the complete tar file into the user specified directory
	//+--------------------------------------------------------------------------
	
	function extract_files( $to_dir, $files="" ) {
	
		$this->error = "";
        
		// Make sure the $to_dir is pointing to a valid dir, or we error
		// and return
		
		if (! is_dir($to_dir) )
		{
			//$this->error = awcsarcade_funcs::get_word('extract_no_dir', '$to_dir', $to_dir);
			return;
		}
        
		//---------------------------------------------
		// change into the directory chosen by the user.
		//---------------------------------------------
		
		chdir($to_dir);
		$cur_dir = getcwd();
		
		$to_dir_slash = $to_dir . "/";
		
		//+------------------------------
		// Get the file info from the tar
		//+------------------------------
		
		$in_files = $this->read_tar();
		
		if ($this->error != "") {
			return;
		}
		die(print_r($in_files));
		foreach ($in_files as $k => $file) {
		
			//---------------------------------------------
			// Are we choosing which files to extract?
			//---------------------------------------------
			
			/*
			if (is_array($files))
			{
				if (! in_array($file['name'], $files) )
				{
					continue;
				}
			}
			*/
			
			
			chdir($cur_dir);
			
			//---------------------------------------------
			// GNU TAR format dictates that all paths *must* be in the *nix
			// format - if this is not the case, blame the tar vendor, not me!
			//---------------------------------------------
			
			if ( preg_match("#/#", $file['name']) )
			{
				$path_info = explode( "/" , $file['name'] );
				$file_name = array_pop($path_info);
			} else
			{
				$path_info = array();
				$file_name = $file['name'];
			}
			
			//---------------------------------------------
			// If we have a path, then we must build the directory tree
			//---------------------------------------------
			
			
			if (count($path_info) > 0)
			{
				foreach($path_info as $dir_component)
				{
					if ($dir_component == "")
					{
						continue;
					}
					if ( (file_exists($dir_component)) && (! is_dir($dir_component)) )
					{
						$this->warnings[] = awcsarcade_funcs::get_word('dir_component_not_dir', '$dir_component', $dir_component);
						continue;
					}
					if (! is_dir($dir_component))
					{
						mkdir( $dir_component, 0777);
						chmod( $dir_component, 0777);
					}
					
					if (! @chdir($dir_component))
					{
						$this->warnings[] = awcsarcade_funcs::get_word('CHDIR_FAILED', '$dir_component', $dir_component);
					}
				}
			}
			
			//---------------------------------------------
			// check the typeflags, and work accordingly
			//---------------------------------------------
			
			if (($file['typeflag'] == 0) or (!$file['typeflag']) or ($file['typeflag'] == ""))
			{
				if ( $FH = fopen($file_name, "wb") )
				{
					fputs( $FH, $file['data'], strlen($file['data']) );
					fclose($FH);
				}
				else
				{
					$this->warnings[] = awcsarcade_funcs::get_word('cant_write_data_file', '$file_name', $file_name);
				}
			}
			else if ($file['typeflag'] == 5)
			{
				if ( (file_exists($file_name)) && (! is_dir($file_name)) )
				{
					$this->warnings[] = awcsarcade_funcs::get_word('file_not_dir', '$file_name', $file_name) ;
					continue;
				}
				if (! is_dir($file_name))
				{
					@mkdir( $file_name, 0777);
				}
			}
			else if ($file['typeflag'] == 6)
			{
				$this->warnings[] = awcsarcade_funcs::get_word('no_pipes');
				continue;
			}
			else if ($file['typeflag'] == 1)
			{
				$this->warnings[] = awcsarcade_funcs::get_word('no_links');
			}
			else if ($file['typeflag'] == 4)
			{
				$this->warnings[] = awcsarcade_funcs::get_word('no_device_files');
			}	
			else if ($file['typeflag'] == 3)
			{
				$this->warnings[] = awcsarcade_funcs::get_word('no_device_files');
			}
			else
			{
				$this->warnings[] = awcsarcade_funcs::get_word('flag_type');
			}
			
			if (! @chmod( $file_name, $file['mode'] ) )
			{
				$this->warnings[] = awcsarcade_funcs::get_word('CHMOD_mode_FAILED', array('$mode', '$file_name'), array($mode, $file_name));
			}
			
			@touch( $file_name, $file['mtime'] );
			
		}
		
		die("sdf");
		// Return to the "real" directory the scripts are in
		
		@chdir($this->current_dir);
        
        return true;
		
	}
	
	
	
	function read_tar() {
	
		$filename = $this->filename;
        
        
        
	
		if ($filename == "") {
			//$this->error = awcsarcade_funcs::get_word('no_tar_to_read');
			return array();
		}
		
		if (! file_exists($filename) ) {
			//$this->error =  awcsarcade_funcs::get_word('can_not_locate_file', '$filename', $filename);
			return array();
		}
		
		$tar_info = array();
		
		
		$this->tar_filename = $filename;
		

		// Open up the tar file and start the loop

        
		if (! $FH = fopen( $filename , 'rb' ) ) {
			//$this->error = awcsarcade_funcs::get_word('can_not_read_tar', '$filename', $filename);
			return array();
		}
        
          
        
		
		// Grrr, perl allows spaces, PHP doesn't. Pack strings are hard to read without
		// them, so to save my sanity, I'll create them with spaces and remove them here
		
		$this->tar_unpack_header = preg_replace( "/\s/", "" , $this->tar_unpack_header);
		
		while (!feof($FH)) {
		
			$buffer = fread( $FH , $this->tar_header_length );
			
			// check the block
			
			$checksum = 0;
			
			for ($i = 0 ; $i < 148 ; $i++) {
				$checksum += ord( substr($buffer, $i, 1) );
			}
			for ($i = 148 ; $i < 156 ; $i++) {
				$checksum += ord(' ');
			}
			for ($i = 156 ; $i < 512 ; $i++) {
				$checksum += ord( substr($buffer, $i, 1) );
			}
			
			$fa = unpack( $this->tar_unpack_header, $buffer);

			$name     = trim($fa[filename]);
			$mode     = OctDec(trim($fa[mode]));
			$uid      = OctDec(trim($fa[uid]));
			$gid      = OctDec(trim($fa[gid]));
			$size     = OctDec(trim($fa[size]));
			$mtime    = OctDec(trim($fa[mtime]));
			$chksum   = OctDec(trim($fa[chksum]));
			$typeflag = trim($fa[typeflag]);
			$linkname = trim($fa[linkname]);
			$magic    = trim($fa[magic]);
			$version  = trim($fa[version]);
			$uname    = trim($fa[uname]);
			$gname    = trim($fa[gname]);
			$devmajor = OctDec(trim($fa[devmajor]));
			$devminor = OctDec(trim($fa[devminor]));
			$prefix   = trim($fa[prefix]);
			
			if ( ($checksum == 256) && ($chksum == 0) ) {
				//EOF!
				break;
			}
			
			if ($prefix) {
				$name = $prefix.'/'.$name;
			}
			
			// Some broken tars don't set the type flag
			// correctly for directories, so we assume that
			// if it ends in / it's a directory...
			
			if ( (preg_match( "#/$#" , $name)) and (! $name) ) {
				$typeflag = 5;
			}
			
			// If it's the end of the tarball...
			$test = $this->internal_build_string( '\0' , 512 );
			if ($buffer == $test) {
				break;
			}
			
			// Read the next chunk
			
			$data = fread( $FH, $size );
			
			if (strlen($data) != $size) {
				$this->error =  awcsarcade_funcs::get_word('read_error_on_tar');
				fclose( $FH );
				return array();
			}
            
			$diff = $size % 512;
			
			if ($diff != 0) {
				// Padding, throw away
				$crap = fread( $FH, (512-$diff) );
			}
			
			// Protect against tarfiles with garbage at the end
			
			if ($name == "") {
				break;
			}
			
			$tar_info[] = array (
								  'name'     => $name,
								  'mode'     => $mode,
								  'uid'      => $uid,
								  'gid'      => $gid,
								  'size'     => $size,
								  'mtime'    => $mtime,
								  'chksum'   => $chksum,
								  'typeflag' => $typeflag,
								  'linkname' => $linkname,
								  'magic'    => $magic,
								  'version'  => $version,
								  'uname'    => $uname,
								  'gname'    => $gname,
								  'devmajor' => $devmajor,
								  'devminor' => $devminor,
								  'prefix'   => $prefix,
								  'data'     => $data
								 );
		}
		
		fclose($FH);
        
    		die(print_r($tar_info));
		   
		
		return $tar_info;
        
	}
	
//+------------------------------------------------------------------------------
// INTERNAL FUNCTIONS - These should NOT be called outside this module
//+------------------------------------------------------------------------------
    
    //+--------------------------------------------------------------------------
    // build_string: Builds a repititive string
    //+--------------------------------------------------------------------------
    
    function internal_build_string($string="", $times=0) {
    
        $return = "";
        for ($i=0 ; $i < $times ; ++$i ) {
            $return .= $string;
        }
        
        return $return;
    }
	
	
	
	
	
	
	
	
	
	
	
}