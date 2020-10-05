var fs = require('fs'),
	path = require('path'),
	rootDir = process.cwd() + '/node_modules/design-system/i18n',
	filename = 'design-system.json',
	destDir = './i18n',
	// keep in sync with DesignSystem/DesignSystemHelper.class.php
	messageParamsMapping = {
		'global-footer-licensing-and-vertical-description': {
			sitename: '$1',
			vertical: '$2'
		},
		'global-navigation-search-placeholder-in-wiki': {
			sitename: '$1'
		},
		'global-footer-copyright-wikia': {
			date: '$1'
		},
		'license-description': {
			license: '$1'
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

	// zh in DS is zh-hans in Oasis
	if (lang === 'zh') {
		lang = 'zh-hans';
	}

	Object.keys(messageParamsMapping).forEach(function (key) {
		if (i18n.hasOwnProperty(key)) {
			i18n[key] = i18n[key].replace(/{(\w+)}/g, function (match, param) {
				return messageParamsMapping[key][param];
			});
		}
	});

	fs.writeFileSync(destDir + '/' + lang + '.json', JSON.stringify(i18n, null, 2), 'utf-8');

	console.log('Messages for language ' + lang + ' built succesfully');
});
