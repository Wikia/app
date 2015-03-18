/*!
 * VisualEditor DataModel MWTransclusionNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki transclusion node.
 *
 * @class
 * @abstract
 * @extends ve.dm.LeafNode
 * @mixins ve.dm.GeneratedContentNode
 * @mixins ve.dm.FocusableNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWTransclusionNode = function VeDmMWTransclusionNode() {
	// Parent constructor
	ve.dm.LeafNode.apply( this, arguments );

	// Mixin constructors
	ve.dm.GeneratedContentNode.call( this );
	ve.dm.FocusableNode.call( this );

	// Properties
	this.partsList = null;

	// Events
	this.connect( this, { attributeChange: 'onAttributeChange' } );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWTransclusionNode, ve.dm.LeafNode );

OO.mixinClass( ve.dm.MWTransclusionNode, ve.dm.GeneratedContentNode );

OO.mixinClass( ve.dm.MWTransclusionNode, ve.dm.FocusableNode );

/* Static members */

ve.dm.MWTransclusionNode.static.name = 'mwTransclusion';

ve.dm.MWTransclusionNode.static.matchTagNames = null;

ve.dm.MWTransclusionNode.static.matchRdfaTypes = [
	'mw:Transclusion',
	// We're interested in all nodes that have mw:Transclusion, even if they also have other mw:
	// types. So we match all mw: types, then use a matchFunction to assert that mw:Transclusion
	// is in there.
	/^mw:/
];

ve.dm.MWTransclusionNode.static.matchFunction = function ( domElement ) {
	return ve.indexOf( 'mw:Transclusion',
		( domElement.getAttribute( 'typeof' ) || '' ).split( ' ' )
	) !== -1;
};

ve.dm.MWTransclusionNode.static.enableAboutGrouping = true;

ve.dm.MWTransclusionNode.static.getHashObject = function ( dataElement ) {
	return {
		type: dataElement.type,
		mw: dataElement.attributes.mw
	};
};

ve.dm.MWTransclusionNode.static.toDataElement = function ( domElements, converter ) {
	if ( converter.isDomAllMetaOrWhitespace( domElements, ['mwTransclusion', 'mwTransclusionInline', 'mwTransclusionBlock'] ) ) {
		return ve.dm.MWTransclusionMetaItem.static.toDataElement( domElements, converter );
	}

	var dataElement, index,
		mwDataJSON = domElements[0].getAttribute( 'data-mw' ),
		mwData = mwDataJSON ? JSON.parse( mwDataJSON ) : {},
		isInline = this.isHybridInline( domElements, converter ),
		type = isInline ? 'mwTransclusionInline' : 'mwTransclusionBlock';

	dataElement = {
		type: type,
		attributes: {
			mw: mwData,
			originalDomElements: ve.copy( domElements ),
			originalMw: mwDataJSON
		}
	};

	if ( !domElements[0].getAttribute( 'data-ve-no-generated-contents' ) ) {
		index = this.storeGeneratedContents( dataElement, domElements, converter.getStore() );
		dataElement.attributes.originalIndex = index;
	}

	return dataElement;
};

