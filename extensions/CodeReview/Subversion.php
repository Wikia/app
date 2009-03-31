<?php
if (!defined('MEDIAWIKI')) die();

abstract class SubversionAdaptor {
	protected $mRepo;

	public static function newFromRepo( $repo ) {
		global $wgSubversionProxy, $wgSubversionProxyTimeout;
		if( $wgSubversionProxy ) {
			return new SubversionProxy( $repo, $wgSubversionProxy, $wgSubversionProxyTimeout );
		} elseif( function_exists( 'svn_log' ) ) {
			return new SubversionPecl( $repo );
		} else {
			return new SubversionShell( $repo );
		}
	}

	function __construct( $repo ) {
		$this->mRepo = $repo;
	}

	abstract function getFile( $path, $rev=null );

	abstract function getDiff( $path, $rev1, $rev2 );

	abstract function getDirList( $path, $rev = null );

	/*
	  array of array(
		'rev' => 123,
		'author' => 'myname',
		'msg' => 'log message'
		'date' => '8601 date',
		'paths' => array(
			array(
				'action' => one of M, A, D, R
				'path' => repo URL of file,
			),
			...
		)
	  */
	abstract function getLog( $path, $startRev=null, $endRev=null );

	protected function _rev( $rev, $default ) {
		if( $rev === null ) {
			return $default;
		} else {
			return intval( $rev );
		}
	}
}

/**
 * Using the SVN PECL extension...
 */
class SubversionPecl extends SubversionAdaptor {
	function getFile( $path, $rev=null ) {
		return svn_cat( $this->mRepo . $path, $rev );
	}

	function getDiff( $path, $rev1, $rev2 ) {
		list( $fout, $ferr ) = svn_diff(
			$this->mRepo . $path, $rev1,
			$this->mRepo . $path, $rev2 );

		if( $fout ) {
			// We have to read out the file descriptors. :P
			$out = '';
			while( !feof( $fout ) ) {
				$out .= fgets( $fout );
			}
			fclose( $fout );
			fclose( $ferr );
	
			return $out;
		} else {
			return new MWException("Diffing error");
		}
	}

	function getDirList( $path, $rev = null ) {
		return svn_ls( $this->mRepo . $path,
			$this->_rev( $rev, SVN_REVISION_HEAD ) );
	}

	function getLog( $path, $startRev=null, $endRev=null ) {
		return svn_log( $this->mRepo . $path,
			$this->_rev( $startRev, SVN_REVISION_INITIAL ),
			$this->_rev( $endRev, SVN_REVISION_HEAD ) );
	}
}

/**
 * Using the thingy-bobber
 */
class SubversionShell extends SubversionAdaptor {
	function getFile( $path, $rev=null ) {
		if( $rev )
			$path .= "@$rev";
		$command = sprintf(
			"svn cat --non-interactive %s %s",
			$this->getExtraArgs(),
			wfEscapeShellArg( $this->mRepo . $path ) );

		return wfShellExec( $command );
	}

	function getDiff( $path, $rev1, $rev2 ) {
		$command = sprintf(
			"svn diff -r%d:%d --non-interactive %s %s",
			intval( $rev1 ),
			intval( $rev2 ),
			$this->getExtraArgs(),
			wfEscapeShellArg( $this->mRepo . $path ) );

		return wfShellExec( $command );
	}

	function getLog( $path, $startRev=null, $endRev=null ) {
		$lang = wfIsWindows() ? "" : "LC_ALL=en_US.utf-8 ";
		$command = sprintf(
			"{$lang}svn log -v -r%s:%s --non-interactive %s %s",
			wfEscapeShellArg( $this->_rev( $startRev, 'BASE' ) ),
			wfEscapeShellArg( $this->_rev( $endRev, 'HEAD' ) ),
			$this->getExtraArgs(),
			wfEscapeShellArg( $this->mRepo . $path ) );

		$lines = explode( "\n", wfShellExec( $command ) );
		$out = array();

		$divider = str_repeat( '-', 72 );
		$formats = array(
			'rev' => '/^r(\d+)$/',
			'author' => '/^(.*)$/',
			'date' => '/^(.*?) \(.*\)$/',
			'lines' => '/^(\d+) lines?$/',
		);
		$state = "start";
		foreach( $lines as $line ) {
			$line = rtrim( $line );

			switch( $state ) {
			case "start":
				if( $line == $divider ) {
					$state = "revdata";
					break;
				} else {
					return $out;
					#throw new MWException( "Unexpected start line: $line" );
				}
			case "revdata":
				if( $line == "" ) {
					$state = "done";
					break;
				}
				$data = array();
				$bits = explode( " | ", $line );
				$i = 0;
				foreach( $formats as $key => $regex ) {
					$text = $bits[$i++];
					if( preg_match( $regex, $text, $matches ) ) {
						$data[$key] = $matches[1];
					} else {
						throw new MWException(
							"Unexpected format for $key in '$text'" );
					}
				}
				$data['msg'] = '';
				$data['paths'] = array();
				$state = 'changedpaths';
				break;
			case "changedpaths":
				if( $line == "Changed paths:" ) { // broken when svn messages are not in English
					$state = "path";
				} elseif( $line == "" ) {
					// No changed paths?
					$state = "msg";
				} else {
					throw new MWException(
						"Expected 'Changed paths:' or '', got '$line'" );
				}
				break;
			case "path":
				if( $line == "" ) {
					// Out of paths. Move on to the message...
					$state = 'msg';
				} else {
					if( preg_match( '/^   (.) (.*)$/', $line, $matches ) ) {
						$data['paths'][] = array(
							'action' => $matches[1],
							'path' => $matches[2] );
					}
				}
				break;
			case "msg":
				$data['msg'] .= $line;
				if( --$data['lines'] ) {
					$data['msg'] .= "\n";
				} else {
					unset( $data['lines'] );
					$out[] = $data;
					$state = "start";
				}
				break;
			case "done":
				throw new MWException( "Unexpected input after end: $line" );
			default:
				throw new MWException( "Invalid state '$state'" );
			}
		}

		return $out;
	}
	
