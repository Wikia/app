<?php
if( !defined('MEDIAWIKI') ) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

class SpecialMaintenance extends SpecialPage {
	private $type = '';
	private $metadata = array();
	private $scripts = array();
	private $loc = ''; //for temporary files
	private $errmsg = false; //if this gets set, we halt execution and display this message

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Maintenance'/*class*/, 'maintenance'/*restriction*/ );
	}
	
	public function getType() { return $this->type; }
	public function getMetadata() { return $this->metadata; }

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		# If the user doesn't have the required 'maintenance' permission, display an error
		if( !$wgUser->isAllowed( 'maintenance' ) ) {
			$wgOut->permissionRequired( 'maintenance' );
			return;
		}
		
		# Grab the ini file and validate it
		$this->metadata = parse_ini_file( dirname( __FILE__ ) . '/metadata.ini', true );
		$this->scripts = @array_keys( $this->metadata ); //suppress errors since metadata could be false if the metadata.ini file doesn't exist
		$valid = $this->parseMetadata(); //parses the metadata ini and validates it
		if( !$valid ) {
			throw new ErrorPageError( 'error', 'maintenance-error-badini' );
			return;
		}

		$this->type = $par ? $par : '';
		$this->validateType(); //this checks to ensure $par is valid so we don't execute arbitrary code
		if( $this->type === '' ) {
			$this->makeInitialForm();
		} elseif( $this->type !== '' && !$wgRequest->wasPosted() ) {
			$this->makeForm( $this->type );
		} elseif( $this->type !== '' && $wgRequest->wasPosted() ) {
			$this->executeScript( $this->type );
		}
	}
	
	private function validateType() {
		if( !in_array( $this->type, $this->scripts ) ) {
			$this->errmsg = 'maintenance-error-invalidtype';
		}
	}

	private function makeInitialForm() {
		global $wgOut, $wgUser;

		$this->setHeaders();
		$wgOut->addWikiMsg( 'maintenance-header' );
		
		$sk = $wgUser->getSkin();
		$wgOut->addHTML( '<ul>' );

		//scripts that we allow to run via this interface, from the metadata.ini file
		$scripts = $this->scripts;
		sort( $scripts );
		foreach( $scripts as $type ) {
			$title = $this->getTitle( $type );
			$wgOut->addHTML( '<li>'. $sk->makeKnownLinkObj( $title, htmlspecialchars( $type ) ) . ' -- '.
				wfMsgExt( 'maintenance-'.$type.'-desc', array( 'parseinline' ) ) . '</li>' );
		}
		$wgOut->addHTML( '</ul>' );
	}

	private function makeForm( $type ) {
		global $wgOut, $wgUser;

		$this->setHeaders();
		$wgOut->addHTML( $wgUser->getSkin()->makeKnownLinkObj( $this->getTitle(), wfMsgHtml( 'maintenance-backlink' ) ). '<br />' );
		
		if( $this->errmsg ) {
			$wgOut->addWikiMsg( $this->errmsg );
			return;
		}
		
		$wgOut->addWikiMsg( 'maintenance-' . $type );

		$wgOut->addHTML( Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle( $type )->getFullURL() ) ) );
		//build the form
		$options = array_merge( $this->metadata[$type]['option'], $this->metadata[$type]['arg'] );
		foreach( $options as $option ) {
			switch( $option['type'] ) {
				case 'check':
					$wgOut->addHTML( Xml::checkLabel( wfMsg( "maintenance-$type-option-" . $option['name'] ), 'wp' . ucfirst( $option['name'] ), 'wp' . ucfirst( $option['name'] ), $option['default'] ) . '<br /><br />' );
					break;
				case 'input':
					$wgOut->addHTML( Xml::inputLabel( wfMsg( "maintenance-$type-option-" . $option['name'] ), 'wp' . ucfirst( $option['name'] ), 'wp' . ucfirst( $option['name'] ), $option['size'], false, $option['attrib'] ) . '<br /><br />' );
					break;
				case 'password':
					$wgOut->addHTML( Xml::inputLabel( wfMsg( "maintenance-$type-option-" . $option['name'] ), 'wp' . ucfirst( $option['name'] ), 'wp' . ucfirst( $option['name'] ), $option['size'], false, array( 'type' => 'password' ) + $option['attrib'] ) . '<br /><br />' );
					break;
				case 'textarea':
					$wgOut->addHTML( wfMsg( "maintenance-$type-option-" . $option['name'] ) . '<textarea name="wp' . ucfirst( $option['name'] ) . '" rows="25" cols="80"></textarea><br /><br />');
					break;
			}
		}
		$wgOut->addHTML( Xml::checkLabel( wfMsg( 'maintenance-option-quiet' ), 'wpQuiet', 'wpQuiet' ) . '<br /><br />' );
		$wgOut->addHTML( Xml::checkLabel( wfMsg( 'maintenance-option-globals' ), 'wpGlobals', 'wpGlobals' ) . '<br /><br />' );
		if( $this->metadata[$type]['batch'] ) {
			$wgOut->addHTML( Xml::inputLabel( wfMsg( 'maintenance-option-batch-size', $this->metadata[$type]['batch'] ), 'wpBatch-size', 'wpBatch-size' ) . '<br /><br />' );
		}
		$wgOut->addHTML( Xml::submitButton( wfMsg( 'maintenance-option-confirm' ), array( 'name' => 'wpConfirm' ) ) . '</form>' );
		return;
	}

	private function executeScript( $type ) {
		global $wgOut, $wgRequest, $wgUser, $IP, $wgMaintenanceScripts;

		$this->setHeaders();
		$wgOut->addHTML( $wgUser->getSkin()->makeKnownLinkObj( $this->getTitle(), wfMsgHtml( 'maintenance-backlink' ) ). '<br />' );
		
		if( $this->errmsg ) {
			$wgOut->addWikiMsg( $this->errmsg );
			return;
		}
		
		@set_time_limit( 0 ); //if we can, disable the time limit
		@ini_set('memory_limit', '-1'); //also try to disable the memory limit
		//run the script and capture output
		define( 'MW_NO_SETUP', true ); //we use our own setup method to work with web requests
		$maintClass = false; //initialize
		//some scripts misbehave and use exit at the end, which messes us up. Let's fix those here
		//(EPIC HAX MAGIC FOLLOWS)
		$needhax = false;
		switch( $type ) {
			case 'sql':
				file_put_contents( $fname = tempnam( sys_get_temp_dir(), 'maintenance' ),
					str_replace(
						array( 'dirname( __FILE__ )' ), //search
						array( '"$IP/maintenance"' ), //replace
						preg_replace( '/\s+(exit|die)\s*\(.*?\)\s*;/', ';', 
							file_get_contents( "$IP/maintenance/sql.php" )
						)
					)
				);
				$needhax = true;
				break;
		}
		if( $needhax ) {
			require_once( $fname );
		} elseif( file_exists( "$IP/maintenance/$type.php" ) ) {
			require_once( "$IP/maintenance/$type.php" );
		} else {
			require_once( $wgMaintenanceScripts[$type] );
		}
		
		//epic hax magic (TODO: figure out a way to do this without using eval, might require core changes)
		eval( 'class WebMaintenanceHack extends ' . $maintClass . ' {
			public $mSpecialMaintenance; //our SpecialMaintenance object
			protected $atLineStart = true;
			protected $lastChannel = null;
			
			public function setSpecialMaintenance( &$abj ) {
				$this->mSpecialMaintenance = &$abj;
			}
			
			protected function output( $out, $channel = null ) {
				if ( $this->mQuiet ) {
					return;
				}
				if ( $channel === null ) {
					$this->cleanupChanneled();
					$this->outputChanneled( $out );
				} else {
					$out = preg_replace( \'/\n\z/\', \'\', $out );
					$this->outputChanneled( $out, $channel );
				}
			}
			
			public function cleanupChanneled() {
				global $wgOut;
				if ( !$this->atLineStart ) {
					$wgOut->addHTML( "\n" );
					$this->atLineStart = true;
				}
			}
			
			public function outputChanneled( $msg, $channel = null ) {
				global $wgOut;
				
				if ( $msg === false ) {
					// For cleanup
					$this->cleanupChanneled();
					return;
				}

				// End the current line if necessary
				if ( !$this->atLineStart && $channel !== $this->lastChannel ) {
					$wgOut->addHTML( "\n" );
				}

				//look up $msg for l10n, treat as plaintext
				$this->output_i18n( $msg, "output" );

				$this->atLineStart = false;
				if ( $channel === null ) {
					// For unchanneled messages, output trailing newline immediately
					$wgOut->addHTML( "\n" );
					$this->atLineStart = true;
				}
				$this->lastChannel = $channel;
			}
			
			protected function error( $err, $die = false ) {
				$this->outputChanneled( false );
				
				//look up $err for l10n, treat as plaintext
				$this->output_i18n( $err, "error" );
				
				if( $die ) throw new SpecialMaintenanceException();
			}
			
			//$type is either "output" or "error"
			private function output_i18n( $msg, $type ) {
				global $wgOut;
				
				$found = false;
				$metadata = $this->mSpecialMaintenance->getMetadata();
				$script = $this->mSpecialMaintenance->getType();
				foreach( $metadata[$script][$type] as $a ) {
					if( $a["type"] == "string" ) {
						if( trim( $msg ) == $a["match"] ) {
							$wgOut->addHTML( wfMsgExt( "maintenance-$script-$type-" . $a["name"], array( "escape" ) ) );
							if( $type == "error" ) {
								$wgOut->addHTML( "\n" );
							}
							$found = true;
							break;
						}
					} elseif( $a["type"] == "regex" ) {
						$matches = array();
						if( preg_match( "/^" . $a["match"] . "\$/", trim( $msg ), $matches ) ) {
							//$matches contains the respective $1, $2, $3, $4, etc. in order once we take out the first match
							array_shift( $matches );
							$wgOut->addHTML( wfMsgExt( "maintenance-$script-$type-" . $a["name"], array( "escape" ), $matches ) );
							if( $type == "error" ) {
								$wgOut->addHTML( "\n" );
							}
							$found = true;
							break;
						}
					}
				}
				//not found, so just output it raw
				if( !$found ) {
					$wgOut->addHTML( htmlspecialchars( $msg ) );
					if( $type == "error" ) {
						$wgOut->addHTML( "\n" );
					}
				}				
			}
			
			protected function validateParamsAndArgs() {
				$die = false;
				
				foreach( $this->mParams as $opt => $info ) {
					if( $info["require"] && !$this->hasOption( $opt ) ) {
						$die = true;
					}
				}
				# Check arg list too
				foreach( $this->mArgList as $k => $info ) {
					if( $info["require"] && !$this->hasArg($k) ) {
						$die = true;
					}
				}
				
				return $die;
			}
			
			public function doValidateParamsAndArgs() {
				return $this->validateParamsAndArgs();
			}
			
			public function globals() {
				if( $this->hasOption( "globals" ) ) {
					global $wgOut;
					$wgOut->addHTML( htmlspecialchars( print_r( $GLOBALS, true ) ) );
				}
			}
			
			public function memoryLimit() {
				return -1;
			}
			
		}' );
		
		//run the script, throwing output into a <pre> block
		$wgOut->addHTML( '<pre>' );
		$script = new WebMaintenanceHack();
		$script->setSpecialMaintenance( $this );
		$res = $this->setup( $script );
		if( !$res ) {
			return;
		}
		try {
			$script->execute();
			if( $needhax ) {
				unlink( $fname );
			}
			$script->globals();
			$wgOut->addHTML( wfMsgExt( 'maintenance-output-success', array( 'escape' ), $this->type ) . "\n" );
		} catch( SpecialMaintenanceException $e ) {
			$wgOut->addHTML( wfMsgExt( 'maintenance-output-failure', array( 'escape' ), $this->type ) . "\n" );
		} catch( MWException $mwe ) {
			$wgOut->addHTML( htmlspecialchars( $mwe->getText() ) . "\n" );
			$wgOut->addHTML( wfMsgExt( 'maintenance-output-failure', array( 'escape' ), $this->type ) . "\n" );
		}
		$wgOut->addHTML( '</pre>' );
		$this->scriptDone( $script );
		$wgOut->addHTML( $wgUser->getSkin()->makeKnownLinkObj( $this->getTitle(), wfMsgHtml( 'maintenance-backlink' ) ). '<br />' );
	}
	
	private function parseMetadata() {
		global $IP, $wgMaintenanceScripts;
		$metadata = $this->metadata;
		$i = -1;
		foreach( $metadata as $script => &$stuff ) {
			//increment $i, which is the index of the $this->scripts array
			$i++;
			
			//is the script disabled for whatever reason?
			if( isset( $stuff['enabled'] ) && !$stuff['enabled'] ) {
				unset( $this->scripts[$i] ); //remove it from the list of scripts
				continue;
			}
			
			//make sure that the script exists
			if( !file_exists( "$IP/maintenance/$script.php" ) && !array_key_exists( $script, $wgMaintenanceScripts ) ) {
				return false;
			}
			
			//parse options
			if( !isset( $stuff['option'] ) ) {
				$stuff['option'] = array();
			} elseif( !is_array( $stuff['option'] ) ) {
				$stuff['option'] = array( $stuff['option'] );
			}
			foreach( $stuff['option'] as &$option ) {
				$name = strtok( $option, ' ' );
				if( !preg_match( '/^[a-z0-9-]+$/i', $name ) ) {
					return false;
				}
				$type = strtok( ' ' );
				if( !in_array( $type, array( 'check', 'input', 'password', 'textarea' ) ) ) {
					return false;
				}
				if( $type == 'check' ) {
					$default = strtok( ' ' ); //if it's missing, it's automatically false due to how strtok works
					$option = array();
					$option['default'] = $default;
				} elseif( $type == 'input' || $type == 'password' ) {
					$size = strtok( ' ' ); //integer size or false
					if( $size !== false && !ctype_digit( $size ) ) {
						return false;
					}
					//rest are attributes, we just ignore poorly-formatted ones here instead of rejecting the entire file
					$attrib = array();
					while( ( $attr = strtok( ' ' ) ) !== false ) {
						$bits = explode( '=', $attr, 2 );
						if( count( $bits ) < 2 || !ctype_alpha( $bits[0] ) ) {
							continue;
						}
						$attrib[strtolower( $bits[0] )] = $bits[1]; //$bits[1] gets sanitized by the Sanitizer before being sent off to output
					}
					$option = array();
					$option['size'] = $size;
					$option['attrib'] = $attrib;
				} elseif( $type == 'textarea' ) {
					$tmpfile = strtok( ' ' );
					$option = array();
					$option['tmpfile'] = $tmpfile;
				}
				$option['name'] = $name;
				$option['type'] = $type;
			}
			
			//parse args
			if( !isset( $stuff['arg'] ) ) {
				$stuff['arg'] = array();
			} elseif( !is_array( $stuff['arg'] ) ) {
				$stuff['arg'] = array( $stuff['arg'] );
			}
			foreach( $stuff['arg'] as &$arg ) {
				$name = strtok( $arg, ' ' );
				if( !preg_match( '/^[a-z0-9-]+$/i', $name ) ) {
					return false;
				}
				$type = strtok( ' ' );
				if( !in_array( $type, array( 'check', 'input', 'password', 'textarea' ) ) ) {
					return false;
				}
				if( $type == 'check' ) {
					$default = strtok( ' ' ); //if it's missing, it's automatically false due to how strtok works
					$arg = array();
					$arg['default'] = $default;
				} elseif( $type == 'input' || $type == 'password' ) {
					$size = strtok( ' ' ); //integer size or false
					if( $size !== false && !ctype_digit( $size ) ) {
						return false;
					}
					//rest are attributes, we just ignore poorly-formatted ones here instead of rejecting the entire file
					$attrib = array();
					while( ( $attr = strtok( ' ' ) ) !== false ) {
						$bits = explode( '=', $attr, 2 );
						if( count( $bits ) < 2 || !ctype_alpha( $bits[0] ) ) {
							continue;
						}
						$attrib[strtolower( $bits[0] )] = $bits[1]; //$bits[1] gets sanitized by the Sanitizer before being sent off to output
					}
					$arg = array();
					$arg['size'] = $size;
					$arg['attrib'] = $attrib;
				} elseif( $type == 'textarea' ) {
					$tmpfile = strtok( ' ' );
					$arg = array();
					$arg['tmpfile'] = $tmpfile;
				}
				$arg['name'] = $name;
				$arg['type'] = $type;
			}
			
			//parse output messages (for i18n)
			if( !isset( $stuff['output'] ) ) {
				$stuff['output'] = array();
			} elseif( !is_array( $stuff['output'] ) ) {
				$stuff['output'] = array( $stuff['output'] );
			}
			foreach( $stuff['output'] as &$autput ) {
				$bits = explode( ' ', $autput, 3 );
				if( count( $bits ) < 3 ) {
					return false;
				}
				$autput = array();
				$autput['name'] = strtolower( $bits[0] );
				if( !preg_match( '/^[a-z0-9-]+$/i', $autput['name'] ) ) {
					return false;
				}
				$autput['type'] = $bits[1];
				if( !in_array( $autput['type'], array( 'string', 'regex' ) ) ) {
					return false;
				}
				$autput['match'] = $bits[2];
			}
			
			//parse error messages (for i18n)
			if( !isset( $stuff['error'] ) ) {
				$stuff['error'] = array();
			} elseif( !is_array( $stuff['error'] ) ) {
				$stuff['error'] = array( $stuff['error'] );
			}
			foreach( $stuff['error'] as &$error ) {
				$bits = explode( ' ', $error, 3 );
				if( count( $bits ) < 3 ) {
					return false;
				}
				$error = array();
				$error['name'] = strtolower( $bits[0] );
				if( !preg_match( '/^[a-z0-9-]+$/i', $error['name'] ) ) {
					return false;
				}
				$error['type'] = $bits[1];
				if( !in_array( $error['type'], array( 'string', 'regex' ) ) ) {
					return false;
				}
				$error['match'] = $bits[2];
			}
			
			//parse special options (batch, stdin)
			if( !isset( $stuff['batch'] ) ) {
				$stuff['batch'] = 0;
			}
			if( !isset( $stuff['stdin'] ) ) {
				$stuff['stdin'] = false;
			}
		}
		$this->metadata = $metadata;
		return true;
	}
	
	private function setup( $maintenance ) {
		//set the memory limit
		@ini_set( 'memory_limit', $maintenance->memoryLimit() );
		
		//set up the params and args
		global $wgRequest;
		$goptions = $this->metadata[$this->type]['option'];
		$gargs = $this->metadata[$this->type]['arg'];
		$opts = $args = null;
		if( $goptions != array() ) {
			$opts = array();
			foreach( $goptions as $a ) {
				if( $a['type'] == 'textarea' && $a['tmpfile'] ) {
					$fname = tempnam( sys_get_temp_dir(), $a['tmpfile'] );
					$f = fopen( $fname, 'wt' );
					fwrite( $f, $wgRequest->getText( 'wp' . ucfirst( $a['name'] ) ) );
					fclose( $f );
					$opts[$a['name']] = $fname;
				} elseif( $a['type'] == 'textarea' ) {
					$opts[$a['name']] = $wgRequest->getText( 'wp' . ucfirst( $a['name'] ) );				
				} elseif( $a['type'] != 'check' ) {
					$opts[$a['name']] = $wgRequest->getVal( 'wp' . ucfirst( $a['name'] ) );
				} else {
					$opts[$a['name']] = $wgRequest->getCheck( 'wp' . ucfirst( $a['name'] ) );
				}
			}
		}
		if( $gargs != array() ) {
			$args = array();
			foreach( $gargs as $a ) {
				if( $a['type'] == 'textarea' && $a['tmpfile'] ) {
					$fname = tempnam( sys_get_temp_dir(), $a['tmpfile'] );
					$f = fopen( $fname, 'wt' );
					fwrite( $f, $wgRequest->getText( 'wp' . ucfirst( $a['name'] ) ) );
					fclose( $f );
					$args[] = $fname;
				} elseif( $a['type'] == 'textarea' ) {
					$args[] = $wgRequest->getText( 'wp' . ucfirst( $a['name'] ) );	
				} elseif( $a['type'] != 'check' ) {
					$args[] = $wgRequest->getVal( 'wp' . ucfirst( $a['name'] ) );
				} else {
					$args[] = $wgRequest->getCheck( 'wp' . ucfirst( $a['name'] ) );
				}
			}
		}
		
		//special opts
		if( $wgRequest->getCheck( 'wpQuiet' ) ) {
			$opts['quiet'] = true;
		}
		if( $wgRequest->getCheck( 'wpGlobals' ) ) {
			$opts['globals'] = true;
		}
		if( $wgRequest->getVal( 'wpBatch-size', false ) ) {
			$opts['batch-size'] = $wgRequest->getVal( 'wpBatch-size' );
		}
		
		//per-script special cases
		switch( $this->type ) {
			case 'checkSyntax':
				//need to save list-file to a temp txt file and set list-file to that file's location
				$this->loc = tempnam( sys_get_temp_dir(), "tmpfile" );
				$f = fopen( $this->loc, 'wt' );
				fwrite( $f, $wgRequest->getText( 'wpList-file' ) );
				fclose( $f );
				$opts['list-file'] = $this->loc;
				break;
		}
		
		$maintenance->loadParamsAndArgs( $this->type, $opts, $args );
		$die = $maintenance->doValidateParamsAndArgs();
		if( $die ) {
			global $wgOut;
			$wgOut->addHTML( wfMsg( 'maintenance-error-badargs' ) );
			return false;
		}
		
		global $IP;
		if( $maintenance->getDbType() === Maintenance::DB_ADMIN ) {
			global $wgDBuser, $wgDBpassword, $wgDBadminuser, $wgDBadminpassword, $wgDBuserold, $wgDBpasswordold;
			if( !isset( $wgDBadminuser ) && is_readable( "$IP/AdminSettings.php" ) ) {
				require( "$IP/AdminSettings.php" );
			}
			if( isset( $wgDBadminuser ) ) {
				$wgDBuserold = $wgDBuser;
				$wgDBpasswordold = $wgDBpassword;
				$wgDBuser = $wgDBadminuser;
				$wgDBpassword = $wgDBadminpassword;
				LBFactory::destroyInstance();
			}
		}
		
		return true;
	}
	
	private function scriptDone( $script ) {
		global $wgDBuser, $wgDBpassword, $wgDBadminuser, $wgDBadminpassword, $wgDBuserold, $wgDBpasswordold;
		if( $script->getDbType() === Maintenance::DB_ADMIN && isset( $wgDBadminuser ) ) {
			$wgDBuser = $wgDBuserold;
			$wgDBpassword = $wgDBpasswordold;
			unset( $GLOBALS['wgDBuserold'], $GLOBALS['wgDBpasswordold'] );
			LBFactory::destroyInstance();
		}
		
		$goptions = $this->metadata[$this->type]['option'];
		$gargs = $this->metadata[$this->type]['arg'];
		
		if( $goptions != array() ) {
			foreach( $goptions as $a ) {
				if( $a['type'] == 'textarea' && $a['tmpfile'] && file_exists( $a['tmpfile'] ) ) {
					unlink( $a['tmpfile'] );
				}
			}
		}
		
		if( $gargs != array() ) {
			foreach( $gargs as $a ) {
				if( $a['type'] == 'textarea' && $a['tmpfile'] && file_exists( $a['tmpfile'] ) ) {
					unlink( $a['tmpfile'] );
				}
			}
		}
	}
}

class SpecialMaintenanceException extends MWException {
	//don't need anything here since we never print this out
	//only used as an exception for the "die" feature of Maintenance::error() as opposed to terminating the script
}