ve.dm.MWTransclusionNode.static.toDomElements = function ( dataElement, doc, converter ) {
	var els, currentDom, i, len, wrapper,
		index = converter.getStore().indexOfHash( OO.getHash( [ this.getHashObject( dataElement ), undefined ] ) ),
		originalMw = dataElement.attributes.originalMw;

	// If the transclusion is unchanged just send back the
	// original DOM elements so selser can skip over it
	if (
		dataElement.attributes.originalDomElements && (
			index === dataElement.attributes.originalIndex ||
			( originalMw && ve.compare( dataElement.attributes.mw, JSON.parse( originalMw ) ) )
		)
	) {
		// The object in the store is also used for CE rendering so return a copy
		return ve.copyDomElements( dataElement.attributes.originalDomElements, doc );
	} else {
		if ( dataElement.attributes.originalDomElements ) {
			els = [ doc.createElement( dataElement.attributes.originalDomElements[0].nodeName ) ];
		} else {
			els = [ doc.createElement( 'span' ) ];
			if ( converter.isForClipboard() ) {
				// For the clipboard use the current DOM contents but mark as ignored
				// for the converter
				currentDom = converter.getStore().value( index );
				if ( currentDom ) {
					currentDom = ve.copyDomElements( currentDom, doc );
					// i = 0 is the data-mw span
					for ( i = 1, len = currentDom.length; i < len; i++ ) {
						// Wrap plain text nodes so we can give them an attribute
						if ( currentDom[i].nodeType === Node.TEXT_NODE ) {
							wrapper = doc.createElement( 'span' );
							wrapper.appendChild( currentDom[i] );
							currentDom[i] = wrapper;
						}
						currentDom[i].setAttribute( 'data-ve-ignore', 'true' );
						els.push( currentDom[i] );
					}
				}
			}
		}
		// All we need to send back to Parsoid is the original transclusion marker, with a
		// reconstructed data-mw property.
		els[0].setAttribute( 'typeof', 'mw:Transclusion' );
		els[0].setAttribute( 'data-mw', JSON.stringify( dataElement.attributes.mw ) );
		// Mark the element as not having valid generated contents with it in case it is
		// inserted into another editor (e.g. via paste).
		els[0].setAttribute( 'data-ve-no-generated-contents', true );
		// TODO: Include last-known generated contents in the output for rich
		// paste into a non-VE editor
		return els;
	}
};

/**
 * Escape a template parameter. Helper function for #getWikitext.
 *
 * @static
 * @param {string} param Parameter value
 * @returns {string} Escaped parameter value
 */
ve.dm.MWTransclusionNode.static.escapeParameter = function ( param ) {
	var match, needsNowiki, input = param, output = '',
		inNowiki = false, bracketStack = 0, linkStack = 0;
	while ( input.length > 0 ) {
		match = input.match( /(?:\[\[)|(?:\]\])|(?:\{\{)|(?:\}\})|\|+|<\/?nowiki>|<nowiki\s*\/>/ );
		if ( !match ) {
			output += input;
			break;
		}
		output += input.slice( 0, match.index );
		input = input.slice( match.index + match[0].length );
		if ( inNowiki ) {
			if ( match[0] === '</nowiki>' ) {
				inNowiki = false;
				output += match[0];
			} else {
				output += match[0];
			}
		} else {
			needsNowiki = true;
			if ( match[0] === '<nowiki>' ) {
				inNowiki = true;
				needsNowiki = false;
			} else if ( match[0] === '</nowiki>' || match[0].match( /<nowiki\s*\/>/ ) ) {
				needsNowiki = false;
			} else if ( match[0].match( /(?:\[\[)/ ) ) {
				linkStack++;
				needsNowiki = false;
			} else if ( match[0].match( /(?:\]\])/ ) ) {
				if ( linkStack > 0 ) {
					linkStack--;
					needsNowiki = false;
				}
			} else if ( match[0].match( /(?:\{\{)/ ) ) {
				bracketStack++;
				needsNowiki = false;
			} else if ( match[0].match( /(?:\}\})/ ) ) {
				if ( bracketStack > 0 ) {
					bracketStack--;
					needsNowiki = false;
				}
			} else if ( match[0].match( /\|+/ ) ) {
				if ( bracketStack > 0 || linkStack > 0 ) {
					needsNowiki = false;
				}
			}

			if ( needsNowiki ) {
				output += '<nowiki>' + match[0] + '</nowiki>';
			} else {
				output += match[0];
			}
		}
	}
	return output;
};

/* Methods */

/**
 * Handle attribute change events.
 *
 * @method
 * @param {string} key Attribute key
 * @param {string} from Old value
 * @param {string} to New value
 */
ve.dm.MWTransclusionNode.prototype.onAttributeChange = function ( key ) {
	if ( key === 'mw' ) {
		this.partsList = null;
	}
};

/**
 * Check if transclusion contains only a single template.
 *
 * @param {string|string[]} [templates] Names of templates to allow, omit to allow any template name
 * @return {boolean} Transclusion only contains a single template, which is one of the ones in templates
 */
