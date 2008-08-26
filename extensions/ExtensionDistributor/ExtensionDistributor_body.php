<?php

class ExtensionDistributorPage extends SpecialPage {
	var $extensionList; // cached list of extensions

	function __construct() {
		parent::__construct( 'ExtensionDistributor' );
	}

	function execute( $subpage ) {
		global $wgExtDistTarDir, $wgExtDistWorkingCopy, $wgOut, $wgRequest;

		wfLoadExtensionMessages( 'ExtensionDistributor' );
		$this->setHeaders();

		if ( !$wgExtDistTarDir || !$wgExtDistWorkingCopy ) {
			$wgOut->addWikiMsg( 'extdist-not-configured' );
			return;
		}

		if ( $subpage ) {
			$parts = explode( '/', $subpage, 2 );
			if ( count( $parts ) == 1 ) {
				$parts[] = false;
			}
			list( $extension, $version ) = $parts;
		} else {
			$extension = $wgRequest->getVal( 'extdist_extension' );
			$version = $wgRequest->getVal( 'extdist_version' );
		}
		
		if ( !$extension ) {
			$this->showExtensionSelector();
			return;
		}

		$extensions = $this->getExtensionList();
		if( !in_array( $extension, $extensions['trunk'] ) ) {
			$wgOut->addWikiMsg( 'extdist-no-such-extension', $extension );
			$this->showExtensionSelector();
			return;
		}

		if ( !$version ) {
			$this->showVersionSelector( $extension );
			return;
		}

		if ( !isset( $extensions[$version] ) || !in_array( $extension, $extensions[$version] ) ) {
			$wgOut->addWikiMsg( 'extdist-no-such-version', $extension, $version );
			return;
		}

		$this->doDownload( $extension, $version );
	}

	function getExtensionList() {
		global $wgExtDistWorkingCopy, $wgExtDistBranches;

		if ( isset( $this->extensionList ) ) {
			return $this->extensionList;
		}

		$this->extensionList = array();
		foreach ( $wgExtDistBranches as $branchPath => $branch ) {
			$wc = "$wgExtDistWorkingCopy/$branchPath/extensions";
			$dir = opendir( $wc );
			if ( !$dir ) {
				return false;
			}

			$this->extensionList[$branchPath] = array();
			while ( false !== ($file = readdir( $dir )) ) {
				if ( substr( $file, 0, 1 ) == '.' ) {
					continue;
				}
				if ( !is_dir( "$wc/$file" ) ) {
					continue;
				}
				if ( file_exists( "$wc/$file/NO-DIST" ) ) {
					continue;
				}
				$this->extensionList[$branchPath][] = $file;
			}
			natcasesort( $this->extensionList[$branchPath] );
		}
		return $this->extensionList;
	}

	function getBranchName( $path ) {
		global $wgExtDistBranches;
		if ( !isset( $wgExtDistBranches[$path] ) ) {
			return false;
		}
		if ( isset( $wgExtDistBranches[$path]['msgName'] ) ) {
			return wfMsg( $wgExtDistBranches[$path]['msgName'] );
		} else {
			return $wgExtDistBranches[$path]['name'];
		}
	}

	function showExtensionSelector() {
		global $wgOut;

		$extensions = $this->getExtensionList();
		if ( $extensions === false ) {
			$wgOut->addWikiMsg( 'extdist-wc-missing' );
			return;
		}
		if ( !$extensions['trunk'] ) {
			$wgOut->addWikiMsg( 'extdist-wc-empty' );
			return;
		}

		$wgOut->addWikiMsg( 'extdist-choose-extension' );
		$wgOut->addHTML( 
			Xml::openElement( 'form', array( 
				'action' => $this->getTitle()->getLocalUrl(),
				'method' => 'POST' ) ) .
			"<select name=\"extdist_extension\">\n" .
			"<option value=''></option\n"
		);

		foreach ( $extensions['trunk'] as $extension ) {
			$wgOut->addHTML( Xml::element( 'option', array( 'value' => $extension ), $extension ) . "\n" );
		}

		$wgOut->addHTML( "</select>" .
			Xml::element( 'input', array( 'type' => 'submit', 'name' => 'extdist_submit', 
				'value' => wfMsg( 'extdist-submit-extension' ) ) ) .
			"</form>\n" );
	}

	function showVersionSelector( $extensionName ) {
		global $wgOut, $wgExtDistBranches;
		$extensions = $this->getExtensionList();

		$versions = array();
		foreach ( $wgExtDistBranches as $branchPath => $branch ) {
			if ( !in_array( $extensionName, $extensions[$branchPath] ) ) {
				continue;
			}

			if ( isset( $branch['msgName'] ) ) {
				$branchName = wfMsg( $branch['msgName'] );
			} else {
				$branchName = $branch['name'];
			}
			$versions[$branchPath] = $branchName;
		}

		if ( !$versions ) {
			$wgOut->addWikiMsg( 'extdist-no-versions', $extensionName );
			$this->showExtensionSelector();
			return;
		}

		$wgOut->addWikiMsg( 'extdist-choose-version', $extensionName );
		$wgOut->addHTML( 
			Xml::openElement( 'form', array(
				'action' => $this->getTitle()->getLocalUrl(),
				'method' => 'POST' ) ) .
			Xml::element( 'input' , array( 'type' => 'hidden', 
				'name' => 'extdist_extension', 'value' => $extensionName ) ) .
			"<select name=\"extdist_version\">\n" );
		foreach ( $versions as $branchPath => $branchName ) {
			$wgOut->addHTML( Xml::element( 'option', 
				array( 'value' => $branchPath ), $branchName ) . "\n" );
		}
		$wgOut->addHTML( "</select>" .
			Xml::element( 'input', array( 'type' => 'submit', 'name' => 'extdist_submit', 
				'value' => wfMsg( 'extdist-submit-version' ) ) ) . 
			"</form>\n"
	   	);
	}

