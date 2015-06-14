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
$wgSecurePasswordsSecretKeys = array(false, false, false); #MUST be customized in LocalSettings.php!

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'SecurePasswords',
	'author'         => 'Ryan Schmidt',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:SecurePasswords',
	'version'        => '2.0',
	'descriptionmsg' => 'securepasswords-desc',
);

$wgExtensionMessagesFiles['SecurePasswords'] = dirname( __FILE__ ) . '/SecurePasswords.i18n.php';

$wgHooks['UserCryptPassword'][] = 'efSecurePasswordsCrypt'; //used to encrypt passwords
$wgHooks['UserComparePasswords'][] = 'efSecurePasswordsCompare'; //used to compare a password with an encrypted password
$wgHooks['isValidPassword'][] = 'efSecurePasswordsValidate'; //used to enforce password strength

//new method
function efSecurePasswordsCrypt( &$password, &$salt, &$wgPasswordSalt, &$hash ) {
	global $wgSecurePasswordsSecretKeys, $wgUser;
	if($wgSecurePasswordsSecretKeys == array(false, false, false)) {
		die('You need to customize $wgSecurePasswordsSecretKeys in your LocalSettings.php file.
		See http://www.mediawiki.org/wiki/Extension:SecurePasswords for more information');
	}
	$hash = 'S2:';
	
	if( $salt === false ) {
		$salt = substr( wfGenerateToken(), 0, 8 );
	}
	$a = efSecurePasswordsHashOrder( $wgUser->getId() ); 
	
	$hash_algos = hash_algos();
	$algos = array();
	//only use algorithms deemed "secure"
	foreach( $hash_algos as $algo ) {
		switch( $algo ) {
			case 'sha512':
				$algos[] = array( $a[0], 'sha512' );
				break;
			case 'ripemd160':
				$algos[] = array( $a[1], 'ripemd160' );
				break;
			case 'ripemd320':
				$algos[] = array( $a[2], 'ripemd320' );
				break;
			case 'whirlpool':
				$algos[] = array( $a[3], 'whirlpool' );
				break;
			case 'gost':
				$algos[] = array( $a[4], 'gost' );
				break;
			case 'tiger192,4':
				$algos[] = array( $a[5], 'tiger192,4' );
				break;
			case 'haval256,5':
				$algos[] = array( $a[6], 'haval256,5' );
				break;
			case 'sha256':
				$algos[] = array( $a[7], 'sha256' );
				break;
			case 'sha384':
				$algos[] = array( $a[8], 'sha384' );
				break;
			case 'ripemd128':
				$algos[] = array( $a[9], 'ripemd128' );
				break;
			case 'ripemd256':
				$algos[] = array( $a[10], 'ripemd256' );
				break;
		}
	}
	
	$r1 = rand( 0, count( $algos ) - 1 );
	$r2 = rand( 0, count( $algos ) - 1 );
	$type = $algos[$r1][0] . $algos[$r2][0];
	$pw1 = hash_hmac( $algos[$r2][1], $salt . '-' . hash_hmac( $algos[$r1][1], $password, $wgSecurePasswordsSecretKeys[0] ), $wgSecurePasswordsSecretKeys[1] );
	$size = mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC );
	$ksize = mcrypt_get_key_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC );
	$iv = mcrypt_create_iv( $size, MCRYPT_RAND );
	$key = substr( $wgSecurePasswordsSecretKeys[2], 0, $ksize - 1 ) . "\0";
	$pw2 = mcrypt_encrypt( MCRYPT_RIJNDAEL_256, $key, $pw1, MCRYPT_MODE_CBC, $iv );
	$pwf = base64_encode( gzcompress( base64_encode( $pw2 ) . '|' . base64_encode( $iv ) ) );
	$hash .= $type . ':' . $salt . ':' . $pwf;
	
	// sometimes the mcrypt is invalid, so we need to do a quick check to make sure that comparing will work in the future
	// otherwise the password won't work... and that would suck
	$hash = efSecurePasswordsRecursiveCheck( $hash, $password, $salt );
	
	return false;
}

