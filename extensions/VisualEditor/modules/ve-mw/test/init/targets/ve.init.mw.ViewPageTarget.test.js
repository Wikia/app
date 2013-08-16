/*!
 * VisualEditor MediaWiki Initialization ViewPageTarget tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */
QUnit.module( 've.init.mw.ViewPageTarget' );

QUnit.test( 'compatibility', function ( assert ) {
	var i, profile, list, matches, compatibility,
		cases = [
			{
				'msg': 'Unidentified browser',
				'userAgent': 'FooBar Browser Company Version 3.141',
				'matches': []
			},
			{
				'msg': 'IE7',
				'userAgent': 'Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 6.0)',
				'matches': [ 'blacklist' ]
			},
			{
				'msg': 'IE8',
				'userAgent': 'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 5.2; Trident/4.0)',
				'matches': [ 'blacklist' ]
			},
			{
				'msg': 'IE9',
				'userAgent': 'Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)',
				'matches': [ 'blacklist' ]
			},
			{
				'msg': 'IE10',
				'userAgent': 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)',
				'matches': [ 'blacklist' ]
			},
			{
				'msg': 'Firefox 10',
				'userAgent': 'Mozilla/5.0 (X11; Mageia; Linux x86_64; rv:10.0.9) Gecko/20100101 Firefox/10.0.9',
				'matches': [ 'blacklist' ]
			},
			{
				'msg': 'Firefox 11',
				'userAgent': 'Mozilla/5.0 (Windows NT 6.1; U;WOW64; de;rv:11.0) Gecko Firefox/11.0',
				'matches': [ 'blacklist' ]
			},
			{
				'msg': 'Firefox 12',
				'userAgent': 'Mozilla/5.0 (compatible; Windows; U; Windows NT 6.2; WOW64; en-US; rv:12.0) Gecko/20120403211507 Firefox/12.0',
				'matches': [ 'blacklist' ]
			},
			{
				'msg': 'Firefox 13',
				'userAgent': 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0',
				'matches': [ 'blacklist' ]
			},
			{
				'msg': 'Firefox 14',
				'userAgent': 'Mozilla/5.0 (Windows NT 6.1; rv:12.0) Gecko/20120403211507 Firefox/14.0.1',
				'matches': [ 'blacklist' ]
			},
			{
				'msg': 'Firefox 15',
				'userAgent': 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:15.0) Gecko/20100101 Firefox/15.0.1',
				'matches': [ 'whitelist' ]
			},
			{
				'msg': 'Firefox 24',
				'userAgent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0',
				'matches': [ 'whitelist' ]
			},
			{
				'msg': 'Iceweasel 9',
				'userAgent': 'Mozilla/5.0 (X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1 Iceweasel/9.0.1',
				'matches': []
			},
			{
				'msg': 'Iceweasel 10',
				'userAgent': 'Mozilla/5.0 (X11; Linux x86_64; rv:10.0) Gecko/20100101 Firefox/10.0 Iceweasel/10.0',
				'matches': [ 'whitelist' ]
			},
			{
				'msg': 'Iceweasel 15',
				'userAgent': 'Mozilla/5.0 (X11; Linux x86_64; rv:15.0) Gecko/20100101 Firefox/15.0.1 Iceweasel/15.0.1',
				'matches': [ 'whitelist' ]
			},
			{
				'msg': 'Safari 4',
				'userAgent': 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_3; en-us) AppleWebKit/531.21.11 (KHTML, like Gecko) Version/4.0.4 Safari/531.21.10',
				'matches': []
			},
			{
				'msg': 'Safari 5',
				'userAgent': 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_3; en-us) AppleWebKit/534.1+ (KHTML, like Gecko) Version/5.0 Safari/533.16',
				'matches': [ 'whitelist' ]
			},
			{
				'msg': 'Safari 6',
				'userAgent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 1084) AppleWebKit/536.30.1 (KHTML like Gecko) Version/6.0.5 Safari/536.30.1',
				'matches': [ 'whitelist' ]
			},
			{
				'msg': 'Chrome 18',
				'userAgent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_5_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.151 Safari/535.19',
				'matches': []
			},
			{
				'msg': 'Chrome 19',
				'userAgent': 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.3 (KHTML, like Gecko) Chrome/19.0.1061.0 Safari/536.3',
				'matches': [ 'whitelist' ]
			},
			{
				'msg': 'Chrome 27',
				'userAgent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36',
				'matches': [ 'whitelist' ]
			},
			{
				'msg': 'Android 2.3',
				'userAgent': 'Mozilla/5.0 (Linux; U; Android 2.3.5; en-us; HTC Vision Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
				'matches': [ 'blacklist' ]
			},
			{
				'msg': 'Android 3.0',
				'userAgent': 'Mozilla/5.0 (Linux; U; Android 3.0; en-us; Xoom Build/HRI39) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13',
				'matches': []
			},
			{
				'msg': 'Android 4.0',
				'userAgent': 'Mozilla/5.0 (Linux; U; Android 4.0.3; HTC Sensation Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
				'matches': []
			},
			{
				'msg': 'Opera 11',
				'userAgent': 'Opera/9.80 (Windows NT 5.1) Presto/2.10.229 Version/11.64',
				'matches': [ 'blacklist' ]
			},
			{
				'msg': 'Opera 12',
				'userAgent': 'Opera/9.80 (Windows NT 5.1) Presto/2.12.388 Version/12.16',
				'matches': []
			},
			{
				'msg': 'BlackBerry',
				'userAgent': 'Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.346 Mobile Safari/534.11+',
				'matches': [ 'blacklist' ]
			}
		];

	compatibility = {
		'whitelist': ve.init.mw.ViewPageTarget.compatibility.whitelist,
		// TODO: Fix this mess when we split ve.init from ve.platform
		'blacklist': mw.libs.ve.blacklist
	};

	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		profile = $.client.profile( { 'userAgent': cases[i].userAgent, 'platform': '' } );
		matches = [];
		for ( list in compatibility ) {
			if ( $.client.test( compatibility[list], profile, true ) ) {
				matches.push( list );
			}
		}
		assert.deepEqual( matches, cases[i].matches,
			cases[i].msg + ': ' + ( cases[i].matches.length ? cases[i].matches.join() : 'greylist (no matches)' ) );
	}
} );
