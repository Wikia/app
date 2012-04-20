var JUnitReport = {};
JUnitReport.getXml = function( testResult ) {
	var xml = '';
	var suiteId = 1;
	var wrapperData = {
		name: testResult.name,
		'package': 'com.wikia.javascript.tests',
		errors: 0,
		failures: 0,
		skipped: 0,
		tests: 0,
		id: 0,
		time: 0
	};
	for (var suiteName in testResult.suites) {
		var suite = testResult.suites[suiteName];
		
		var suiteXml = '';
		for (var testName in suite.tests) {
			var test = suite.tests[testName];
			var testContent = '';
			if (test.status != JTR.status.SUCCESS) {
				testContent += Xml.element('failure',Xml.cdata(test.messages||''));
			}
			suiteXml += Xml.element('testcase',testContent,{
				name: testName,
				time: test.time / 1000
			});
		};
		
		suiteXml = Xml.element('properties') + suiteXml;
		var suiteData = {
				name: suiteName,
				'package': 'com.wikia.javascript.tests',
				errors: suite.stats[JTR.status.ERROR],
				failures: suite.stats[JTR.status.FAILURE],
				skipped: suite.stats[JTR.status.SKIPPED],
				tests: suite.stats.total,
				id: suiteId,
				time: suite.stats.time / 1000
		};
		var accumKeys = ['errors','failures','skipped','tests','time'];
		for (var i=0;i<accumKeys.length;i++) {
			wrapperData[accumKeys[i]] += suiteData[accumKeys[i]];
		}
		xml += Xml.element('testsuite',suiteXml,suiteData);
		suiteId++;
	}
	xml = Xml.element('testsuites',xml,wrapperData);
	//xml = Xml.intro() + Xml.element('testsuites',xml);
	xml = Xml.intro() + xml;
	return xml;
};
