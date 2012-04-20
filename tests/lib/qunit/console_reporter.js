/*
 * Qunit overrides for phantomJS test runner
 * 
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
QUnit.testStart = function(data){
	console.log('Test running: ', data.module, '::', data.name);
};

QUnit.testDone = function(data){
	console.log('Test completed', data.module, '::', data.name, '(', data.failed, 'failed and', data.passed,'passed on', data.total, 'total)' );
};

QUnit.log = function(data){
	console.log('Assert:', data.message, 'is', data.result);
};

QUnit.moduleStart = function(data){
	console.log('Module running:', data.name);
};

QUnit.moduleDone = function(data){
	console.log('Module completed', data.name, '(', data.failed, 'failed and', data.passed,'passed on', data.total, 'total)' );
};

QUnit.begin = function(){
	console.log('Start...');
};

QUnit.done = function(data){
	console.log('End -', data.failed, 'failed and', data.passed,'passed on', data.total, 'total in', data.runtime, 'milliseconds');
	console.log('!!PHANTOM_EXIT!!');
};