<?php

/**
 * File holding the FtpFilesystem class.
 *
 * @file FtpFilesystem.php
 * @ingroup Deployment
 * @ingroup Filesystem
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Filesystem class for file and folder manipulation over FTP.
 * 
 * @author Jeroen De Dauw
 */
class FtpFilesystem extends Filesystem {
	
	/**
	 * A list of options.
	 * 
	 * @var array
	 */
	protected $options = array();
	
	/**
	 * The FTP connection link.
	 * 
	 * @var FTP resource or false
	 */
	protected $connection = false;
	
	/**
	 * Constructor.
	 * 
	 * @param array $options
	 */
	public function __construct( array $options ) {
		parent::__construct();
		
		// Check if possible to use ftp functions.
		if ( !extension_loaded( 'ftp' ) ) {
			$this->addError( 'deploy-ftp-not-loaded' );
			return false;
		}
		
		// Check for missing required options.
		if ( !array_key_exists( 'username', $options ) ) {
			$this->addError( 'deploy-ftp-username-required' );
		}
		
		if ( !array_key_exists( 'password', $options ) ) {
			$this->addError( 'deploy-ftp-password-required' );
		}	

		if ( !array_key_exists( 'hostname', $options ) ) {
			$this->addError( 'deploy-ftp-hostname-required' );
		}			
		
		// Set default option values for those not provided.
		if ( !array_key_exists( 'port', $options ) ) {
			$options['port'] = 21;
		}
		
		if ( !array_key_exists( 'timeout', $options ) ) {
			$options['timeout'] = 240;
		}		
		
		// Other option handling.
		$options['ssl'] = array_key_exists( 'connection_type', $options ) && $options['connection_type'] == 'ftps';
		
		// Store the options.
		$this->options = $options;
	}
	
	/**
	 * @see Filesystem::connect
	 */
	public function connect() {
		// Attempt to create a connection, either with ssl or without.
		if ( $this->options['ssl'] && function_exists( 'ftp_ssl_connect' ) ) {
			wfSuppressWarnings();
			$this->connection = ftp_ssl_connect( $this->options['hostname'], $this->options['port'], $this->options['timeout'] );
			wfRestoreWarnings();			
		}
		else {
			// If this is true, ftp_ssl_connect was not defined, so add an error.
			if ( $this->options['ssl'] ) {
				$this->addError( 'deploy-ftp-ssl-not-loaded' );
			}
			
			wfSuppressWarnings();
			$this->connection = ftp_connect( $this->options['hostname'], $this->options['port'], $this->options['timeout'] );
			wfRestoreWarnings();			
		}
		
		// Check if a connection has been established.
		if ( !$this->connection ) {
			$this->addErrorMessage( wfMsgExt( 'deploy-ftp-connect-failed', 'parsemag', $this->options['hostname'], $this->options['port'] ) );
			return false;
		}
		
		// Attempt to set the connection to use passive FTP.
		wfSuppressWarnings();
		ftp_pasv( $this->connection, true );		
		wfRestoreWarnings();		

		// Make sure the timeout is at least as much as the option.
		wfSuppressWarnings();
		if ( ftp_get_option( $this->connection, FTP_TIMEOUT_SEC ) < $this->options['timeout'] ) {
			ftp_set_option( $this->connection, FTP_TIMEOUT_SEC, $this->options['timeout'] );
		}		
		wfRestoreWarnings();		
		
		return true;
	}
	
	/**
	 * @see Filesystem::changeDir
	 */
	public function changeDir( $dir ) {
		wfSuppressWarnings();
		$result = (bool)ftp_chdir( $this->connection, $dir );
		wfRestoreWarnings();		
		return $result;
	}

