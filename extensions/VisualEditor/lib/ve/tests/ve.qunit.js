/*!
 * VisualEditor plugin for QUnit.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/*global difflib,diffview */

( function ( QUnit ) {
	/**
	 * Plugin for QUnit.
	 *
	 * @class ve.QUnit
	 * @extends QUnit
	 */

	/**
	 * Builds a summary of a node tree.
	 *
	 * Generated summaries contain node types, lengths, outer lengths, attributes and summaries for
	 * each child recursively. It's simple and fast to use deepEqual on this.
	 *
	 * @method
	 * @private
	 * @param {ve.Node} node Node tree to summarize
	 * @param {boolean} [shallow] Do not summarize each child recursively
	 * @return {Object} Summary of node tree
	 */
	function getNodeTreeSummary( node, shallow ) {
		var i,
			summary = {
				getType: node.getType(),
				getLength: node.getLength(),
				getOuterLength: node.getOuterLength(),
				element: node.element
			},
			numChildren;

		if ( node.children !== undefined ) {
			numChildren = node.children.length;
			if ( !shallow ) {
				summary.children = [];
				for ( i = 0; i < numChildren; i++ ) {
					summary.children.push( getNodeTreeSummary( node.children[ i ] ) );
				}
			}
		}
		return summary;
	}

	/**
	 * Builds a summary of a node selection.
	 *
	 * Generated summaries contain length of results as well as node summaries, ranges, indexes, indexes
	 * within parent and node ranges for each result. It's simple and fast to use deepEqual on this.
	 *
	 * @method
	 * @private
	 * @param {Object[]} selection Selection to summarize
	 * @return {Object} Summary of selection
	 */
	function getNodeSelectionSummary( selection ) {
		var i,
			summary = {
				length: selection.length
			};

		if ( selection.length ) {
			summary.results = [];
			for ( i = 0; i < selection.length; i++ ) {
				summary.results.push( {
					node: getNodeTreeSummary( selection[ i ].node, true ),
					range: selection[ i ].range,
					index: selection[ i ].index,
					indexInNode: selection[ i ].indexInNode,
					nodeRange: selection[ i ].nodeRange,
					nodeOuterRange: selection[ i ].nodeOuterRange,
					parentOuterRange: selection[ i ].parentOuterRange
				} );
			}
		}
		return summary;
	}

	/**
	 * Callback for ve#copy to convert nodes to a comparable summary.
	 *
	 * @private
	 * @param {ve.dm.Node|Object} value Value in the object/array
	 * @return {Object} Node summary if value is a node, otherwise just the value
	 */
	function convertNodes( value ) {
		return value instanceof ve.dm.Node || value instanceof ve.ce.Node ?
			getNodeTreeSummary( value ) :
			value;
	}

	/**
	 * Undo what QUnit's escapeText does.
	 *
	 * @ignore
	 * @param {string} s
	 * @return {string}
	 */
	function unescapeText( s ) {
		return s.replace( /&(#039|quot|lt|gt|amp);/g, function ( match, seq ) {
			switch ( seq )  {
			case '#039':
				return '\'';
			case 'quot':
				return '"';
			case 'lt':
				return '<';
			case 'gt':
				return '>';
			case 'amp':
				return '&';
			}
		} );
	}

	/**
	 * Assertion helpers for VisualEditor test suite.
	 * @class ve.QUnit.assert
	 */

	/**
	 * Assert that summaries of two node trees are equal.
	 *
	 * @method
	 * @static
	 */
	QUnit.assert.equalNodeTree = function ( actual, expected, shallow, message ) {
		var actualSummary, expectedSummary;
		if ( typeof shallow === 'string' && arguments.length === 3 ) {
			message = shallow;
			shallow = undefined;
		}
		actualSummary = getNodeTreeSummary( actual, shallow );
		expectedSummary = getNodeTreeSummary( expected, shallow );
		QUnit.push(
			QUnit.equiv( actualSummary, expectedSummary ), actualSummary, expectedSummary, message
		);
	};

	/**
	 * @method
	 * @static
	 */
	QUnit.assert.equalNodeSelection = function ( actual, expected, message ) {
		var i,
			actualSummary = getNodeSelectionSummary( actual ),
			expectedSummary = getNodeSelectionSummary( expected );

		for ( i = 0; i < actual.length; i++ ) {
			if ( expected[ i ] && expected[ i ].node !== actual[ i ].node ) {
				QUnit.push( false, actualSummary, expectedSummary,
					message + ' (reference equality for selection[' + i + '].node)'
				);
				return;
			}
		}
		QUnit.push(
			QUnit.equiv( actualSummary, expectedSummary ), actualSummary, expectedSummary, message
		);
	};

	/**
	 * @method
	 * @static
	 */
	QUnit.assert.equalDomElement = function ( actual, expected, message ) {
		var actualSummary = ve.getDomElementSummary( actual ),
			expectedSummary = ve.getDomElementSummary( expected ),
			actualSummaryHtml = ve.getDomElementSummary( actual, true ),
			expectedSummaryHtml = ve.getDomElementSummary( expected, true );

		QUnit.push(
			QUnit.equiv( actualSummary, expectedSummary ), actualSummaryHtml, expectedSummaryHtml, message
		);
	};

	QUnit.assert.equalLinearData = function ( actual, expected, message ) {
		function removeOriginalDomElements( arr ) {
			var i = 0,
				len = arr.length;
			for ( ; i < len; i++ ) {
				if ( arr[ i ].originalDomElements ) {
					delete arr[ i ].originalDomElements;
				}
			}
		}

		if ( Array.isArray( actual ) ) {
			actual = actual.slice();
			removeOriginalDomElements( actual );
		}
		if ( Array.isArray( expected ) ) {
			expected = expected.slice();
			removeOriginalDomElements( expected );
		}

		// FIXME domElements handling here shouldn't be necessary, but it is because of AlienNode
		actual = ve.copy( actual, ve.convertDomElements );
		expected = ve.copy( expected, ve.convertDomElements );

		QUnit.push( QUnit.equiv( actual, expected ), actual, expected, message );
	};

	/**
	 * Assert that two objects which may contain dom elements are equal.
	 *
	 * @method
	 * @static
	 */
	QUnit.assert.deepEqualWithDomElements = function ( actual, expected, message ) {
		// Recursively copy objects or arrays, converting any dom elements found to comparable summaries
		actual = ve.copy( actual, ve.convertDomElements );
		expected = ve.copy( expected, ve.convertDomElements );

		QUnit.push( QUnit.equiv( actual, expected ), actual, expected, message );
	};

	/**
	 * Assert that two objects which may contain node trees are equal.
	 *
	 * @method
	 * @static
	 */
	QUnit.assert.deepEqualWithNodeTree = function ( actual, expected, message ) {
		// Recursively copy objects or arrays, converting any dom elements found to comparable summaries
		actual = ve.copy( actual, convertNodes );
		expected = ve.copy( expected, convertNodes );

		QUnit.push( QUnit.equiv( actual, expected ), actual, expected, message );
	};

	QUnit.assert.equalRange = function ( actual, expected, message ) {
		actual = actual && {
			from: actual.from,
			to: actual.to
		};
		expected = expected && {
			from: expected.from,
			to: expected.to
		};
		QUnit.push( QUnit.equiv( actual, expected ), actual, expected, message );
	};

	QUnit.assert.equalHash = function ( actual, expected, message ) {
		actual = actual && actual.toJSON();
		expected = expected && expected.toJSON();
		QUnit.push( QUnit.equiv( actual, expected ), actual, expected, message );
	};

	QUnit.diff = function ( o, n ) {
		// o and n are partially HTML escaped by QUnit. As difflib does
		// its own escaping we should unescape them first.
		var oLines = difflib.stringAsLines( unescapeText( o ) ),
			nLines = difflib.stringAsLines( unescapeText( n ) ),
			sm = new difflib.SequenceMatcher( oLines, nLines ),
			// jscs:disable requireCamelCaseOrUpperCaseIdentifiers
			opcodes = sm.get_opcodes(),
			// jscs:enable requireCamelCaseOrUpperCaseIdentifiers
			$div = $( '<div>' );

		$div.append( diffview.buildView( {
			baseTextLines: oLines,
			newTextLines: nLines,
			opcodes: opcodes,
			baseTextName: 'Expected',
			newTextName: 'Result',
			contextSize: 10,
			viewType: 0
		} ) );

		return $div.html();
	};

}( QUnit ) );
