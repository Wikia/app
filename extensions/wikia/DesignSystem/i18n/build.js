var fs = require('fs'),
	path = require('path'),
	rootDir = process.cwd() + '/node_modules/design-system-i18n/i18n',
	filename = 'design-system.json',
	destDir = './i18n',
	variablesMapping = {
		'global-footer-licensing-and-vertical-description': {
			sitename: '$1',
			vertical: '$2',
			license: '$3'
		}
	};

function directoryExists(path) {
	try {
		return fs.statSync(path).isDirectory();
	}
	catch (err) {
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

	Object.keys(variablesMapping).forEach(function (key) {
		if (i18n.hasOwnProperty(key)) {
			i18n[key] = i18n[key].replace(/__([a-z]+)__/gi, function (match, variable) {
				return variablesMapping[key][variable];
			});
		}
	});

	fs.writeFileSync(destDir + '/' + lang + '.json', JSON.stringify(i18n, null, 2), 'utf-8');

	console.log('Messages for language ' + lang + ' built succesfully');
});
