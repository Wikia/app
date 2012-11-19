/**
 * VisualEditor data model Converter class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Converter between HTML DOM and VisualEditor linear data.
 *
 * @class
 * @constructor
 * @param {Object} options Conversion options
 */
ve.dm.Converter = function VeDmConverter( nodeFactory, annotationFactory ) {
	// Properties
	this.nodeFactory = nodeFactory;
	this.annotationFactory = annotationFactory;
	this.elements = {
		'toDomElement': {},
		'toDataElement': {},
		'dataElementTypes': {}
	};

	// Events
	this.nodeFactory.addListenerMethod( this, 'register', 'onNodeRegister' );
};

/* Static Methods */

/**
 * Get linear model data from a string optionally applying annotations
 *
 * @param {String} text Plain text to convert
 * @param {Array} [annotations] Array of annotation objects to apply
 * @returns {Array} Linear model data, one element per character
 */
ve.dm.Converter.getDataContentFromText = function ( text, annotations ) {
	var characters = text.split( '' ),
		annotationSet = new ve.AnnotationSet(),
		i;
	if ( !annotations || annotations.length === 0 ) {
		return characters;
	}
	// Build annotation set
	for ( i = 0; i < annotations.length; i++ ) {
		annotationSet.push( annotations[i] );
	}
	// Apply annotations to characters
	for ( i = 0; i < characters.length; i++ ) {
		// Make a shallow copy of the annotationSet object, otherwise adding an annotation to one
		// character automatically adds it to all of others as well, annotations should be treated
		// as immutable, so it's OK to share references, but annotation sets are not immutable, so
		// it's not safe to share references - each annotated character needs its own set
		characters[i] = [characters[i], annotationSet.clone()];
	}
	return characters;
};

/* Methods */

/**
 * Responds to register events from the node factory.
 *
 * If a node is special; such as document, alienInline, alienBlock and text; its {converters}
 * property should be set to null, as to distinguish it from a new node type that someone has simply
 * forgotten to implement converters for.
 *
 * @method
 * @param {String} type Node type
 * @param {Function} constructor Node constructor
 * @throws 'Missing conversion data in node implementation of {type}'
 */
ve.dm.Converter.prototype.onNodeRegister = function ( dataElementType, constructor ) {
	if ( constructor.converters === undefined ) {
		throw new Error( 'Missing conversion data in node implementation of ' + dataElementType );
	} else if ( constructor.converters !== null ) {
		var i,
			domElementTypes = constructor.converters.domElementTypes,
			toDomElement = constructor.converters.toDomElement,
			toDataElement = constructor.converters.toDataElement;
		// Registration
		this.elements.toDomElement[dataElementType] = toDomElement;
		for ( i = 0; i < domElementTypes.length; i++ ) {
			this.elements.toDataElement[domElementTypes[i]] = toDataElement;
			this.elements.dataElementTypes[domElementTypes[i]] = dataElementType;
		}
	}
};

/**
 * Get the DOM element for a given linear model element.
 *
 * This invokes the toDomElement function registered for the element type.
 * NOTE: alienBlock and alienInline elements are not supported, if you pass them this function
 * will return false. (Opposite of District 9: no aliens allowed.)
 *
 * @method
 * @param {Object} dataElement Linear model element
 * @returns {HTMLElement|false} DOM element, or false if this element cannot be converted
 */
ve.dm.Converter.prototype.getDomElementFromDataElement = function ( dataElement ) {
	var key, domElement, dataElementAttributes,
		dataElementType = dataElement.type;
	if (
		// Aliens
		dataElementType === 'alienInline' || dataElementType === 'alienBlock' ||
		// Unsupported elements
		!( dataElementType in this.elements.toDomElement)
	) {
		return false;
	}
	domElement = this.elements.toDomElement[dataElementType]( dataElementType, dataElement );
	dataElementAttributes = dataElement.attributes;
	if ( dataElementAttributes ) {
		for ( key in dataElementAttributes ) {
			// Only include 'html/*' attributes and strip the 'html/' from the beginning of the name
			if ( key.indexOf( 'html/' ) === 0 ) {
				domElement.setAttribute( key.substr( 5 ), dataElementAttributes[key] );
			}
		}
	}
	// Change markers
	if (
		dataElement.internal && dataElement.internal.changed &&
		!ve.isEmptyObject( dataElement.internal.changed ) &&
		ve.init.platform.useChangeMarkers()
	) {
		domElement.setAttribute( 'data-ve-changed',
			JSON.stringify( dataElement.internal.changed )
		);
	}
	return domElement;
};

