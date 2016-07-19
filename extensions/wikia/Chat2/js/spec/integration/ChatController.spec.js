describe("ChatView Test", function(){
	var origwgServer,
		origwgArticlePath,
		origEMOTICONS;

	beforeEach(function(){
		origwgServer = window.wgServer;
		origwgArticlePath = window.wgArticlePath;
		origEMOTICONS = window.wgChatEmoticons;

		/*
		 * some mockup so we can create NodeRoomController
		 */
		window.wgServer = "http://poznan.mech.wikia-dev.com";
		window.wgArticlePath = "/wiki/$1";
		window.wgChatEmoticons = '';
	});

	afterEach(function(){
		window.wgServer = origwgServer;
		window.wgArticlePath = origwgArticlePath;
		window.wgChatEmoticons = origEMOTICONS;
	});

	it("processText links", function() {
		// create a view instance and test the processtest method
		var c = new ChatView({});

		expect(c.processText('[[Test_underscores]]'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/Test_underscores">Test underscores</a>', 'underscores in article name');

		expect(c.processText('[[Are you sure?]][[xxx]]'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/Are_you_sure%3F">Are you sure?</a><a href="http://poznan.mech.wikia-dev.com/wiki/xxx">xxx</a>', 'two links in brackets');

		expect(c.processText('[[Are you sure?]]'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/Are_you_sure%3F">Are you sure?</a>', 'escaping question mark in bracket link');

		expect(c.processText('[[Are you sure?|Custom?]]'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/Are_you_sure%3F">Custom?</a>', 'escaping question mark in pipelined bracket link');

		expect(c.processText('http://poznan.mech.wikia-dev.com/index.php?title=Lost&action=edit'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/index.php?title=Lost&action=edit">http://poznan.mech.wikia-dev.com/index.php?title=Lost&action=edit</a>', 'not escaping question mark in local wiki url');

		expect(c.processText('http://poznan.mech.wikia-dev.com/wiki/Lost?action=edit'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/Lost?action=edit">Lost?action=edit</a>', 'not escaping question mark in local wiki url and shortening local url');

		expect(c.processText('http://poznan.mech.wikia.com/index.php?title=Lost&action=edit'))
			.toEqual('<a href="http://poznan.mech.wikia.com/index.php?title=Lost&action=edit">http://poznan.mech.wikia.com/index.php?title=Lost&action=edit</a>', 'not escaping question mark in external url');

		expect(c.processText('http://poznan.mech.wikia.com/wiki/Lost?action=edit'))
			.toEqual('<a href="http://poznan.mech.wikia.com/wiki/Lost?action=edit">http://poznan.mech.wikia.com/wiki/Lost?action=edit</a>', 'not escaping question mark in external wiki address');

		expect(c.processText('http://poznan.mech.wikia.com/wiki/Lost?action=edit http://poznan.mech.wikia.com/wiki/Lost2?action=edit'))
			.toEqual('<a href="http://poznan.mech.wikia.com/wiki/Lost?action=edit">http://poznan.mech.wikia.com/wiki/Lost?action=edit</a> <a href="http://poznan.mech.wikia.com/wiki/Lost2?action=edit">http://poznan.mech.wikia.com/wiki/Lost2?action=edit</a>', 'two external links in one message');

		expect(c.processText('[[Are you sure?]] http://poznan.mech.wikia-dev.com/wiki/Lost?action=edit'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/Are_you_sure%3F">Are you sure?</a> <a href="http://poznan.mech.wikia-dev.com/wiki/Lost?action=edit">Lost?action=edit</a>', 'local and external link in one message');

		expect(c.processText('[[XXX:YY/ZZZ]]'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/XXX:YY/ZZZ">XXX:YY/ZZZ</a>', 'bracket link with slashes and colons');

		expect(
			c.processText('[[Benutzer_Blog:MtaÄ/Änderungen_am_Geschichtsseiten-Layout]]')
		)
		.toEqual(
			'<a href="http://poznan.mech.wikia-dev.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout">Benutzer Blog:MtaÄ/Änderungen am Geschichtsseiten-Layout</a>',
			'bracket link with national characters'
		);

		expect(
			c.processText('http://poznan.mech.wikia-dev.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout')
		)
		.toEqual(
			'<a href="http://poznan.mech.wikia-dev.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout">Benutzer Blog:MtaÄ/Änderungen am Geschichtsseiten-Layout</a>',
			'local url with national characters'
		);

		expect(
			c.processText('http://poznan.mech.wikia.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout')
		)
		.toEqual(
			'<a href="http://poznan.mech.wikia.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout">http://poznan.mech.wikia.com/wiki/Benutzer_Blog:MtaÄ/Änderungen_am_Geschichtsseiten-Layout</a>',
			'external url with national characters'
		);

		expect(
			c.processText('[[Benutzer_Blog:MtaÄ/Änderungen_am_Geschichtsseiten-Layout|Benutzer_Blog:MtaÄ/Änderungen_am_Geschichtsseiten-Layout]]')
		)
		.toEqual(
			'<a href="http://poznan.mech.wikia-dev.com/wiki/Benutzer_Blog:Mta%C3%84/%C3%84nderungen_am_Geschichtsseiten-Layout">Benutzer Blog:MtaÄ/Änderungen am Geschichtsseiten-Layout</a>',
			'pipelined bracket link with national characters'
		);

		expect(c.processText('http://poznan.mech.wikia-dev.com/wiki/Benutzer:MtaÄ'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/Benutzer:MtaÄ">Benutzer:MtaÄ</a>','local url with non-ascii characters');

		expect(c.processText('http://de.community.wikia.com/wiki/Benutzer:MtaÄ'))
			.toMatch('<a href="http://de.community.wikia.com/wiki/Benutzer:MtaÄ">http://de.community.wikia.com/wiki/Benutzer:MtaÄ</a>', 'external url with non-ascii characters');

		expect(c.processText('http://www.wikia.com'))
			.toEqual('<a href="http://www.wikia.com">http://www.wikia.com</a>', 'server only');

		expect(c.processText('http://www.wikia.com:443'))
			.toEqual('<a href="http://www.wikia.com:443">http://www.wikia.com:443</a>', 'server with port');

		expect(c.processText('http://www.wikia.com/'))
			.toEqual('<a href="http://www.wikia.com/">http://www.wikia.com/</a>', 'root document');

		expect(c.processText('go to http://www.wikia.com/.'))
			.toEqual('go to <a href="http://www.wikia.com/">http://www.wikia.com/</a>.', 'dot at the end');

		expect(c.processText('Did you see the news on http://www.wikia.com/?'))
			.toEqual('Did you see the news on <a href="http://www.wikia.com/">http://www.wikia.com/</a>?', 'question mark at the end');

		expect(c.processText('http://www.wikia.com/, http://www.google.pl'))
			.toEqual('<a href="http://www.wikia.com/">http://www.wikia.com/</a>, <a href="http://www.google.pl">http://www.google.pl</a>', 'coma separated addresses');

		expect(c.processText('http://potentially_dangerous_site.com/#http://poznan.mech.wikia-dev.com/wiki/Click%20here'))
			.toEqual('<a href="http://potentially_dangerous_site.com/#http://poznan.mech.wikia-dev.com/wiki/Click%20here">http://potentially_dangerous_site.com/#http://poznan.mech.wikia-dev.com/wiki/Click here</a>', 'showing potentially dangerous URL as a local link (bugid:44524)');

		expect(c.processText('[[Namespace:Test pipe trick|]]'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/Namespace:Test_pipe_trick">Test pipe trick</a>', 'pipe-trick link with namespace');

		expect(c.processText('[[Test pipe trick|]]'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/Test_pipe_trick">Test pipe trick</a>', 'pipe-trick link without namespace');

		expect(c.processText('[[Namespace:Test_pipe_trick:Foo:bar|]]'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/Namespace:Test_pipe_trick:Foo:bar">Test pipe trick:Foo:bar</a>', 'pipe-trick link with namespace and multiple colons');

		expect(c.processText('http://poznan.mech.wikia-dev.com/wiki/Test_Page'))
			.toEqual('<a href="http://poznan.mech.wikia-dev.com/wiki/Test_Page">Test Page</a>', 'replace underscores with spaces in local link names');
	});
});
