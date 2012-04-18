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
	requiredFiles.push('extensions/wikia/JavascriptTestRunner/js/qunit.js');
} else {
	console.error("You're fucked without a test framework");
	phantom.exit(-1);
}

do {
    match = requires.exec(testSource);
    if (match) {
    	requiredFiles.push(match[1]);
        //console.log(match[1]);
    }
} while (match != null);

console.log(requiredFiles);

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
	// run the tests here
	console.log('callback called!!!');
	page.includeJs( test, function(){
		console.log('runs!');
		phantom.exit();
		} 
	);	
});

page.open('test.html', runAll);