/**
 * Get the linear model data element for a given DOM element.
 *
 * This invokes the toDataElement function registered for the element type
 *
 * @method
 * @param {HTMLElement} domElement DOM element
 * @returns {Object|false} Linear model element, or false if this node cannot be converted
 */
ve.dm.Converter.prototype.getDataElementFromDomElement = function ( domElement ) {
	var dataElement, domElementAttributes, dataElementAttributes, domElementAttribute, i,
		domElementType = domElement.nodeName.toLowerCase();
	if (
		// Unsupported elements
		!( domElementType in this.elements.toDataElement )
		// TODO check for generated elements
	) {
		return false;
	}
	dataElement = this.elements.toDataElement[domElementType]( domElementType, domElement );
	domElementAttributes = domElement.attributes;
	if ( domElementAttributes.length ) {
		dataElementAttributes = dataElement.attributes = dataElement.attributes || {};
		// Include all attributes and prepend 'html/' to each attribute name
		for ( i = 0; i < domElementAttributes.length; i++ ) {
			domElementAttribute = domElementAttributes[i];
			dataElementAttributes['html/' + domElementAttribute.name] = domElementAttribute.value;
		}
	}
	return dataElement;
};

/**
 * Check if an HTML DOM node represents an annotation, and if so, build an annotation object for it.
 *
 * @example Annotation Object
 *    { 'type': 'type', data: { 'key': 'value', ... } }
 *
 * @param {HTMLElement} domElement HTML DOM node
 * @returns {Object|false} Annotation object, or false if this node is not an annotation
 */
ve.dm.Converter.prototype.getDataAnnotationFromDomElement = function ( domElement ) {
	return ve.dm.annotationFactory.createFromElement( domElement ) || false;
};

/**
 * Build an HTML DOM node for a linear model annotation.
 *
 * @method
 * @param {Object} dataAnnotation Annotation object
 * @returns {HTMLElement} HTML DOM node
 */
ve.dm.Converter.prototype.getDomElementFromDataAnnotation = function ( dataAnnotation ) {
	var htmlData = dataAnnotation.toHTML(),
		domElement = document.createElement( htmlData.tag );
	ve.setDOMAttributes( domElement, htmlData.attributes );
	return domElement;
};

/**
 * Convert an HTML DOM tree to a linear model.
 *
 * Do not use the annotations, dataElement and path parameters, they're used for internal
 * recursion only.
 *
 * @method
 * @param {HTMLElement} domElement Wrapper div containing the HTML to convert
 * @param {Array} [annotations] Array of annotations (objects) to apply to the generated data
 * @param {Object} [dataElement] Data element to wrap the returned data in
 * @param {Array} [path] Array of linear model element types
 * @param {Boolean} [alreadyWrapped] Whether the caller has already started wrapping bare content in a paragraph
 * @returns {Array} Linear model data
 */