	/**
	 * @see Filesystem::changeFileGroup
	 */
	public function changeFileGroup( $file, $group, $recursive = false ) {
		return false;
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
			if ( !function_exists( 'ftp_chmod' ) ) {
				wfSuppressWarnings();
				$result = (bool)ftp_site( $this->connection, sprintf( 'CHMOD %o %s', $mode, $file ) );
				wfRestoreWarnings();				
				return $result;
			}
			else {
				wfSuppressWarnings();
				$result = (bool)ftp_chmod( $this->connection, $mode, $file );
				wfRestoreWarnings();				
				return $result;
			}
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
		return false;
	}

	/**
	 * @see Filesystem::delete
	 */
	public function delete( $path, $recursive = false ) {
		if ( empty( $path ) ) {
			return false;
		}
			
		if ( $this->isFile( $path ) ) {
			wfSuppressWarnings();
			$result = (bool)ftp_delete( $this->connection, $path );
			wfRestoreWarnings();			
			return $result;
		}
			
		if ( !$recursive ) {
			wfSuppressWarnings();
			$result = (bool)ftp_rmdir( $this->connection, $path );
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

		if ( $success && $this->exists( $path ) ) {
			wfSuppressWarnings();
			$ftp_rmdir = ftp_rmdir( $this->connection, $path );
			wfRestoreWarnings();

			if ( !$ftp_rmdir ) {
				$success = false;
			} 
		}
		
		return $success;
	}

	/**
	 * @see Filesystem::doCopy
	 */
	protected function doCopy( $from, $to ) {
		$content = $this->getContents( $from );
		
		if ( $content === false ) {
			return false;
		}
			
		return $this->writeToFile( $to, $content );		
	}

	/**
	 * @see Filesystem::doMove
	 */
	protected function doMove( $from, $to, $overwrite ) {
		wfSuppressWarnings();
		$result = (bool)ftp_rename( $this->connection, $from, $to );
		wfRestoreWarnings();		
		return $result;
	}

	/**
	 * @see Filesystem::exists
	 */
	public function exists( $file ) {
		wfSuppressWarnings();
		$list = ftp_nlist( $this->connection, $file );
		wfRestoreWarnings();		
		return !empty( $list );		
	}

	/**
	 * @see Filesystem::getChmod
	 */
	public function getChmod( $file ) {
		$dir = $this->listDir( $file );
		return $dir[$file]['permsn'];		
	}

	/**
	 * @see Filesystem::getContents
	 */
	public function getContents( $file ) {
		$type = FTP_BINARY;

		// TODO: port wp_tempnam
		die( __METHOD__ . ' TODO: port wp_tempnam' );
		$tempFileName = wp_tempnam( $file );
		$temp = fopen( $tempFileName , 'w+' );

		if ( !$temp ) {
			return false;
		}
			
		wfSuppressWarnings();
		$ftp_fget = ftp_fget( $this->connection, $temp, $file, $type );
		wfRestoreWarnings();
				
		if ( !$ftp_fget ) {
			return false;
		}

		// Skip back to the start of the file being written to.
		fseek( $temp, 0 ); 
		
		$contents = array();

		while ( !feof( $temp ) ) {
			$contents[] = fread( $temp, 8192 );
		}

		fclose( $temp );
		unlink( $tempFileName );
		
		return implode( '', $contents );		
	}

	/**
	 * @see Filesystem::getCurrentWorkingDir
	 */
	public function getCurrentWorkingDir() {
		wfSuppressWarnings();
		$result = ftp_pwd( $this->connection );
		wfRestoreWarnings();		
		return $result;			
	}

	/**
	 * @see Filesystem::getGroup
	 */
	public function getGroup( $file ) {
		$dir = $this->listDir( $file );
		return $dir[$file]['group'];		
	}

	/**
	 * @see Filesystem::getModificationTime
	 */
	public function getModificationTime( $file ) {
		return ftp_mdtm( $this->connection, $file );
	}

	/**
	 * @see Filesystem::getOwner
	 */
	public function getOwner( $file ) {
		$dir = $this->listDir( $file );
		return $dir[$file]['owner'];		
	}

	/**
	 * @see Filesystem::getSize
	 */
	public function getSize( $file ) {
		return ftp_size( $this->connection, $file );
	}

	/**
	 * @see Filesystem::isDir
	 */
	public function isDir( $path ) {
		$cwd = $this->getCurrentWorkingDir();
		wfSuppressWarnings();
		$result = ftp_chdir( $this->connection, rtrim( $path, '/' ) . '/' );
		wfRestoreWarnings();
		
		if ( $result && $path == $this->getCurrentWorkingDir() || $this->getCurrentWorkingDir() != $cwd ) {
			wfSuppressWarnings();
			ftp_chdir( $this->connection, $cwd );
			wfRestoreWarnings();
			return true;
		}
		
		return false;		
	}

	/**
	 * @see Filesystem::isFile
	 */
	public function isFile( $path ) {
		return $this->exists( $path ) && !$this->isDir( $path );
	}

	/**
	 * @see Filesystem::isReadable
	 * 
	 * TODO
	 */
	public function isReadable( $file ) {
		return true;
	}

	/**
	 * @see Filesystem::isWritable
	 * 
	 * TODO
	 */
	public function isWritable( $file ) {
		return true;
	}

	/**
	 * @see Filesystem::listDir
	 */
	public function listDir( $path, $includeHidden = true, $recursive = false ) {
		if ( $this->isFile( $path ) ) {
			$limit_file = basename( $path );
			$path = dirname( $path );
		}
		else {
			$limit_file = false;
		}
		
		wfSuppressWarnings();
		$ftp_chdir = ftp_chdir( $this->connection, $path );
		wfRestoreWarnings();
		
		if ( !$ftp_chdir ) {
			return false;
		}
		
		wfSuppressWarnings();
		$pwd = ftp_pwd( $this->connection );
		$list = ftp_rawlist( $this->connection, '-a', false );
		ftp_chdir( $this->connection, $pwd );
		wfRestoreWarnings();
		
		if ( empty( $list ) ) {
			return false;
		}
			
		$dirlist = array();
		
		foreach ( $list as $k => $v ) {
			$entry = $this->parseListing( $v );
			
			if ( empty( $entry ) 
				|| ( '.' == $entry['name'] || '..' == $entry['name'] )
				|| ( !$includeHidden && '.' == $entry['name'][0] ) 
				|| ( $limit_file && $entry['name'] != $limit_file ) ) {
					continue;
			}

			$dirlist[ $entry['name'] ] = $entry;
		}

		$ret = array();
		
		foreach ( (array)$dirlist as $struc ) {
			if ( 'd' == $struc['type'] ) {
				if ( $recursive ) {
					$struc['files'] = $this->listDir( $path . '/' . $struc['name'], $includeHidden, $recursive );
				}					
				else {
					$struc['files'] = array();
				}
			}

			$ret[$struc['name']] = $struc;
		}
		
		return $ret;		
	}
	
	/**
	 * @see Filesystem::makeDir
	 */
	public function makeDir( $path, $chmod = false, $chown = false, $chgrp = false ) {
		wfSuppressWarnings();
		$ftp_mkdir = ftp_mkdir( $this->connection, $path );
		wfRestoreWarnings();
		
		if ( !$ftp_mkdir ) {
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
		return false;
	}

	/**
	 * @see Filesystem::writeToFile
	 */
	public function writeToFile( $file, $contents, $mode = false  ) {
		$tempfile = wp_tempnam( $file );
		$temp = fopen( $tempfile, 'w+' );
		
		if ( !$temp ) {
			return false;
		}

		fwrite( $temp, $contents );
		
		// Skip back to the start of the file being written to
		fseek( $temp, 0 );

		wfSuppressWarnings();
		$ret = ftp_fput( $this->connection, $file, $temp, $this->isBinary( $contents ) ? FTP_BINARY : FTP_ASCII );
		wfRestoreWarnings();
		
		fclose( $temp );
		unlink( $tempfile );

		$this->chmod( $file, $mode );

		return $ret;		
	}	
	
	/**
	 * Function copied from wp-admin/includes/class-wp-filesystem-ftpext.php in WP 3.0.
	 * Only made it conform to the general MW guidelines, might still be messy at places though.
	 */
	protected function parseListing( $line ) {
		static $is_windows;
		
		if ( is_null( $is_windows ) ) {
			$is_windows = stripos( ftp_systype( $this->connection ), 'win' ) !== false;
		}

		if ( $is_windows && preg_match( '/([0-9]{2})-([0-9]{2})-([0-9]{2}) +([0-9]{2}):([0-9]{2})(AM|PM) +([0-9]+|<DIR>) +(.+)/', $line, $lucifer ) ) {
			$b = array();
			
			if ( $lucifer[3] < 70 ) {
				$lucifer[3] += 2000;
			}
			else {
				$lucifer[3] += 1900; // 4 digit year fix
			}
				
			$b['isdir'] = ( $lucifer[7] == '<DIR>' );
			$b['type'] = $b['isdir'] ? 'd' : 'f';
			$b['size'] = $lucifer[7];
			$b['month'] = $lucifer[1];
			$b['day'] = $lucifer[2];
			$b['year'] = $lucifer[3];
			$b['hour'] = $lucifer[4];
			$b['minute'] = $lucifer[5];
			wfSuppressWarnings();
			$b['time'] = mktime( $lucifer[4] + (strcasecmp($lucifer[6], 'PM' ) == 0 ? 12 : 0), $lucifer[5], 0, $lucifer[1], $lucifer[2], $lucifer[3] );
			wfRestoreWarnings();
			$b['am/pm'] = $lucifer[6];
			$b['name'] = $lucifer[8];
		} elseif ( !$is_windows && $lucifer = preg_split( '/[ ]/', $line, 9, PREG_SPLIT_NO_EMPTY ) ) {
			//echo $line."\n";
			
			$lcount = count($lucifer);
			
			if ( $lcount < 8 ) {
				return '';
			}
				
			$b = array();
			$b['isdir'] = $lucifer[0]{0} === 'd';
			$b['islink'] = $lucifer[0]{0} === 'l';
			if ( $b['isdir'] ) {
				$b['type'] = 'd';
			}
			elseif ( $b['islink'] ) {
				$b['type'] = 'l';
			}	
			else {
				$b['type'] = 'f';
			}
			$b['perms'] = $lucifer[0];
			$b['number'] = $lucifer[1];
			$b['owner'] = $lucifer[2];
			$b['group'] = $lucifer[3];
			$b['size'] = $lucifer[4];
			
			if ( $lcount == 8 ) {
				sscanf( $lucifer[5], '%d-%d-%d', $b['year'], $b['month'], $b['day'] );
				sscanf( $lucifer[6], '%d:%d', $b['hour'], $b['minute'] );
				wfSuppressWarnings();
				$b['time'] = mktime( $b['hour'], $b['minute'], 0, $b['month'], $b['day'], $b['year'] );
				wfRestoreWarnings();
				$b['name'] = $lucifer[7];
			} else {
				$b['month'] = $lucifer[5];
				$b['day'] = $lucifer[6];
				
				if ( preg_match( '/([0-9]{2}):([0-9]{2})/', $lucifer[7], $l2 ) ) {
					$b['year'] = date( 'Y' );
					$b['hour'] = $l2[1];
					$b['minute'] = $l2[2];
				} else {
					$b['year'] = $lucifer[7];
					$b['hour'] = 0;
					$b['minute'] = 0;
				}
				
				$b['time'] = strtotime( sprintf( '%d %s %d %02d:%02d', $b['day'], $b['month'], $b['year'], $b['hour'], $b['minute'] ) );
				$b['name'] = $lucifer[8];
			}
		}

		return $b;
	} 
		
}