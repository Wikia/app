/*!
 * VisualEditor Wikia test utilities.
 *
 * TODO: determine what can be moved to ve.test.utils.js
 */

ve.wikiaTest = { 'utils': {} };

ve.wikiaTest.utils.assertEqualNodeView = function ( assert, nodeView, HTML, message ) {
	// TODO: figure out a better way to remove debug styles
	nodeView.$.find( '.ve-ce-generated-wrapper' ).removeAttr( 'style' );
	assert.equalDomElement( nodeView.$[ 0 ], $( HTML )[ 0 ], message );

	return 1;
};

// TODO: make options into a hash, add 'join' and 'pair' options
ve.wikiaTest.utils.getAssertMessageFromAttributes = function ( prefix, changes, suffix ) {
	var key,
		parts = [];

	suffix = suffix || '';

	if ( ve.isPlainObject( prefix ) ) {
		changes = prefix;
		prefix = '';
	}

	for ( key in changes ) {
		parts.push( key + ': ' + changes[ key ] );
	}

	return prefix + parts.join( ', ' ) + suffix;
};

ve.wikiaTest.utils.getAttributeChanges = function ( first, second, copyOver ) {
	var diff = {},
		key;

	for ( key in second ) {
		if ( key === null ) {
			continue;
		} else if ( first[ key ] !== second[ key ] ) {
			diff[ key ] = second[ key ];
		} else if ( copyOver === true ) {
			diff[ key ] = first[ key ];
		}
	}

	return diff;
};

// TODO: make this actually recursive
ve.wikiaTest.utils.getMediaTestPermutations = function ( displayType, rdfaType ) {
	var data = ve.ce.wikiaExample.data[ displayType ][ rdfaType ],
		i,
		j,
		k,
		l,
		permutations = [];

	for ( i = 0; i < data.align.length; i++ ) {
		for ( j = 0; j < data.height.length; j++ ) {
			for ( k = 0; k < data.type.length; k++ ) {
				for ( l = 0; l < data.width.length; l++ ) {
					permutations.push({
						align: data.align[ i ],
						height: data.height[ j ],
						type: data.type[ k ],
						width: data.width[ l ]
					});
				}
			}
		}
	}

	return permutations;
};