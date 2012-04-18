QUnit.testStart = function(test){
	console.log('TEST START', test);
};

QUnit.testDone = function(name, failed, passed, total){
	console.log('TEST DONE', name, failed, passed, total);
};

QUnit.log = function(result, actual, expected, message){
	console.log('LOG', result, actual, expected, message);
};

QUnit.moduleStart = function(name){
	console.log('MODULE START', name);
};

QUnit.moduleDone = function(name, failed, passed, total){
	console.log('MODULE DONE', name, failed, passed, total);
};

QUnit.begin = function(){
	console.log('BEGIN');
};

QUnit.done = function(failed, passed, total, runtime){
	console.log('DONE', failed, passed, total, runtime);
	console.log('!!PHANTOM_EXIT!!');
};