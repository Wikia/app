var fs = require('fs'),
	path = require('path'),
	rootDir = process.cwd() + '/node_modules/design-system-i18n/i18n',
	filename = 'design-system.json',
	destDir = './i18n',
	// keep in sync with DesignSystem/DesignSystemHelper.class.php
	messageParamsMapping = {
		'global-footer-licensing-and-vertical-description': {
			sitename: '$1',
			vertical: '$2',
			license: '$3'
		},
		'global-navigation-search-placeholder-in-wiki': {
			sitename: '$1'
		},
		'global-footer-copyright-wikia': {
			date: '$1'
		},
		"notifications-replied-by-multiple-users-with-title": {
			mostRecentUser: '$1',
			number: '$2',
			postTitle: '$3'
		},
		"notifications-replied-by-multiple-users-no-title": {
			mostRecentUser: '$1',
			number: '$2'
		},
		"notifications-replied-by-two-users-with-title": {
			firstUser: '$1',
			secondUser: '$2',
			postTitle: '$3'
		},
		"notifications-replied-by-two-users-no-title": {
			firstUser: '$1',
			secondUser: '$2'
		},
		"notifications-replied-by-with-title": {
			user: '$1',
			number: '$2',
			postTitle: '$3'
		},
		"notifications-replied-by-no-title": {
			user: '$1',
			number: '$2'
		},
		"notifications-post-upvote-single-user-with-title": {
			postTitle: '$1'
		},
		"notifications-post-upvote-multiple-users-with-title": {
			number: '$1',
			postTitle: '$2'
		},
		"notifications-post-upvote-multiple-users-no-title": {
			number: '$1'
		},
		"notifications-reply-upvote-single-user-with-title": {
			postTitle: '$1'
		},
		"notifications-reply-upvote-multiple-users-with-title": {
			number: '$1',
			postTitle: '$2'
		},
		"notifications-reply-upvote-multiple-users-no-title": {
			number: '$1'
		}
	};

function directoryExists(path) {
	try {
		return fs.statSync(path).isDirectory();
	} catch (err) {
		return false;
	}
}

function ensureDirectoryExistence(dirname) {
	if (directoryExists(dirname)) {
		return true;
	}

	fs.mkdirSync(dirname);
}

ensureDirectoryExistence(destDir);

var languages = fs.readdirSync(rootDir).filter(function (file) {
	return fs.statSync(path.join(rootDir, file)).isDirectory();
});

languages.forEach(function (lang) {
	var i18n = require(rootDir + '/' + lang + '/' + filename);

	// Oasis uses zh for simplified Chinese, while the DS uses zh for traditional
	// so we need to correct the lang code here so the Oasis fallbacks take effect
	if (lang === 'zh') {
		lang = 'zh-hant';
	}

	Object.keys(messageParamsMapping).forEach(function (key) {
		if (i18n.hasOwnProperty(key)) {
			i18n[key] = i18n[key].replace(/__([a-z0-9]+)__/gi, function (match, param) {
				return messageParamsMapping[key][param];
			});
		}
	});

	fs.writeFileSync(destDir + '/' + lang + '.json', JSON.stringify(i18n, null, 2), 'utf-8');

	console.log('Messages for language ' + lang + ' built succesfully');
});
