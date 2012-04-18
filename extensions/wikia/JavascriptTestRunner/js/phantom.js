var page = require('webpage').create(),
	system = require('system'),
	test;

if (system.args.length === 1) {
	console.log('Usage: phantom.js <test file>');
	phantom.exit();
}

test = system.args[1];

page.onConsoleMessage = function(msg){
	console.log(msg);
	if (msg == '!!PHANTOM_EXIT!!') {
		phantom.exit();
	}
};

page.onError  = function(msg){
	console.error(msg);
};

var fs = require('fs');
var testSource = fs.read(test);

var framework = /@test-framework[\s]+([^\s]+)/g;
framework = framework.exec(testSource);
console.log(framework[1]);

var requires = /@test-require-file[\s]+([^\s]+)/g, requiredFiles = [], match;

if (framework[1] == "QUnit") {
	requiredFiles.push('../extensions/wikia/JavascriptTestRunner/js/qunit.js');
	requiredFiles.push('../extensions/wikia/JavascriptTestRunner/js/phantom-qunit.js');
} else if (framework[1] == "jsUnity") {
	requiredFiles.push('../extensions/wikia/JavascriptTestRunner/js/jsunity-0.6.js');
} else {
	console.error("You're fucked without a test framework");
	phantom.exit(-1);
}

do {
    match = requires.exec(testSource);
    if (match) {
    	requiredFiles.push('../' + match[1]);
        //console.log(match[1]);
    }
} while (match != null);

requiredFiles.push(test);

console.log(requiredFiles);

var htmlTemplate = fs.read('test.html');

var header = '';
for(var i = 0 ; i < requiredFiles.length ; i++) {
	header += '<script type="text/javascript" src="' + requiredFiles[i] + '"></script>\n';
}
htmlTemplate = htmlTemplate.replace( '<!--PHANTOM_SCRIPT_PLACEHOLDER-->', header);

var tempPath = 'phantom_js_test.html';

fs.write(tempPath, htmlTemplate, 'w');

page.open(tempPath);

/*
var runAll = function(files, runTestsCallback) {
  var no = -1;
  function consumer() {
	  no++;
	  if (no >= files.length) {
		  runTestsCallback();
		  return;
	  }
	  console.log('Will include ' + files[no]);
	  page.includeJs('../' + files[no], consumer);
  };
  return consumer;
}(requiredFiles, function() {
	page.evaluate(function() {
		console.log('EVALUATED!');
		console.log(this);
		
		jsUnity.log = function (s) {
			console.log('jsUnity: ' + s);
		};
	});
	// run the tests here
	console.log('callback called!!!');
	page.includeJs( test, function(){
			console.log('will run some tests!');
			phantom.exit();
		} 
	);	
});

page.open('test.html', runAll);
*/
