<?php
/**
 * MediaWiki math extension
 *
 * (c) 2002-2011 Tomasz Wegrzanowski, Brion Vibber, and other MediaWiki contributors
 * GPLv2 license; info in main package.
 *
 * Contains everything related to <math> </math> parsing
 * @file
 * @ingroup Parser
 */

if ( !function_exists('wfEscapeSingleQuotes') ) {
	/**
	 * Escapes a string with single quotes for a UNIX shell.
	 * It's equivalente to escapeshellarg() in UNIX, but also 
	 * working in Windows, where we need it for cygwin shell.
	 */
	function wfEscapeSingleQuotes( $str ) {
		return "'" . str_replace( "'", "'\\''", $str ) . "'";
	}
}

/**
 * Takes LaTeX fragments, sends them to a helper program (texvc) for rendering
 * to rasterized PNG and HTML and MathML approximations. An appropriate
 * rendering form is picked and returned.
 *
 * @author Tomasz Wegrzanowski, with additions by Brion Vibber (2003, 2004)
 * @ingroup Parser
 */
class MathRenderer {
	var $mode = MW_MATH_PNG;
	var $tex = '';
	var $inputhash = '';
	var $hash = '';
	var $html = '';
	var $mathml = '';
	var $conservativeness = 0;

	private $md5; // Wikia change

	function __construct( $tex, $params = array() ) {
		$this->tex = $tex;
		$this->params = $params;
 	}

	function setOutputMode( $mode ) {
		$validModes = array( MW_MATH_PNG, MW_MATH_SOURCE );
		if ( in_array( $mode, $validModes ) ) {
			$this->mode = $mode;
		} else {
			// Several mixed modes have been phased out.
			$this->mode = MW_MATH_PNG;
		}
	}

