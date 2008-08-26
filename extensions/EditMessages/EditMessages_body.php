<?php

class EditMessagesPage extends SpecialPage {

	function __construct() {
		parent::__construct( 'EditMessages' );
	}

	function execute( $subpage = '' ) {
		global $wgOut, $wgRequest;
		wfLoadExtensionMessages('EditMessages');
		$this->setHeaders();

		$messageName = $wgRequest->getVal( 'messageName' );

		if ( $wgRequest->getVal( 'editmsg_search' ) ) {
			$this->showEditForm( $messageName );
		} elseif ( $wgRequest->getVal( 'editmsg_get_patch' ) ) {
			$this->generatePatch();
		} elseif ( $wgRequest->getVal( 'editmsg_apply_patch' ) ) {
			$this->applyPatch();
		} else {
			$this->showSearchForm( $messageName );
		}
	}

	function showSearchForm( $messageName ) {
		global $wgOut;
		$encAction = $this->getTitle()->escapeFullUrl();

		$wgOut->addHTML( "<form method=\"POST\" action=\"$encAction\">" );
		$wgOut->addHTML( "<p><label>" . wfMsgHtml( 'editmsg-target' ) .
			Xml::element( 'input', array( 'type' => 'text', 'name' => 'messageName',
				'value' => $messageName, 'size' => 70 ) ) .
			'</label></p>' );
		$wgOut->addHTML( '<p>' . Xml::element( 'input',
			array(
				'type' => 'submit',
				'name' => 'editmsg_search',
				'value' => wfMsg( 'editmsg-search' )
			) ) . '</p>' );
		$wgOut->addHTML( '</form>' );
	}

	function showEditForm( $messageName ) {
		global $wgOut, $wgUser;
		$originalMsgs = array();
		$encAction = $this->getTitle()->escapeFullUrl();
		$languages = Language::getLanguageNames( true );
		$sk = $wgUser->getSkin();
		$wgOut->addHTML( Xml::element( 'h3', null, wfMsg( 'editmsg-show-list', $messageName ) . "\n" ) );
		$wgOut->addHTML( '<p>' . $sk->makeLinkObj( $this->getTitle(), wfMsg( 'editmsg-new-search' ) ) . '</p>' );
		$wgOut->addHTML( "<form method=\"POST\" action=\"$encAction\"><table>" );
		foreach ( $languages as $lang => $langName ) {
			$messages = false;
			require( Language::getMessagesFileName( $lang ) );
			if ( isset( $messages[$messageName] ) ) {
				$msgValue = $messages[$messageName];
				$originalMsgs[$lang] = $msgValue;
				$wgOut->addHTML( '<tr>' .
					Xml::element( 'td', null, $lang ) .
					Xml::tags( 'td', null,
						Xml::element( 'textarea',
							array(
								'name' => "msg[{$lang}]",
								'rows' => ceil( mb_strlen( $msgValue ) / 70 )
								          + substr_count( $msgValue, "\n" ),
								'cols' => '70',
							), $msgValue
						)
					) .
					'</tr>'
				);
			}
		}
		$wgOut->addHTML( "</table>" );
		$wgOut->addHTML( Xml::element( 'input', array(
			'type' => 'hidden',
			'name' => 'originalMsgs',
			'value' => chunk_split( base64_encode( gzdeflate( json_encode( $originalMsgs ) ) ), 120, ' ' ) ) ) );
		$wgOut->addHTML( Xml::element( 'input', array(
			'type' => 'hidden',
			'name' => 'messageName',
			'value' => $messageName
		)));
		$wgOut->addHTML( '<p>' . Xml::element( 'input',
			array(
				'type' => 'submit',
				'name' => 'editmsg_get_patch',
				'value' => wfMsg( 'editmsg-get-patch' )
			) ) . '</p></form>' );
	}

