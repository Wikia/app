<?php

/*

md5crypt.php5
--------------
Modified by
   - Bryan Tong Minh

Written by

   - Dennis Riehle <selfhtml@riehle-web.com>

Based on

   - perl's Crypt::PasswdMD5 by Luis Munoz (lem@cantv.net)
   - phyton's md5crypt.py by Michal Wallace http://www.sabren.com/
   - /usr/src/libcrypt/crypt.c from FreeBSD 2.2.5-RELEASE

Many thanks to

   - Fabian Steiner <info@fabis-site.net>
     without him this script would not work!!

Version:   1.0 stable
Last edit: Tue, 13 September 2005 13:49:28 GMT


USAGE

  $cryptedpassword = md5crypt_unix   ($password [, $salt [, $magicstring ]);
  $apachepassword  = md5crypt_apache ($password [, $salt]);

DESCRIPTION

  unix_md5_crypt() provides a crypt()-compatible interface to the
  rather new MD5-based crypt() function found in modern operating systems.
  It's based on the implementation found on FreeBSD 2.2.[56]-RELEASE and
  contains the following license in it:

   "THE BEER-WARE LICENSE" (Revision 42):
   <phk@login.dknet.dk> wrote this file.  As long as you retain this notice you
   can do whatever you want with this stuff. If we meet some day, and you think
   this stuff is worth it, you can buy me a beer in return.   Poul-Henning Kamp

  apache_md5_crypt() provides a function compatible with Apache's
  .htpasswd files. This was contributed by Bryan Hart <bryan@eai.com>.

*/

class Md5crypt {
	private static $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

	static function to64($v, $n) {
		$ret = '';

		while(--$n >= 0) {
			$ret .= self::$itoa64{$v & 0x3f};
			$v = $v >> 6;
		}
		return $ret;
	}

	static function encryptPassword($pw, $salt = NULL, $Magic = '$1$') {
		if($salt !== NULL) {
			// Take care of the magic string if present
			if(substr($salt, 0, strlen($Magic)) == $Magic) {
				$salt = substr($salt, strlen($Magic), strlen($salt));
			}
			// Salt can have up to 8 characters
			$parts = explode('$', $salt, 1);
			$salt = substr($parts[0], 0, 8);
		} else {
			$salt = '';
			mt_srand((double)(microtime() * 10000000));

			while(strlen($salt) < 8) {
				$salt .= self::$itoa64{mt_rand(0, strlen(self::$itoa64))};
			}
		}

		$ctx = $pw . $Magic . $salt;

		$final = pack('H*', md5($pw . $salt . $pw));

		for ($pl = strlen($pw); $pl > 0; $pl -= 16) {
		   $ctx .= substr($final, 0, ($pl > 16) ? 16 : $pl);
		}

		// Now the 'weird' xform
		for($i = strlen($pw); $i; $i >>= 1) {
			if($i & 1) {			// This comes from the original version,
				$ctx .= pack("C", 0);   // where a memset() is done to $final
			} else {			// before this loop
				$ctx .= $pw{0};
			}
		}

		$final = pack('H*', md5($ctx)); // The following is supposed to make
						// things run slower

		for($i = 0; $i < 1000; $i++) {
			$ctx1 = '';
			if($i & 1) {
				$ctx1 .= $pw;
			} else {
				$ctx1 .= substr($final, 0, 16);
			}
			if($i % 3) {
				$ctx1 .= $salt;
			}
			if($i % 7) {
				$ctx1 .= $pw;
			}
			if($i & 1) {
				$ctx1 .= substr($final, 0, 16);
			} else {
				$ctx1 .= $pw;
			}
			$final = pack('H*', md5($ctx1));
		}

		// Final xform
		$passwd = '';
		$passwd .= self::to64((intval(ord($final{0})) << 16)
					|(intval(ord($final{6})) << 8)
					|(intval(ord($final{12}))),4);
		$passwd .= self::to64((intval(ord($final{1})) << 16)
					|(intval(ord($final{7})) << 8)
					|(intval(ord($final{13}))), 4);
		$passwd .= self::to64((intval(ord($final{2})) << 16)
					|(intval(ord($final{8})) << 8)
					|(intval(ord($final{14}))), 4);
		$passwd .= self::to64((intval(ord($final{3})) << 16)
					|(intval(ord($final{9})) << 8)
					|(intval(ord($final{15}))), 4);
		$passwd .= self::to64((intval(ord($final{4}) << 16)
					|(intval(ord($final{10})) << 8)
					|(intval(ord($final{5})))), 4);
		$passwd .= self::to64((intval(ord($final{11}))), 2);

		// Return the final string
		return $Magic . $salt . '$' . $passwd;
	}
}