	function render() {
		global $wgTmpDirectory;
		global $wgTexvc, $wgMathCheckFiles, $wgTexvcBackgroundColor;

		if( $this->mode == MW_MATH_SOURCE ) {
			# No need to render or parse anything more!
			# New lines are replaced with spaces, which avoids confusing our parser (bugs 23190, 22818)
			return ('<span class="tex" dir="ltr">$ ' . str_replace( "\n", " ", htmlspecialchars( $this->tex ) ) . ' $</span>');
		}
		if( $this->tex == '' ) {
			return; # bug 8372
		}

		if( !$this->_recall() ) {
			if( $wgMathCheckFiles ) {
				# Ensure that the temp and output directories are available before continuing...
				if( !file_exists( $wgTmpDirectory ) ) {
					if( !wfMkdirParents( $wgTmpDirectory, null, __METHOD__ ) ) {
						return $this->_error( 'math_bad_tmpdir' );
					}
				} elseif( !is_dir( $wgTmpDirectory ) || !is_writable( $wgTmpDirectory ) ) {
					return $this->_error( 'math_bad_tmpdir' );
				}
			}

			if( !is_executable( $wgTexvc ) ) {
				return $this->_error( 'math_notexvc' );
			}
			$cmd = $wgTexvc . ' ' .
					wfEscapeSingleQuotes( $wgTmpDirectory ) . ' '.
					wfEscapeSingleQuotes( $wgTmpDirectory ) . ' '.
					wfEscapeSingleQuotes( $this->tex ) . ' '.
					wfEscapeSingleQuotes( 'UTF-8' ) . ' '.
					wfEscapeSingleQuotes( $wgTexvcBackgroundColor );

			if ( wfIsWindows() ) {
				# Invoke it within cygwin sh, because texvc expects sh features in its default shell
				$cmd = 'sh -c ' . wfEscapeShellArg( $cmd );
			}

			wfDebug( "TeX: $cmd\n" );
			$contents = wfShellExec( $cmd );
			wfDebug( "TeX output:\n $contents\n---\n" );

			if ( strlen( $contents ) == 0 ) {
				return $this->_error( 'math_unknown_error' );
			}

			$retval = substr( $contents, 0, 1 );
			$errmsg = '';
			if ( ( $retval == 'C' ) || ( $retval == 'M' ) || ( $retval == 'L' ) ) {
				if ( $retval == 'C' ) {
					$this->conservativeness = 2;
				} elseif ( $retval == 'M' ) {
					$this->conservativeness = 1;
				} else {
					$this->conservativeness = 0;
				}
				$outdata = substr( $contents, 33 );

				$i = strpos( $outdata, "\000" );

				$this->html = substr( $outdata, 0, $i );
				$this->mathml = substr( $outdata, $i + 1 );
			} elseif ( ( $retval == 'c' ) || ( $retval == 'm' ) || ( $retval == 'l' ) ) {
				$this->html = substr( $contents, 33 );
				if ( $retval == 'c' ) {
					$this->conservativeness = 2;
				} elseif ( $retval == 'm' ) {
					$this->conservativeness = 1;
				} else {
					$this->conservativeness = 0;
				}
				$this->mathml = null;
			} elseif ( $retval == 'X' ) {
				$this->html = null;
				$this->mathml = substr( $contents, 33 );
				$this->conservativeness = 0;
			} elseif ( $retval == '+' ) {
				$this->html = null;
				$this->mathml = null;
				$this->conservativeness = 0;
			} else {
				$errbit = htmlspecialchars( substr( $contents, 1 ) );
				switch( $retval ) {
					case 'E':
						$errmsg = $this->_error( 'math_lexing_error', $errbit );
						break;
					case 'S':
						$errmsg = $this->_error( 'math_syntax_error', $errbit );
						break;
					case 'F':
						$errmsg = $this->_error( 'math_unknown_function', $errbit );
						break;
					default:
						$errmsg = $this->_error( 'math_unknown_error', $errbit );
				}
			}

			if ( !$errmsg ) {
				$this->hash = substr( $contents, 1, 32 );
			}

			Hooks::run( 'MathAfterTexvc', [ $this, &$errmsg ] );

			if ( $errmsg ) {
				return $errmsg;
			}

			if ( !preg_match( "/^[a-f0-9]{32}$/", $this->hash ) ) {
				return $this->_error( 'math_unknown_error' );
			}

			if( !file_exists( "$wgTmpDirectory/{$this->hash}.png" ) ) {
				return $this->_error( 'math_image_error' );
			}

			if( filesize( "$wgTmpDirectory/{$this->hash}.png" ) == 0 ) {
				return $this->_error( 'math_image_error' );
			}

			// Wikia change - begin
			// store on Swift (@author macbre)
			global $wgCityId;
			$swift = \Wikia\SwiftStorage::newFromWiki( $wgCityId );

			$localFile = "$wgTmpDirectory/{$this->hash}.png";
			$remotePath = $this->getSwiftPath();

			$res = $swift->store( $localFile, $remotePath, [], 'image/png' );

			if ( !$res->isOK() ) {
				return $this->_error( 'math_output_error' );
			}
			// Wikia change - end

			# Now save it back to the DB:
			if ( !wfReadOnly() ) {
				$outmd5_sql = pack( 'H32', $this->hash );

				$md5_sql = pack( 'H32', $this->md5 ); # Binary packed, not hex

				$dbw = wfGetDB( DB_MASTER );
				$dbw->replace(
					'math',
					array( 'math_inputhash' ),
					array(
						'math_inputhash' => $dbw->encodeBlob( $md5_sql ),
						'math_outputhash' => $dbw->encodeBlob( $outmd5_sql ),
						'math_html_conservativeness' => $this->conservativeness,
						'math_html' => $this->html,
						'math_mathml' => $this->mathml,
					),
					__METHOD__
				);
			}

			// If we're replacing an older version of the image, make sure it's current.
			global $wgUseSquid;
			if ( $wgUseSquid ) {
				$urls = array( $this->_mathImageUrl() );
				$u = new SquidUpdate( $urls );
				$u->doUpdate();
			}
		}

		return $this->_doRender();
	}

	function _error( $msg, $append = '' ) {
		$mf = htmlspecialchars( wfMsg( 'math_failure' ) );
		$errmsg = htmlspecialchars( wfMsg( $msg ) );
		$source = htmlspecialchars( str_replace( "\n", ' ', $this->tex ) );

		Wikia::log(__METHOD__, false, $msg); // Wikia change
		return "<strong class='error'>$mf ($errmsg$append): $source</strong>\n";
	}