	function getDirList( $path, $rev = null ) {
		$command = sprintf(
			"svn list --xml -r%s --non-interactive %s %s",
			wfEscapeShellArg( $this->_rev( $rev, 'HEAD' ) ),
			$this->getExtraArgs(),
			wfEscapeShellArg( $this->mRepo . $path ) );
		$document = new DOMDocument(); 
		
		if ( !@$document->loadXML( wfShellExec( $command ) ) )
			// svn list --xml returns invalid XML if the file does not exist
			// FIXME: report bug upstream
			return false;
		
		$entries = $document->getElementsByTagName( 'entry' );
		$result = array();
		foreach ( $entries as $entry ) {
			$item = array();
			$item['type'] = $entry->getAttribute( 'kind' );
			foreach ( $entry->childNodes as $child ) {
				switch ( $child->nodeName ) {
				case 'name':
					$item['name'] = $child->textContent;
					break;
				case 'size':
					$item['size'] = intval( $child->textContent ); 
					break;
				case 'commit':
					$item['created_rev'] = intval( $child->getAttribute( 'revision' ) );
					foreach ( $child->childNodes as $commitEntry ) {
						switch ( $commitEntry->nodeName ) {
						case 'author':
							$item['last_author'] = $commitEntry->textContent;
							break;
						case 'date':
							$item['time_t'] = wfTimestamp( TS_UNIX, $commitEntry->textContent ); 
							break;
						}
					}
					break;	
				}
			}
			$result[] = $item;
		}
		return $result;
	}
	
	/**
	 * Returns a string of extra arguments to be passed into the shell commands
	 */
	private function getExtraArgs() {
		global $wgSubversionUser, $wgSubversionPassword;
		if($wgSubversionUser) {
			return '--username ' . wfEscapeShellArg($wgSubversionUser)
				. ' --password ' . wfEscapeShellArg($wgSubversionPassword);
		}
		return '';
	}
}

/**
 * Using a remote JSON proxy
 */
class SubversionProxy extends SubversionAdaptor {
	function __construct( $repo, $proxy, $timeout=30 ) {
		parent::__construct( $repo );
		$this->mProxy = $proxy;
		$this->mTimeout = $timeout;
	}
	
	function getFile( $path, $rev=null ) {
		throw new MWException( "NYI" );
	}

	function getDiff( $path, $rev1, $rev2 ) {
		return $this->_proxy( array(
			'action' => 'diff',
			'path' => $path,
			'rev1' => $rev1,
			'rev2' => $rev2 ) );
	}

	function getLog( $path, $startRev=null, $endRev=null ) {
		return $this->_proxy( array(
			'action' => 'log',
			'path' => $path,
			'start' => $startRev,
			'end' => $endRev ) );
	}
	
	function getDirList( $path, $rev = null ) {
		return $this->_proxy( array(
			'action' => 'list',
			'path' => $path,
			'rev' => $rev ) );
	}
	
	protected function _proxy( $params ) {
		foreach( $params as $key => $val ) {
			if( is_null( $val ) ) {
				// Don't pass nulls to remote
				unset( $params[$key] );
			}
		}
		$target = $this->mProxy . '?' . wfArrayToCgi( $params );
		$blob = Http::get( $target, $this->mTimeout );
		if( $blob === false ) {
			throw new MWException( "SVN proxy error" );
		}
		$data = unserialize( $blob );
		return $data;
	}
}
