/**
 * VisualEditor DataModel namespace.
 * 
 * All classes and functions will be attached to this object to keep the global namespace clean.
 */
ve.dm = {

	/* Static Members */

	/**
	 * Mapping of symbolic names and node model constructors.
	 */
	'nodeModels': {},
	/**
	 * Mapping of symbolic names and nesting rules.
	 * 
	 * Each rule is an object with the follwing properties:
	 *     parents and children properties may contain one of two possible values:
	 *         {Array} List symbolic names of allowed element types (if empty, none will be allowed)
	 *         {Null} Any element type is allowed (as long as the other element also allows it)
	 * 
	 * @example Paragraph rules
	 *     {
	 *         'parents': null,
	 *         'children': []
	 *     }
	 * @example List rules
	 *     {
	 *         'parents': null,
	 *         'children': ['listItem']
	 *     }
	 * @example ListItem rules
	 *     {
	 *         'parents': ['list'],
	 *         'children': null
	 *     }
	 * @example TableCell rules
	 *     {
	 *         'parents': ['tableRow'],
	 *         'children': null
	 *     }
	 */
	'nodeRules': {
		'document': {
			'parents': null,
			'children': null
		}
	},

	/* Static Methods */

	/*
	 * Create child nodes from an array of data.
	 * 
	 * These child nodes are used for the model tree, which is a space partitioning data structure
	 * in which each node contains the length of itself (1 for opening, 1 for closing) and the
	 * lengths of it's child nodes.
	 */
	'createNodesFromData': function( data ) {
		var currentNode = new ve.dm.BranchNode();
		for ( var i = 0, length = data.length; i < length; i++ ) {
			if ( data[i].type !== undefined ) {
				// It's an element, figure out it's type
				var element = data[i],
					type = element.type,
					open = type.charAt( 0 ) !== '/';
				// Trim the "/" off the beginning of closing tag types
				if ( !open ) {
					type = type.substr( 1 );
				}
				if ( open ) {
					// Validate the element type
					if ( !( type in ve.dm.DocumentNode.nodeModels ) ) {
						throw 'Unsuported element error. No class registered for element type: ' +
							type;
					}
					// Create a model node for the element
					var newNode = new ve.dm.DocumentNode.nodeModels[element.type]( element, 0 );
					// Add the new model node as a child
					currentNode.push( newNode );
					// Descend into the new model node
					currentNode = newNode;
				} else {
					// Return to the parent node
					currentNode = currentNode.getParent();
					if ( currentNode === null ) {
						throw 'createNodesFromData() received unbalanced data: found closing ' +
							'without matching opening at index ' + i;
					}
				}
			} else {
				// It's content, let's start tracking the length
				var start = i;
				// Move forward to the next object, tracking the length as we go
				while ( data[i].type === undefined && i < length ) {
					i++;
				}
				// Now we know how long the current node is
				currentNode.setContentLength( i - start );
				// The while loop left us 1 element to far
				i--;
			}
		}
		return currentNode.getChildren().slice( 0 );
	},
	/**
	 * Creates a document model from a plain object.
	 * 
	 * @static
	 * @method
	 * @param {Object} obj Object to create new document model from
	 * @returns {ve.dm.DocumentNode} Document model created from obj
	 */
	'newFromPlainObject': function( obj ) {
		if ( obj.type === 'document' ) {
			var data = [],
				attributes = ve.isPlainObject( obj.attributes ) ?
					ve.copyObject( obj.attributes ) : {};
			for ( var i = 0; i < obj.children.length; i++ ) {
				data = data.concat(
					ve.dm.DocumentNode.flattenPlainObjectElementNode( obj.children[i] )
				);
			}
			return new ve.dm.DocumentNode( data, attributes );
		}
		throw 'Invalid object error. Object is not a valid document object.';
	},
	/**
	 * Generates a hash of an annotation object based on it's name and data.
	 * 
	 * @static
	 * @method
	 * @param {Object} annotation Annotation object to generate hash for
	 * @returns {String} Hash of annotation
	 */
	'getHash': ( window.JSON && typeof JSON.stringify === 'function' ) ?
		JSON.stringify : ve.dm.JsonSerializer.stringify,
	/**
	 * Gets the index of the first instance of a given annotation.
	 * 
	 * This method differs from ve.inArray because it compares hashes instead of references.
	 * 
	 * @static
	 * @method
	 * @param {Array} annotations Annotations to search through
	 * @param {Object} annotation Annotation to search for
	 * @param {Boolean} typeOnly Whether to only consider the type
	 * @returns {Integer} Index of annotation in annotations, or -1 if annotation was not found
	 */
	'getIndexOfAnnotation': function( annotations, annotation, typeOnly ) {
		if ( annotation === undefined || annotation.type === undefined ) {
			throw 'Invalid annotation error. Can not find non-annotation data in character.';
		}
		if ( ve.isArray( annotations ) ) {
			// Find the index of a comparable annotation (checking for same value, not reference)
			for ( var i = 0; i < annotations.length; i++ ) {
				// Skip over character data - used when this is called on a content data item
				if ( typeof annotations[i] === 'string' ) {
					continue;
				}
				if (
					(
						typeOnly && 
						annotations[i].type === annotation.type
					) ||
					(
						!typeOnly &&
						annotations[i].hash === (
							annotation.hash || ve.dm.DocumentNode.getHash( annotation )
						)
					)
				) {
					return i;
				}
			}
		}
		return -1;
	},
	/**
	 * Gets a list of indexes of annotations that match a regular expression.
	 * 
	 * @static
	 * @method
	 * @param {Array} annotations Annotations to search through
	 * @param {RegExp} pattern Regular expression pattern to match with
	 * @returns {Integer[]} List of indexes in annotations that match
	 */
	'getMatchingAnnotations': function( annotations, pattern ) {
		if ( !( pattern instanceof RegExp ) ) {
			throw 'Invalid annotation error. Can not find non-annotation data in character.';
		}
		var matches = [];
		if ( ve.isArray( annotations ) ) {
			// Find the index of a comparable annotation (checking for same value, not reference)
			for ( var i = 0; i < annotations.length; i++ ) {
				// Skip over character data - used when this is called on a content data item
				if ( typeof annotations[i] === 'string' ) {
					continue;
				}
				if ( pattern.test( annotations[i].type ) ) {
					matches.push( annotations[i] );
				}
			}
		}
		return matches;
	},
	/**
	 * Sorts annotations of a character.
	 * 
	 * This method modifies data in place. The string portion of the annotation character will always
	 * remain at the beginning.
	 * 
	 * @static
	 * @method
	 * @param {Array} character Annotated character to be sorted
	 */
	'sortCharacterAnnotations': function( character ) {
		if ( !ve.isArray( character ) ) {
			return;
		}
		character.sort( function( a, b ) {
			var aHash = a.hash || ve.dm.DocumentNode.getHash( a ),
				bHash = b.hash || ve.dm.DocumentNode.getHash( b );
			return typeof a === 'string' ? -1 :
				( typeof b === 'string' ? 1 : ( aHash == bHash ? 0 : ( aHash < bHash ? -1 : 1 ) ) );
		} );
	},
	/**
	 * Adds annotation hashes to content data.
	 * 
	 * This method modifies data in place.
	 * 
	 * @method
	 * @param {Array} data Data to add annotation hashes to
	 */
	'addAnnotationHashesToData': function( data ) {
		for ( var i = 0; i < data.length; i++ ) {
			if ( ve.isArray( data[i] ) ) {
				for ( var j = 1; j < data.length; j++ ) {
					if ( data[i][j].hash === undefined ) {
						data[i][j].hash = ve.dm.DocumentNode.getHash( data[i][j] );
					}
				}
			}
		}
	},
	/**
	 * Applies annotations to content data.
	 * 
	 * This method modifies data in place.
	 * 
	 * @method
	 * @param {Array} data Data to remove annotations from
	 * @param {Array} annotations Annotations to apply
	 */
	'addAnnotationsToData': function( data, annotations ) {
		if ( annotations && annotations.length ) {
			for ( var i = 0; i < data.length; i++ ) {
				if ( ve.isArray( data[i] ) ) {
					data[i] = [data[i]];
				}
				data[i] = [data[i]].concat( annotations );
			}
		}
	},
	/**
	 * Removes annotations from content data.
	 * 
	 * This method modifies data in place.
	 * 
	 * @method
	 * @param {Array} data Data to remove annotations from
	 * @param {Array} [annotations] Annotations to remove (all will be removed if undefined)
	 */
	'removeAnnotationsFromData': function( data, annotations ) {
		for ( var i = 0; i < data.length; i++ ) {
			if ( ve.isArray( data[i] ) ) {
				data[i] = data[i][0];
			}
		}
	},
	/**
	 * Creates an ve.ContentModel object from a plain content object.
	 * 
	 * A plain content object contains plain text and a series of annotations to be applied to ranges of
	 * the text.
	 * 
	 * @example
	 * {
	 *     'text': '1234',
	 *     'annotations': [
	 *         // Makes "23" bold
	 *         {
	 *             'type': 'bold',
	 *             'range': {
	 *                 'start': 1,
	 *                 'end': 3
	 *             }
	 *         }
	 *     ]
	 * }
	 * 
	 * @static
	 * @method
	 * @param {Object} obj Plain content object, containing a "text" property and optionally
	 * an "annotations" property, the latter of which being an array of annotation objects including
	 * range information
	 * @returns {Array}
	 */
	'flattenPlainObjectContentNode': function( obj ) {
		if ( !ve.isPlainObject( obj ) ) {
			// Use empty content
			return [];
		} else {
			// Convert string to array of characters
			var data = obj.text.split('');
			// Render annotations
			if ( ve.isArray( obj.annotations ) ) {
				for ( var i = 0, length = obj.annotations.length; i < length; i++ ) {
					var src = obj.annotations[i];
					// Build simplified annotation object
					var dst = { 'type': src.type };
					if ( 'data' in src ) {
						dst.data = ve.copyObject( src.data );
					}
					// Add a hash to the annotation for faster comparison
					dst.hash = ve.dm.DocumentNode.getHash( dst );
					// Apply annotation to range
					if ( src.range.start < 0 ) {
						// TODO: The start can not be lower than 0! Throw error?
						// Clamp start value
						src.range.start = 0;
					}
					if ( src.range.end > data.length ) {
						// TODO: The end can not be higher than the length! Throw error?
						// Clamp end value
						src.range.end = data.length;
					}
					for ( var j = src.range.start; j < src.range.end; j++ ) {
						// Auto-convert to array
						if ( typeof data[j] === 'string' ) {
							data[j] = [data[j]];
						}
						// Append 
						data[j].push( dst );
					}
				}
			}
			return data;
		}
	},
	/**
	 * Flatten a plain node object into a data array, recursively.
	 * 
	 * TODO: where do we document this whole structure - aka "WikiDom"?
	 * 
	 * @static
	 * @method
	 * @param {Object} obj Plain node object to flatten
	 * @returns {Array} Flattened version of obj
	 */
	'flattenPlainObjectElementNode': function( obj ) {
		var i,
			data = [],
			element = { 'type': obj.type };
		if ( ve.isPlainObject( obj.attributes ) ) {
			element.attributes = ve.copyObject( obj.attributes );
		}
		// Open element
		data.push( element );
		if ( ve.isPlainObject( obj.content ) ) {
			// Add content
			data = data.concat( ve.dm.DocumentNode.flattenPlainObjectContentNode( obj.content ) );
		} else if ( ve.isArray( obj.children ) ) {
			// Add children - only do this if there is no content property
			for ( i = 0; i < obj.children.length; i++ ) {
				// TODO: Figure out if all this concatenating is inefficient. I think it is
				data = data.concat( ve.dm.DocumentNode.flattenPlainObjectElementNode( obj.children[i] ) );
			}
		}
		// Close element - TODO: Do we need attributes here or not?
		data.push( { 'type': '/' + obj.type } );
		return data;
	},
	/**
	 * Get a plain object representation of content data.
	 * 
	 * @method
	 * @returns {Object} Plain object representation
	 */
	'getExpandedContentData': function( data ) {
		var stack = [];
		// Text and annotations
		function start( offset, annotation ) {
			// Make a new verion of the annotation object and push it to the stack
			var obj = {
				'type': annotation.type,
				'range': { 'start': offset }
			};
			if ( annotation.data ) {
				obj.data = ve.copyObject( annotation.data );
			}
			stack.push( obj );
		}
		function end( offset, annotation ) {
			for ( var i = stack.length - 1; i >= 0; i-- ) {
				if ( !stack[i].range.end ) {
					if ( annotation ) {
						// We would just compare hashes, but the stack doesn't contain any
						if ( stack[i].type === annotation.type &&
								ve.compareObjects( stack[i].data, annotation.data ) ) {
							stack[i].range.end = offset;
							break;
						}
					} else {
						stack[i].range.end = offset;
					}
				}
			}
		}
		var left = '',
			right,
			leftPlain,
			rightPlain,
			obj = { 'text': '' },
			offset = 0,
			i,
			j;
		for ( i = 0; i < data.length; i++ ) {
			right = data[i];
			leftPlain = typeof left === 'string';
			rightPlain = typeof right === 'string';
			// Open or close annotations
			if ( !leftPlain && rightPlain ) {
				// [formatted][plain] pair, close any annotations for left
				end( i - offset );
			} else if ( leftPlain && !rightPlain ) {
				// [plain][formatted] pair, open any annotations for right
				for ( j = 1; j < right.length; j++ ) {
					start( i - offset, right[j] );
				}
			} else if ( !leftPlain && !rightPlain ) {
				// [formatted][formatted] pair, open/close any differences
				for ( j = 1; j < left.length; j++ ) {
					if ( ve.dm.DocumentNode.getIndexOfAnnotation( data[i] , left[j], true ) === -1 ) {
						end( i - offset, left[j] );
					}
				}
				for ( j = 1; j < right.length; j++ ) {
					if ( ve.dm.DocumentNode.getIndexOfAnnotation( data[i - 1], right[j], true ) === -1 ) {
						start( i - offset, right[j] );
					}
				}
			}
			obj.text += rightPlain ? right : right[0];
			left = right;		
		}
		if ( data.length ) {
			end( i - offset );
		}
		if ( stack.length ) {
			obj.annotations = stack;
		}
		// Copy attributes if there are any set
		if ( !ve.isEmptyObject( this.attributes ) ) {
			obj.attributes = ve.extendObject( true, {}, this.attributes );
		}
		return obj;
	},
	/**
	 * Checks if a data at a given offset is content.
	 * 
	 * @example Content data:
	 *      <paragraph> a b c </paragraph> <list> <listItem> d e f </listItem> </list>
	 *                 ^ ^ ^                                ^ ^ ^
	 * 
	 * @static
	 * @method
	 * @param {Array} data Data to evaluate offset within
	 * @param {Integer} offset Offset in data to check
	 * @returns {Boolean} If data at offset is content
	 */
	'isContentData': function( data, offset ) {
		// Shortcut: if there's already content there, we will trust it's supposed to be there
		return typeof data[offset] === 'string' || ve.isArray( data[offset] );
	},
	/**
	 * Checks if a data at a given offset is an element.
	 * 
	 * @example Element data:
	 *      <paragraph> a b c </paragraph> <list> <listItem> d e f </listItem> </list>
	 *     ^                 ^            ^      ^                ^           ^
	 * 
	 * @static
	 * @method
	 * @param {Array} data Data to evaluate offset within
	 * @param {Integer} offset Offset in data to check
	 * @returns {Boolean} If data at offset is an element
	 */
	'isElementData': function( data, offset ) {
		// TODO: Is there a safer way to check if it's a plain object without sacrificing speed?
		return offset >= 0 && offset < data.length && data[offset].type !== undefined;
	},
	/**
	 * Checks if an offset within given data is structural.
	 * 
	 * Structural offsets are those at the beginning, end or surrounded by elements. This differs
	 * from a location at which an element is present in that elements can be safely inserted at a
	 * structural location, but not nessecarily where an element is present.
	 * 
	 * @example Structural offsets:
	 *      <paragraph> a b c </paragraph> <list> <listItem> d e f </listItem> </list>
	 *     ^                              ^      ^                            ^       ^
	 * 
	 * @static
	 * @method
	 * @param {Array} data Data to evaluate offset within
	 * @param {Integer} offset Offset to check
	 * @returns {Boolean} Whether offset is structural or not
	 */
	'isStructuralOffset': function( data, offset ) {
		// Edges are always structural
		if ( offset === 0 || offset === data.length ) {
			return true;
		}
		// Structual offsets will have elements on each side
		if ( data[offset - 1].type !== undefined && data[offset].type !== undefined ) {
			if ( '/' + data[offset - 1].type === data[offset].type ) {
				return false;
			}
			return true;
		}
		return false;
	},
	/**
	 * Checks if elements are present within data.
	 * 
	 * @static
	 * @method
	 * @param {Array} data Data to look for elements within
	 * @returns {Boolean} If elements exist in data
	 */
	'containsElementData': function( data ) {
		for ( var i = 0, length = data.length; i < length; i++ ) {
			if ( data[i].type !== undefined ) {
				return true;
			}
		}
		return false;
	}
};
