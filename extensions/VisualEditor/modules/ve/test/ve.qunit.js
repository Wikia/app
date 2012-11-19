( function ( QUnit ) {

QUnit.config.requireExpects = true;

/**
 * Builds a summary of a node tree.
 *
 * Generated summaries contain node types, lengths, outer lengths, attributes and summaries for
 * each child recursively. It's simple and fast to use deepEqual on this.
 *
 * @method
 * @param {ve.Node} node Node tree to summarize
 * @param {Boolean} [shallow] Do not summarize each child recursively
 * @returns {Object} Summary of node tree
 */
function getNodeTreeSummary( node, shallow ) {
	var i,
		summary = {
			'getType': node.getType(),
			'getLength': node.getLength(),
			'getOuterLength': node.getOuterLength(),
			'attributes': node.attributes
		};

	if ( node.children !== undefined ) {
		summary['children.length'] = node.children.length;
		if ( !shallow ) {
			summary.children = [];
			for ( i = 0; i < node.children.length; i++ ) {
				summary.children.push( getNodeTreeSummary( node.children[i] ) );
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
 * @param {Object[]} selection Selection to summarize
 * @returns {Object} Summary of selection
 */
function getNodeSelectionSummary( selection ) {
	var i,
		summary = {
			'length': selection.length
		};

	if ( selection.length ) {
		summary.results = [];
		for ( i = 0; i < selection.length; i++ ) {
			summary.results.push( {
				'node': getNodeTreeSummary( selection[i].node, true ),
				'range': selection[i].range,
				'index': selection[i].index,
				'indexInNode': selection[i].indexInNode,
				'nodeRange': selection[i].nodeRange,
				'nodeOuterRange': selection[i].nodeOuterRange,
				'parentOuterRange': selection[i].parentOuterRange
			} );
		}
	}
	return summary;
}

/**
 * Builds a summary of an HTML element.
 *
 * Summaries include node name, text, attributes and recursive summaries of children.
 *
 * @method
 * @param {HTMLElement} element Element to summarize.
 * @returns {Object} Summary of element.
 */
function getDomElementSummary( element ) {
	var i,
		$element = $( element ),
		summary = {
			'type': element.nodeName.toLowerCase(),
			'text': $element.text(),
			'attributes': {},
			'children': []
		};

	// Gather attributes
	for ( i = 0; i < element.attributes.length; i++ ) {
		summary.attributes[element.attributes[i].name] = element.attributes[i].value;
	}
	// Summarize children
	for ( i = 0; i < element.children.length; i++ ) {
		summary.children.push( getDomElementSummary( element.children[i] ) );
	}
	return summary;
}

QUnit.assert.equalNodeTree = function ( actual, expected, shallow, message ) {
	if ( typeof shallow === 'string' && arguments.length === 3 ) {
		message = shallow;
		shallow = undefined;
	}
	var actualSummary = getNodeTreeSummary( actual, shallow ),
		expectedSummary = getNodeTreeSummary( expected, shallow );
	QUnit.push(
		QUnit.equiv( actualSummary, expectedSummary ), actualSummary, expectedSummary, message
	);
};

QUnit.assert.equalNodeSelection = function ( actual, expected, message ) {
	var i,
		actualSummary = getNodeSelectionSummary( actual ),
		expectedSummary = getNodeSelectionSummary( expected );

	for ( i = 0; i < actual.length; i++ ) {
		if ( expected[i] && expected[i].node !== actual[i].node ) {
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

QUnit.assert.equalDomElement = function ( actual, expected, message ) {
	var actualSummary = getDomElementSummary( actual ),
		expectedSummary = getDomElementSummary( expected );

	QUnit.push(
		QUnit.equiv( actualSummary, expectedSummary ), actualSummary, expectedSummary, message
	);
};

}( QUnit ) );
