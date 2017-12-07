var file = require('process').argv[2];

CKEDITOR = {};
CKEDITOR.lang = {};

CKEDITOR.plugins = {};

CKEDITOR.plugins.setLang = function(pluginName, langCode, langEntries){
CKEDITOR.lang[langCode] = langEntries;
console.log(JSON.stringify(langEntries));

};

require('./' + file);


