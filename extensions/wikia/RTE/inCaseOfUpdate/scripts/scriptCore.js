var file = require('process').argv[2];

CKEDITOR = {};
CKEDITOR.lang = {};
require('./' + file);

var lang = file.split('.')[0];
var strings = CKEDITOR.lang[lang];

console.log(JSON.stringify(strings));
