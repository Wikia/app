/*!
 * VisualEditor ContentEditable Wikia example data sets.
 */

/* global mw: false */

/**
 * @namespace
 * @ignore
 */
ve.ce.wikiaExample = ( function ( utils ) {
	var fakeLinkUrl = 'Foo',
		fakeLinkUrlResolved = ve.resolveUrl( fakeLinkUrl, document ),
		fakeImageUrl = 'Bar',
		fakeImageUrlResolved = ve.resolveUrl( fakeImageUrl, document ),
		media = {},
		defaultThumbWidth = mw.config.get( 'wgVisualEditorConfig' ).defaultUserOptions.defaultthumbsize,
		defaultThumbHeight = ( defaultThumbWidth / 2 );

	/* Data */

	media.data = {
		'defaultWidth': defaultThumbWidth,
		'defaultHeight': defaultThumbHeight
	};

	media.data.cssClasses = {
		'htmlAlign': {
			'frame': {
				'left': 'tleft',
				'right': 'tright',
				'center': 'tnone',
				'none': 'tnone'
			},
			'none': {
				'left': 'floatleft',
				'right': 'floatright',
				'center': 'floatnone',
				'none': 'floatnone'
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

	media.html = { };

	media.html.block = {
		'caption':
			'<figcaption class="ve-ce-branchNode">' +
				'<p class="ve-ce-paragraphNode ve-ce-generated-wrapper caption ve-ce-branchNode">abc</p>' +
			'</figcaption>',
		'frame':
			'<figure class="article-thumb" style="">' +
				'<a class="image" href="' + fakeLinkUrlResolved + '"><img src="' + fakeImageUrlResolved + '"></a>' +
			'</figure>',
		'frameless':
			'<div class="" style="">' +
				'<a class="image" href="' + fakeLinkUrlResolved + '"><img src="' + fakeImageUrlResolved + '"></a>' +
			'</div>'
	};

	media.html.block.none = media.html.block.frameless;
	media.html.block.thumb = media.html.block.frame;

	media.html.inline = {
		'frameless':
			'<a class="image mw-default-size ve-ce-mwInlineImageNode ve-ce-leafNode ve-ce-generatedContentNode ve-ce-noHighlight ve-ce-focusableNode" contenteditable="false">' +
				'<img src="' + fakeImageUrlResolved + '" width="" height="">' +
			'</a>'
	};

	media.html.inline.none = media.html.inline.frameless;

	media.html.video = {
		'playButton':
			'<span class="play-circle ve-no-shield"></span>'
	};

	media.html.video.block = {
		'title':
			'<p class="title ve-no-shield">FooBar</p>'
	};

	/* Mock HTMLDOM */

	media.htmlDom = {
		'block':
			'<figure data-mw=\'{"user":"Foo"}\'>' +
				'<a href="' + fakeLinkUrl + '"><img src="' + fakeImageUrl + '" resource="FooBar"></a>' +
				'<figcaption>abc</figcaption>' +
			'</figure>',
		'inline':
			'<span data-mw=\'{"user":"Foo"}\'>' +
				'<a href="' + fakeLinkUrl + '"><img src="' + fakeImageUrl + '" resource="FooBar"></a>' +
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
	media.getHtmlDom = function ( displayType, rdfaType, attributes ) {
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

		$mock.find( 'img[src="' + fakeImageUrl + '"]' ).attr( {
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
	 * @param {String} rdfaType The node's RDFa type: 'mw:Image' or 'mw:Video'
	 * @returns {String} The mocked HTML.
	 */
	media.block.getHtml = function ( attributes, rdfaType ) {
		var $root,
			$mock,
			$figcaption,
			$caption,
			align = attributes.align,
			type = attributes.type,
			width = attributes.width;

		$mock = $( media.html.block[ type ] );

		$mock.addClass( media.getAlignClass( type, align, $mock ) );

		if ( type === 'frame' || type === 'thumb' ) {
			$mock.css( 'width', width + 'px' );
			// Caption applies only to "frame" and "thumb" types of media, appropriate logic
			// is implemented in ve.ce.WikiaBlockMediaNode.prototype.rebuild
			// @see https://bugzilla.wikimedia.org/show_bug.cgi?id=54479
			$mock.append( media.html.block.caption );

			$figcaption = $mock.find( 'figcaption' );
			$caption = $figcaption.find( '.caption' );

			// DOM order is title, caption
			if ( rdfaType === 'mw:Video' ) {
				$caption.before( media.html.video.block.title );
			}
		} else {
			$mock.removeAttr( 'style' );
		}

		if ( align === 'center' ) {
			$root = $( '<div>' ).addClass( 'center' ).append( $mock );
			$mock = $root;
		}

		$mock
			.addClass( 've-ce-branchNode ve-ce-generatedContentNode ve-ce-noHighlight ve-ce-focusableNode' )
			.attr( 'contenteditable', false );

		$mock.find( 'img[src="' + fakeImageUrlResolved + '"]' ).attr( {
			height: attributes.height,
			width: width
		} );

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
		return media.video.getHtml( attributes, media.block.getHtml( attributes, 'mw:Video' ) );
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

		$mock.find( 'img[src="' + fakeImageUrlResolved + '"]' ).attr( {
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
	 * @param {Object} attributes The node attributes from which to build the mock.
	 * @param {String} html The base HTML to inherit from.
	 * @returns {String} The mocked HTML.
	 */
	media.video.getHtml = function ( attributes, html ) {
		var $mock = $( html ),
			$mockImage = $mock.find( 'img[src="' + fakeImageUrlResolved + '"]' ),
			$playButton = $( media.html.video.playButton ),
			size,
			width = attributes.width;

		// copied from ThumbnailHelper::getThumbnailSize
		if ( width < 100 ) {
			size = 'xxsmall';
		} else if ( width < 200 ) {
			size = 'xsmall';
		} else if ( width < 270 ) {
			size = 'small';
		} else if ( width < 470 ) {
			size = 'medium';
		} else if ( width < 720 ) {
			size = 'large';
		} else {
			size = 'xlarge';
		}

		$mockImage.parent()
			.addClass( 'video video-thumbnail ' + size )
			.append( $playButton );

		return $mock[ 0 ].outerHTML;
	};

	// Exports
	return { 'media': media };
}( ve.wikiaTest.utils ) );
