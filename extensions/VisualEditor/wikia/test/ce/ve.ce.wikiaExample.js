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
			null,
			100
		],
		'type': [
			'frame',
			'frameless',
			'none',
			'thumb'
		],
		'width': [
			null,
			200
		]
	}
};

ve.ce.wikiaExample.assertEqualNodeView = function ( assert, nodeView, test ) {
	var message = JSON.stringify( test.attributes ) || 'default';

	// TODO: figure out a better way to remove debug styles
	nodeView.$.find( '.ve-ce-generated-wrapper' ).removeAttr( 'style' );
	assert.equalDomElement( nodeView.$[ 0 ], $( test.HTML )[ 0 ], message );

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
 * Get the mocked HTMLDOM output for an image node.
 *
 * @method
 * @param {Object} attributes The attributes from which to build the mock.
 * @returns {String} The mocked HTML.
 */
ve.ce.wikiaExample.getImageHTMLDOM = (function () {
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
		].join( '' ),
		type = 'mw:Image';

	function ucFirst( str ) {
		return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
	}

	return function( attributes ) {
		var $mock = $( mock ),
			typeOf = type + (
				attributes.type !== 'none' ? '/' + ucFirst( attributes.type ) : ''
			);

		if ( attributes.height === null && attributes.width === null ) {
			$mock.addClass( 'mw-default-size' );
		}

		if ( attributes.align !== 'default' ) {
			$mock.addClass( alignClasses[ attributes.align ] );
		}

		$mock
			.attr( 'typeof', typeOf )
			.find( 'img[src="Bar"]' )
				.attr({
					height: attributes.height || 1,
					width: attributes.width || 2
				});

		return $mock[ 0 ].outerHTML;
	};
})();

/**
 * Get the mocked HTML output for an image node.
 *
 * @method
 * @param {Object} attributes The attributes from which to build the mock.
 * @returns {String} The mocked HTML.
 */
ve.ce.wikiaExample.getImageHTML = (function () {
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
			) ? 'none' : 'default',
			height = attributes.height || 1,
			width = attributes.width || 2;

		$mock.addClass( ve.ce.wikiaExample.getAlignClass( $mock, attributes ) );

		if ( alignType !== 'none' ) {
			$mock.css( 'width', ( width + 2 ) + 'px' );
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
					height: height,
					width: width
				});

		if ( width >= 102 ) {
			$mock.find( 'figcaption' ).append( mocks.attribution );
		}

		return $mock[ 0 ].outerHTML;
	};
})();