function efSecurePasswordsCompare( &$hash, &$password, &$userId, &$result ) {
	global $wgSecurePasswordsSecretKeys;
	$bits = explode( ':', $hash, 4 );
	if( $bits[0] == 'SP' && count( $bits ) == 4 ) {
		//old check
		return efSecurePasswordsOldCompare( $hash, $password, $userId, $result );
	} elseif( $bits[0] != 'S2' || count( $bits ) != 4 ) {
		//must be a default hash or something, let mw handle it
		return true;
	}
	
	$type1 = substr( $bits[1], 0, 1 );
	$type2 = substr( $bits[1], 1, 1 );
	$salt = $bits[2];
	$hash1 = $bits[3];
	
	$a = efSecurePasswordsHashOrder( $userId );
	$algos = array(
		$a[0] => 'sha512',
		$a[1] => 'ripemd160',
		$a[2] => 'ripemd320',
		$a[3] => 'whirlpool',
		$a[4] => 'gost',
		$a[5] => 'tiger192,4',
		$a[6] => 'haval256,5',
		$a[7] => 'sha256',
		$a[8] => 'sha384',
		$a[9] => 'ripemd128',
		$a[10] => 'ripemd256',
	);
	$pw = hash_hmac( $algos[$type2], $salt . '-' . hash_hmac( $algos[$type1], $password, $wgSecurePasswordsSecretKeys[0] ), $wgSecurePasswordsSecretKeys[1] );
	$h1 = gzuncompress( base64_decode( $hash1 ) );
	$ksize = mcrypt_get_key_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC );
	$key = substr( $wgSecurePasswordsSecretKeys[2], 0, $ksize - 1 ) . "\0";
	$bits = explode( '|', $h1 );
	$iv = base64_decode( $bits[1] );
	$h2 = base64_decode( $bits[0] );
	$hf = mcrypt_decrypt( MCRYPT_RIJNDAEL_256, $key, $h2, MCRYPT_MODE_CBC, $iv );
	
	$result = ( $pw === $hf );
	return false;
}

//does an old compare used in version 1.x of SecurePasswords
function efSecurePasswordsOldCompare( &$hash, &$password, &$userId, &$result ) {
	$bits = explode( ':', $hash, 4 );
	
	if( $bits[0] != 'SP' || count( $bits ) != 4 ) {
		return true;
	}
	
	$type1 = substr( $bits[1], 0, 1 );
	$type2 = substr( $bits[1], 1, 1 );
	$salt = $bits[2];
	$hash1 = $bits[3];
	
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
	
	$pw1 = hash( $algos[$type1], $password );
	$pwf = hash( $algos[$type2], $salt . '-' . $pw1 );
	
	if( $g ) {
		$h1 = gzuncompress( base64_decode( $hash1 ) );
	} else {
		$h1 = base64_decode( $hash1 );
	}
	
	if( $m ) {
		global $wgSecretKey;
		$ksize = mcrypt_get_key_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC );
		$key = substr( $wgSecretKey, 0, $ksize - 1 ) . "\0";
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

	$ok = true;

	global $wgValidPasswords, $wgContLang, $wgSecurePasswordsSpecialChars, $wgLang, $wgUser;
	$lang = $wgContLang->getPreferredVariant( false );
	// check password length
	if( strlen( $password ) < $wgValidPasswords['minlength'] ) {
		$ok = false;
	}
	
	// check for a lowercase letter, if needed
	if( $wgValidPasswords['lowercase'] && !preg_match( '/[a-z]/', $password ) ) {
		$ok = false;
	}
	
	// check for an uppercase letter, if needed
	if( $wgValidPasswords['uppercase'] && !preg_match( '/[A-Z]/', $password ) ) {
		$ok = false;
	}
	
	// check for a digit, if needed
	if( $wgValidPasswords['digit'] && !preg_match( '/[0-9]/', $password ) ) {
		$ok = false;
	}
	
	// check for a special character, if needed
	if( $wgValidPasswords['special'] && !preg_match( '/[' . $wgSecurePasswordsSpecialChars . ']/', $password ) ) {
		$ok = false;
	}
	
	// check for the username, if needed
	if( $wgValidPasswords['usercheck'] && $wgContLang->lc( $password ) == $wgContLang->lc( $user->getName() ) ) {
		$ok = false;
	}
	
	// check for words, if needed
	if( $wgValidPasswords['wordcheck'] && function_exists( 'pspell_check' ) ) {
		$link = pspell_new( $lang, '', '', ( PSPELL_FAST | PSPELL_RUN_TOGETHER ) );
		if( $link ) {
			if( pspell_check( $link, $password ) ) {
				$ok = false;
			}
		}
		if( $lang != 'en' ) {
			$link = pspell_new( 'en', '', '', ( PSPELL_FAST | PSPELL_RUN_TOGETHER ) );
			if( $link ) {
				if( pspell_check( $link, $password ) ) {
					$ok = false;
				}
			}
		}
	}

	if ( !$ok ) {
		$conds = array( wfMsgExt( 'securepasswords-minlength', array( 'parsemag' ), $wgValidPasswords['minlength'] ) );
		if( $wgValidPasswords['lowercase'] ) {
			$conds[] = wfMsg( 'securepasswords-lowercase' );
		}
		if( $wgValidPasswords['uppercase'] ) {
			$conds[] = wfMsg( 'securepasswords-uppercase' );
		}
		if( $wgValidPasswords['digit'] ) {
			$conds[] = wfMsg( 'securepasswords-digit' );
		}
		if( $wgValidPasswords['special'] ) {
			$conds[] = wfMsg( 'securepasswords-special', str_replace( '\\', '', $wgSecurePasswordsSpecialChars ) );
		}
		if( $wgValidPasswords['usercheck'] ) {
			$conds[] = wfMsgExt( 'securepasswords-username', array( 'parsemag' ), $wgUser->getName() );
		}
		if( $wgValidPasswords['wordcheck'] ) {
			$conds[] = wfMsg( 'securepasswords-word' );
		}
		$result = array( 'securepasswords-valid', $wgLang->listToText( $conds ) );
		return false;
	}

	$result = true;
	return false;
}

