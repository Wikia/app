<?php
/**
 * MediaWiki math extension
 *
 * (c) 2002-2012 Tomasz Wegrzanowski, Brion Vibber, Moritz Schubotz, and other MediaWiki contributors
 * GPLv2 license; info in main package.
 *
 * Contains the driver function for the texvc program
 * @file
 */
/**
 * Takes LaTeX fragments, sends them to a helper program (texvc) for rendering
 * to rasterized PNG and HTML and MathML approximations. An appropriate
 * rendering form is picked and returned.
 *
 * @author Tomasz Wegrzanowski
 * @author Brion Vibber
 * @author Moritz Schubotz
 */
define( 'MW_TEXVC_SUCCESS', -1 );
class MathTexvc extends MathRenderer {
	const CONSERVATIVE = 2;
	const MODERATE = 1;
	const LIBERAL = 0;

	/**
	 * Renders TeX using texvc
	 *
	 * @return string rendered TeK
	 */
	function render() {
		if ( !$this->readCache() ) { // cache miss
			$result = $this->callTexvc();
			if ( $result != MW_TEXVC_SUCCESS ) {
				return $result;
			}
		}
		return $this->doHTMLRender();
	}

	/**
	 * Gets path to store hashes in
	 *
	 * @return string Storage directory
	 */
	function getHashPath() {
		$path = $this->getBackend()->getRootStoragePath() .
			'/math-render/' . $this->getHashSubPath();
		wfDebug( "TeX: getHashPath, hash is: $this->hash, path is: $path\n" );
		return $path;
	}

	/**
	 * Gets relative directory for this specific hash
	 *
	 * @return string Relative directory
	 */
	function getHashSubPath() {
		return substr( $this->hash, 0, 1 )
			. '/' . substr( $this->hash, 1, 1 )
			. '/' . substr( $this->hash, 2, 1 );
	}

	/**
	 * Gets URL for math image
	 *
	 * @return string image URL
	 */
	function getMathImageUrl() {
		global $wgMathPath;
		$dir = $this->getHashSubPath();
		return "$wgMathPath/$dir/{$this->hash}.png";
	}

	/**
	 * Gets img tag for math image
	 *
	 * @return string img HTML
	 */
	function getMathImageHTML() {
		$url = $this->getMathImageUrl();

		return Xml::element( 'img',
			$this->getAttributes(
				'img',
				array(
					'class' => 'tex',
					'alt' => $this->tex
				),
				array(
					'src' => $url
				)
			)
		);
	}

	/**
	 * Does the actual call to texvc
	 *
	 * @return int|string MW_TEXVC_SUCCESS or error string
	 */
	function callTexvc() {
		global $wgTexvc, $wgTexvcBackgroundColor, $wgUseSquid, $wgMathCheckFiles;
		$tmpDir = wfTempDir();
		if ( !is_executable( $wgTexvc ) ) {
			return $this->getError( 'math_notexvc' );
		}

		$escapedTmpDir = wfEscapeShellArg( $tmpDir );

		$cmd = $wgTexvc . ' ' .
			$escapedTmpDir . ' ' .
			$escapedTmpDir . ' ' .
			wfEscapeShellArg( $this->tex ) . ' ' .
			wfEscapeShellArg( 'UTF-8' ) . ' ' .
			wfEscapeShellArg( $wgTexvcBackgroundColor );

		if ( wfIsWindows() ) {
			# Invoke it within cygwin sh, because texvc expects sh features in its default shell
			$cmd = 'sh -c ' . wfEscapeShellArg( $cmd );
		}
		wfDebugLog( 'Math', "TeX: $cmd\n" );
		$contents = wfShellExec( $cmd );
		wfDebugLog( 'Math', "TeX output:\n $contents\n---\n" );

		if ( strlen( $contents ) == 0 ) {
			if ( !file_exists( $tmpDir ) || !is_writable( $tmpDir ) ) {
				return $this->getError( 'math_bad_tmpdir' );
			} else {
				return $this->getError( 'math_unknown_error' );
			}
		}

		$tempFsFile = new TempFSFile( "$tmpDir/{$this->hash}.png" );
		$tempFsFile->autocollect(); // destroy file when $tempFsFile leaves scope

		$retval = substr( $contents, 0, 1 );
		$errmsg = '';
		if ( ( $retval == 'C' ) || ( $retval == 'M' ) || ( $retval == 'L' ) ) {
			if ( $retval == 'C' ) {
				$this->conservativeness = self::CONSERVATIVE;
			} elseif ( $retval == 'M' ) {
				$this->conservativeness = self::MODERATE;
			} else {
				$this->conservativeness = self::LIBERAL;
			}
			$outdata = substr( $contents, 33 );

			$i = strpos( $outdata, "\000" );

			$this->html = substr( $outdata, 0, $i );
			$this->mathml = substr( $outdata, $i + 1 );
		} elseif ( ( $retval == 'c' ) || ( $retval == 'm' ) || ( $retval == 'l' ) ) {
			$this->html = substr( $contents, 33 );
			if ( $retval == 'c' ) {
				$this->conservativeness = self::CONSERVATIVE;
			} elseif ( $retval == 'm' ) {
				$this->conservativeness = self::MODERATE;
			} else {
				$this->conservativeness = self::LIBERAL;
			}
			$this->mathml = null;
		} elseif ( $retval == 'X' ) {
			$this->html = null;
			$this->mathml = substr( $contents, 33 );
			$this->conservativeness = self::LIBERAL;
		} elseif ( $retval == '+' ) {
			$this->html = null;
			$this->mathml = null;
			$this->conservativeness = self::LIBERAL;
		} else {
			$errbit = htmlspecialchars( substr( $contents, 1 ) );
			switch( $retval ) {
				case 'E':
					$errmsg = $this->getError( 'math_lexing_error', $errbit );
					break;
				case 'S':
					$errmsg = $this->getError( 'math_syntax_error', $errbit );
					break;
				case 'F':
					$errmsg = $this->getError( 'math_unknown_function', $errbit );
					break;
				default:
					$errmsg = $this->getError( 'math_unknown_error', $errbit );
			}
		}

		if ( !$errmsg ) {
			$this->hash = substr( $contents, 1, 32 );
		}

		wfRunHooks( 'MathAfterTexvc', array( &$this, &$errmsg ) );

		if ( $errmsg ) {
			return $errmsg;
		} elseif ( !preg_match( "/^[a-f0-9]{32}$/", $this->hash ) ) {
			return $this->getError( 'math_unknown_error' );
		} elseif ( !file_exists( "$tmpDir/{$this->hash}.png" ) ) {
			return $this->getError( 'math_image_error' );
		} elseif ( filesize( "$tmpDir/{$this->hash}.png" ) == 0 ) {
			return $this->getError( 'math_image_error' );
		}

		$hashpath = $this->getHashPath(); // final storage directory

		$backend = $this->getBackend();
		# Create any containers/directories as needed...
		if ( !$backend->prepare( array( 'dir' => $hashpath ) )->isOK() ) {
			return $this->getError( 'math_output_error' );
		}
		// Store the file at the final storage path...
		if ( !$backend->quickStore( array(
			'src' => "$tmpDir/{$this->hash}.png", 'dst' => "$hashpath/{$this->hash}.png"
		) )->isOK()
		) {
			return $this->getError( 'math_output_error' );
		}
		return MW_TEXVC_SUCCESS;
	}

