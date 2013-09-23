/*!
 * VisualEditor ContentEditable Wikia example data sets.
 */

/* global mw: false */

/**
 * @namespace
 * @ignore
 */
ve.ce.wikiaExample = ( function ( utils ) {
	var media = {};

	/* Data */

	media.data = {
		'attribution': {
			'minWidth': 102
		},
		'defaultWidth': 200,
		'defaultHeight': 100,
		'video': {
			'playButtonSmallWidth': 170,
			'playButtonLargeWidth': 360
		}
	};

	media.data.cssClasses = {
		'htmlAlign': {
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
		},
		'htmlDomAlign': {
			'center': 'mw-halign-center',
			'left': 'mw-halign-left',
			'none': 'mw-halign-none',
			'right': 'mw-halign-right'
		}
	};

	media.data.cssClasses.htmlAlign.frameless = media.data.cssClasses.htmlAlign.none;
	media.data.cssClasses.htmlAlign.thumb = media.data.cssClasses.htmlAlign.frame;

	media.data.testCases = {
		'block': {
			'mw:Image': {
				'align': [ 'center', 'default', 'left', 'none', 'right' ],
				'height': [ media.data.defaultHeight, 1 ],
				'type': [ 'frame', 'frameless', 'none', 'thumb' ],
				'width': [ media.data.defaultWidth, 2 ]
			}
		},
		'inline': {
			'mw:Video': {
				'align': [ 'none' ],
				'height': [ media.data.defaultHeight ],
				'type': [ 'frameless', 'none' ],
				'width': [ media.data.defaultWidth ]
			}
		}
	};

	media.data.testCases.block[ 'mw:Video' ] = media.data.testCases.block[ 'mw:Image' ];

	/* Mock HTML */

	media.html = {
		'shield':
			'<img class="ve-ce-protectedNode-shield" ' +
				'src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">'
	};

	media.html.block = {
		'attribution':
			'<div class="picture-attribution">' +
				'<img class="avatar" alt="Foo" height="16" src="Foo.png" width="16">' +
				mw.message( 'oasis-content-picture-added-by', '<a href="/wiki/User:Foo">Foo</a>' ).plain() +
			'</div>',
		'caption':
			'<figcaption class="thumbcaption ve-ce-branchNode">' +
				'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>' +
			'</figcaption>',
		'frame':
			'<figure class="thumb thumbinner" style="">' +
				'<a class="image" href="Foo"><img src="Bar"></a>' +
				'<a class="internal sprite details magnify ve-no-shield"></a>' +
			'</figure>',
		'frameless':
			'<div class="" style="">' +
				'<a class="image" href="Foo"><img src="Bar"></a>' +
			'</div>'
	};

	media.html.block.none = media.html.block.frameless;
	media.html.block.thumb = media.html.block.frame;

	media.html.inline = {
		'frameless':
			'<a class="image ve-ce-mwInlineImageNode ve-ce-leafNode ve-ce-protectedNode" contenteditable="false">' +
				'<img src="Bar" width="" height="">' +
				media.html.shield +
			'</a>'
	};

	media.html.inline.none = media.html.inline.frameless;

	media.html.video = {
		//'overlay':
		'playButton':
			'<div class="Wikia-video-play-button ve-no-shield" style="">' +
				'<img class="sprite play" src="">' +
			'</div>'
	};

	/* Mock HTMLDOM */

	media.htmlDom = {
		'block':
			'<figure data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'>' +
				'<a href="Foo"><img src="Bar" resource="FooBar"></a>' +
				'<figcaption>abc</figcaption>' +
			'</figure>',
		'inline':
			'<span data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'>' +
				'<a href="Foo"><img src="Bar" resource="FooBar"></a>' +
			'</span>'
	};

	/**
	 * Get the right class alignment for a node.
	 *
	 * @method
	 * @param {String} type Node type; 'frame', 'frameless', 'none' or 'thumb'
	 * @param {String} align Node alignment: 'center', 'default', 'left', 'none' or 'right'
	 * @param {jQuery} [$element] A jQuery object used to determine text direction
	 * @returns {String} The alignment class.
	 */
	media.getAlignClass = function ( type, align, $element ) {
		var alignClass;

		if ( align === 'default' && ( type === 'frame' || type === 'thumb' ) ) {
			if ( $element && $element.css( 'direction' ) === 'rtl' ) {
				alignClass = 'tleft';
			} else {
				alignClass = 'tright';
			}
		} else {
			alignClass = media.data.cssClasses.htmlAlign[ type ][ align ];
		}

		return alignClass;
	};

	/**
	 * Get the mocked HTMLDOM output for a media node.
	 *
	 * @method
	 * @param {String} displayType The node's display type; 'block' or 'inline'
	 * @param {String} rdfaType The node's RDFa type; 'mw:Image' or 'mw:Video'
	 * @param {Object} attributes The node attributes from which to build the mock.
	 * @returns {String} The mocked HTMLDOM.
	 */
	media.getHtmlDom = function( displayType, rdfaType, attributes ) {
		var $mock = $( media.htmlDom[ displayType ] ),
			typeOf = rdfaType;

		if ( attributes.type !== 'none' ) {
			typeOf = typeOf + '/' + utils.ucFirst( attributes.type );
		}

		$mock.attr( 'typeof', typeOf );

		if (
			attributes.height === media.data.defaultHeight &&
			attributes.width === media.data.defaultWidth
		) {
			$mock.addClass( 'mw-default-size' );
		}

		if ( attributes.align !== 'default' ) {
			$mock.addClass( media.data.cssClasses.htmlDomAlign[ attributes.align ] );
		}

		$mock.find( 'img[src="Bar"]' ).attr( {
			height: attributes.height,
			width: attributes.width
		} );

		return $mock[ 0 ].outerHTML;
	};

	/* Block Media */

	media.block = { 'mw:Image': {}, 'mw:Video': {} };

	/**
	 * Get the mocked HTML output for a block media node.
	 * Anything shared between block media types should go in here.
	 *
	 * @method
	 * @param {Object} attributes The node attributes from which to build the mock.
	 * @returns {String} The mocked HTML.
	 */
	media.block.getHtml = function ( attributes ) {
		var $root,
			$mock,
			align = attributes.align,
			type = attributes.type,
			width = attributes.width;

		$mock = $( media.html.block[ type ] )
			.addClass( media.getAlignClass( type, align, $mock ) )
			// HACK - this should only apply to type "frame" and "thumb" but
			// parsoid includes it even for "frameless" and "none"
			// @see https://bugzilla.wikimedia.org/show_bug.cgi?id=54479
			.append( media.html.block.caption );

		if ( type === 'frame' || type === 'thumb' ) {
			$mock.css( 'width', ( width + 2 ) + 'px' );
		} else {
			$mock.removeAttr( 'style' );
		}

		if ( align === 'center' ) {
			$root = $( '<div>' ).addClass( 'center' ).append( $mock );
			$mock = $root;
		}

		$mock
			.addClass( 've-ce-branchNode ve-ce-protectedNode' )
			.attr( 'contenteditable', false )
			.append( media.html.shield );

		$mock.find( 'img[src="Bar"]' ).attr( {
			height: attributes.height,
			width: width
		} );

		if ( width >= media.data.attribution.minWidth ) {
			$mock.find( 'figcaption' ).append( media.html.block.attribution );
		}

		return $mock[ 0 ].outerHTML;
	};

	/**
	 * Get the mocked HTML output for a block image node.
	 *
	 * @method
	 * @param {Object} attributes The node attributes from which to build the mock.
	 * @returns {String} The mocked HTML.
	 */
	 media.block[ 'mw:Image' ].getHtml = media.block.getHtml;

	/**
	 * Get the mocked HTML output for a block video node.
	 *
	 * @method
	 * @param {Object} attributes The node attributes from which to build the mock.
	 * @returns {String} The mocked HTML.
	 */
	media.block[ 'mw:Video' ].getHtml = function ( attributes ) {
		return media.video.getHtml( attributes, media.block.getHtml( attributes ) );
	};

	/* Inline Media */

	media.inline = { 'mw:Video': {} };

	/**
	 * Get the mocked HTML output for an linline media node.
	 * Anything shared between inline media types should go in here.
	 *
	 * @method
	 * @param {Object} attributes The node attributes from which to build the mock.
	 * @returns {String} The mocked HTML.
	 */
	media.inline.getHtml = function ( attributes ) {
		var $mock = $( media.html.inline[ attributes.type ] );

		$mock.find( 'img[src="Bar"]' ).attr( {
			height: attributes.height,
			width: attributes.width
		} );

		return $mock[ 0 ].outerHTML;
	};

	/**
	 * Get the mocked HTML output for an inline video node.
	 *
	 * @method
	 * @param {Object} attributes The node attributes from which to build the mock.
	 * @returns {String} The mocked HTML.
	 */
	media.inline[ 'mw:Video' ].getHtml = function ( attributes ) {
		return media.video.getHtml( attributes, media.inline.getHtml( attributes ) );
	};

	/* Video specific */

	media.video = {};

	/**
	 * Get the mocked HTML output for a video node.
	 * Anything shared between block and inline videos should go here.
	 *
	 * @method
	 * @param {String} html The base HTML to inherit from.
	 * @param {Object} attributes The node attributes from which to build the mock.
	 * @returns {String} The mocked HTML.
	 */
	media.video.getHtml = function ( attributes, html ) {
		var $mock = $( html ),
			$mockImage = $mock.find( 'img[src="Bar"]' ),
			$playButton = $( media.html.video.playButton ),
			$playButtonImage = $playButton.find( 'img' ),
			size,
			width = attributes.width;

		if ( width <= media.data.video.playButtonSmallWidth ) {
			size = 'small';
		} else if ( width > media.data.video.playButtonLargeWidth ) {
			size = 'large';
		}

		$playButton.css( {
			'line-height': attributes.height + 'px',
			'width': width
		} );

		$playButtonImage.attr( 'src', mw.config.get( 'wgBlankImgUrl' ) );

		if ( size !== undefined ) {
			$playButtonImage.addClass( size );
		}

		$mockImage.addClass( 'Wikia-video-thumb' );

		$mockImage.parent()
			.addClass( 'video' )
			.prepend( $playButton );

		return $mock[ 0 ].outerHTML;
	};

	// Exports
	return { 'media': media };
}( ve.wikiaTest.utils ) );
