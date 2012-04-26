<?php

/**
 * @see http://embeddedgmetric.googlecode.com/svn-history/r149/trunk/php/gmetric.php
 * @see http://code.google.com/p/embeddedgmetric/wiki/GmetricProtocol
 */

/**
 * This is the MIT LICENSE
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright (c) 2007 Nick Galbreath
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

function xdr_uint32($val)
{
	return pack("N", intval($val));
}

function xdr_string($str)
{
	$len = strlen(strval($str));
	$pad = (4 - $len % 4) % 4;
	return xdr_uint32($len) . $str . pack("a$pad", "");
}

function makexdr($name, $value, $typename, $units, $slope, $tmax, $dmax)
{
	if ($slope == "zero") {
		$slopenum = 0;
	} else if ($slope == "positive") {
		$slopenum = 1;
	} else if ($slope == "negative") {
		$slopenum = 2;
	} else if ($slope == "both") {
		$slopenum = 3;
	} else {
		$slopenum = 4;
	}

	$str  = xdr_uint32(0);
	$str .= xdr_string($typename);
	$str .= xdr_string($name);
	$str .= xdr_string($value);
	$str .= xdr_string($units);
	$str .= xdr_uint32($slopenum);
	$str .= xdr_uint32($tmax);
	$str .= xdr_uint32($dmax);
	return $str;
}

function gmetric_open($host, $port, $proto)
{
	if ($proto == "udp") {
		$fp = fsockopen("udp://$host", $port, $errno, $errstr);

		if (!$fp) {
			return false;
		}

		return array('protocol' => $proto,
				'socket' => $fp);
	} else if ($proto == "multicast") {
		return array('protocol' => 'not supported');

		// the code should look something like this however

		$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		if ($sock === false) {
			echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
			return false;
		}
		$address = gethostbyname($host);
		$result = socket_connect($sock, $address, $port);
		if ($result === false) {
			echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
			return false;
		}

		/**
		 ** MUTLICAST SOCKET OPTIONS GO HERE
		 ** http://devzone.zend.com/node/view/id/1432
		 ** http://diary.rozsnyo.com/2006/06/16/php-multicast/
		 **/
		return array('protocol' => $proto,
				'socket' => $sock);
	} else {
		// unknown!
		return false;
	}
}

function gmetric_send($gm, $name, $value, $typename, $units, $slope, $tmax, $dmax)
{
	$msg  = makexdr($name, $value, $typename, $units, $slope, $tmax, $dmax);
	if ($gm['protocol'] == 'udp') {
		return fwrite($gm['socket'], $msg);
	} else if ($gm['protocol'] == 'mutlicast') {
		return socket_write($gm['socket'], $msg, strlen($msg));
	} else {
		return false;
	}
}

function gmetric_close($gm)
{
	if ($gm['protocol'] == 'udp') {
		return fclose($gm['socket']);
	} else if ($gm['protocol'] == 'multicast') {
		return socket_close($gm);
	}
}

/**
  $gm = gmetric_open('localhost', 8651, 'udp');
  gmetric_send($gm, 'foo', 'bar', 'string', '', 'both', 60, 0);
  gmetric_close($gm);
 **/