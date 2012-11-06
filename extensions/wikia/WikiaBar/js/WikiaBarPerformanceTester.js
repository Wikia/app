function randomString(length) {
	var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz '.split('');
	if (! length) {
		length = Math.floor(Math.random() * chars.length);
	}
	var str = '';
	for (var i = 0; i < length; i++) {
		str += chars[Math.floor(Math.random() * chars.length)];
	}
	return str;
}

function performanceTest(randomStringLength, cutMessagePrecision) {
	var container = $('.wikia-bar .message');
	var messages = [
		{'text': randomString(randomStringLength)},
		{'text': randomString(randomStringLength)},
		{'text': randomString(randomStringLength)},
		{'text': randomString(randomStringLength)},
		{'text': randomString(randomStringLength)}
	];
	var start = +(new Date());
	WikiaBar.cutMessageIntoSmallPieces(messages, container, cutMessagePrecision);
	var stop = +(new Date());
	var executionTime = stop - start;
	$().log(
		"StringLength: "+randomStringLength+" | " +
		"cutMessagePrecision: "+cutMessagePrecision+" | " +
		"executionTime: "+executionTime
	);
}

function runTestPackage(cutMessagePrecision) {
	performanceTest(20, cutMessagePrecision);
	performanceTest(40, cutMessagePrecision);
	performanceTest(60, cutMessagePrecision);
	performanceTest(80, cutMessagePrecision);
	performanceTest(100, cutMessagePrecision);
	performanceTest(120, cutMessagePrecision);
	performanceTest(140, cutMessagePrecision);
	performanceTest(160, cutMessagePrecision);
	performanceTest(180, cutMessagePrecision);
	performanceTest(200, cutMessagePrecision);
}

runTestPackage(1);
runTestPackage(10);
runTestPackage(20);
runTestPackage(30);
runTestPackage(40);
runTestPackage(50);
