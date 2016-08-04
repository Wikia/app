var rootDir = process.cwd() + '/node_modules/design-system-i18n/i18n',
	filename = 'design-system.json',
	destDir = './i18n',
	fs = require('fs'),
	path = require('path');

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
	var i18n = require(rootDir + '/' + lang + '/' + filename),
		i18nConverted = {};

	for (var key in i18n) {
		var counter = 0;

		if (i18n.hasOwnProperty(key)) {
			i18nConverted[key] = i18n[key].replace(/__[a-z]+__/gi, function () {
				return '$' + ++counter;
			});
		}
	}

	fs.writeFileSync(destDir + '/' + lang + '.json', JSON.stringify(i18nConverted, null, 2), 'utf-8');

	console.log('Messages for language ' + lang + ' built succesfully');
});
