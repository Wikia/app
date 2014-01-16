window.adSlots = {
	// TODO: tile is not used
	// GPT: only loc, pos and size keys are used
	map: {
		MOBILE_TOP_LEADERBOARD: {size: '320x50'},
		MOBILE_IN_CONTENT: {size: '300x250'},
		MOBILE_PREFOOTER: {size: '300x250'},
		GPT_FLUSH: 'flushonly'
	},
	// TODO: integrate this array to slotMap if it makes sense
	gptConfig: { // slots to use SRA with
		GPT_FLUSH: 'flushonly',

		MOBILE_TOP_LEADERBOARD: 'flush',
		MOBILE_IN_CONTENT: 'flush',
		MOBILE_PREFOOTER: 'flush'
	}
};

