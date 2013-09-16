/*!
 * VisualEditor ContentEditable Wikia example data sets.
 */

/**
 * @namespace
 * @ignore
 */
ve.ce.wikiaExample = {};

ve.ce.wikiaExample.data = {
	'mw:Image': {
		'align': [
			'center',
			'default',
			'left',
			'none',
			'right'
		],
		'height': [
			1,
			100
		],
		'type': [
			'frame',
			'frameless',
			'none',
			'thumb'
		],
		'width': [
			2,
			200
		]
	}
};

// mw:Video is the same for now
ve.ce.wikiaExample.data[ 'mw:Video' ] = ve.ce.wikiaExample.data[ 'mw:Image' ];

// TODO: put this in ve.test.utils.js ?
// TODO: make options into a hash, add 'join' and 'pair' options
ve.ce.wikiaExample.getAssertMessageFromAttributes = function ( prefix, changes, suffix ) {
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

// TODO: move this to ve.test.utils.js ?
ve.ce.wikiaExample.getAttributeChanges = function ( first, second, copyOver ) {
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

// TODO: put this in ve.test.utils.js ?
ve.ce.wikiaExample.assertEqualNodeView = function ( assert, nodeView, HTML, message ) {
	// TODO: figure out a better way to remove debug styles
	nodeView.$.find( '.ve-ce-generated-wrapper' ).removeAttr( 'style' );
	assert.equalDomElement( nodeView.$[ 0 ], $( HTML )[ 0 ], message );

	return 1;
};

/**
 * Get the right class alignment.
 *
 * @method
 * @returns {String} The alignment class.
 */
ve.ce.wikiaExample.getAlignClass = (function () {
	var cssClasses = {
		'frame': {
			'left': 'tleft',
			'right': 'tright',
			'center' : 'tnone',
			'none' : 'tnone'
		},
		'none': {
			'left': 'floatleft',
			'right': 'floatright',
			'center' : 'floatnone',
			'none' : 'floatnone'
		}
	};

	cssClasses.frameless = cssClasses.none;
	cssClasses.thumb = cssClasses.frame;

	return function ( $mock, attributes ) {
		if (
			attributes.align === 'default' &&
			(
				attributes.type === 'frame' ||
				attributes.type === 'thumb'
			)
		) {
			if ( $mock.css( 'direction' ) === 'rtl' ) {
				return 'tleft';
			} else {
				return 'tright';
			}
		} else {
			return cssClasses[ attributes.type ][ attributes.align ];
		}
	};
})();

/**
 * Get the mocked HTMLDOM output for a block media node.
 *
 * @method
 * @param {Object} attributes The attributes from which to build the mock.
 * @returns {String} The mocked HTML.
 */
ve.ce.wikiaExample.getBlockMediaHTMLDOM = (function () {
	var alignClasses = {
			'center': 'mw-halign-center',
			'left': 'mw-halign-left',
			'none': 'mw-halign-none',
			'right': 'mw-halign-right'
		},
		mock = [
			'<figure data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'>',
				'<a href="Foo"><img src="Bar" resource="FooBar"></a>',
				'<figcaption>abc</figcaption>',
			'</figure>'
		].join( '' );

	function ucFirst( str ) {
		return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
	}

	return function( type, attributes ) {
		var $mock = $( mock ),
			typeOf = type + (
				attributes.type !== 'none' ? '/' + ucFirst( attributes.type ) : ''
			);

		if ( attributes.height === 1 && attributes.width === 2 ) {
			$mock.addClass( 'mw-default-size' );
		}

		if ( attributes.align !== 'default' ) {
			$mock.addClass( alignClasses[ attributes.align ] );
		}

		$mock
			.attr( 'typeof', typeOf )
			.find( 'img[src="Bar"]' )
				.attr({
					height: attributes.height,
					width: attributes.width
				});

		return $mock[ 0 ].outerHTML;
	};
})();

/**
 * Get the mocked HTML output for a block image node.
 *
 * @method
 * @param {Object} attributes The attributes from which to build the mock.
 * @returns {String} The mocked HTML.
 */
ve.ce.wikiaExample.getBlockImageHTML = (function () {
	var mocks = {};

	mocks.attribution = [
		'<div class="picture-attribution">',
			'<img class="avatar" alt="Foo" height="16" src="Foo.png" width="16">',
			$.msg( 'oasis-content-picture-added-by', '<a href="/wiki/User:Foo">Foo</a>' ),
		'</div>'
	].join( '' );

	mocks.shield = '<img class="ve-ce-protectedNode-shield" ' +
		'src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">';

	mocks.frame = [
		'<figure class="thumb thumbinner" style="">',
			'<a class="image" href="Foo"><img src="Bar"></a>',
			'<a class="internal sprite details magnify ve-no-shield"></a>',
			'<figcaption class="thumbcaption ve-ce-branchNode">',
				'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
			'</figcaption>',
		'</figure>'
	].join( '' );

	mocks.frameless = [
		'<div class="" style="">',
			'<a class="image" href="Foo"><img src="Bar"></a>',
		'</div>'
	].join( '' );

	mocks.thumb = mocks.frame;
	mocks.none = mocks.frameless;

	return function ( attributes ) {
		var $root,
			$mock = $( mocks[ attributes.type ] ),
			alignType = (
				attributes.type === 'frameless' ||
				attributes.type === 'none'
			) ? 'none' : 'default';

		$mock.addClass( ve.ce.wikiaExample.getAlignClass( $mock, attributes ) );

		if ( alignType !== 'none' ) {
			$mock.css( 'width', ( attributes.width + 2 ) + 'px' );
		} else {
			$mock.removeAttr( 'style' );
		}

		if ( attributes.align === 'center' ) {
			$root = $( '<div>' ).addClass( 'center' ).append( $mock );
			$mock = $root;
		}

		$mock
			.addClass( 've-ce-branchNode ve-ce-protectedNode' )
			.attr( 'contenteditable', false )
			.append( mocks.shield )
			.find( 'img[src="Bar"]' )
				.attr({
					height: attributes.height,
					width: attributes.width
				});

		if ( attributes.width >= 102 ) {
			$mock.find( 'figcaption' ).append( mocks.attribution );
		}

		return $mock[ 0 ].outerHTML;
	};
})();