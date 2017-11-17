const fs = require('fs'),
	path = 'src/locales/',
	languages = fs.readdirSync(path);
let result = '';

languages.forEach((lang, index) => {
	const stat = fs.statSync(path + lang);
	if (stat.isDirectory()) {
		const translations = fs.readFileSync(path + lang + '/main.json').toString();
		result += '"' + lang + '": ' + translations;
		if (index < languages.length - 1) {
			result += ',\n';
		}
	}
});

result = 'var wikiaJWPlayeri18n = {\n' + result + '\n};';

fs.writeFileSync('src/i18n.js', result);
