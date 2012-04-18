var page = require('webpage').create(),
	system = require('system'),
	test;

if (system.args.length === 1) {
	console.log('Usage: phantom.js <test file>');
	phantom.exit();
}

test = system.args[2];

page.includeJS( test, function(){
	console.log('runs!');
	phantom.exit();
} );

console.log('fuck!');