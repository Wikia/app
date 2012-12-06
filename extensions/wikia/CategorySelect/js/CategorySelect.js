(function( window, $, undefined ) {

/* global Mustache:true */
'use strict';

var cached = {},
	namespace = 'categorySelect',
	slice = Array.prototype.slice,
	wgCategorySelect = window.wgCategorySelect,
	Wikia = window.Wikia || {};

// Static message cache
cached.messages = {
	buttonSave: $.msg( 'categoryselect-button-save' ),
	categoryEdit: $.msg( 'categoryselect-category-edit' ),
	errorEmptyCategoryName: $.msg( 'categoryselect-error-empty-category-name' )
};

// Static template cache
cached.templates = {
	category: {
		data: {
			blankImageUrl: window.wgBlankImgUrl,
			className: 'normal',
			messages: {
				edit: cached.messages.categoryEdit,
				remove: $.msg( 'categoryselect-category-remove' )
			}
		}
	},
	categoryEdit: {
		data: {
			messages: {
				name: $.msg( 'categoryselect-modal-category-name' )
			}
		}
	}
};

/**
 * CategorySelect Class
 *
 * @param { Element | jQuery | String } element
 *        The element to initialize the class on, acts as a wrapper for all the
 *        necessary elements.
 *
 * @param { Object } options
 *        The settings to configure the instance with.
 */
var CategorySelect = function( element, options ) {
	var limit,
		elements = {},
		self = this;

	// Protect against calling without the 'new' operator
	if ( !( self instanceof CategorySelect ) ) {
		return new CategorySelect( element, options );
	}

	self.options = options = $.extend( true, {}, CategorySelect.options, options );

	// Store a reference to this class in the element
	self.element = element = $( element )
		.off( '.' + namespace )
		.data( namespace, self );

	// How to insert new categories into the DOM
	self.insertionMethod =
		( options.placement === 'bottom' || options.placement === 'right' ) ?
			'appendTo' : 'prependTo';

	self.dirty = true;
	self.elements = elements;

	// Attach listeners
	element
		.on( 'click.' + namespace, options.selectors.editCategory, function( event ) {
			self.editCategory( $( event.currentTarget ).closest( options.selectors.category ) );
		})
		.on( 'click.' + namespace, options.selectors.removeCategory, function( event ) {
			self.removeCategory( $( event.currentTarget ).closest( options.selectors.category ) );
		})
		.on( 'reset.' + namespace, $.proxy( self.resetCategories, self ) );

	// Handle keypresses on the input element
	elements.input = element.find( options.selectors.input )
		.on( 'keypress.' + namespace, function( event ) {
			if ( event.which === 13 ) {
				event.preventDefault();
				self.addCategory( elements.input.val() );
			}
		});

	elements.list = element.find( options.selectors.categories );

	// Store category data in categories
	elements.categories = elements.list
		.find( options.selectors.category )
		.each(function( i ) {
			$( this ).data( 'category',
				CategorySelect.normalize( options.categories[ i ] ) );
		});

	if ( typeof options.autocomplete === 'object' ) {
		limit = self.options.autocomplete.limit;

		elements.input.autocomplete( $.extend( options.autocomplete, {
			select: function( event, ui ) {
				event.preventDefault();
				self.addCategory( ui.item.value );
			},
			source: function( request, response ) {
				$.when( CategorySelect.getWikiCategories() ).done(function( categories ) {
					response( $.ui.autocomplete.filter( categories, request.term ).slice( 0, limit ) );
				});
			}
		}));

		// If there is already a value present, search for it now
		if ( elements.input.val() !== '' ) {
			elements.input.autocomplete( 'search' );
		}
	}

	if ( typeof options.popover === 'object' ) {
		self.popover = elements.input
			.on( 'blur.' + namespace, function() {
				elements.input.popover( 'hide' );
			})
			.popover( options.popover ).data( 'popover' );
	}

	if ( typeof options.sortable === 'object' ) {
		elements.list.sortable( $.extend( options.sortable, {
			update: function( event, ui ) {
				self.dirty = true;
				self.updateCategories();

				self.trigger( 'sort', {
					element: ui.item
				});

				self.trigger( 'update' );
			}
		}));
	}
};

/**
 * Public instance
 */
$.extend( CategorySelect.prototype, {

	/**
	 * Adds a category.
	 *
	 * @param { Element | jQuery | Number | String } category
	 *        The index of a category relative to the list of categories, the
	 *        name of a category or the jQuery or DOM Element for a category.
	 *
	 * @returns	{ Object }
	 *          The normalized category object, or undefined if the category is
	 *          invalid.
	 */
	addCategory: function( category ) {
		var data,
			self = this,
			input = self.elements.input,
			options = self.options;

		category = CategorySelect.normalize( category );

		if ( category ) {
			data = self.getData( category.name );

			if ( data ) {
				category = data;

				input.val( category.name );

				if ( options.popover ) {
					self.popover.options.content = $.msg(
						'categoryselect-error-duplicate-category', category.name );

					input.popover( 'show' );
				}

			} else {
				$.when( CategorySelect.getTemplate( 'category' ) ).done(function( template ) {
					var element;

					template.data.category = category;

					// Add the new category to the DOM
					element = $( Mustache.render( template.content, template.data ) ).addClass( 'new' )
						.data( 'category', category )[ self.insertionMethod ]( self.elements.list );

					self.dirty = true;
					self.updateCategories();

					self.trigger( 'add', {
						category: category,
						element: element
					});

					self.trigger( 'update' );
				});

				input.val( '' );

				if ( options.autocomplete ) {
					input.autocomplete( 'close' );
				}

				if ( options.popover ) {
					input.popover( 'hide' );
				}
			}
		}

		return category;
	},

	/**
	 * Edits a category.
	 *
	 * @param { Element | jQuery | Number | String } category
	 *        The index of a category relative to the list of categories, the
	 *        name of a category or the jQuery or DOM Element for a category.
	 */
	editCategory: function( category ) {
		var modal,
			self = this,
			element = self.getCategory( category );

		if ( element.length ) {
			category = element.data( 'category' );

			$.when( CategorySelect.getTemplate( 'categoryEdit' ) ).done(function( template ) {
				template.data.category = category;
				template.data.messages.sortKey = $.msg( 'categoryselect-modal-category-sortkey', category.name );

				modal = $.showCustomModal( cached.messages.categoryEdit, Mustache.render( template.content, template.data ), {
					buttons: [
						{
							id: 'CategorySelectEditModalSave',
							defaultButton: true,
							message: cached.messages.buttonSave,
							handler: function() {
								var error,
									name = modal.find( '[name="categoryName"]' ).val(),
									sortKey = modal.find( '[name="categorySortKey"]' ).val();

								if ( name === '' ) {
									error = cached.messages.errorEmptyCategoryName;

								} else if ( name !== category.name && self.getData( name ) ) {
									error = $.msg( 'categoryselect-error-duplicate-category-name', name );
								}

								if ( error ) {
									modal
										.find( '.categoryName' ).addClass( 'error' )
										.find( '.error-msg' ).text( error );

								} else {
									if ( name !== category.name || sortKey !== category.sortKey ) {
										$.extend( category, {
											name: name,
											sortKey: sortKey
										});

										element
											.data( 'category', category )
											.find( '.name' )
											.text( name );

										self.trigger( 'edit', {
											category: category,
											element: element
										});

										self.trigger( 'update' );
									}

									modal.closeModal();
								}
							}
						}
					],
					id: 'CategorySelectEditModal',
					width: 500
				});
			});
		}
	},

	/**
	 * Gets the data associated with a category, or the data for all categories.
	 *
	 * @param { Element | jQuery | Number | String } [ category ]
	 *        The index of a category relative to the list of categories, the
	 *        name of a category or the jQuery or DOM Element for a category.
	 *
	 * @returns	{ Object }
	 *			The data associated with the category, an array of category data
	 *          for all categories, or undefined if not found.
	 */
	getData: (function() {
		var categories = [];

		return function( category ) {
			var data;

			// Get the data for one category
			if ( category ) {
				return this.getCategory( category ).data( 'category' );
			}

			// Cache is stale, rebuild it
			if ( this.dirty ) {
				data = [];

				this.dirty = false;
				this.updateCategories().each(function() {
					data.push( $( this ).data( 'category' ) );
				});

				categories = data;
			}

			return categories;
		};
	}()),

	/**
	 * Gets a category from the list of categories.
	 *
	 * @param { Element | jQuery | Number | String } category
	 *        The index of a category relative to the list of categories, the
	 *        name of a category or the jQuery or DOM Element for a category.
	 *
	 * @returns	{ jQuery }
	 *			The category, or an empty jQuery object if not found.
	 */
	getCategory: function( category ) {
		var data;

		// By index (relative to other categories)
		if ( !isNaN( parseInt( category, 10 ) ) ) {
			category = this.elements.categories.eq( category );

		// By category name
		} else if ( typeof category === 'string' ) {
			category = this.elements.categories.filter(function() {
				data = $( this ).data( 'category' );
				return data && data.name === category;
			});

		// By jQuery object or DOM Element
		} else {
			category = this.elements.list.find( category );
		}

		return category;
	},

	/**
	 * Removes one or more categories from the list of categories.
	 *
	 * @param { Element | jQuery | Number | String } category
	 *        The index of a category relative to the list of categories, the
	 *        name of a category or the jQuery or DOM Element for a category.
	 *
	 * @returns { Deferred }
	 *          The promise that will be resolved when the categories are
	 *          removed.
	 */
	removeCategory: function( category ) {
		var dfd = $.Deferred(),
			self = this,
			animation = self.options.animations.remove,
			element = self.getCategory( category );

		element
			.animate( animation.properties, animation.options )
			.promise()
			.done(function() {
				dfd.resolve( element.detach() );

				self.dirty = true;
				self.updateCategories();

				self.trigger( 'remove', {
					element: element
				});

				self.trigger( 'update' );
			});

		return dfd.promise();
	},

	/**
	 * Resets categories to what they were on initialization.
	 *
	 * @returns { Deferred }
	 *          The promise that will be resolved when the categories are
	 *          removed.
	 */
	resetCategories: function() {
		return this.removeCategory( this.elements.categories.filter( '.new' ) );
	},

	/**
	 * Triggers an event on the wrapper element. The CategorySelect class is
	 * always passed as the second argument to handlers, further arguments are
	 * optional.
	 *
	 * @param { String } eventType
	 *        The type of event to trigger.
	 *
	 * @returns { Mixed }
	 *          The result returned from the last handler that was triggered.
	 */
	trigger: function( eventType ) {
		var args = [ this ].concat( slice.call( arguments, 1 ) );
		return this.element.triggerHandler( eventType + '.' + namespace, args );
	},

	/**
	 * Updates the cached categories object.
	 *
	 * @returns { jQuery }
	 *          The updated categories object.
	 */
	updateCategories: function() {
		return this.elements.categories = this.elements.list
			.find( this.options.selectors.category );
	}
});

// Public static properties/methods
$.extend( CategorySelect, {

	/**
	 * Throws error messages.
	 *
	 * @param { String } message
	 *        The message to throw.
	 *
	 * @returns { Exception }
	 *          The namespaced exception message.
	 */
	error: function( message ) {
		throw namespace + ': ' + message;
	},

	/**
	 * Gets a mustache template and caches it.
	 *
	 * @param { String } name
	 *        The name of a mustache template. Make sure this name exists in the
	 *        template cache (cached.templates).
	 *
	 * @returns { Deferred }
	 *          The promise that will be resolved with the template object once
	 *          it is loaded.
	 */
	getTemplate: function( name ) {
		var template = cached.templates[ name ];

		if ( !template ) {
			this.error( 'Template "' + name + '" is not defined' );
		}

		return template.content && template || $.Deferred(function( dfd ) {
			Wikia.getMultiTypePackage({
				mustache: 'extensions/wikia/CategorySelect/templates/CategorySelectController_' + name + '.mustache',
				callback: function( pkg ) {
					template.content = pkg.mustache[ 0 ];
					dfd.resolve( template );
				}
			});

			return dfd.promise();
		});
	},

	/**
	 * Gets the categories for a wiki and caches it.
	 *
	 * @returns { Deferred }
	 *          The promise that will be resolved with the categories array once
	 *          it is loaded.
	 */
	getWikiCategories: function() {
		return cached.wikiCategories || $.nirvana.sendRequest({
			controller: 'CategorySelectController',
			method: 'getWikiCategories',
			type: 'GET',
			callback: function( categories ) {
				cached.wikiCategories = categories;
			}
		});
	},

	/**
	 * Normalizes and validates a category object.
	 *
	 * @param { Object | String } category
	 *        The name of a category or an object with category properties.
	 *
	 * @returns { Object }
	 *          The normalized category object or undefined if the category is
	 *          invalid.
	 */
	normalize: (function() {
		var properties = [ 'name', 'namespace', 'sortKey' ],
			rCategory = new RegExp( '\\[\\[' +
				// Category namespace
				'(' + wgCategorySelect.defaultNamespaces + '):' +
				// Category name
				'([^\\]|]+)' +
				// Category sortKey (optional)
				'\\|?([^\\]]+)?' +
			']]', 'i' );

		return function( category ) {
			var pieces, prop,
				base = {
					namespace: wgCategorySelect.defaultNamespace,
					sortKey: wgCategorySelect.defaultSortKey
				};

			if ( typeof category === 'object' ) {
				category = $.extend( base, category );

			} else {
				base.name = category;
				category = base;
			}

			// Must have a name to be valid
			if ( !category.name ) {
				category = undefined;

			} else {

				// Get rid of unecessary properties
				for ( prop in category ) {
					if ( $.inArray( prop, properties ) < 0 ) {
						delete category[ prop ];
					}
				}

				// Extract more information if name is a wikilink
				if ( ( pieces = rCategory.exec( category.name ) ) ) {
					category.namespace = pieces[ 1 ];
					category.name = pieces[ 2 ];

					// SortKey is optional
					if ( pieces[ 3 ] !== undefined ) {
						category.sortKey = pieces[ 3 ];
					}
				}
			}

			return category;
		};
	}()),

	/**
	 * Default options
	 */
	options: {
		animations: {
			remove: {
				options: {
					duration: 0
				},
				properties: {
					opacity: 'hide'
				}
			}
		},
		autocomplete: {
			appendTo: '.CategorySelect',

			// Non-standard
			limit: 10
		},
		categories: [],
		placement: 'top',
		popover: {
			trigger: 'manual'
		},
		selectors: {
			categories: '.categories',
			category: '.category',
			editCategory: '.editCategory',
			input: '.addCategory',
			removeCategory: '.removeCategory'
		},
		sortable: {
			axis: 'y',
			containment: 'parent',
			handle: '.name',
			items: '.category',
			placeholder: 'placeholder',
			tolerance: 'pointer'
		}
	}
});

/**
 * jQuery.fn.categorySelect
 * The bridge between jQuery and the CategorySelect class.
 *
 * @param { Object } options
 *        The settings to configure the instances with.
 */
$.fn.categorySelect = function( options ) {
	options = $.extend( true, {}, CategorySelect.options, options );

	return this.each(function() {
		new CategorySelect( this, options );
	});
};

// Exports
Wikia.CategorySelect = CategorySelect;
window.Wikia = Wikia;

})( window, window.jQuery );
