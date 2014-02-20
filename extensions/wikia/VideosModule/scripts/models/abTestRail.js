define('videosmodule.models.abTestRail', [], function() {
	'use strict';

	var instance;

	// Singleton to protect integrity of test cases
	function ABTestBottom() {
		var testParams = window.Wikia.AbTest;
		this.testGroup = testParams ? testParams.getGroup('VIDEOS_MODULE_RAIL') : null;
	}

	ABTestBottom.prototype.getGroupParams = function() {
		return this.groups[this.testGroup];
	};

	/*
	 * @description Object containing test cases for bottom module variant test
	 * @property {boolean} verticalOnly - Shows only videos for the wikis vertical, falls back to article if set false
	 * @property {number} name - name 1 is before "Read More", 2 is after
	 * @property {number} thumbs - Show one row of videos or two (max)
	 */
	ABTestBottom.prototype.groups = {
		// Article, Above Read More, 2 thumbs
		'GROUP_A': {
			verticalOnly: false,
			thumbs: 3
		},
		// Vertical, Above Read More, 2 thumbs
		'GROUP_B': {
			verticalOnly: true,
			thumbs: 3
		},
		// Article, Below Read More, 2 thumbs
		'GROUP_C': {
			verticalOnly: false,
			thumbs: 3
		},
		// Article, Above Read More, 2 thumbs
		'GROUP_D': {
			verticalOnly: false,
			thumbs: 5
		},
		// Article, Above Read More, 1 Row
		'GROUP_E': {
			verticalOnly: true,
			thumbs: 3
		},
		// Article, Above Read More, 1 Row
		'GROUP_F': {
			name: 'trending',
			verticalOnly: true,
			thumbs: 3
		}
	};

	return function() {
		return (instance = (instance || new ABTestBottom()));
	};
});
