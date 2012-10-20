/*
@test-framework QUnit
@test-require-asset resources/jquery/jquery-1.7.2.js
 @test-require-asset resources/wikia/libraries/jquery/throttle-debounce/jquery.throttle-debounce.js
@test-require-asset resources/wikia/jquery.wikia.js
@test-require-asset extensions/wikia/Chat2/js/emoticons.js
@test-require-asset extensions/wikia/Chat2/js/lib/underscore.js
@test-require-asset extensions/wikia/Chat2/js/lib/backbone.js
@test-require-asset extensions/wikia/Chat2/js/views/views.js
*/
module("ChatView Test");
test("processText links", function() {
	/*
	 * some mockup so we can create NodeRoomController
	 */
	window.wgServer = "http://poznan.mech.wikia-dev.com";
	window.wgArticlePath = "/wiki/$1";
	window.EMOTICONS = '';

	// create a view instance and test the processtest method
	var c = new ChatView({});
    equal(c.processText('[[Test_underscores]]'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Test_underscores">Test underscores</a>',
 		   'underscores in article name');

    equal(c.processText('[[Are you sure?]][[xxx]]'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Are_you_sure%3F">Are you sure?</a><a href="http://poznan.mech.wikia-dev.com/wiki/xxx">xxx</a>',
 			'two links in brackets');

    equal(c.processText('[[Are you sure?]]'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Are_you_sure%3F">Are you sure?</a>',
 		   'escaping question mark in bracket link');

    equal(c.processText('[[Are you sure?|Custom?]]'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Are_you_sure%3F">Custom?</a>',
 		   'escaping question mark in pipelined bracket link');

    equal(c.processText('http://poznan.mech.wikia-dev.com/index.php?title=Lost&action=edit'),
 		   '<a href="http://poznan.mech.wikia-dev.com/index.php?title=Lost&action=edit">http://poznan.mech.wikia-dev.com/index.php?title=Lost&action=edit</a>',
 		   'not escaping question mark in local wiki url');

    equal(c.processText('http://poznan.mech.wikia-dev.com/wiki/Lost?action=edit'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Lost?action=edit">Lost?action=edit</a>',
 		   'not escaping question mark in local wiki url and shortening local url');

    equal(c.processText('http://poznan.mech.wikia.com/index.php?title=Lost&action=edit'),
 		   '<a href="http://poznan.mech.wikia.com/index.php?title=Lost&action=edit">http://poznan.mech.wikia.com/index.php?title=Lost&action=edit</a>',
 		   'not escaping question mark in external url');

    equal(c.processText('http://poznan.mech.wikia.com/wiki/Lost?action=edit'),
 		   '<a href="http://poznan.mech.wikia.com/wiki/Lost?action=edit">http://poznan.mech.wikia.com/wiki/Lost?action=edit</a>',
 		   'not escaping question mark in external wiki address');

    equal(c.processText('http://poznan.mech.wikia.com/wiki/Lost?action=edit http://poznan.mech.wikia.com/wiki/Lost2?action=edit'),
 		   '<a href="http://poznan.mech.wikia.com/wiki/Lost?action=edit">http://poznan.mech.wikia.com/wiki/Lost?action=edit</a> <a href="http://poznan.mech.wikia.com/wiki/Lost2?action=edit">http://poznan.mech.wikia.com/wiki/Lost2?action=edit</a>',
 		   'two external links in one message');

    equal(c.processText('[[Are you sure?]] http://poznan.mech.wikia-dev.com/wiki/Lost?action=edit'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Are_you_sure%3F">Are you sure?</a> <a href="http://poznan.mech.wikia-dev.com/wiki/Lost?action=edit">Lost?action=edit</a>',
 		   'local and external link in one message');

    equal(c.processText('[[XXX:YY/ZZZ]]'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/XXX:YY/ZZZ">XXX:YY/ZZZ</a>',
 		   'bracket link with slashes and colons');

    equal(c.processText('[[Benutzer_Blog:MtaÄ/Änderungen_am_Geschichtsseiten-Layout]]'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout">Benutzer Blog:MtaÄ/Änderungen am Geschichtsseiten-Layout</a>',
 		   'bracket link with national characters');

    equal(c.processText('http://poznan.mech.wikia-dev.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout">Benutzer_Blog:MtaÄ/Änderungen_am_Geschichtsseiten-Layout</a>',
 		   'local url with national characters');

    equal(c.processText('http://poznan.mech.wikia.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout'),
 		   '<a href="http://poznan.mech.wikia.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout">http://poznan.mech.wikia.com/wiki/Benutzer_Blog:MtaÄ/Änderungen_am_Geschichtsseiten-Layout</a>',
 		   'external url with national characters');

    equal(c.processText('[[Benutzer_Blog:MtaÄ/Änderungen_am_Geschichtsseiten-Layout|Benutzer_Blog:MtaÄ/Änderungen_am_Geschichtsseiten-Layou]]'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout">Benutzer Blog:MtaÄ/Änderungen am Geschichtsseiten-Layou</a>',
 		   'pipelined bracket link with national characters');

    equal(c.processText('http://poznan.mech.wikia-dev.com/wiki/Benutzer:MtaÄ'),
   		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Benutzer:MtaÄ">Benutzer:MtaÄ</a>',
   		   'local url with non-ascii characters');

    equal(c.processText('http://de.community.wikia.com/wiki/Benutzer:MtaÄ'),
  		   '<a href="http://de.community.wikia.com/wiki/Benutzer:MtaÄ">http://de.community.wikia.com/wiki/Benutzer:MtaÄ</a>',
  		   'external url with non-ascii characters');

    equal(c.processText('http://www.wikia.com'),
   		   '<a href="http://www.wikia.com">http://www.wikia.com</a>',
   		   'server only');

    equal(c.processText('http://www.wikia.com:443'),
    		   '<a href="http://www.wikia.com:443">http://www.wikia.com:443</a>',
    		   'server with port');

    equal(c.processText('http://www.wikia.com/'),
    		   '<a href="http://www.wikia.com/">http://www.wikia.com/</a>',
    		   'root document');

    equal(c.processText('go to http://www.wikia.com/.'),
 		   'go to <a href="http://www.wikia.com/">http://www.wikia.com/</a>.',
 		   'dot at the end');

    equal(c.processText('Did you see the news on http://www.wikia.com/?'),
  		   'Did you see the news on <a href="http://www.wikia.com/">http://www.wikia.com/</a>?',
  		   'question mark at the end');

    equal(c.processText('http://www.wikia.com/, http://www.google.pl'),
   		   '<a href="http://www.wikia.com/">http://www.wikia.com/</a>, <a href="http://www.google.pl">http://www.google.pl</a>',
   		   'coma separated addresses');

	equal(c.processText('http://potentially_dangerous_site.com/#http://poznan.mech.wikia-dev.com/wiki/Click%20here'),
		'<a href="http://potentially_dangerous_site.com/#http://poznan.mech.wikia-dev.com/wiki/Click%20here">http://potentially_dangerous_site.com/#http://poznan.mech.wikia-dev.com/wiki/Click here</a>',
		'showing potentially dangerous URL as a local link (bugid:44524)');

    equal(c.processText('[[Namespace:Test pipe trick|]]'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Namespace:Test_pipe_trick">Test pipe trick</a>',
 		   'pipe-trick link with namespace');

    equal(c.processText('[[Test pipe trick|]]'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Test_pipe_trick">Test pipe trick</a>',
 		   'pipe-trick link without namespace');

    equal(c.processText('[[Namespace:Test_pipe_trick:Foo:bar|]]'),
 		   '<a href="http://poznan.mech.wikia-dev.com/wiki/Namespace:Test_pipe_trick:Foo:bar">Test pipe trick:Foo:bar</a>',
 		   'pipe-trick link with namespace and multiple colons');
});
