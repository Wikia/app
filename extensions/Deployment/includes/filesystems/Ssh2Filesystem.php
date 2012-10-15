<?php

/**
 * File holding the Ssh2Filesystem class.
 *
 * @file Ssh2Filesystem.php
 * @ingroup Deployment
 * @ingroup Filesystem
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Filesystem class for file and folder manipulation over SSH2.
 * 
 * @author Jeroen De Dauw
 */
class Ssh2Filesystem extends Filesystem {
	
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
	 * The SFTP connection link.
	 * 
	 * @var SSH2 SFTP resource
	 */
	protected $sftpConnection;	
	
	/**
	 * Indicates if public key authentication is used instead of a regular password.
	 * 
	 * @var boolean
	 */
	protected $publicKeyAuthentication;
	
	/**
	 * Constructor.
	 * 
	 * @param array $options
	 */
	public function __construct( array $options ) {
		parent::__construct();
		
		// Check if possible to use ssh2 functions.
		if ( !extension_loaded( 'ssh2' ) ) {
			$this->addError( 'deploy-ssh2-not-loaded' );
			return false;
		}
		
		// Check if function stream_get_contents is available.
		if ( !function_exists( 'stream_get_contents' ) ) {
			$this->addError( 'deploy-ssh2-no-stream-get-contents' );
			return false;
		}		
		
		// Check for missing required options.		
		if ( !array_key_exists( 'password', $options ) ) {
			$this->addError( 'deploy-ssh2-password-required' );
		}	

		if ( !array_key_exists( 'hostname', $options ) ) {
			$this->addError( 'deploy-ssh2-hostname-required' );
		}

		// TODO: validate that both keys are set (error if only one)
		$this->publicKeyAuthentication = array_key_exists( 'public_key', $options ) && array_key_exists( 'private_key', $options );
		
		if ( $this->publicKeyAuthentication ) {
			$options['hostkey'] = array( 'hostkey' => 'ssh-rsa' );
		}
		
		// Regular authentication needs a username.
		if ( !$this->publicKeyAuthentication && !array_key_exists( 'username', $options ) ) {
			$this->addError( 'deploy-ssh2-username-required' );
		}
		
		// Regular authentication needs a password.
		// TODO: if publick key: make sure the key is not empty
		if ( !$this->publicKeyAuthentication && !array_key_exists( 'password', $options ) ) {
			$this->addError( 'deploy-ssh2-password-required' );
		}		
		
		// Set default option values for those not provided.
		if ( !array_key_exists( 'port', $options ) ) {
			$options['port'] = 21;
		}
		
		if ( !array_key_exists( 'timeout', $options ) ) {
			$options['timeout'] = 240;
		}		
		
		// Store the options.
		$this->options = $options;		
	}
	
	/**
	 * @see Filesystem::connect
	 */
	public function connect() {
		if ( $this->publicKeyAuthentication ) {
			wfSuppressWarnings();
			$this->connection = ssh2_connect( $this->options['hostname'], $this->options['port'], $this->options['hostkey'] );
			wfRestoreWarnings();
		} else {
			wfSuppressWarnings();
			$this->connection = ssh2_connect( $this->options['hostname'], $this->options['port'] );
			wfRestoreWarnings();
		}

		if ( !$this->connection ) {
			$this->addErrorMessage( wfMsgExt( 'deploy-ssh2-connect-failed', 'parsemag', $this->options['hostname'], $this->options['port'] ) );
			return false;
		}

		if ( $this->publicKeyAuthentication ) {
			$ssh2_auth_pubkey_file = ssh2_auth_pubkey_file( $this->link, $this->options['username'], $this->options['public_key'], $this->options['private_key'], $this->options['password'] );
			
			if ( !$ssh2_auth_pubkey_file ) {
				$this->addErrorMessage( wfMsgExt( 'deploy-ssh2-key-authentication-failed', 'parsemag', $this->options['username'] ) );
				return false;
			}			

		} else {
			$ssh2_auth_password = ssh2_auth_password( $this->connection, $this->options['username'], $this->options['password'] );
			
			if ( !$ssh2_auth_password ) {
				$this->addErrorMessage( wfMsgExt( 'deploy-ssh2-password-authentication-failed', 'parsemag', $this->options['username'] ) );
				return false;
			}
		}

		$this->sftpConnection = ssh2_sftp( $this->connection );

		return true;		
	}
	