	/**
	 * Check whether given file exists on Math storage (either NFS or Swift)
	 *
	 * @return bool true if rendered PNG exists
	 */
	function _recall() {
		global $wgMathCheckFiles;

		$this->md5 = md5( $this->tex );
		$dbr = wfGetDB( DB_SLAVE );
		$rpage = $dbr->selectRow(
			'math',
			array(
				'math_outputhash', 'math_html_conservativeness', 'math_html',
				'math_mathml'
			),
			array(
				'math_inputhash' => $dbr->encodeBlob( pack( "H32", $this->md5 ) ) # Binary packed, not hex
			),
			__METHOD__
		);

		if( $rpage !== false ) {
			# Tailing 0x20s can get dropped by the database, add it back on if necessary:
			$xhash = unpack( 'H32md5', $dbr->decodeBlob( $rpage->math_outputhash ) . "                " );
			$this->hash = $xhash['md5'];

			$this->conservativeness = $rpage->math_html_conservativeness;
			$this->html = $rpage->math_html;
			$this->mathml = $rpage->math_mathml;

			$filename = $this->_getHashPath() . "/{$this->hash}.png";
			wfDebug(__METHOD__ . ": rendering to {$filename}\n"); // Wikia change

			if( !$wgMathCheckFiles ) {
				// Short-circuit the file existence & migration checks
				return true;
			}

			// Wikia change - begin
			// use Swift storage instead of NFS mount (@author macbre)
			global $wgCityId;
			$swift = \Wikia\SwiftStorage::newFromWiki( $wgCityId );
			$remotePath = $this->getSwiftPath();

			return $swift->exists( $remotePath );
			// Wikia change - end - removed the rest of this method (SUS-2429)
		}

		# Missing from the database and/or the render cache
		return false;
	}

	/**
	 * Select among PNG, HTML, or MathML output depending on
	 */
	function _doRender() {
		if( $this->mode == MW_MATH_MATHML && $this->mathml != '' ) {
			return Xml::tags( 'math',
				$this->_attribs( 'math',
					array( 'xmlns' => 'http://www.w3.org/1998/Math/MathML' ) ),
				$this->mathml );
		}
		if ( ( $this->mode == MW_MATH_PNG ) || ( $this->html == '' ) ||
			( ( $this->mode == MW_MATH_SIMPLE ) && ( $this->conservativeness != 2 ) ) ||
			( ( $this->mode == MW_MATH_MODERN || $this->mode == MW_MATH_MATHML ) && ( $this->conservativeness == 0 ) )
		)
		{
			return $this->_linkToMathImage();
		} else {
			return Xml::tags( 'span',
				$this->_attribs( 'span',
					array( 'class' => 'texhtml',
						'dir' => 'ltr'
					) ),
				$this->html
			);
		}
	}

	function _attribs( $tag, $defaults = array(), $overrides = array() ) {
		$attribs = Sanitizer::validateTagAttributes( $this->params, $tag );
		$attribs = Sanitizer::mergeAttributes( $defaults, $attribs );
		$attribs = Sanitizer::mergeAttributes( $attribs, $overrides );
		return $attribs;
	}

	function _linkToMathImage() {
		$url = $this->_mathImageUrl();

		return Xml::element( 'img',
			$this->_attribs(
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

	function _mathImageUrl() {
		global $wgMathPath;
		$dir = $this->_getHashSubPath();
		return wfReplaceImageServer( "$wgMathPath/$dir/{$this->hash}.png" ); // Wikia change
	}

	function _getHashPath() {
		global $wgMathDirectory;
		$path = $wgMathDirectory . '/' . $this->_getHashSubPath();
		wfDebug( "TeX: getHashPath, hash is: $this->hash, path is: $path\n" );
		return $path;
	}

	function _getHashSubPath() {
		return substr( $this->hash, 0, 1)
					. '/' . substr( $this->hash, 1, 1 )
					. '/' . substr( $this->hash, 2, 1 );
	}

	public static function renderMath( $tex, $params = array(), ParserOptions $parserOptions = null ) {
		$math = new MathRenderer( $tex, $params );
		if ( $parserOptions ) {
			$math->setOutputMode( $parserOptions->getMath() );
		}
		return $math->render();
	}

	/**
	 * Return remote path (to be used by Swift) - Wikia change
	 *
	 * @yauthor macbre
	 * @return string remote path
	 */
	public function getSwiftPath() {
		return sprintf( '/math/%s/%s.png', $this->_getHashSubPath(), $this->hash );
	}
}
