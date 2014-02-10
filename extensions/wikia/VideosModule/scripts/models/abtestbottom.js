define( 'videosmodule.models.abtestbottom', [
], function() {
	'use strict';

	var instance;

	// Singleton to protect integrity of test cases
	function ABTestBottom() {
		var testParams = window.Wikia.AbTest;
		testParams.getGroup = function() {
			return 'GROUP_C';
		};
		this.testGroup = testParams ? testParams.getGroup( 'VIDEOS_MODULE_BOTTOM' ) : null;
	}

	ABTestBottom.prototype.getGroupParams = function() {
		return this.groups [ this.testGroup ];
	};

	/*
	 * @description Object containing test cases for bottom module variant test
	 * @property {boolean} verticalOnly - Shows only videos for the wikis vertical, falls back to article if set false
	 * @property {number} position - Position 1 is before "Read More", 2 is after
	 * @property {number} rows - Show one row of videos or two (max)
	 */
	ABTestBottom.prototype.groups = {
		// Article, Above Read More, 2 Rows
		'GROUP_A': {
			verticalOnly: false,
			position: 2,
			rows: 2
		},
		// Vertical, Above Read More, 2 Rows
		'GROUP_B': {
			verticalOnly: true,
			position: 2,
			rows: 2
		},
		// Article, Below Read More, 2 Rows
		'GROUP_C': {
			verticalOnly: false,
			position: 1,
			rows: 2
		},
		// Article, Above Read More, 2 Rows
		'GROUP_D': {
			verticalOnly: false,
			position: 2,
			rows: 2
		},
		// Article, Above Read More, 1 Row
		'GROUP_E': {
			verticalOnly: false,
			position: 2,
			rows: 1
		},
		// Article, Above Read More, 1 Row
		'GROUP_F': {
			verticalOnly: true,
			position: 2,
			rows: 1
		},
		// Article, Below Read More, 1 Row
		'GROUP_G': {
			verticalOnly: false,
			position: 1,
			rows: 1
		},
		// Article, Above Read More, 1 Row
		'GROUP_H': {
			verticalOnly: false,
			position: 2,
			rows: 1
		}
	};

	return function() {
		return ( instance = ( instance || new ABTestBottom() ) );
	};
} );