	/**
	 * Gets file backend
	 *
	 * @return FileBackend appropriate file backend
	 */
	function getBackend() {
		global $wgMathFileBackend, $wgMathDirectory;
		if ( $wgMathFileBackend ) {
			return FileBackendGroup::singleton()->get( $wgMathFileBackend );
		} else {
			static $backend = null;
			if ( !$backend ) {
				$backend = new FSFileBackend( array(
					'name'           => 'math-backend',
					'lockManager'    => 'nullLockManager',
					'containerPaths' => array( 'math-render' => $wgMathDirectory ),
					'fileMode'       => 0777
				) );
			}
			return $backend;
		}
	}

	/**
	 * Does the HTML rendering
	 *
	 * @return string HTML string
	 */
	function doHTMLRender() {
		if ( $this->mode == MW_MATH_MATHML && $this->mathml != '' ) {
			return Xml::tags( 'math',
				$this->getAttributes( 'math',
					array( 'xmlns' => 'http://www.w3.org/1998/Math/MathML' ) ),
				$this->mathml );
		}
		if ( ( $this->mode == MW_MATH_PNG ) || ( $this->html == '' ) ||
			( ( $this->mode == MW_MATH_SIMPLE ) && ( $this->conservativeness != self::CONSERVATIVE ) ) ||
			( ( $this->mode == MW_MATH_MODERN || $this->mode == MW_MATH_MATHML ) && ( $this->conservativeness == self::LIBERAL ) )
		)
		{
			return $this->getMathImageHTML();
		} else {
			return Xml::tags( 'span',
				$this->getAttributes( 'span',
					array( 'class' => 'texhtml',
						'dir' => 'ltr'
					) ),
				$this->html
			);
		}
	}

	/**
	 * Overrides base class.  Writes to database, and if configured, squid.
	 */
	public function writeCache() {
		global $wgUseSquid;
		// If cache hit, don't write anything.
		if ( $this->isRecall() ) {
			return;
		}
		$this->writeToDatabase();
		// If we're replacing an older version of the image, make sure it's current.
		if ( $wgUseSquid ) {
			$urls = array( $this->getMathImageUrl() );
			$u = new SquidUpdate( $urls );
			$u->doUpdate();
		}
	}

	/**
	 * Reads the rendering information from the database.  If configured, checks whether files exist
	 *
	 * @return boolean true if retrieved, false otherwise
	 */
	function readCache() {
		global $wgMathCheckFiles;
		if ( $this->readFromDatabase() ) {
			if ( !$wgMathCheckFiles ) {
				// Short-circuit the file existence & migration checks
				return true;
			}
			$filename = $this->getHashPath() . "/{$this->hash}.png"; // final storage path
			$backend = $this->getBackend();
			if ( $backend->fileExists( array( 'src' => $filename ) ) ) {
				if ( $backend->getFileSize( array( 'src' => $filename ) ) == 0 ) {
					// Some horrible error corrupted stuff :(
					$backend->quickDelete( array( 'src' => $filename ) );
				} else {
					return true; // cache hit
				}
			}
		} else {
			return false;
		}
	}

}