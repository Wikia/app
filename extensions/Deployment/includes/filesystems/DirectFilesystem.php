<?php

/**
 * File holding the DirectFilesystem class.
 *
 * @file DirectFilesystem.php
 * @ingroup Deployment
 * @ingroup Filesystem
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Filesystem class for direct PHP file and folder manipulation.
 * 
 * @author Jeroen De Dauw
 */
class DirectFilesystem extends Filesystem {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		
		// TODO
	}
	
	/**
	 * @see Filesystem::connect
	 */
	public function connect() {
		return true;
	}
	
	/**
	 * @see Filesystem::changeDir
	 */
	public function changeDir( $dir ) {
		wfSuppressWarnings();
		$result = (bool)chdir( $dir );
		wfRestoreWarnings();
		return $result;
	}

	/**
	 * @see Filesystem::changeFileGroup
	 */
	public function changeFileGroup( $file, $group, $recursive = false ) {
		if ( !$this->exists( $file ) ) {
			return false;
		}
		
		// Not recursive, so just use chgrp.
		if ( !$recursive || !$this->isDir( $file ) ) {
			wfSuppressWarnings();
			$result = chgrp( $file, $group );
			wfRestoreWarnings();
			return $result;
		}
		
		// Recursive approach required.
		$file = rtrim( $file, '/' ) . '/';
		$files = $this->listDir( $file );
		
		foreach ( $files as $fileName ) {
			$this->changeFileGroup( $file . $fileName, $group, $recursive );
		}

		return true;		
	}

	/**
	 * @see Filesystem::chmod
	 */
	public function chmod( $file, $mode = false, $recursive = false ) {
		// TODO: refactor up?
		if ( !$mode ) {
			if ( $this->isFile( $file ) ) {
				$mode = FS_CHMOD_FILE;
			}
			elseif ( $this->isDir( $file ) ) {
				$mode = FS_CHMOD_DIR;
			}
			else {
				return false;
			}
		}

		// Not recursive, so just use chmod.
		if ( !$recursive || !$this->isDir( $file ) ) {
			wfSuppressWarnings();
			$result = (bool)chmod( $file, $mode );
			wfRestoreWarnings();
			return $result; 
		}
			
		// Recursive approach required.
		$file = rtrim( $file, '/' ) . '/';
		$files = $this->listDir( $file );
		
		foreach ( $files as $fileName ) {
			$this->chmod( $file . $fileName, $mode, $recursive );
		}

		return true;	
	}

	/**
	 * @see Filesystem::chown
	 */
	public function chown( $file, $owner, $recursive = false ) {
		if ( !$this->exists( $file ) ) {
			return false;
		}
		
		// Not recursive, so just use chown.
		if ( !$recursive || !$this->isDir( $file ) ) {
			wfSuppressWarnings();
			$result = (bool)chown( $file, $owner );
			wfRestoreWarnings();			
			return $result;
		}
			
		// Recursive approach required.
		$file = rtrim( $file, '/' ) . '/';
		$files = $this->listDir( $file );
		
		foreach ( $files as $fileName ) {
			$this->chown( $file . $fileName, $owner, $recursive );
		}

		return true;	
	}

	/**
	 * @see Filesystem::delete
	 */
	public function delete( $path, $recursive = false ) {
		if ( empty( $path ) ) {
			return false;
		}
			
		// For win32, occasional problems deleteing files otherwise.
		$path = str_replace( '\\', '/', $path ); 

		if ( $this->isFile( $path ) ) {
			wfSuppressWarnings();
			$result = (bool)unlink( $path );
			wfRestoreWarnings();			
			return $result;
		}
			
		if ( !$recursive && $this->isDir( $path ) ) {
			wfSuppressWarnings();
			$result = (bool)rmdir( $path );
			wfRestoreWarnings();			
			return $result;
		}
			
		// Recursive approach required.
		$path = rtrim( $path, '/' ) . '/';
		$files = $this->listDir( $path );
		
		$success = true;
		
		foreach ( $files as $fileName ) {
			if ( !$this->delete( $path . $fileName, $recursive ) ) {
				$success = false;
			}
		}

		if ( $success && file_exists( $path ) ) {
			wfSuppressWarnings();
			$rmdirRes = rmdir( $path );
			wfRestoreWarnings();	

			if ( !$rmdirRes ) {
				$success = false;
			}
		}
		
		return $success;
	}

	/**
	 * @see Filesystem::doCopy
	 */
	protected function doCopy( $from, $to ) {
		return copy( $from, $to );
	}

	/**
	 * @see Filesystem::doMove
	 */
	protected function doMove( $from, $to, $overwrite ) {
		// try using rename first.  if that fails (for example, source is read only) try copy and delete.
			wfSuppressWarnings();
			$renameRes = rename( $from, $to);
			wfRestoreWarnings();		
		if ( $renameRes ) {
			return true;
		}

		if ( $this->copy( $from, $to, $overwrite ) && $this->exists( $to ) ) {
			$this->delete( $from );
			return true;
		} else {
			return false;
		}	
	}

	/**
	 * @see Filesystem::exists
	 */
	public function exists( $file ) {
		wfSuppressWarnings();
		$result = file_exists( $file );
		wfRestoreWarnings();		
		return $result;
	}

	/**
	 * @see Filesystem::getChmod
	 */
	public function getChmod( $file ) {
		wfSuppressWarnings();
		$fileperms = fileperms( $file );
		wfRestoreWarnings();		
		return substr( decoct( $fileperms ), 3 );
	}

	/**
	 * @see Filesystem::getContents
	 */
	public function getContents( $file ) {
		wfSuppressWarnings();
		$result = file_get_contents( $file );
		wfRestoreWarnings();		
		return $result;
	}

	/**
	 * @see Filesystem::getCurrentWorkingDir
	 */
	public function getCurrentWorkingDir() {
		wfSuppressWarnings();
		$result = getcwd();
		wfRestoreWarnings();		
		return $result;		
	}

	/**
	 * @see Filesystem::getGroup
	 */
	public function getGroup( $file ) {
		wfSuppressWarnings();
		$gid = filegroup( $file );
		wfRestoreWarnings();
		
		if ( !$gid ) {
			return false;
		}
			
		if ( function_exists( 'posix_getgrgid' ) ) {
			$groupArray = posix_getgrgid( $gid );
			return $groupArray['name'];				
		}
		
		return $gid;
	}

	/**
	 * @see Filesystem::getModificationTime
	 */
	public function getModificationTime( $file ) {
		wfSuppressWarnings();
		$result = filemtime( $file );
		wfRestoreWarnings();		
		return $result;		
	}

	/**
	 * @see Filesystem::getOwner
	 */
	public function getOwner( $file ) {
		wfSuppressWarnings();
		$owneruid = fileowner( $file );
		wfRestoreWarnings();
		
		if ( !$owneruid ) {
			return false;
		}
			
		if ( function_exists( 'posix_getpwuid' ) ) {
			$ownerArray = posix_getpwuid( $owneruid );
			return $ownerArray['name'];				
		}
		
		return $owneruid;		
	}

	/**
	 * @see Filesystem::getSize
	 */
	public function getSize( $file ) {
		wfSuppressWarnings();
		$result = filesize( $file );
		wfRestoreWarnings();		
		return $result;			
	}

	/**
	 * @see Filesystem::isDir
	 */
	public function isDir( $path ) {
		wfSuppressWarnings();
		$result = (bool)is_dir( $path );
		wfRestoreWarnings();		
		return $result;				
	}

	/**
	 * @see Filesystem::isFile
	 */
	public function isFile( $path ) {
		wfSuppressWarnings();
		$result = (bool)is_file( $path );
		wfRestoreWarnings();		
		return $result;				
	}

	/**
	 * @see Filesystem::isReadable
	 */
	public function isReadable( $file ) {
		wfSuppressWarnings();
		$result = (bool)is_readable( $file );
		wfRestoreWarnings();		
		return $result;			
	}

	/**
	 * @see Filesystem::isWritable
	 */
	public function isWritable( $file ) {
		wfSuppressWarnings();
		$result = (bool)is_writable( $file );
		wfRestoreWarnings();		
		return $result;			
	}

	/**
	 * @see Filesystem::listDir
	 */
	public function listDir( $path, $includeHidden = true, $recursive = false ) {
		if ( $this->isFile( $path ) ) {
			$limit_file = basename( $path );
			$path = dirname( $path );
		} else {
			$limit_file = false;
		}

		if ( !$this->isDir( $path ) ) {
			return false;
		}

		wfSuppressWarnings();
		$dir = dir( $path );
		wfRestoreWarnings();
		
		if ( !$dir ) {
			return false;
		}

		$ret = array();

		while ( false !== ( $entry = $dir->read() ) ) {
			$struc = array();
			$struc['name'] = $entry;

			if ( '.' == $struc['name'] || '..' == $struc['name'] )
				continue;

			if ( ( !$includeHidden && '.' == $struc['name'][0] ) || ( $limit_file && $struc['name'] != $limit_file ) ) {
				continue;
			}

			$entryPath = "$path/$entry";
			
			$struc['perms'] 	= $this->getChmod( $entryPath );
			$struc['number'] 	= false;
			$struc['owner']    	= $this->getOwner( $entryPath );
			$struc['group']    	= $this->getGroup( $entryPath );
			$struc['size']    	= $this->getSize( $entryPath );
			$struc['lastmodunix']= $this->getModificationTime( $entryPath );
			$struc['lastmod']   = date( 'M j', $struc['lastmodunix'] );
			$struc['time']    	= date( 'h:i:s', $struc['lastmodunix'] );
			$struc['type']		= $this->isDir( $entryPath ) ? 'd' : 'f';

			if ( $struc['type'] == 'd' ) {
				if ( $recursive ) {
					$struc['files'] = $this->listDir( $path . '/' . $struc['name'], $includeHidden, $recursive );
				}
				else {
					$struc['files'] = array();
				}
			}

			$ret[$struc['name']] = $struc;
		}
		
		$dir->close();
		unset($dir);
		
		return $ret;		
	}

	/**
	 * @see Filesystem::makeDir
	 */
	public function makeDir( $path, $chmod = false, $chown = false, $chgrp = false ) {
		// Safe mode fails with a trailing slash under certain PHP versions.
		$path = rtrim( $path, '/' );
		
		if ( empty( $path ) ) {
			$path = '/';
		}

		if ( !$chmod ) {
			$chmod = FS_CHMOD_DIR;
		}
			
		wfSuppressWarnings();
		$mkdir = mkdir($path);
		wfRestoreWarnings();
		
		if ( !$mkdir ) {
			return false;
		}
			
		$this->chmod( $path, $chmod );
		
		if ( $chown ) {
			$this->chown( $path, $chown );
		}
			
		if ( $chgrp ) {
			$this->changeFileGroup( $path, $chgrp );
		}
			
		return true;		
	}

	/**
	 * @see Filesystem::touch
	 */
	public function touch( $file, $time = 0, $atime = 0 ) {
		if ( $time == 0 ) {
			$time = time();
		}
			
		if ( $atime == 0 ) {
			$atime = time();
		}
			
		wfSuppressWarnings();
		$result = (bool)touch( $file, $time, $atime );
		wfRestoreWarnings();
				
		return $result;			
	}

	/**
	 * @see Filesystem::writeToFile
	 */
	public function writeToFile( $file, $contents, $mode = false  ) {
		wfSuppressWarnings();
		$fopen = fopen( $file, 'w' );
		wfRestoreWarnings();
		
		if ( !( $fp = $fopen ) ) {
			return false;
		}
		
		wfSuppressWarnings();
		fwrite( $fp, $contents );
		fclose( $fp );
		wfRestoreWarnings();
		
		$this->chmod( $file, $mode );
		
		return true;		
	}	
	
}