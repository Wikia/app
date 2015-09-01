/*!
 * VisualEditor test utilities.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

( function () {
	/*jshint browser:true */

	// Create a standalone platform and target so ve.init.platform/target are available
	/*jshint nonew:false */
	new ve.init.sa.Platform();
	new ve.init.sa.Target();
	/*jshint nonew:true */

	// Configure QUnit
	QUnit.config.requireExpects = true;

	// Disable scroll animatinos
	ve.scrollIntoView = function () {};

	// Extend QUnit.module to provide a fixture element. This used to be in tests/index.html, but
	// dynamic test runners like Karma build their own web page.
	( function () {
		var orgModule = QUnit.module;

		QUnit.module = function ( name, localEnv ) {
			localEnv = localEnv || {};
			orgModule( name, {
				setup: function () {
					this.fixture = document.createElement( 'div' );
					this.fixture.id = 'qunit-fixture';
					document.body.appendChild( this.fixture );

					if ( localEnv.setup ) {
						localEnv.setup.call( this );
					}
				},
				teardown: function () {
					if ( localEnv.teardown ) {
						localEnv.teardown.call( this );
					}

					this.fixture.parentNode.removeChild( this.fixture );
				}
			} );
		};
	}() );

	/**
	 * @class
	 * @singleton
	 * @ignore
	 */
	ve.test = { utils: {} };

	ve.test.utils.runIsolateTest = function ( assert, type, range, expected, label ) {
		var doc = ve.dm.example.createExampleDocument( 'isolationData' ),
			surface = new ve.dm.Surface( doc ),
			fragment = surface.getLinearFragment( range ),
			data;

		data = ve.copy( doc.getFullData() );
		fragment.isolateAndUnwrap( type );
		expected( data );

		assert.deepEqual( doc.getFullData(), data, label );
	};

	ve.test.utils.runFormatConverterTest = function ( assert, range, type, attributes, expectedRange, expectedData, msg ) {
		var surface = ve.test.utils.createModelOnlySurfaceFromHtml( ve.dm.example.isolationHtml ),
			formatAction = new ve.ui.FormatAction( surface ),
			data = ve.copy( surface.getModel().getDocument().getFullData() ),
			originalData = ve.copy( data );

		expectedData( data );

		surface.getModel().setLinearSelection( range );
		formatAction.convert( type, attributes );

		assert.equalLinearData( surface.getModel().getDocument().getFullData(), data, msg + ': data models match' );
		assert.equalRange( surface.getModel().getSelection().getRange(), expectedRange, msg + ': ranges match' );

		surface.getModel().undo();

		assert.equalLinearData( surface.getModel().getDocument().getFullData(), originalData, msg + ' (undo): data models match' );
		assert.equalRange( surface.getModel().getSelection().getRange(), range, msg + ' (undo): ranges match' );
	};

	ve.test.utils.countGetModelFromDomTests = function ( cases ) {
		var msg, n = 0;
		for ( msg in cases ) {
			if ( cases[ msg ].head !== undefined || cases[ msg ].body !== undefined ) {
				n += 3;
				if ( cases[ msg ].storeLength ) {
					n += 1;
				}
				if ( cases[ msg ].storeItems ) {
					n += cases[ msg ].storeItems.length;
				}
			}
		}
		return n;
	};

	ve.test.utils.runGetModelFromDomTest = function ( assert, caseItem, msg ) {
		var model, i, length, hash, html, htmlDoc, actualData, actualRtDoc, expectedRtDoc,
			// Make sure we've always got a <base> tag
			defaultHead = '<base href="' + ve.dm.example.baseUri + '">';

		if ( caseItem.head !== undefined || caseItem.body !== undefined ) {
			html = '<head>' + ( caseItem.head || defaultHead ) + '</head><body>' + caseItem.body + '</body>';
			htmlDoc = ve.createDocumentFromHtml( html );
			model = ve.dm.converter.getModelFromDom( htmlDoc, { fromClipboard: !!caseItem.fromClipboard } );
			actualData = model.getFullData();
			// Round-trip here, check round-trip later
			if ( caseItem.modify ) {
				actualData = ve.copy( actualData );
				caseItem.modify( model );
			}
			actualRtDoc = ve.dm.converter.getDomFromModel( model );

			// Normalize and verify data
			ve.dm.example.postprocessAnnotations( actualData, model.getStore() );
			assert.equalLinearData( actualData, caseItem.data, msg + ': data' );
			assert.deepEqual( model.getInnerWhitespace(), caseItem.innerWhitespace || new Array( 2 ), msg + ': inner whitespace' );
			if ( caseItem.storeLength !== undefined ) {
				assert.strictEqual( model.getStore().valueStore.length, caseItem.storeLength, msg + ': store length matches' );
			}
			// check storeItems have been added to store
			if ( caseItem.storeItems ) {
				for ( i = 0, length = caseItem.storeItems.length; i < length; i++ ) {
					hash = caseItem.storeItems[ i ].hash || OO.getHash( caseItem.storeItems[ i ].value );
					assert.deepEqualWithDomElements(
						model.getStore().value( model.getStore().indexOfHash( hash ) ) || {},
						caseItem.storeItems[ i ].value,
						msg + ': store item ' + i + ' found'
					);
				}
			}
			// Check round-trip
			expectedRtDoc = caseItem.normalizedBody ?
				ve.createDocumentFromHtml( caseItem.normalizedBody ) :
				htmlDoc;
			assert.equalDomElement( actualRtDoc.body, expectedRtDoc.body, msg + ': round-trip' );
		}
	};

	ve.test.utils.getModelFromTestCase = function ( caseItem ) {
		var i, length, model,
			store = new ve.dm.IndexValueStore();

		// Load storeItems into store
		if ( caseItem.storeItems ) {
			for ( i = 0, length = caseItem.storeItems.length; i < length; i++ ) {
				store.index( caseItem.storeItems[ i ].value, caseItem.storeItems[ i ].hash );
			}
		}
		model = new ve.dm.Document( ve.dm.example.preprocessAnnotations( caseItem.data, store ) );
		model.innerWhitespace = caseItem.innerWhitespace ? ve.copy( caseItem.innerWhitespace ) : new Array( 2 );
		if ( caseItem.modify ) {
			caseItem.modify( model );
		}
		return model;
	};

	ve.test.utils.runGetDomFromModelTest = function ( assert, caseItem, msg ) {
		var originalData, model, html, fromDataBody, clipboardHtml;

		model = ve.test.utils.getModelFromTestCase( caseItem );
		originalData = ve.copy( model.getFullData() );
		fromDataBody = caseItem.fromDataBody || caseItem.normalizedBody || caseItem.body;
		html = '<body>' + fromDataBody + '</body>';
		clipboardHtml = '<body>' + ( caseItem.clipboardBody || fromDataBody ) + '</body>';
		assert.equalDomElement(
			ve.dm.converter.getDomFromModel( model ),
			ve.createDocumentFromHtml( html ),
			msg
		);
		assert.equalDomElement(
			ve.dm.converter.getDomFromModel( model, true ),
			ve.createDocumentFromHtml( clipboardHtml ),
			msg + ' (clipboard mode)'
		);
		assert.deepEqualWithDomElements( model.getFullData(), originalData, msg + ' (data hasn\'t changed)' );
	};

	/**
	 * Create a UI surface from some HTML
	 *
	 * @param {string} html Document HTML
	 * @return {ve.ui.Surface} UI surface
	 */
	ve.test.utils.createSurfaceFromHtml = function ( html ) {
		return this.createSurfaceFromDocument( ve.createDocumentFromHtml( html ) );
	};

	/**
	 * Create a UI surface from a document
	 *
	 * @param {ve.dm.Document} doc Document
	 * @return {ve.ui.Surface} UI surface
	 */
	ve.test.utils.createSurfaceFromDocument = function ( doc ) {
		var target = new ve.init.sa.Target();
		$( '#qunit-fixture' ).append( target.$element );
		target.addSurface( doc );
		return target.surface;
	};

	/**
	 * Create a CE surface from some HTML
	 *
	 * @param {string} html Document HTML
	 * @return {ve.ce.Surface} CE surface
	 */
	ve.test.utils.createSurfaceViewFromHtml = function ( html ) {
		return this.createSurfaceViewFromDocument(
			ve.dm.converter.getModelFromDom( ve.createDocumentFromHtml( html ) )
		);
	};

	/**
	 * Create a CE surface from a document
	 *
	 * @param {ve.dm.Document} doc Document
	 * @return {ve.ce.Surface} CE surface
	 */
	ve.test.utils.createSurfaceViewFromDocument = function ( doc ) {
		var mockSurface = {
				$blockers: $( '<div>' ),
				$selections: $( '<div>' ),
				$element: $( '<div>' ),
				isMobile: function () {
					return false;
				},
				getBoundingClientRect: function () {
					return {};
				},
				getImportRules: function () {
					return ve.init.sa.Target.static.importRules;
				}
			},
			model = new ve.dm.Surface( doc ),
			view = new ve.ce.Surface( model, mockSurface );

		view.surface = mockSurface;
		mockSurface.$element.append( view.$element );
		$( '#qunit-fixture' ).append( mockSurface.$element );

		view.initialize();
		model.initialize();

		return view;
	};

	/**
	 * Create a model-only UI surface from some HTML
	 *
	 * @param {string} html Document HTML
	 * @return {Object} Mock UI surface which only returns a real model
	 */
	ve.test.utils.createModelOnlySurfaceFromHtml = function ( html ) {
		var model = new ve.dm.Surface(
			ve.dm.converter.getModelFromDom( ve.createDocumentFromHtml( html ) )
		);
		return {
			getModel: function () {
				return model;
			},
			getView: function () {
				// Mock view
				return {
					focus: function () {}
				};
			}
		};
	};

	/**
	 * Build a DOM from a JSON structure.
	 *
	 * @param {Object} data JSON structure
	 * @param {string} data.type Tag name or '#text' or '#comment'
	 * @param {string} [data.text] Node text, only used if type is '#text' or '#comment'
	 * @param {Object[]} [data.children] Node's children; array of objects like data
	 * @return {Node} DOM node corresponding to data
	 */
	ve.test.utils.buildDom = function buildDom( data ) {
		var i, node;
		if ( data.type === '#text' ) {
			return document.createTextNode( data.text );
		}
		if ( data.type === '#comment' ) {
			return document.createComment( data.text );
		}
		node = document.createElement( data.type );
		if ( data.children ) {
			for ( i = 0; i < data.children.length; i++ ) {
				node.appendChild( buildDom( data.children[ i ] ) );
			}
		}
		return node;
	};

	/**
	 * Like a reduced outerHTML serialization, but with a position marker '|'.
	 *
	 * For clarity, also wraps each text node in a fake tag, and omits non-class attributes.
	 *
	 * @param {Node} rootNode The node to serialize
	 * @param {Object} position
	 * @param {Node} position.node The node at which the position marker lies
	 * @param {number} position.offset The offset at which the position marker lies
	 * @param {Object} [options]
	 * @param {Function|string} options.ignore Selector for nodes to omit from output
	 * @return {string} Serialization of the node and position
	 */
	ve.test.utils.serializePosition = function ( rootNode, position, options ) {
		var html = [];
		function add( node ) {
			var i, len;

			if ( options && options.ignore && $( node ).is( options.ignore ) ) {
				return;
			} else if ( node.nodeType === Node.TEXT_NODE ) {
				html.push( '<#text>' );
				if ( node === position.node ) {
					html.push( ve.escapeHtml(
						node.textContent.substring( 0, position.offset ) +
						'|' +
						node.textContent.substring( position.offset )
					) );
				} else {
					html.push( ve.escapeHtml( node.textContent ) );
				}
				html.push( '</#text>' );
				return;
			} else if ( node.nodeType !== Node.ELEMENT_NODE ) {
				html.push( '<#unknown type=\'' + node.nodeType + '\'/>' );
				return;
			}
			// else node.nodeType === Node.ELEMENT_NODE

			html.push( '<', ve.escapeHtml( node.nodeName.toLowerCase() ) );
			if ( node.hasAttribute( 'class' ) ) {
				// Single quotes are less annoying for JSON escaping
				html.push(
					' class=\'',
					ve.escapeHtml( node.getAttribute( 'class' ) ),
					'\''
				);
			}
			html.push( '>' );
			for ( i = 0, len = node.childNodes.length; i < len; i++ ) {
				if ( node === position.node && i === position.offset ) {
					html.push( '|' );
				}
				add( node.childNodes[ i ] );
			}
			if ( node === position.node && node.childNodes.length === position.offset ) {
				html.push( '|' );
			}
			html.push( '</', ve.escapeHtml( node.nodeName.toLowerCase() ), '>' );
		}
		add( rootNode );
		return html.join( '' );
	};
}() );