	/**
	 * @see Filesystem::changeDir
	 */
	public function changeDir( $dir ) {
		return $this->runCommand( 'cd ' . $dir );
	}

	/**
	 * @see Filesystem::changeFileGroup
	 */
	public function changeFileGroup( $file, $group, $recursive = false ) {
		// FIXME?		
		return $this->runCommandRecursivly( 'chgrp', $file, $recursive );		
	}

	/**
	 * @see Filesystem::chmod
	 */
	public function chmod( $file, $mode = false, $recursive = false ) {
		return $this->runCommandRecursivly( 'chmod', $file, $recursive, $mode );
	}

	/**
	 * @see Filesystem::chown
	 */
	public function chown( $file, $owner, $recursive = false ) {
		return $this->runCommandRecursivly( 'chown', $file, $recursive, $mode );
	}

	/**
	 * @see Filesystem::delete
	 */
	public function delete( $path, $recursive = false ) {
		if ( $this->isFile( $path ) ) {
			return ssh2_sftp_unlink( $this->sftp_link, $path );
		}
			
		if ( !$recursive ) {
			return ssh2_sftp_rmdir( $this->sftp_link, $path );
		}
			 
		$filelist = $this->listDir( $path );
		
		if ( is_array( $filelist ) ) {
			foreach ( $filelist as $filename => $fileinf ) {
				$this->delete( $path . '/' . $filename, $recursive );
			}
		}
		
		return ssh2_sftp_rmdir( $this->sftpConnection, $path );		
	}

	/**
	 * @see Filesystem::doCopy
	 */
	protected function doCopy( $source, $destination ) {
		$content = $this->get_contents( $source );
		
		if ( false === $content ) {
			return false;
		}
			
		return $this->writeToFile( $destination, $content );		
	}

	/**
	 * @see Filesystem::doMove
	 */
	protected function doMove( $source, $destination ) {
		wfSuppressWarnings();
		$ssh2_sftp_rename = ssh2_sftp_rename( $this->connection, $source, $destination );
		wfRestoreWarnings();
		return $ssh2_sftp_rename; 
	}

	/**
	 * @see Filesystem::exists
	 */
	public function exists( $file ) {
		return file_exists( 'ssh2.sftp://' . $this->sftpConnection . '/' . ltrim( $file, '/' ) );		
	}

	/**
	 * @see Filesystem::getChmod
	 */
	public function getChmod( $file ) {
		wfSuppressWarnings();
		$fileperms = fileperms( 'ssh2.sftp://' . $this->sftpConnection . '/' . ltrim( $file, '/' ) );
		wfRestoreWarnings();
		return substr( decoct( $fileperms ), 3 );
	}

	/**
	 * @see Filesystem::getContents
	 */
	public function getContents( $file ) {
		return file_get_contents( 'ssh2.sftp://' . $this->sftpConnection . '/' . ltrim( $file, '/' ) );
	}

	/**
	 * @see Filesystem::getCurrentWorkingDir
	 */
	public function getCurrentWorkingDir() {
		$cwd = $this->runCommand( 'pwd' );
		
		if ( $cwd ) {
			$cwd = rtrim( $cwd, '/' ) . '/';
		}
			
		return $cwd;		
	}

	/**
	 * @see Filesystem::getGroup
	 */
	public function getGroup( $file ) {
		wfSuppressWarnings();
		$gid = filegroup( 'ssh2.sftp://' . $this->sftpConnection . '/' . ltrim( $file, '/' ) );
		wfRestoreWarnings();
		
		if ( !$gid ) {
			return false;
		}
			
		if ( !function_exists( 'posix_getgrgid' ) ) {
			return $gid;
		}
			
		$groupArray = posix_getgrgid( $gid );
		return $groupArray['name'];		
	}

	/**
	 * @see Filesystem::getModificationTime
	 */
	public function getModificationTime( $file ) {
		return filemtime( 'ssh2.sftp://' . $this->sftpConnection . '/' . ltrim( $file, '/' ) );
	}