	function doDownload( $extension, $version ) {
		global $wgExtDistWorkingCopy, $wgExtDistTarDir, $wgExtDistBranches, 
			$wgOut, $wgExtDistTarUrl, $wgExtDistRemoteClient;

		if ( $wgExtDistRemoteClient ) {
			$rev = $this->updateAndGetRevisionRemote( $extension, $version );
		} else {
			$rev = $this->updateAndGetRevisionLocal( $extension, $version );
		}
		if ( $rev === false ) {
			// Error already displayed
			return;
		}

		// Determine tar name
		$cleanName = str_replace( '/', '_', $extension );
		$versionName = $wgExtDistBranches[$version]['tarLabel'];
		$tarName = "$cleanName-$versionName-r$rev.tar.gz";
		$tarFile = "$wgExtDistTarDir/$tarName";

		// Create it if it doesn't exist
		if ( !file_exists( $tarFile ) ) {
			// Does the tar file need ExtensionFunctions.php?
			$dir = "$wgExtDistWorkingCopy/$version/extensions/$extension";
			$retval = -1;
			$files = call_user_func_array( 'wfEscapeShellArg', glob( "$dir/*.php" ) );
			wfShellExec( "grep -q ExtensionFunctions " . $files, $retval );
			$needEF = !$retval;

			// Create the archive
			$cmd = 'tar -czf ' . wfEscapeShellArg( $tarFile ) .
				' --exclude \'*/.svn*\'' .
				' -C ' . wfEscapeShellArg( "$wgExtDistWorkingCopy/$version/extensions" ) .
				' ' . wfEscapeShellArg( $extension ) .
				( $needEF ? ' ExtensionFunctions.php' : '' ) .
				' 2>&1';
			$retval = -1;
			$result = wfShellExec( $cmd, $retval );
			if ( $retval ) {
				$wgOut->addWikiMsg( 'extdist-tar-error', $retval );
				$wgOut->addHTML( '<pre>' . htmlspecialchars( $result ) . '</pre>' );
				return;
			}
		}

		$url = "$wgExtDistTarUrl/$tarName";

		// Show a message
		$wgOut->addWikiMsg( 'extdist-created', $extension, "r$rev", 
			$this->getBranchName( $version ), $url, $tarName );
		$wgOut->addHTML( '<p><br/><big>' .
			'<a href="' . $this->getTitle()->escapeLocalUrl() . '">' . 
			htmlspecialchars( wfMsg( 'extdist-want-more' ) ) . '</a></big></p>' );

		// Redirect to the file
		header( 'Refresh: 5;' . $url );
	}

	function updateAndGetRevisionLocal( $extension, $version ) {
		global $wgExtDistWorkingCopy, $wgOut;
		// svn up
		$dir = "$wgExtDistWorkingCopy/$version/extensions/$extension";
		$cmd = "svn up --non-interactive " . wfEscapeShellArg( $dir ) . " 2>&1";
		$retval = -1;
		$result = wfShellExec( $cmd, $retval );
		if ( $retval ) {
			$wgOut->addWikiMsg( 'extdist-svn-error', $result );
			return false;
		}

		// Determine last changed revision
		$cmd = "svn info --non-interactive --xml " . wfEscapeShellArg( $dir );
		$retval = -1;
		$result = wfShellExec( $cmd, $retval );
		if ( $retval ) {
			$wgOut->addWikiMsg( 'extdist-svn-error', $result );
			return false;
		}

		$sx = new SimpleXMLElement( $result );
		$rev = $sx->entry->commit['revision'];
		if ( !$rev || strpos( $rev, '/' ) !== false || strpos( $rev, "\000" ) !== false ) {
			$wgOut->addWikiMsg( 'extdist-svn-parse-error', $result );
			return false;
		}

		return $rev;
	}

	function updateAndGetRevisionRemote( $extension, $version ) {
		global $wgExtDistRemoteClient, $wgOut;
		$cmd = json_encode( array( 'extension' => $extension, 'version' => $version ) );
		$cmd = str_replace( "\000", '', $cmd );
		list( $host, $port ) = explode( ':', $wgExtDistRemoteClient, 2 );
		$sock = fsockopen( $host, $port );
		if ( !$sock ) {
			$wgOut->addWikiMsg( 'extdist-no-remote' );
			return false;
		}

		fwrite( $sock, $cmd . "\000\000\000" );
		$encReponse = '';
		while ( $sock && !feof( $sock ) ) {
			$encResponse .= fread( $sock, 8192 );
		}
		fclose( $sock );
		
		$response = json_decode( $encResponse );
		if ( isset( $response->error ) ) {
			$info = isset( $response->errorInfo ) ? $response->errorInfo : '';
			$wgOut->addWikiMsg( $response->error, $info );
			return false;
		}
		if ( !isset( $response->revision ) ) {
			$wgOut->addWikiMsg( 'extdist-remote-invalid-response' );
			return false;
		}
		return $response->revision;
	}
}
