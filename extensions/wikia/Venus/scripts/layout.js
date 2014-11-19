/**
 * @define venus.layout
 * useful variables and functions for javascript (mostly derived from SASS)
 *
 * @author Bartosz 'V.' Bentkowski
 */

define('venus.layout', ['wikia.window'], function(win)  {
	'use strict';

	return {
		normalTextFontSize: 12,
		breakpoints: {
			smallMin: 768,
			mediumMin: 1024,
			bigMin: 1496
		},
		grid: {
			small: {
				columnPadding: 8,
				gutter: 8,
				innerColumn: 38
			},
			medium: {
				columnPadding: 10,
				gutter: 10,
				innerColumn: 53
			},
			big: {
				columnPadding: 12,
				gutter: 12,
				innerColumn: 58
			}
		},
		getBreakpoint: function() {
			var breakpoint = 'small',
				currentWidth = win.innerWidth;

			if (currentWidth > this.breakpoints.mediumMin) {
				breakpoint = 'medium';
			}
			if (currentWidth > this.breakpoints.bigMin) {
				breakpoint = 'big';
			}
			return breakpoint;
		},
		getGridColumnWidth: function(breakpoint, columnCount) {
			var currentBreakpointGrid = this.grid[breakpoint];
			return columnCount * (currentBreakpointGrid.innerColumn + 2 * currentBreakpointGrid.columnPadding + currentBreakpointGrid.gutter) - currentBreakpointGrid.gutter;
		}
	};
});