function efSecurePasswordsHashOrder( $userid ) {
	if( $userid > 999999 ) {
		$userid = substr( $userid, 0, 6 );
	}
	$o = floor( ( ( $userid * 3 ) + 513829 ) / 5 ) + 925487; #just two random prime numbers with no significance attached
	$s = str_split( $o );
	$r = array();
	$f = false;
	$n = 64;
	//in case it is impossible to get all values 65-90 from the above values, we break after 1000 iterations
	for($i = 0; $i < 1000; $i++) {
		$n += $s[0];
		if( $n < 65 ) $n = 65;
		elseif( $n > 90 ) $n = 65 + $s[0];
		if( !in_array( chr( $n ), $r ) ) $r[] = chr( $n );
		$n -= $s[1];
		if( $n < 65 ) $n = 65;
		elseif( $n > 90 ) $n = 90 - $s[0];
		if( !in_array( chr( $n ), $r ) ) $r[] = chr( $n );
		$n += 2 * $s[2];
		if( $n < 65 ) $n = 65;
		elseif( $n > 90 ) $n = 65 + $s[0];
		if( !in_array( chr( $n ), $r ) ) $r[] = chr( $n );
		$n -= 2 * $s[3];
		if( $n < 65 ) $n = 65;
		elseif( $n > 90 ) $n = 90 - $s[0];
		if( !in_array( chr( $n ), $r ) ) $r[] = chr( $n );
		$n += 3 * $s[4];
		if( $n < 65 ) $n = 65;
		elseif( $n > 90 ) $n = 65 + $s[0];
		if( !in_array( chr( $n ), $r ) ) $r[] = chr( $n );
		$n -= 3 * $s[5];
		if( $n < 65 ) $n = 65;
		elseif( $n > 90 ) $n = 90 - $s[0];
		if( !in_array( chr( $n ), $r ) ) $r[] = chr( $n );
		if( count( $r ) == 26 ) {
			$f = true;
			break;
		}
	}
	if( !$f ) {
		return array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
	}
	return $r;
}
