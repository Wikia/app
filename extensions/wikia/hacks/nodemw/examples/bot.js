var TEMPLATE = 'Brak ważnej treści',
	SUMMARY = 'Brak ważnej treści',
	//regexp = /\|kody\=\s+\|/;
	regexp = /^\s*{{Ulica infobox[^{]+}}\s*$/;

var bot = require('../lib/bot').bot;

var client = new bot({
	server: 'poznan.wikia.com',
	//server: 'poznan.macbre.wikia-dev.com',
	//proxy: 'dev-macbre',
	//debug: true
});

// log in
client.logIn('xxx', 'xxx', function(data) {
	console.log('Logged in as ' + data.lgusername + ' (session ID: ' + data.sessionid + ')');

	client.getPagesInCategory('Ulice', function(pages) {
		pages && pages.forEach(function(page) {
			// ignore pages outside main namespace
			if (page.ns != 0) {
				return;
			}

			client.getArticle(page.title, function(content) {
				if (content.indexOf(TEMPLATE) > -1) return;
				if (!regexp.test(content)) return;

				// add a template
				content = content + '{{' + TEMPLATE + '}}';

				console.log('\n\n================================\n' + page.title + '\n================================');
				console.log(content);

				// and save it
				/**/
				client.edit(page.title, content, SUMMARY, function(data) {
					console.log('\n\n> ' + page.title + ' edited!');
				});
				/**/
			});
		});
	});

/**
	client.edit('Foo', 'Test', 'Test --~~~~', function(data) {
		console.log(data);
	});
**/
});