	/**
	 * @see Filesystem::getOwner
	 */
	public function getOwner( $file ) {
		wfSuppressWarnings();
		$owneruid = filegroup( 'ssh2.sftp://' . $this->sftpConnection . '/' . ltrim( $file, '/' ) );
		wfRestoreWarnings();
		
		if ( !$owneruid ) {
			return false;
		}
			
		if ( !function_exists( 'posix_getpwuid' ) ) {
			return $owneruid;
		}
			
		$ownerArray = posix_getpwuid( $owneruid );
		return $ownerArray['name'];			
	}

	/**
	 * @see Filesystem::getSize
	 */
	public function getSize( $file ) {
		return filesize( 'ssh2.sftp://' . $this->sftpConnection . '/' . ltrim( $file, '/' ) );
	}

	/**
	 * @see Filesystem::isDir
	 */
	public function isDir( $path ) {
		return is_dir( 'ssh2.sftp://' . $this->sftpConnection . '/' . ltrim( $path, '/' ) );
	}

	/**
	 * @see Filesystem::isFile
	 */
	public function isFile( $path ) {
		return is_file( 'ssh2.sftp://' . $this->sftpConnection . '/' . ltrim( $path, '/' ) );
	}

	/**
	 * @see Filesystem::isReadable
	 */
	public function isReadable( $file ) {
		return is_readable( 'ssh2.sftp://' . $this->sftpConnection . '/' . ltrim( $file, '/' ) );
	}

	/**
	 * @see Filesystem::isWritable
	 */
	public function isWritable( $file ) {
		return is_writable( 'ssh2.sftp://' . $this->sftpConnection . '/' . ltrim( $file, '/' ) );
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

		$ret = array();
		wfSuppressWarnings();
		$dir = dir( 'ssh2.sftp://' . $this->sftpConnection .'/' . ltrim( $path, '/' ) );
		wfRestoreWarnings();

		if ( !$dir ) {
			return false;
		}

		while ( ( $entry = $dir->read() ) !== false ) {
			$struc = array();
			$struc['name'] = $entry;

			if ( 
				( $struc['name'] == '.' || $struc['name'] == '..' ) 
				|| ( !$includeHidden && $struc['name'][0] == '.' )
				|| ( $limit_file && $struc['name'] != $limit_file )
				) {
					continue; // Do not care about these folders.
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
		unset( $dir );
		
		return $ret;		
	}

	/**
	 * @see Filesystem::makeDir
	 */
	public function makeDir( $path, $chmod = false, $chown = false, $chgrp = false ) {
		$path = rtrim( $path, '/' );
		
		if ( !$chmod ) {
			$chmod = FS_CHMOD_DIR;
		}
			
		if ( !ssh2_sftp_mkdir( $this->sftpConnection, $path, $chmod, true ) ) {
			return false;
		}
			
		if ( $chown ) {
			$this->chown( $path, $chown );
		}
			
		if ( $chgrp ) {
			$this->chgrp( $path, $chgrp );
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
	public function writeToFile( $file, $contents ) {
		$file = ltrim( $file, '/' );
		$ret = file_put_contents( 'ssh2.sftp://' . $this->sftpConnection . '/' . $file, $contents );

		$this->chmod( $file );

		return $ret !== false;		
	}	
	
	protected function  runCommandRecursivly( $command, $file, $recursive, $mode = false ) {
		if ( !$this->exists( $file ) ) {
			return false;
		}
		
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
		
		if ( !$recursive || !$this->isDir( $file ) ) {
			return $this->runCommand( $command . sprintf( 'chmod %o %s', $mode, escapeshellarg( $file ) ) );
		}
			
		return $this->runCommand( $command .sprintf( 'chmod -R %o %s', $mode, escapeshellarg( $file ) ) );		
	}
	
	/**
	 * Executes a command.
	 * 
	 * @param string $command
	 */
	protected function runCommand( $command ) {
		if ( !$this->connection ) {
			return false;
		}
		
		if ( $stream = ssh2_exec( $this->connection, $command ) ) {
			stream_set_blocking( $stream, true );
			stream_set_timeout( $stream, $this->options['timeout'] );
			
			$data = stream_get_contents( $stream );
			
			fclose( $stream );

			return $data;
		}
		else {
			$this->addErrorMessage( wfMsgExt( 'deploy-ssh2-command-failed', 'parsemag', $command ) );
			return false;			
		}
	}
	
}