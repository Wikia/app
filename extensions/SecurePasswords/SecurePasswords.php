<?php

/**
 * SecurePasswords extension by Ryan Schmidt (Skizzerz)
 * See http://www.mediawiki.org/wiki/Extension:SecurePasswords for details
 * Code is released under the Public Domain -- just please give credit where credit is due :)
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo "Not an entry point!\n";
	die( 1 );
}

$wgValidPasswords = array(
	'minlength' => $wgMinimalPasswordLength, #Minimum password length, should be at least 8 for decent security
	'lowercase' => true, #Should we require at least one lowercase letter?
	'uppercase' => true, #Should we require at least one uppercase letter?
	'digit'     => true, #Should we require at least one digit?
	'special'   => false, #Should we require at least one special character (punctuation, etc.)?
	'usercheck' => true, #Should we disallow passwords that are the same as the username?
	'wordcheck' => function_exists( 'pspell_check' ), #Should we check the password against a dictionary to make sure that it is not a word?
);

$wgSecurePasswordSpecialChars = '.|\/!@#$%^&*\(\)-_=+\[\]{}`~,<>?\'";: '; # Character class of special characters for a regex

$wgExtensionCredits['other'][] = array(
	'name'           => 'SecurePasswords',
	'author'         => 'Ryan Schmidt',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:SecurePasswords',
	'version'        => '1.1.1',
	'svn-date'       => '$LastChangedDate: 2009-03-08 19:52:31 +0100 (ndz, 08 mar 2009) $',
	'svn-revision'   => '$LastChangedRevision: 48175 $',
	'description'    => 'Creates more secure password hashes and adds a password strength checker',
	'descriptionmsg' => 'securepasswords-desc',
);

$wgExtensionMessagesFiles['SecurePasswords'] = dirname( __FILE__ ) . '/SecurePasswords.i18n.php';

$wgHooks['UserCryptPassword'][] = 'efSecurePasswordsCrypt'; //used to encrypt passwords
$wgHooks['UserComparePasswords'][] = 'efSecurePasswordsCompare'; //used to compare a password with an encrypted password
$wgHooks['isValidPassword'][] = 'efSecurePasswordsValidate'; //used to enforce password strength
$wgHooks['NormalizeMessageKey'][] = 'efSecurePasswordsMessage'; //used to override the message to show what the password requirements are

function efSecurePasswordsCrypt( &$password, &$salt, &$wgPasswordSalt, &$hash ) {
	$hash = 'SP:';
	
	if( $salt === false ) {
		$salt = substr( wfGenerateToken(), 0, 8 );
	}
	
	$h = function_exists( 'hash' );
	$m = function_exists( 'mcrypt_encrypt' );
	$g = function_exists( 'gzcompress' );
	
	if( $h ) {
		$hash_algos = hash_algos();
		$algos = array();
		foreach( $hash_algos as $algo ) {
			switch( $algo ) {
				case 'md5':
					$algos[] = array( 'A', 'md5' );
					break;
				case 'sha1':
					$algos[] = array( 'B', 'sha1' );
					break;
				case 'sha512':
					$algos[] = array( 'C', 'sha512' );
					break;
				case 'ripemd160':
					$algos[] = array( 'D', 'ripemd160' );
					break;
				case 'ripemd320':
					$algos[] = array( 'E', 'ripemd320' );
					break;
				case 'whirlpool':
					$algos[] = array( 'F', 'whirlpool' );
					break;
				case 'tiger192,4':
					$algos[] = array( 'G', 'tiger192,4' );
					break;
				case 'snefru':
					$algos[] = array( 'H', 'snefru' );
					break;
				case 'gost':
					$algos[] = array( 'I', 'gost' );
					break;
				case 'haval256,5':
					$algos[] = array( 'J', 'haval256,5' );
					break;
			}
		}
		
		$r1 = rand( 0, count( $algos ) - 1 );
		$r2 = rand( 0, count( $algos ) - 1 );
	} else {
		$algos = array( array( 'A', 'md5' ), array( 'B', 'sha1' ) );
		$r1 = rand( 0, 1 );
		$r2 = rand( 0, 1 );
	}
	
	$type = $algos[$r1][0] . $algos[$r2][0];
	
	if( $h ) {
		$pw1 = hash( $algos[$r1][1], $password );
		$pw2 = hash( $algos[$r2][1], $salt . '-' . $pw1 );
	} else {
		if( $r1 === 0 ) {
			$pw1 = md5( $password );
		} else {
			$pw1 = sha1( $password );
		}
		
		if( $r2 === 0 ) {
			$pw2 = md5( $salt . '-' . $pw1 );
		} else {
			$pw2 = sha1( $salt . '-' . $pw1 );
		}
	}
	
	if( $m ) {
		global $wgSecretKey;
		$size = mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC );
		$ksize = mcrypt_get_key_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC );
		$iv = mcrypt_create_iv( $size, MCRYPT_RAND );
		$key = substr( $wgSecretKey, 0, $ksize - 1 );
		$pw3 = mcrypt_encrypt( MCRYPT_RIJNDAEL_256, $key, $pw2, MCRYPT_MODE_CBC, $iv );
		$pw4 = base64_encode( $pw3 ) . '|' . base64_encode( $iv );
	} else {
		$pw4 = $pw2;
	}
	
	if( $g ) {
		$pwf = base64_encode( gzcompress( $pw4 ) );
	} else {
		$pwf = base64_encode( $pw4 );
	}
	
	$hash .= $type . ':' . $salt . ':' . $pwf;
	
	// sometimes the mcrypt is invalid, so we need to do a quick check to make sure that comparing will work in the future
	// otherwise the password won't work... and that would suck
	$hash = efSecurePasswordsRecursiveCheck( $hash, $password, $salt );
	
	return false;
}

function efSecurePasswordsCompare( &$hash, &$password, &$userId, &$result ) {
	$bits = explode( ':', $hash, 4 );
	
	if( $bits[0] != 'SP' || count( $bits ) != 4 ) {
		return true;
	}
	
	$type1 = substr( $bits[1], 0, 1 );
	$type2 = substr( $bits[1], 1, 1 );
	$salt = $bits[2];
	$hash1 = $bits[3];
	
	$h = function_exists( 'hash' );
	$m = function_exists( 'mcrypt_encrypt' );
	$g = function_exists( 'gzcompress' );
	
	$algos = array(
		'A' => 'md5',
		'B' => 'sha1',
		'C' => 'sha512',
		'D' => 'ripemd160',
		'E' => 'ripemd320',
		'F' => 'whirlpool',
		'G' => 'tiger192,4',
		'H' => 'snefru',
		'I' => 'gost',
		'J' => 'haval256,5',
	);
	
	if( $h ) {
		$pw1 = hash( $algos[$type1], $password );
		$pwf = hash( $algos[$type2], $salt . '-' . $pw1 );
	} else {
		if( $r1 === 0 ) {
			$pw1 = md5( $password );
		} else {
			$pw1 = sha1( $password );
		}
		
		if( $r2 === 0 ) {
			$pwf = md5( $salt . '-' . $pw1 );
		} else {
			$pwf = sha1( $salt . '-' . $pw1 );
		}
	}
	
	if( $g ) {
		$h1 = gzuncompress( base64_decode( $hash1 ) );
	} else {
		$h1 = base64_decode( $hash1 );
	}
	
	if( $m ) {
		global $wgSecretKey;
		$ksize = mcrypt_get_key_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC );
		$key = substr( $wgSecretKey, 0, $ksize - 1 );
		$bits = explode( '|', $h1 );
		$iv = base64_decode( $bits[1] );
		$h2 = base64_decode( $bits[0] );
		$hf = mcrypt_decrypt( MCRYPT_RIJNDAEL_256, $key, $h2, MCRYPT_MODE_CBC, $iv );
	} else {
		$hf = $h1;
	}
	
	$result = ($hf === $pwf);
	return false;
}

function efSecurePasswordsRecursiveCheck( $hash, $password, $salt ) {
	$result = false;
	$x = 1; // unused, but necessary since everything is by reference
	efSecurePasswordsCompare( $hash, $password, $x, $result );
	if(!$result) {
		efSecurePasswordsCrypt( $password, $salt, $x, $hash );
		return efSecurePasswordsRecursiveCheck( $hash, $password, $salt );
	}
	return $hash;
}

function efSecurePasswordsValidate( $password, &$result, $user ) {
	// if the password matches the user's current password, then don't check for validity
	// this way users with passwords that don't fit the criteria can still log in :)
	if( ( $id = $user->getId() ) !== 0 ) {
		$dbr = wfGetDB( DB_SLAVE );
		$hash = $dbr->selectField( 'user', 'user_password', 'user_id=' . $id );
		if( User::comparePasswords( $hash, $password, $id ) ) {
			$result = true;
			return false;
		}
	}
	
	global $wgValidPasswords, $wgContLang, $wgSecurePasswordsSpecialChars;
	$lang = $wgContLang->getPreferredVariant( false );
	
	// check password length
	if( strlen( $password ) < $wgValidPasswords['minlength'] ) {
		$result = false;
		return false;
	}
	
	// check for a lowercase letter, if needed
	if( $wgValidPasswords['lowercase'] && !preg_match( '/[a-z]/', $password ) ) {
		$result = false;
		return false;
	}
	
	// check for an uppercase letter, if needed
	if( $wgValidPasswords['uppercase'] && !preg_match( '/[A-Z]/', $password ) ) {
		$result = false;
		return false;
	}
	
	// check for a digit, if needed
	if( $wgValidPasswords['digit'] && !preg_match( '/[0-9]/', $password ) ) {
		$result = false;
		return false;
	}
	
	// check for a special character, if needed
	if( $wgValidPasswords['special'] && !preg_match( '/[' . $wgSecurePasswordsSpecialChars . ']/', $password ) ) {
		$result = false;
		return false;
	}
	
	// check for the username, if needed
	if( $wgValidPasswords['usercheck'] && $wgContLang->lc( $password ) == $wgContLang->lc( $user->getName() ) ) {
		$result = false;
		return false;
	}
	
	// check for words, if needed
	if( $wgValidPasswords['wordcheck'] && function_exists( 'pspell_check' ) ) {
		$link = pspell_new( $lang );
		if( $link ) {
			if( pspell_check( $link, $password ) ) {
				$result = false;
				return false;
			}
		}
		if( $lang != 'en' ) {
			$link = pspell_new( 'en' );
			if( $link ) {
				if( pspell_check( $link, $password ) ) {
					$result = false;
					return false;
				}
			}
		}
	}

	$result = true;
	return false;
}

function efSecurePasswordsMessage( &$key, &$useDB, &$langCode, &$transform ) {
	// do we have the right key?
	if( $key != 'passwordtooshort' ) {
		return true;
	}

	// don't replace the message if we're viewing Special:AllMessages
	global $wgTitle, $wgMessageCache, $wgValidPasswords;
	if( is_object( $wgTitle ) && $wgTitle instanceOf Title ) {
		$page = $wgTitle->getText();
		$ns = $wgTitle->getNamespace();
	} else {
		// $wgTitle isn't defined, fail gracefully
		return true;
	}
	
	if( $ns === NS_SPECIAL ) {
		list( $title, $sp ) = SpecialPage::resolveAliasWithSubpage( $page );
		if( $title == 'AllMessages' ) {
			return true;
		}
	}
	
	// ok, this isn't AllMessages, so we can replace the key
	// TODO: this is an epic hack, add a hook to core to modify the message params
	if( !is_object( $wgMessageCache ) ) {
		// quit early... we can't properly change the message
		return true;
	}
	wfLoadExtensionMessages('SecurePasswords');
	$key = 'securepasswords-password';
	$msg = wfMsg( 'securepasswords-valid' ) . ' ';
	$msg .= wfMsgExt( 'securepasswords-minlength', array( 'parsemag' ), $wgValidPasswords['minlength'] );
	if( $wgValidPasswords['lowercase'] ) {
		$msg .= ', ' . wfMsg( 'securepasswords-lowercase' );
	}
	if( $wgValidPasswords['uppercase'] ) {
		$msg .= ', ' . wfMsg( 'securepasswords-uppercase' );
	}
	if( $wgValidPasswords['digit'] ) {
		$msg .= ', ' . wfMsg( 'securepasswords-digit' );
	}
	if( $wgValidPasswords['special'] ) {
		$msg .= ', ' . wfMsg( 'securepasswords-special', str_replace( '\\', '', $wgSecurePasswordsSpecialChars ) );
	}
	if( $wgValidPasswords['usercheck'] ) {
		$msg .= ', ' . wfMsgExt( 'securepasswords-username', array( 'parsemag' ), $user->getName() );
	}
	if( $wgValidPasswords['wordcheck'] ) {
		$msg .= ', ' . wfMsg( 'securepasswords-word' );
	}
	$wgMessageCache->addMessage( 'securepasswords-password', $msg, 'en' );
	
	return true;
}