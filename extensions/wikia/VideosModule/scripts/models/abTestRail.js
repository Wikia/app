define('videosmodule.models.abTestRail', [], function () {
	'use strict';

	var instance;

	// Singleton to protect integrity of test cases
	function ABTestBottom() {
		var testParams = window.Wikia.AbTest;
		this.testGroup = testParams ? testParams.getGroup('VIDEOS_MODULE_RAIL_2') : null;
	}

	ABTestBottom.prototype.getGroupParams = function () {
		return this.groups[this.testGroup];
	};

	/*
	 * @description Object containing test cases for rail module variant test.
	 * Note that GROUP_L shows no videos
	 * @property {boolean} verticalOnly - Shows only videos for the wikis vertical, falls back to article if set false
	 * @property {number} thumbs - Show either 3 or 5 thumbs
	 */
	ABTestBottom.prototype.groups = {
		// Article, 3 thumbs
		'GROUP_H': {
			verticalOnly: false,
			thumbs: 3
		},
		// Vertical, 3 thumbs
		'GROUP_I': {
			verticalOnly: true,
			thumbs: 3
		},
		// Article, 5 thumbs
		'GROUP_J': {
			verticalOnly: false,
			thumbs: 5
		},
		// Vertical, 5 thumbs
		'GROUP_K': {
			verticalOnly: true,
			thumbs: 5
		}
	};

	return function () {
		return (instance = (instance || new ABTestBottom()));
	};
});
