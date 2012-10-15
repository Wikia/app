<?php


abstract class SubversionAdaptor {
	/**
	 * @var string
	 */
	protected $mRepoPath;

	/**
	 * @param $repo string
	 * @return SubversionAdaptor
	 */
	public static function newFromRepo( $repo ) {
		global $wgSubversionProxy, $wgSubversionProxyTimeout;
		if ( $wgSubversionProxy ) {
			return new SubversionProxy( $repo, $wgSubversionProxy, $wgSubversionProxyTimeout );
		} elseif ( function_exists( 'svn_log' ) ) {
			return new SubversionPecl( $repo );
		} else {
			return new SubversionShell( $repo );
		}
	}

	/**
	 * @param $repo String Path to SVN Repo
	 */
	function __construct( $repoPath ) {
		$this->mRepoPath = $repoPath;
	}

	abstract function canConnect();

	abstract function getFile( $path, $rev = null );

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
	abstract function getLog( $path, $startRev = null, $endRev = null );

	protected function _rev( $rev, $default ) {
		if ( $rev === null ) {
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

	function __construct( $repoPath ) {
		parent::__construct( $repoPath );
		global $wgSubversionUser, $wgSubversionPassword;
		if ( $wgSubversionUser ) {
			svn_auth_set_parameter( SVN_AUTH_PARAM_DEFAULT_USERNAME, $wgSubversionUser );
			svn_auth_set_parameter( SVN_AUTH_PARAM_DEFAULT_PASSWORD, $wgSubversionPassword );
		}
	}

	/**
	 * Just return true for now. svn_info() is too slow to be useful...
	 *
	 * Using undocumented svn_info function. Looking at the source, this has
	 * existed since version 0.3 of the Pecl extension (per release notes).
	 * Nobody ever bothered filling in the documentation on php.net though.
	 * The function returns a big array of a bunch of info about the repository
	 * It throws a warning if the repository does not exist.
	 */
	function canConnect() {
		//wfSuppressWarnings();
		//$result = svn_info( $this->mRepoPath );
		//wfRestoreWarnings();
		return true;
	}

	function getFile( $path, $rev = null ) {
		return svn_cat( $this->mRepoPath . $path, $rev );
	}

	function getDiff( $path, $rev1, $rev2 ) {
		list( $fout, $ferr ) = svn_diff(
			$this->mRepoPath . $path, $rev1,
			$this->mRepoPath . $path, $rev2 );

		if ( $fout ) {
			// We have to read out the file descriptors. :P
			$out = '';
			while ( !feof( $fout ) ) {
				$out .= fgets( $fout );
			}
			fclose( $fout );
			fclose( $ferr );

			return $out;
		} else {
			return new MWException( "Diffing error" );
		}
	}

	function getDirList( $path, $rev = null ) {
		return svn_ls( $this->mRepoPath . $path,
			$this->_rev( $rev, SVN_REVISION_HEAD ) );
	}

	function getLog( $path, $startRev = null, $endRev = null ) {
		wfSuppressWarnings();
		$log = svn_log( $this->mRepoPath . $path,
			$this->_rev( $startRev, SVN_REVISION_INITIAL ),
			$this->_rev( $endRev, SVN_REVISION_HEAD ) );
		wfRestoreWarnings();
		return $log;
	}
}

/**
 * Using the thingy-bobber
 */
class SubversionShell extends SubversionAdaptor {
	const MIN_MEMORY = 204800;

	function __construct( $repo ) {
		parent::__construct( $repo );
		global $wgMaxShellMemory;
		if( $wgMaxShellMemory < self::MIN_MEMORY ) {
			$wgMaxShellMemory = self::MIN_MEMORY;
			wfDebug( __METHOD__ . " raised wgMaxShellMemory to $wgMaxShellMemory\n" );
		}
	}

	function canConnect() {
		$command = sprintf(
			"svn info %s %s",
			$this->getExtraArgs(),
			wfEscapeShellArg( $this->mRepoPath ) );

		$result = wfShellExec( $command );
		if ( $result == "" ) {
			return false;
		} elseif ( strpos( $result, "No repository found" ) !== false ) {
			return false;
		} else {
			return true;
		}
	}

	function getFile( $path, $rev = null ) {
		if ( $rev ) {
			$path .= "@$rev";
		}
		$command = sprintf(
			"svn cat %s %s",
			$this->getExtraArgs(),
			wfEscapeShellArg( $this->mRepoPath . $path ) );

		return wfShellExec( $command );
	}

	function getDiff( $path, $rev1, $rev2 ) {
		$command = sprintf(
			"svn diff -r%d:%d %s %s",
			intval( $rev1 ),
			intval( $rev2 ),
			$this->getExtraArgs(),
			wfEscapeShellArg( $this->mRepoPath . $path ) );

		return wfShellExec( $command );
	}

	function getLog( $path, $startRev = null, $endRev = null ) {
		$lang = wfIsWindows() ? "" : "LC_ALL=en_US.utf-8 ";
		$command = sprintf(
			"{$lang}svn log -v -r%s:%s %s %s",
			wfEscapeShellArg( $this->_rev( $startRev, 'BASE' ) ),
			wfEscapeShellArg( $this->_rev( $endRev, 'HEAD' ) ),
			$this->getExtraArgs(),
			wfEscapeShellArg( $this->mRepoPath . $path ) );

		$lines = explode( "\n", wfShellExec( $command ) );
		$out = array();

		$divider = str_repeat( '-', 72 );
		$formats = array(
			'rev' => '/^r(\d+)$/',
			'author' => '/^(.*)$/',
			'date' => '/^(?:(.*?) )?\(.*\)$/', // account for '(no date)'
			'lines' => '/^(\d+) lines?$/',
		);
		$state = "start";
		foreach ( $lines as $line ) {
			$line = rtrim( $line );

			switch( $state ) {
			case "start":
				if ( $line == $divider ) {
					$state = "revdata";
					break;
				} else {
					return $out;
					# throw new MWException( "Unexpected start line: $line" );
				}
			case "revdata":
				if ( $line == "" ) {
					$state = "done";
					break;
				}
				$data = array();
				$bits = explode( " | ", $line );
				$i = 0;
				foreach ( $formats as $key => $regex ) {
					$text = $bits[$i++];
					$matches = array();
					if ( preg_match( $regex, $text, $matches ) ) {
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
				if ( $line == "Changed paths:" ) { // broken when svn messages are not in English
					$state = "path";
				} elseif ( $line == "" ) {
					// No changed paths?
					$state = "msg";
				} else {
					throw new MWException(
						"Expected 'Changed paths:' or '', got '$line'" );
				}
				break;
			case "path":
				if ( $line == "" ) {
					// Out of paths. Move on to the message...
					$state = 'msg';
				} else {
					$matches = array();
					if ( preg_match( '/^   (.) (.*)$/', $line, $matches ) ) {
						$data['paths'][] = array(
							'action' => $matches[1],
							'path' => $matches[2] );
					}
				}
				break;
			case "msg":
				$data['msg'] .= $line;
				if ( --$data['lines'] ) {
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
			"svn list --xml -r%s %s %s",
			wfEscapeShellArg( $this->_rev( $rev, 'HEAD' ) ),
			$this->getExtraArgs(),
			wfEscapeShellArg( $this->mRepoPath . $path ) );
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
		global $wgSubversionOptions, $wgSubversionUser, $wgSubversionPassword;
		$args = $wgSubversionOptions;
		if ( $wgSubversionUser ) {
			$args .= ' --username ' . wfEscapeShellArg( $wgSubversionUser )
				. ' --password ' . wfEscapeShellArg( $wgSubversionPassword );
		}
		return $args;
	}
}

/**
 * Using a remote JSON proxy
 */
class SubversionProxy extends SubversionAdaptor {
	function __construct( $repo, $proxy, $timeout = 30 ) {
		parent::__construct( $repo );
		$this->mProxy = $proxy;
		$this->mTimeout = $timeout;
	}

	function canConnect() {
		// TODO!
		return true;
	}

	function getFile( $path, $rev = null ) {
		throw new MWException( "NYI" );
	}

	function getDiff( $path, $rev1, $rev2 ) {
		return $this->_proxy( array(
			'action' => 'diff',
			'base' => $this->mRepoPath,
			'path' => $path,
			'rev1' => $rev1,
			'rev2' => $rev2 ) );
	}

	function getLog( $path, $startRev = null, $endRev = null ) {
		return $this->_proxy( array(
			'action' => 'log',
			'base' => $this->mRepoPath,
			'path' => $path,
			'start' => $startRev,
			'end' => $endRev ) );
	}

	function getDirList( $path, $rev = null ) {
		return $this->_proxy( array(
			'action' => 'list',
			'base' => $this->mRepoPath,
			'path' => $path,
			'rev' => $rev ) );
	}

	protected function _proxy( $params ) {
		foreach ( $params as $key => $val ) {
			if ( is_null( $val ) ) {
				// Don't pass nulls to remote
				unset( $params[$key] );
			}
		}
		$target = $this->mProxy . '?' . wfArrayToCgi( $params );
		$blob = Http::get( $target, $this->mTimeout );
		if ( $blob === false ) {
			throw new MWException( "SVN proxy error" );
		}
		$data = unserialize( $blob );
		return $data;
	}
}