ve.dm.Converter.prototype.getDataFromDom = function ( domElement, annotations, dataElement, path, alreadyWrapped ) {
	function createAlien( domElement, isInline, isWrapper ) {
		var type = isInline ? 'alienInline' : 'alienBlock', html;
		if ( isWrapper ) {
			html =  $( domElement ).html();
		} else {
			html = $( '<div>' ).append( $( domElement ).clone() ).html();
		}
		return [
			{
				'type': type,
				'attributes': {
					'html': html
				}
			},
			{ 'type': '/' + type }
		];
	}
	function addWhitespace( element, index, whitespace ) {
		if ( !element.internal ) {
			element.internal = {};
		}
		// whitespace = [ outerPre, innerPre, innerPost, outerPost ]
		//           <tag>         text           </tag>          <nextTag>
		// ^^^^^^^^^^     ^^^^^^^^^    ^^^^^^^^^^^      ^^^^^^^^^^
		//  outerPre      innerPre      innerPost        outerPost
		if ( !element.internal.whitespace ) {
			element.internal.whitespace = [];
		}
		if ( !element.internal.whitespace[index] ) {
			element.internal.whitespace[index] = '';
		}
		element.internal.whitespace[index] = whitespace;
	}
	function processNextWhitespace( element ) {
		// This function uses and changes nextWhitespace in the outer function's scope,
		// which means it's not really a function but more of a shortcut.
		if ( nextWhitespace !== '' ) {
			addWhitespace( element, 0, nextWhitespace );
			nextWhitespace = '';
		}
	}

	/**
	 * Helper function to group adjacent child elements with the same about attribute together.
	 * If there are multiple adjacent child nodes with the same about attribute, they are
	 * wrapped in a <div> with the data-ve-aboutgroup attribute set.
	 *
	 * This function does not wrap single-element about groups, and does not descend into the
	 * child elements.
	 *
	 * @param element {HTMLElement} Element to process
	 */
	function doAboutGrouping( element ) {
		var child = element.firstChild, textNodes = [],
			prevChild, aboutGroup, aboutWrapper, childAbout, nextChild, i;
		while ( child ) {
			nextChild = child.nextSibling;
			if ( !child.getAttribute ) {
				// Text nodes don't have a getAttribute() method. Thanks HTML DOM,
				// that's really helpful ^^
				textNodes.push( child );
				child = nextChild;
				continue;
			}
			childAbout = child.getAttribute( 'about' );
			if ( childAbout && !aboutGroup ) {
				// Start of a new about group
				aboutGroup = childAbout;
			} else if ( childAbout && childAbout === aboutGroup ) {
				// Continuation of the current about group
				if ( !aboutWrapper ) {
					// This is the second child in this group, so the
					// previous child is the first child in this group.
					// Wrap the previous child
					aboutWrapper = document.createElement( 'div' );
					aboutWrapper.setAttribute( 'data-ve-aboutgroup', aboutGroup );
					element.insertBefore( aboutWrapper, prevChild );
					aboutWrapper.appendChild( prevChild );
				}
				// Append any outstanding text nodes to the wrapper
				for ( i = 0; i < textNodes.length; i++ ) {
					aboutWrapper.appendChild( textNodes[i] );
				}
				// Append this child to the wrapper
				aboutWrapper.appendChild( child );
			} else if ( aboutGroup ) {
				// This child isn't in the current about group
				aboutGroup = undefined;
				aboutWrapper = undefined;
				if ( childAbout ) {
					// Start of a new about group
					aboutGroup = childAbout;
				}
			}
			prevChild = child;
			child = nextChild;
			textNodes = [];
		}
	}

	// Fallback to defaults
	annotations = annotations || [];
	path = path || ['document'];
	var i, j, childDomElement, annotation, childDataElement, text, childTypes, matches,
		wrappingParagraph, prevElement, alien, rdfaType, isLink,
		data = [],
		branchType = path[path.length - 1],
		branchIsContent = ve.dm.nodeFactory.canNodeContainContent( branchType ),
		nextWhitespace = '',
		wrappedWhitespace = '',
		wrapping = alreadyWrapped,
		wrappingIsOurs = false;
	// Open element
	if ( dataElement ) {
		data.push( dataElement );
	}
	// Do about grouping
	// FIXME this assumes every about group is an alien
	doAboutGrouping( domElement );
	// Add contents
	for ( i = 0; i < domElement.childNodes.length; i++ ) {
		childDomElement = domElement.childNodes[i];
		switch ( childDomElement.nodeType ) {
			case Node.ELEMENT_NODE:
				// Alienate about groups
				if ( childDomElement.hasAttribute( 'data-ve-aboutgroup' ) ) {
					alien = createAlien( childDomElement, branchIsContent, true );
					data = data.concat( alien );
					processNextWhitespace( alien[0] );
					prevElement = alien[0];
					break;
				}

				// HACK handle <meta>/<link> separately because of the
				// metaInline/metaBlock distinction
				if (
					childDomElement.nodeName.toLowerCase() === 'meta' ||
					childDomElement.nodeName.toLowerCase() === 'link'
				) {
					isLink = childDomElement.nodeName.toLowerCase() === 'link';
					childDataElement = {
						'type': branchIsContent ? 'metaInline' : 'metaBlock',
						'attributes': {
							'style': isLink ? 'link' : 'meta',
							'key': childDomElement.getAttribute( isLink ? 'rel' : 'property' )
						}
					};
					if ( childDomElement.hasAttribute( isLink ? 'href' : 'content' ) ) {
						childDataElement.attributes.value = childDomElement.getAttribute( isLink ? 'href' : 'content' );
					}
					// Preserve HTML attributes
					// FIXME the following is duplicated from getDataElementFromDomElement()
					// Include all attributes and prepend 'html/' to each attribute name
					for ( j = 0; j < childDomElement.attributes.length; j++ ) {
						// ..but exclude attributes we've already processed,
						// because they'll be overwritten otherwise *sigh*
						// FIXME this sucks, we need a new node type API so bad
						if (
							childDomElement.attributes[j].name !== ( isLink ? 'rel' : 'property' ) &&
							childDomElement.attributes[j].name !== ( isLink ? 'href' : 'content' )
						) {
							childDataElement.attributes['html/' + childDomElement.attributes[j].name] = childDomElement.attributes[j].value;
						}
					}
					data.push( childDataElement );
					data.push( { 'type': branchIsContent ? '/metaInline' : '/metaBlock' } );
					processNextWhitespace( childDataElement );
					prevElement = childDataElement;
					break;
				}
				// Alienate anything with a mw: type that isn't registered
				// HACK because we don't actually have an RDFa type registry yet,
				// this hardcodes the set of recognized types
				rdfaType = childDomElement.getAttribute( 'rel' ) ||
					childDomElement.getAttribute( 'typeof' ) ||
					childDomElement.getAttribute( 'property' );
				if (
					rdfaType &&
					rdfaType.match( /^mw:/ ) &&
					!rdfaType.match( /^mw:WikiLink/ ) &&
					!rdfaType.match( /^mw:ExtLink/ )
				) {
					alien = createAlien( childDomElement, branchIsContent );
					data = data.concat( alien );
					processNextWhitespace( alien[0] );
					prevElement = alien[0];
					break;
				}

				// Detect and handle annotated content
				annotation = this.getDataAnnotationFromDomElement( childDomElement );
				if ( annotation ) {
					// Start auto-wrapping of bare content
					if ( !wrapping && !branchIsContent ) {
						// Mark this paragraph as having been generated by
						// us, so we can strip it on the way out
						wrappingParagraph = {
							'type': 'paragraph',
							'internal': { 'generated': 'wrapper' }
						};
						data.push( wrappingParagraph );
						wrapping = true;
						wrappingIsOurs = true;
						processNextWhitespace( wrappingParagraph );
						prevElement = wrappingParagraph;
					}
					// Append child element data
					data = data.concat(
						this.getDataFromDom(
							childDomElement, annotations.concat( [ annotation ] ), undefined, path, wrapping
						)
					);
					break;
				}

				// Look up child element type
				childDataElement = this.getDataElementFromDomElement( childDomElement );
				// End auto-wrapping of bare content from a previously processed node
				// but only if childDataElement is a non-content element or if
				// we are about to produce a block alien
				if (
					wrapping && (
						(
							childDataElement &&
							!ve.dm.nodeFactory.isNodeContent( childDataElement.type )
						) || (
							!childDataElement &&
							ve.isBlockElement( childDomElement )
						)
					)
				) {
					if ( wrappedWhitespace !== '' ) {
						// Remove wrappedWhitespace from data
						data.splice( -wrappedWhitespace.length, wrappedWhitespace.length );
						addWhitespace( wrappingParagraph, 3, wrappedWhitespace );
						nextWhitespace = wrappedWhitespace;
					}
					data.push( { 'type': '/paragraph' } );
					wrappingParagraph = undefined;
					wrapping = false;
					wrappingIsOurs = false;
				}
				// Append child element data
				if ( childDataElement ) {
					data = data.concat(
						this.getDataFromDom(
							childDomElement,
							[],
							childDataElement,
							path.concat( childDataElement.type ),
							wrapping
						)
					);
					processNextWhitespace( childDataElement );
					prevElement = childDataElement;
					break;
				}
				// We don't know what this is, fall back to alien.
				// If we're in wrapping mode, we don't know if this alien is
				// supposed to be block or inline, so detect it based on the HTML
				// tag name.
				alien = createAlien( childDomElement, wrapping ?
					!ve.isBlockElement( childDomElement ) : branchIsContent
				);
				data = data.concat( alien );
				processNextWhitespace( alien[0] );
				prevElement = alien[0];
				break;
			case Node.TEXT_NODE:
				text = childDomElement.data;
				if ( text === '' ) {
					// Empty text node?!?
					break;
				}
				if ( !branchIsContent ) {
					// Strip and store outer whitespace
					if ( text.match( /^\s+$/ ) ) {
						// This text node is whitespace only
						if ( wrapping ) {
							// We're already wrapping, so output this whitespace
							// and store it in wrappedWhitespace (see
							// comment about wrappedWhitespace below)
							wrappedWhitespace = text;
							data = data.concat(
								ve.dm.Converter.getDataContentFromText( wrappedWhitespace, annotations )
							);
						} else {
							// We're not in wrapping mode, store this whitespace
							if ( !prevElement ) {
								if ( dataElement ) {
									// First child, store as inner
									// whitespace in the parent
									addWhitespace( dataElement, 1, text );
								}
								// Else, WTF?!? This is not supposed to
								// happen, but it's not worth
								// throwing an exception over.
							} else {
								addWhitespace( prevElement, 3, text );
							}
							nextWhitespace = text;
							wrappedWhitespace = '';
						}
						// We're done, no actual text left to process
						break;
					} else {
						// This text node contains actual text
						// Separate the real text from the whitespace
						// HACK: . doesn't match newlines in JS, so use
						// [\s\S] to match any character
						matches = text.match( /^(\s*)([\s\S]*?)(\s*)$/ );
						if ( !wrapping ) {
							// Wrap the text in a paragraph and output it
							// Mark this paragraph as having been generated by
							// us, so we can strip it on the way out
							wrappingParagraph = {
								'type': 'paragraph',
								'internal': { 'generated': 'wrapper' }
							};
							processNextWhitespace( wrappingParagraph );
							data.push( wrappingParagraph );
							wrapping = true;
							wrappingIsOurs = true;

							// Only store leading whitespace if we just
							// started wrapping
							if ( matches[1] !== '' ) {
								if ( !prevElement ) {
									if ( dataElement ) {
										// First child, store as inner
										// whitespace in the parent
										addWhitespace( dataElement, 1, matches[1] );
									}
									// Else, WTF?!? This is not supposed to
									// happen, but it's not worth
									// throwing an exception over.
								} else {
									addWhitespace( prevElement, 3, matches[1] );
								}
								addWhitespace( wrappingParagraph, 0, matches[1] );
							}
						} else {
							// We were already wrapping in a paragraph,
							// so the leading whitespace must be output
							data = data.concat(
								ve.dm.Converter.getDataContentFromText( matches[1], annotations )
							);
						}
						// Output the text sans whitespace
						data = data.concat(
							ve.dm.Converter.getDataContentFromText( matches[2], annotations )
						);

						// Don't store this in wrappingParagraph.internal.whitespace[3]
						// and nextWhitespace just yet. Instead, store it
						// in wrappedWhitespace. There might be more text
						// nodes after this one, so we output wrappedWhitespace
						// for now and undo that if it turns out this was
						// the last text node. We can't output it later
						// because we have to apply the correct annotations.
						wrappedWhitespace = matches[3];
						data = data.concat(
							ve.dm.Converter.getDataContentFromText( wrappedWhitespace, annotations )
						);
						prevElement = wrappingParagraph;
						break;
					}
				}

				// Strip leading and trailing inner whitespace
				// (but only in non-annotation nodes)
				// and store it so it can be restored later.
				if (
					annotations.length === 0 && i === 0 && dataElement &&
					!ve.dm.nodeFactory.doesNodeHaveSignificantWhitespace( dataElement.type )
				) {
					// Strip leading whitespace from the first child
					matches = text.match( /^\s+/ );
					if ( matches && matches[0] !== '' ) {
						addWhitespace( dataElement, 1, matches[0] );
						text = text.substring( matches[0].length );
					}
				}
				if (
					annotations.length === 0 &&
					i === domElement.childNodes.length - 1 &&
					dataElement &&
					!ve.dm.nodeFactory.doesNodeHaveSignificantWhitespace( dataElement.type )
				) {
					// Strip trailing whitespace from the last child
					matches = text.match( /\s+$/ );
					if ( matches && matches[0] !== '' ) {
						addWhitespace( dataElement, 2, matches[0] );
						text = text.substring( 0,
							text.length - matches[0].length );
					}
				}

				// Annotate the text and output it
				data = data.concat(
					ve.dm.Converter.getDataContentFromText( text, annotations )
				);
				break;
			case Node.COMMENT_NODE:
				// TODO: Preserve comments by inserting them into the linear model too
				// Could use placeholders for this too, although they'd need to be
				// inline in certain cases
				break;
		}
	}
	// End auto-wrapping of bare content
	if ( wrapping && wrappingIsOurs ) {
		if ( wrappedWhitespace !== '' ) {
			// Remove wrappedWhitespace from data
			data.splice( -wrappedWhitespace.length, wrappedWhitespace.length );
			addWhitespace( wrappingParagraph, 3, wrappedWhitespace );
			nextWhitespace = wrappedWhitespace;
		}
		data.push( { 'type': '/paragraph' } );
		// Don't set wrapping = false here because it's checked below
		wrappingParagraph = undefined;
	}

	// If we're closing a node that doesn't have any children, but could contain a paragraph,
	// add a paragraph. This prevents things like empty list items
	childTypes = ve.dm.nodeFactory.getChildNodeTypes( branchType );
	if ( branchType !== 'paragraph' && dataElement && data[data.length - 1] === dataElement &&
		!wrapping && !ve.dm.nodeFactory.canNodeContainContent( branchType ) &&
		!ve.dm.nodeFactory.isNodeContent( branchType ) &&
		( childTypes === null || ve.indexOf( 'paragraph', childTypes ) !== -1 )
	) {
		data.push( { 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } } );
		data.push( { 'type': '/paragraph' } );
	}

	// Close element
	if ( dataElement ) {
		data.push( { 'type': '/' + dataElement.type } );
		// Add the whitespace after the last child to the parent as innerPost
		if ( nextWhitespace !== '' ) {
			addWhitespace( dataElement, 2, nextWhitespace );
			nextWhitespace = '';
		}
	}
	// Don't return an empty document
	if ( branchType === 'document' && data.length === 0 ) {
		return [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			{ 'type': '/paragraph' }
		];
	}
	return data;
};

