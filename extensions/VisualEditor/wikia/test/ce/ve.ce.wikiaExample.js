/*!
 * VisualEditor ContentEditable Wikia example data sets.
 */

/* global mw: false */

/**
 * @namespace
 * @ignore
 */
ve.ce.wikiaExample = {};

ve.ce.wikiaExample.data = {
	'block': {
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
	},
	'inline': {
		'mw:Video': {
			'align': [
				'none'
			],
			// not supported?
			'height': [
				1
			],
			'type': [
				'frameless',
				'none'
			],
			// not supported?
			'width': [
				2
			]
		}
	}
};

// mw:Video is the same for now
ve.ce.wikiaExample.data.block[ 'mw:Video' ] = ve.ce.wikiaExample.data.block[ 'mw:Image' ];

// Re-usable HTML fragments
ve.ce.wikiaExample.html = {
	'shield': '<img class="ve-ce-protectedNode-shield" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">'
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
} )();

/**
 * Get the mocked HTML output for a block media node.
 * Anything shared between block media types should go in here.
 *
 * @method
 * @param {Object} attributes The attributes from which to build the mock.
 * @returns {String} The mocked HTML.
 */
ve.ce.wikiaExample.getBlockMediaHTML = (function () {
	var mocks = {};

	mocks.attribution = [
		'<div class="picture-attribution">',
			'<img class="avatar" alt="Foo" height="16" src="Foo.png" width="16">',
			$.msg( 'oasis-content-picture-added-by', '<a href="/wiki/User:Foo">Foo</a>' ),
		'</div>'
	].join( '' );

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
			.append( ve.ce.wikiaExample.html.shield )
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
} )();

/**
 * Get the mocked HTML output for a block image node.
 *
 * @method
 * @param {Object} attributes The attributes from which to build the mock.
 * @returns {String} The mocked HTML.
 */
 ve.ce.wikiaExample.getBlockImageHTML = ve.ce.wikiaExample.getBlockMediaHTML;

/**
 * Get the mocked HTML output for a block video node.
 *
 * @method
 * @param {Object} attributes The attributes from which to build the mock.
 * @returns {String} The mocked HTML.
 */
ve.ce.wikiaExample.getBlockVideoHTML = function ( attributes ) {
	return ve.ce.wikiaExample.getVideoHTML(
		ve.ce.wikiaExample.getBlockMediaHTML( attributes ),
		attributes
	);
};

/**
 * Get the mocked HTML output for an linline media node.
 * Anything shared between inline media types should go in here.
 *
 * @method
 * @param {Object} attributes The attributes from which to build the mock.
 * @returns {String} The mocked HTML.
 */
ve.ce.wikiaExample.getInlineMediaHTML = (function () {
	var mocks = {};

	mocks.frameless = [
		'<a class="image ve-ce-mwInlineImageNode ve-ce-leafNode ve-ce-protectedNode" contenteditable="false">',
			'<img src="Bar" width="" height="">',
			ve.ce.wikiaExample.html.shield,
		'</a>'
	].join( '' );

	mocks.none = mocks.frameless;

	return function ( attributes ) {
		var $mock = $( mocks[ attributes.type ] );

		$mock.find( 'img[src="Bar"]' ).attr({
			height: attributes.height,
			width: attributes.width
		});

		return $mock[ 0 ].outerHTML;
	};
} )();

/**
 * Get the mocked HTML output for an inline video node.
 *
 * @method
 * @param {Object} attributes The attributes from which to build the mock.
 * @returns {String} The mocked HTML.
 */
ve.ce.wikiaExample.getInlineVideoHTML = function ( attributes ) {
	return ve.ce.wikiaExample.getVideoHTML(
		ve.ce.wikiaExample.getInlineMediaHTML( attributes ),
		attributes
	);
};

/**
 * Get the mocked HTMLDOM output for a media node.
 *
 * @method
 * @param {Object} attributes The attributes from which to build the mock.
 * @returns {String} The mocked HTML.
 */
ve.ce.wikiaExample.getMediaHTMLDOM = (function () {
	var alignClasses = {
			'center': 'mw-halign-center',
			'left': 'mw-halign-left',
			'none': 'mw-halign-none',
			'right': 'mw-halign-right'
		},
		mock = {};

	mock.block = [
		'<figure data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'>',
			'<a href="Foo"><img src="Bar" resource="FooBar"></a>',
			'<figcaption>abc</figcaption>',
		'</figure>'
	].join( '' );

	mock.inline = [
		'<span data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'>',
			'<a href="Foo"><img src="Bar" resource="FooBar"></a>',
		'</span>'
	].join( '' );

	function ucFirst( str ) {
		return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
	}

	return function( displayType, rdfaType, attributes ) {
		var $mock = $( mock[ displayType ] ),
			typeOf = rdfaType + (
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
} )();

/**
 * Get the mocked HTML output for a video node.
 * Anything shared between block and inline videos should go here.
 *
 * @method
 * @param {String} mock The base mock to inherit from.
 * @param {Object} attributes The attributes from which to build the mock.
 * @returns {String} The mocked HTML.
 */
ve.ce.wikiaExample.getVideoHTML = (function () {
	var mocks = {};

	mocks.playButton = [
		'<div class="Wikia-video-play-button ve-no-shield" style="">',
			'<img class="sprite play" src="">',
		'</div>'
	].join( '' );

	return function ( mock, attributes ) {
		var $mock = $( mock ),
			$playButton = $( mocks.playButton ),
			size = ( attributes.width <= 170 ? 'small' : attributes.width > 360 ? 'large' : '' );

		$playButton
			.css({
				'line-height': attributes.height + 'px',
				'width': attributes.width
			})
			.find( 'img' )
				.addClass( size )
				.attr( 'src', mw.config.get( 'wgBlankImgUrl' ) );

		$mock
			.find( 'img[src="Bar"]' )
			.addClass( 'Wikia-video-thumb' )
			.parent()
				.addClass( 'video' )
				.prepend( $playButton );

		return $mock[ 0 ].outerHTML;
	};
} )();