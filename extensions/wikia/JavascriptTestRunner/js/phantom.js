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

page.open('test.html', function(){
	page.includeJs( test, function(){
		console.log('runs!');
		phantom.exit();
	} );
});