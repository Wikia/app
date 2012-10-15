var JTR = {
	status: {
		SUCCESS: 'success',
		FAILURE: 'failure',
		ERROR: 'error',
		SKIPPED: 'skipped',
		UNKNOWN: 'unknown'
	},
	statusList: {},
	frameworks: {},
	tools: {},
	outputs: {},
	TestRunner: null
};
	
for (var i in JTR.status) {
	JTR.statusList[JTR.status[i]] = true;
}
