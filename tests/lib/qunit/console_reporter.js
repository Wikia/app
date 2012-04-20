/*
 * Qunit overrides for phantomJS test runner
 * 
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
QUnit.testStart = function(data){
	console.log('Test running: ', data.module, '::', data.name);
	console.log(JSON.stringify({
		command:'startTest',
		name: data.name
	}));
    QUnit.reporter_messages = [];
    QUnit.reporter_assertions = 0;

};

QUnit.testDone = function(data){
	console.log('Test completed', data.module, '::', data.name, '(', data.failed, 'failed and', data.passed,'passed on', data.total, 'total)' );
		
	console.log(JSON.stringify({
		command:'stopTest',
		status: data.failed == 0 ? 'SUCCESS' : 'FAILURE',
		assertions: QUnit.reporter_assertions,
		messages: QUnit.reporter_messages.join('\n')
	}));
};

QUnit.log = function(data){
    QUnit.reporter_assertions++;
    if (!data.result) QUnit.reporter_messages.push(data.message);
	console.log('Assert:', data.message, 'is', data.result);
};

QUnit.moduleStart = function(data){
	console.log('Module running:', data.name);
	console.log(JSON.stringify({
		command:'startSuite',
		name: data.name
	}));
};

QUnit.moduleDone = function(data){
	console.log('Module completed', data.name, '(', data.failed, 'failed and', data.passed,'passed on', data.total, 'total)' );
	console.log(JSON.stringify({command:'stopSuite'}));
};

QUnit.begin = function(){
	console.log('Start...');
};

QUnit.done = function(data){
	console.log('End -', data.failed, 'failed and', data.passed,'passed on', data.total, 'total in', data.runtime, 'milliseconds');
	console.log(JSON.stringify({command:'PHANTOM_EXIT'}));
};