	function generatePatch() {
		global $wgOut, $wgRequest, $wgTmpDirectory, $IP;

		$originalMsgs = $wgRequest->getVal( 'originalMsgs' );
		if ( !$originalMsgs ) {
			throw new MWException( 'Bad form input: no originalMsgs' );
		}
		$originalMsgs = json_decode( gzinflate( base64_decode( $originalMsgs ) ) );
		if ( !$originalMsgs ) {
			throw new MWException( 'Bad form input: originalMsgs invalid' );
		}
		$newMsgs = $wgRequest->getArray( 'msg' );
		$messageName = $wgRequest->getVal( 'messageName' );
		if ( !$newMsgs ) {
			throw new MWException( 'Bad form input: msg missing' );
		}
		if (  !$messageName ) {
			throw new MWException( 'Bad form input: messageName missing' );
		}

		$quote = "['\"]";
		$encMsgName = preg_quote( $messageName, '/' );

		$warnings = array(); //( 'parse' => array(), 'file' => array(), 'mismatch' => array() );
		$escapedChars = array(
			'single' => array( "'", "\\" ),
			'double' => array( 'n', 'r', 't', 'v', 'f', "\\", '$', '"' )
		);
		$dcRegex = '/[0-7]{1,3}|x[0-9A-Fa-f]{1,2}/';

		wfMkdirParents( "$wgTmpDirectory/EditMessages" );
		$out = '';
		foreach ( $originalMsgs as $lang => $origValue ) {
			if ( !isset( $newMsgs[$lang] ) ) {
				continue;
			}
			$newValue = $newMsgs[$lang];

			if ( $newValue === $origValue ) {
				# No change requested
				continue;
			}

			$fileName = Language::getMessagesFileName( $lang );
			$text = file_get_contents( $fileName );
			if ( !$text ) {
				$warnings['file'][] = $lang;
				continue;
			}

			# Find the message name in the file text
			if ( !preg_match( "/^\s*$quote$encMsgName$quote\s*=>\s*/m", $text, $m, PREG_OFFSET_CAPTURE ) ) {
				$warnings['parse1'][] = $lang;
				continue;
			}

			# Determine the starting quote character
			$i = $startPos = $m[0][1] + strlen( $m[0][0] );
			$quoteChar = substr( $text, $i, 1 );
			if ( $quoteChar == '"' ) {
				$mode = 'double';
			} elseif ( $quoteChar == "'" ) {
				$mode = 'single';
			} else {
				$warnings['parse2'][] = $lang;
				continue;
			}

			# Search for the end of the string, respecting escaping
			$i++;
			$found = false;
			do {
				$curChar = substr( $text, $i, 1 );
				if ( $curChar === '\\' ) {
					$nextChar = substr( $text, $i + 1, 1 );
					if ( in_array( $nextChar, $escapedChars[$mode] ) ) {
						$i += 2;
						continue;
					}
					if ( $mode == 'double' && preg_match( $dcRegex, $text, $m, 0, $i + 1 ) ) {
						$i += strlen( $m[0] ) + 1;
						continue;
					}
				} elseif ( $curChar === $quoteChar ) {
					$found = true;
					break;
				}
				++$i;
			} while ( $i < strlen( $text ) );

			if ( !$found ) {
				$warnings['parse3'][] = $lang;
				continue;
			}

			$length = $i - $startPos + 1;

			# Evaluate the string that we just got from the message file, so that we can
			# see if it matches the expected starting value
			$fileValue = eval( 'return ' . substr( $text, $startPos, $length ) . ';' );

			if ( $fileValue !== $origValue ) {
				$warnings['mismatch'][] = $lang;
				continue;
			}

			# Escape the new value, keeping the same quoting style
			if ( $mode == 'single' ) {
				$encNewValue = var_export( $newValue, true );
			} else {
				$encNewValue = '"' . strtr( $newValue, array(
					'\\' => '\\\\',
					'"' => '\\"',
					'$' => '\\$',
				) ) . '"';
			}

			# Replace the string with the new value
			$newText = substr_replace( $text, $encNewValue, $startPos, $length );

			# Generate the diff
			$tempName = "$wgTmpDirectory/EditMessages/" . basename( $fileName );
			file_put_contents( $tempName, $newText );
			$cmd = "diff -u " . wfEscapeShellArg( $fileName, $tempName );
			$diff = "$cmd\n" . wfShellExec( $cmd );
			$diff = str_replace( "$IP/", '', $diff );
			$diff = str_replace( "\r", '', $diff );
			$out .= $diff;
		}

		foreach ( $warnings as $warningType => $warnings2 ) {
			if ( count( $warnings2 ) ) {
				$wgOut->addWikiMsg( 'editmsg-warning-' . $warningType,
					implode( ', ', $warnings2 ) );
			}
		}

		if ( $out !== '' ) {
			$wgOut->addHTML( '<pre><bdo dir="ltr">' . htmlspecialchars( $out ) . '</bdo></pre>' );
			$encodedValue = chunk_split( base64_encode( gzdeflate( $out ) ), 120, ' ' );
			$encAction = $this->getTitle()->escapeFullUrl();
			$wgOut->addHTML(
				"<p>\n" .
				"<form method=\"POST\" action=\"$encAction\">" .
				"<input type=\"hidden\" name=\"diffText\" value=\"$encodedValue\"/>" .
				'<input type="submit" name="editmsg_apply_patch" value="' .
					htmlspecialchars( wfMsg( 'editmsg-apply-patch' ) ) . '"/>' .
				'</form></p>' );
		}
	}

	function applyPatch() {
		global $wgRequest, $wgOut, $IP, $wgTmpDirectory, $wgUser;
		$diffText = $wgRequest->getVal( 'diffText' );
		if ( !$diffText ) {
			throw new MWException( "diffText missing" );
		}
		$diffText = gzinflate( base64_decode( $diffText ) );
		$wd = getcwd();
		chdir( $IP );
		$tmp = "$wgTmpDirectory/EditMessages/diff.out." . mt_rand( 0, 1000000000 );
		$encTmp = wfEscapeShellArg( $tmp );
		$pipe = popen( "patch -Nt -p0 > $encTmp 2>&1", 'w' );
		if ( !$pipe ) {
			$wgOut->addWikiMsg( 'editmsg-no-patch' );
			return;
		}

		fwrite( $pipe, $diffText );
		$status = pclose( $pipe );
		chdir( $wd );

		$error = file_get_contents( $tmp );
		if ( $error !== '' ) {
			$wgOut->addHTML( '<pre>' . htmlspecialchars( $error ) . '</pre>' );
		}
		if ( $status ) {
			$wgOut->addWikiMsg( 'editmsg-patch-failed', $status );
		} else {
			$wgOut->addWikiMsg( 'editmsg-patch-success' );
		}
		$sk = $wgUser->getSkin();
		$wgOut->addHTML( '<p>' . $sk->makeLinkObj( $this->getTitle(), wfMsg( 'editmsg-new-search' ) ) . '</p>' );
	}
}