ve.dm.MWTransclusionNode.prototype.isSingleTemplate = function ( templates ) {
	function normalizeTitle( name ) {
		var title = mw.Title.newFromText( name );
		return title ? title.getPrefixedText() : name;
	}

	var i, len, partsList = this.getPartsList();
	if ( partsList.length !== 1 ) {
		return false;
	}
	if ( templates === undefined ) {
		return true;
	}
	if ( typeof templates === 'string' ) {
		templates = [ templates ];
	}
	for ( i = 0, len = templates.length; i < len; i++ ) {
		if (
			partsList[0].template &&
			normalizeTitle( partsList[0].template ) === normalizeTitle( templates[i] )
		) {
			return true;
		}
	}
	return false;
};

/**
 * Get a simplified description of the transclusion's parts.
 *
 * @returns {Object[]} List of objects with either template or content properties
 */
ve.dm.MWTransclusionNode.prototype.getPartsList = function () {
	var i, len, part, content;

	if ( !this.partsList ) {
		this.partsList = [];
		content = this.getAttribute( 'mw' );
		for ( i = 0, len = content.parts.length; i < len; i++ ) {
			part = content.parts[i];
			this.partsList.push(
				part.template ?
					{ template: part.template.target.wt } :
					{ content: part }
			);
		}
	}

	return this.partsList;
};

/**
 * Get the wikitext for this transclusion.
 *
 * @method
 * @returns {string} Wikitext like `{{foo|1=bar|baz=quux}}`
 */
ve.dm.MWTransclusionNode.prototype.getWikitext = function () {
	var i, len, part, template, param,
		content = this.getAttribute( 'mw' ),
		wikitext = '';

	// Normalize to multi template format
	if ( content.params ) {
		content = { parts: [ { template: content } ] };
	}
	// Build wikitext from content
	for ( i = 0, len = content.parts.length; i < len; i++ ) {
		part = content.parts[i];
		if ( part.template ) {
			// Template
			template = part.template;
			wikitext += '{{' + template.target.wt;
			for ( param in template.params ) {
				wikitext += '|' + param + '=' +
					this.constructor.static.escapeParameter( template.params[param].wt );
			}
			wikitext += '}}';
		} else {
			// Plain wikitext
			wikitext += part;
		}
	}
	return wikitext;
};

/** */
ve.dm.MWTransclusionNode.prototype.getClonedElement = function () {
	var clone = ve.dm.LeafNode.prototype.getClonedElement.call( this );
	delete clone.attributes.originalMw;
	delete clone.attributes.originalDomElements;
	// Remove about attribute to prevent about grouping of duplicated transclusions
	this.constructor.static.removeHtmlAttribute( clone, 'about' );
	return clone;
};

/* Concrete subclasses */

/**
 * DataModel MediaWiki transclusion block node.
 *
 * @class
 * @extends ve.dm.MWTransclusionNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWTransclusionBlockNode = function VeDmMWTransclusionBlockNode() {
	// Parent constructor
	ve.dm.MWTransclusionNode.apply( this, arguments );
};

OO.inheritClass( ve.dm.MWTransclusionBlockNode, ve.dm.MWTransclusionNode );

ve.dm.MWTransclusionBlockNode.static.matchTagNames = [];

ve.dm.MWTransclusionBlockNode.static.name = 'mwTransclusionBlock';

/**
 * DataModel MediaWiki transclusion inline node.
 *
 * @class
 * @extends ve.dm.MWTransclusionNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWTransclusionInlineNode = function VeDmMWTransclusionInlineNode() {
	// Parent constructor
	ve.dm.MWTransclusionNode.apply( this, arguments );
};

OO.inheritClass( ve.dm.MWTransclusionInlineNode, ve.dm.MWTransclusionNode );

ve.dm.MWTransclusionInlineNode.static.matchTagNames = [];

ve.dm.MWTransclusionInlineNode.static.name = 'mwTransclusionInline';

ve.dm.MWTransclusionInlineNode.static.isContent = true;

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWTransclusionNode );
ve.dm.modelRegistry.register( ve.dm.MWTransclusionBlockNode );
ve.dm.modelRegistry.register( ve.dm.MWTransclusionInlineNode );