/**
 * Convert linear model data to an HTML DOM
 *
 * @method
 * @param {Array} data Linear model data
 * @returns {HTMLElement} Wrapper div containing the resulting HTML
 */
ve.dm.Converter.prototype.getDomFromData = function ( data ) {
	var text, i, j, k, annotations, annotation, annotationElement, dataElement, arr,
		wrapper, childDomElement, pre, ours, theirs, parentDomElement, startClosingAt,
		isContentNode, changed, parentChanged,
		container = document.createElement( 'div' ),
		domElement = container,
		annotationStack = new ve.AnnotationSet();
	for ( i = 0; i < data.length; i++ ) {
		if ( typeof data[i] === 'string' ) {
			// Text
			text = '';
			// Continue forward as far as the plain text goes
			while ( typeof data[i] === 'string' ) {
				text += data[i];
				i++;
			}
			// i points to the first non-text thing, go back one so we don't skip this later
			i--;
			// Add text
			domElement.appendChild( document.createTextNode( text ) );
		} else if (
			ve.isArray( data[i] ) ||
			(
				data[i].annotations !== undefined &&
				ve.dm.nodeFactory.isNodeContent( data[i].type )
			)
		) {
			// Annotated text or annotated nodes
			text = '';
			while (
				ve.isArray( data[i] ) ||
				(
					data[i].annotations !== undefined &&
					ve.dm.nodeFactory.isNodeContent( data[i].type )
				)
			) {
				annotations = data[i].annotations || data[i][1];
				// Close annotations as needed
				// Go through annotationStack from bottom to top (low to high),
				// and find the first annotation that's not in annotations.
				startClosingAt = undefined;
				arr = annotationStack.get();
				for ( j = 0; j < arr.length; j++ ) {
					annotation = arr[j];
					if ( !annotations.contains( annotation ) ) {
						startClosingAt = j;
						break;
					}
				}
				if ( startClosingAt !== undefined ) {
					// Close all annotations from top to bottom (high to low)
					// until we reach startClosingAt
					for ( j = annotationStack.getLength() - 1; j >= startClosingAt; j-- ) {
						// Add text if needed
						if ( text.length > 0 ) {
							domElement.appendChild( document.createTextNode( text ) );
							text = '';
						}
						// Traverse up
						domElement = domElement.parentNode;
						// Remove from annotationStack
						annotationStack.removeAt( j );
					}
				}

				// Open annotations as needed
				arr = annotations.get();
				for ( j = 0; j < arr.length; j++ ) {
					annotation = arr[j];
					if ( !annotationStack.contains( annotation ) ) {
						// Add text if needed
						if ( text.length > 0 ) {
							domElement.appendChild( document.createTextNode( text ) );
							text = '';
						}
						// Create new node and descend into it
						annotationElement = this.getDomElementFromDataAnnotation( annotation );
						domElement.appendChild( annotationElement );
						domElement = annotationElement;
						// Add to annotationStack
						annotationStack.push( annotation );
					}
				}

				if ( data[i].annotations === undefined ) {
					// Annotated text
					text += data[i][0];
				} else {
					// Annotated node
					// Add text if needed
					if ( text.length > 0 ) {
						domElement.appendChild( document.createTextNode( text ) );
						text = '';
					}
					// Insert the element
					domElement.appendChild( this.getDomElementFromDataElement( data[i] ) );
					// Increment i once more so we skip over the closing as well
					i++;
				}
				i++;
			}
			// We're now at the first non-annotated thing, go back one so we don't skip this later
			i--;

			// Add any gathered text
			if ( text.length > 0 ) {
				domElement.appendChild( document.createTextNode( text ) );
				text = '';
			}
			// Close any remaining annotation nodes
			for ( j = annotationStack.getLength() - 1; j >= 0; j-- ) {
				// Traverse up
				domElement = domElement.parentNode;
			}
			// Clear annotationStack
			annotationStack = new ve.AnnotationSet();
		} else if ( data[i].type !== undefined ) {
			dataElement = data[i];
			// Element
			if ( dataElement.type.charAt( 0 ) === '/' ) {
				parentDomElement = domElement.parentNode;
				isContentNode = ve.dm.nodeFactory.isNodeContent( data[i].type.substr( 1 ) );
				// Process whitespace
				// whitespace = [ outerPre, innerPre, innerPost, outerPost ]
				if (
					!isContentNode &&
					domElement.veInternal &&
					domElement.veInternal.whitespace
				) {
					// Process inner whitespace. innerPre is for sure legitimate
					// whitespace that should be inserted; if it was a duplicate
					// of our child's outerPre, we would have cleared it.
					pre = domElement.veInternal.whitespace[1];
					if ( pre ) {
						if (
							domElement.firstChild &&
							domElement.firstChild.nodeType === 3
						) {
							// First child is a TextNode, prepend to it
							domElement.firstChild.insertData( 0, pre );
						} else {
							// Prepend a TextNode
							domElement.insertBefore(
								document.createTextNode( pre ),
								domElement.firstChild
							);
						}
					}
					ours = domElement.veInternal.whitespace[2];
					if ( domElement.lastOuterPost === undefined ) {
						// This node didn't have any structural children
						// (i.e. it's a content-containing node), so there's
						// nothing to check innerPost against
						theirs = ours;
					} else {
						theirs = domElement.lastOuterPost;
					}
					if ( ours && ours === theirs ) {
						if (
							domElement.lastChild &&
							domElement.lastChild.nodeType === 3
						) {
							// Last child is a TextNode, append to it
							domElement.lastChild.appendData( ours );
						} else {
							// Append a TextNode
							domElement.appendChild(
								document.createTextNode( ours )
							);
						}
					}
					// Tell the parent about our outerPost
					parentDomElement.lastOuterPost = domElement.veInternal.whitespace[3] || '';
				} else if ( !isContentNode ) {
					// Use empty string, because undefined means there were no
					// structural children
					parentDomElement.lastOuterPost = '';
				}
				// else don't touch lastOuterPost

				// If closing a generated wrapper node, unwrap it
				// It would be nicer if we could avoid generating in the first
				// place, but then remembering where we have to skip ascending
				// to the parent would be tricky.
				if ( domElement.veInternal && domElement.veInternal.generated === 'wrapper' ) {
					while ( domElement.firstChild ) {
						parentDomElement.insertBefore(
							domElement.firstChild,
							domElement
						);
					}
					// Transfer change markers
					changed = domElement.getAttribute( 'data-ve-changed' );
					if ( changed ) {
						parentChanged = parentDomElement.getAttribute( 'data-ve-changed' );
						if ( parentChanged ) {
							changed = $.parseJSON( changed );
							parentChanged = $.parseJSON( parentChanged );
							for ( k in changed ) {
								if ( k in parentChanged ) {
									parentChanged[k] += changed[k];
								} else {
									parentChanged[k] = changed[k];
								}
							}
							parentDomElement.setAttribute( 'data-ve-changed',
								$.toJSON( parentChanged ) );
						} else {
							parentDomElement.setAttribute( 'data-ve-changed',
								changed );
						}
					}
					parentDomElement.removeChild( domElement );
				}

				delete domElement.veInternal;
				delete domElement.lastOuterPost;
				// Ascend to parent node
				domElement = parentDomElement;
			} else {
				if ( dataElement.type === 'alienBlock' || dataElement.type === 'alienInline' ) {
					// Create nodes from source
					wrapper = document.createElement( 'div' );
					wrapper.innerHTML = dataElement.attributes.html;
					if ( wrapper.childNodes.length > 1 ) {
						// Wrap the HTML in a single element, this makes
						// it much easier to deal with. It'll be unwrapped
						// at the end of this function.
						childDomElement = document.createElement( 'div' );
						childDomElement.setAttribute( 'data-ve-multi-child-alien-wrapper', 'true' );
						while ( wrapper.firstChild ) {
							childDomElement.appendChild( wrapper.firstChild );
						}
					} else {
						childDomElement = wrapper.firstChild;
					}
				} else {
					// Create node from data
					childDomElement = this.getDomElementFromDataElement( dataElement );
				}
				// Add reference to internal data
				if ( dataElement.internal ) {
					childDomElement.veInternal = dataElement.internal;
				}
				// Add element
				domElement.appendChild( childDomElement );
				// Descend into child node
				parentDomElement = domElement;
				domElement = childDomElement;

				// Process outer whitespace
				// Every piece of outer whitespace is duplicated somewhere:
				// each node's outerPost is duplicated as the next node's
				// outerPre, the first node's outerPre is the parent's
				// innerPre, and the last node's outerPost is the parent's
				// innerPost. For each piece of whitespace, we verify that
				// the duplicate matches. If it doesn't, we take that to
				// mean the user has messed with it and don't output any
				// whitespace.
				if ( domElement.veInternal && domElement.veInternal.whitespace ) {
					// Process this node's outerPre
					ours = domElement.veInternal.whitespace[0];
					theirs = undefined;
					if ( domElement.previousSibling ) {
						// Get previous sibling's outerPost
						theirs = parentDomElement.lastOuterPost;
					} else if ( parentDomElement === container ) {
						// outerPre of the very first node in the document, this one
						// has no duplicate
						theirs = ours;
					} else {
						// First child, get parent's innerPre
						if (
							parentDomElement.veInternal &&
							parentDomElement.veInternal.whitespace
						) {
							theirs = parentDomElement.veInternal.whitespace[1];
							// Clear after use so it's not used twice
							parentDomElement.veInternal.whitespace[1] = undefined;
						}
						// else theirs=undefined
					}
					if ( ours && ours === theirs ) {
						// Matches the duplicate, insert a TextNode
						parentDomElement.insertBefore(
							document.createTextNode( ours ),
							domElement
						);
					}
				}
			}
		}
	}
	// Process the outerPost whitespace of the very last node
	if ( container.lastOuterPost !== undefined ) {
		if ( container.lastChild && container.lastChild.nodeType === 3 ) {
			// Last child is a TextNode, append to it
			container.lastChild.appendData( container.lastOuterPost );
		} else {
			// Append a TextNode
			container.appendChild( document.createTextNode( container.lastOuterPost ) );
		}
		delete container.lastOuterPost;
	}

	// Unwrap multi-child alien wrappers
	$( container ).find( '[data-ve-multi-child-alien-wrapper]' ) .each( function() {
		$( this ).replaceWith( $( this ).contents() );
	} );
	return container;
};

/* Initialization */

ve.dm.converter = new ve.dm.Converter( ve.dm.nodeFactory, ve.dm.annotationFactory );
