/* global Mustache:true */
(function( window, $, undefined ) {
	'use strict';

	var cached = {},
		namespace = 'categorySelect',
		properties = [ 'name', 'namespace', 'outertag', 'sortkey', 'type' ],
		slice = Array.prototype.slice,
		wgCategorySelect = window.wgCategorySelect,
		Wikia = window.Wikia || {},
		CategorySelect;

	// Static message cache
	cached.messages = {
		buttonSave: $.msg( 'categoryselect-button-save' ),
		categoryEdit: $.msg( 'categoryselect-category-edit' ),
		errorCategoryNameLength: $.msg( 'categoryselect-error-category-name-length' ),
		errorEmptyCategoryName: $.msg( 'categoryselect-error-empty-category-name' ),
		tooltipAdd: $.msg( 'categoryselect-tooltip-add' )
	};

	// Static template cache
	cached.templates = {
		category: {
			data: {
				blankImageUrl: window.wgBlankImgUrl,
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

	// Safely decode HTML entities.
	// TODO: move this somewhere else?
	function decodeHtmlEntities( str ) {
		var textarea = document.createElement( 'textarea' );
		textarea.innerHTML = str;
		return textarea.value;
	}

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
	CategorySelect = function( element, options ) {
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

		self.elements = elements;

		// Attach listeners
		element
			.on( 'click.' + namespace, options.selectors.editCategory, function( event ) {
				CategorySelect.track({
					label: 'button-edit'
				});

				self.editCategory( $( event.currentTarget ).closest( options.selectors.category ) );
			})
			.on( 'click.' + namespace, options.selectors.removeCategory, function( event ) {
				CategorySelect.track({
					label: 'button-remove'
				});

				self.removeCategory( $( event.currentTarget ).closest( options.selectors.category ) );
			})
			.on( 'reset.' + namespace, $.proxy( self.resetCategories, self ) );

		// Handle keypresses on the input element
		elements.input = element.find( options.selectors.input )
			.attr( 'maxlength', options.maxLength )
			.on( 'keydown.' + namespace + ' paste.' + namespace, function( event ) {
				var value = elements.input.val();

				// Enter or Return key
				if ( event.which === 13 ) {
					event.preventDefault();
					self.addCategory( value );

				// Enforce maxLength
				} else if ( options.maxLength ) {

					// Defer processing so we can catch pasted values
					setTimeout(function() {
						value = elements.input.val();

						if ( value.length >= options.maxLength ) {
							elements.input.val( value.substr( 0, options.maxLength ) );

							if ( options.popover ) {
								$.extend( self.popover.options, {
									content: cached.messages.errorCategoryNameLength,
									placement: 'right',
									type: 'error'
								});

								elements.input.popover( 'show' );
							}
						}
					}, 0 );
				}
			});

		elements.list = element.find( options.selectors.categories );
		elements.categories = elements.list.find( options.selectors.category );

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

			if ( options.popover.hint ) {
				elements.input
					.on( 'focus.' + namespace + ' keyup.' + namespace, function() {
						if ( elements.input.val() === '' ) {
							$.extend( self.popover.options, {
								content: cached.messages.tooltipAdd,
								placement: 'bottom',
								type: 'add'
							});

							elements.input.popover( 'show' );

						// Only hide popovers of the same type
						} else if ( self.popover.options.type === 'add' ) {
							elements.input.popover( 'hide' );
						}
					})
					.trigger( 'focus' );
			}
		}

		if ( typeof options.sortable === 'object' ) {
			elements.sortable = $( options.selectors.sortable || elements.list )
				.sortable( $.extend( options.sortable, {
					update: function( event, ui ) {
						self.dirty = true;

						CategorySelect.track({
							label: 'sort'
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
			var existing,
				self = this,
				input = self.elements.input,
				options = self.options;

			category = CategorySelect.normalize( category );

			if ( category ) {
				existing = self.getDatum( category.name );

				// Category already exists
				if ( existing !== undefined ) {
					input.val( existing.name );

					if ( options.popover ) {
						$.extend( self.popover.options, {
							content: $.msg( 'categoryselect-error-duplicate-category-name', existing.name ),
							placement: 'top',
							type: 'error'
						});

						input.popover( 'show' );
					}

				} else {
					$.when( CategorySelect.getTemplate( 'category' ) ).done(function( template ) {
						var data = $.extend( {}, template.data, category ),
							element = $( Mustache.render( template.content, data ) );

						element
							.addClass( 'new' )
							.data( category );

						self.dirty = true;

						self.trigger( 'add', {
							category: category,
							element: element
						});

						CategorySelect.track({
							action: Wikia.Tracker.ACTIONS.ADD,
							label: 'new-category'
						});

						self.trigger( 'update' );
					});

					if ( options.autocomplete ) {
						input.autocomplete( 'close' );
					}

					if ( options.popover ) {
						input.popover( 'hide' );
					}

					input.val( '' );
				}
			}

			return category;
		},

		/**
		 * Edit an existing category.
		 *
		 * @param { Element | jQuery | Number | String } category
		 *        The index of a category relative to the list of categories, the
		 *        name of a category or the jQuery or DOM Element for a category.
		 */
		editCategory: function( category ) {
			var self = this,
				element = self.getCategory( category );

			category = element && self.getDatum( element );

			if ( category !== undefined ) {
				$.when( CategorySelect.getTemplate( 'categoryEdit' ) ).done(function( template ) {
					var data = $.extend( true, {}, template.data, category, {
						messages: {
							sortKey: $.msg( 'categoryselect-modal-category-sortkey', category.name )
						}
					});

					require( [ 'wikia.ui.factory' ], function( uiFactory ) {
						uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
							var categoryEditModalConfig = {
								vars: {
									id: 'categorySelectEditModal',
									size: 'small',
									content: Mustache.render( template.content, data ),
									title: cached.messages.categoryEdit,
									buttons: [
										{
											vars: {
												value: cached.messages.buttonSave,
												classes: [ 'normal', 'primary' ],
												data: [
													{
														key: 'event',
														value: 'save'
													}
												]
											}
										}
									]
								}
							};

							uiModal.createComponent( categoryEditModalConfig, function( categoryEditModal ) {
								categoryEditModal.bind( 'save', function() {

									var error,
										name = categoryEditModal.$content.find( '[name="categoryName"]' ).val(),
										sortKey = categoryEditModal.$content.find( '[name="categorySortKey"]' ).val();

									if ( name === '' ) {
										error = cached.messages.errorEmptyCategoryName;

									} else if ( name !== category.name && self.getDatum( name ) ) {
										error = $.msg( 'categoryselect-error-duplicate-category-name', name );
									}

									if ( error ) {
										categoryEditModal.$content
											.find( '.categoryName' ).addClass( 'error' )
											.find( '.error-msg' ).text( error );

									} else {
										if ( name !== category.name || sortKey !== category.sortkey ) {
											$.extend( category, {
												name: name,
												sortkey: sortKey
											});

											element
												.data( category )
												.find( '.name' )
												.text( name );

											self.trigger( 'edit', {
												category: category,
												element: element
											});

											CategorySelect.track({
												label: 'button-edit-save'
											});

											self.trigger( 'update' );
										}
										categoryEditModal.trigger( 'close' );
									}
								});

								categoryEditModal.bind( 'close', function( event ) {
									if ( typeof event !== 'undefined' ) {
										CategorySelect.track({
											label: 'button-edit-close'
										});
									}
								});

								categoryEditModal.show();
							});
						});
					});
				});
			}
		},

		/**
		 * Gets the data associated with categories.
		 *
		 * @param { Element | jQuery | Number | String } filter
		 *        The index of a category relative to the list of categories, the
		 *        name of a category, a selector string or the jQuery object or
		 *        DOM Element for a category.
		 *
		 * @returns	{ Array }
		 *          An array of data associated with the categories.
		 */
		getData: function( filter ) {
			var data = [];

			this.getCategories( filter ).each(function() {
				data.push( CategorySelect.normalize( $( this ).data() ) );
			});

			return data;
		},

		/**
		 * Gets the data associated with a single category.
		 *
		 * @param { Element | jQuery | Number | String } filter
		 *        The index of a category relative to the list of categories, a
		 *        selector string or the jQuery object or DOM Element for a category.
		 *
		 * @returns	{ Object }
		 *          The data associated with the category or undefined if not found.
		 */
		getDatum: function( filter ) {
			return this.getData( filter )[ 0 ];
		},

		/**
		 * Gets categories from the list of categories.
		 *
		 * @param { Element | jQuery | Number | String } filter
		 *        The index of a category relative to the list of categories, the
		 *        name of a category, a selector string or the jQuery object or
		 *        DOM Element for a category.
		 *
		 * @returns	{ jQuery }
		 *          The categories, or an empty jQuery object if not found.
		 */
		getCategories: function( filter ) {
			var categories = this.elements.categories;

			// Rebuild categories cache if it has been modified
			if ( this.dirty ) {
				categories = this.elements.categories =
					this.elements.list.find( this.options.selectors.category );
			}

			return filter !== undefined ?
				( typeof filter === 'number' ?
					// By category index (relative to other categories)
					categories.eq( filter ) :
					// By category name, selector string, jQuery object or DOM Element
					categories.filter(function() {
						var $category = $( this ),
							category = CategorySelect.normalize( $category.data() ),
							match = category.name === decodeHtmlEntities( filter );

						// Try to match a selector string, jQuery object or DOM Element
						if ( !match ) {

							// Sizzle can throw a syntax error here if filter is an invalid expression
							try {
								match = $category.is( filter );

							} catch( e ) {}
						}

						return match;
					})
				) : categories;
		},

		/**
		 * Gets a category from the list of categories.
		 *
		 * @param { Element | jQuery | Number | String } filter
		 *        The index of a category relative to the list of categories, a
		 *        selector string or the jQuery object or DOM Element for a category.
		 *
		 * @returns	{ jQuery }
		 *          The categories, or an empty jQuery object if not found.
		 */
		getCategory: function( filter ) {
			return this.getCategories( filter ).eq( 0 );
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
			return this.removeCategory( this.getCategories( '.new' ) );
		},

		/**
		 * Associates category data with DOM elements.
		 *
		 * @param { Element | jQuery | Number | String } filter
		 *        The index of a category relative to the list of categories, the
		 *        name of a category or the jQuery or DOM Element for a category.
		 *
		 * @param { Object } data
		 *        The data associated with a category.
		 */
		setData: function( filter, data ) {
			return this.getCategories( filter ).data( data );
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
			return this.element.triggerHandler( eventType, args );
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
					mustache: 'extensions/wikia/CategorySelect/templates/CategorySelect_' + name + '.mustache',
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
			var rCategory = new RegExp( '\\[\\[' +
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
						namespace: wgCategorySelect.defaultNamespace
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
					category.name = $.trim( decodeHtmlEntities( category.name ) );

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
							category.sortkey = pieces[ 3 ];
						}
					}

					// Uppercase the first letter in name to match MediaWiki article titles
					category.name = category.name[ 0 ].toUpperCase() + category.name.slice( 1 );
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
				appendTo: '.article-categories, .CategorySelect',
				// Non-standard
				limit: 6
			},

			// Based on Title max length
			maxLength: 255,
			popover: {
				trigger: 'manual',

				// Non-standard
				// Set to true to enable the category add tooltip
				hint: false
			},
			selectors: {
				categories: '.categories',
				category: '.category',
				editCategory: '.editCategory',
				input: '.input',
				removeCategory: '.removeCategory',

				// Uses options.selectors.categories by default
				sortable: undefined
			},
			sortable: {
				appendTo: 'parent',
				axis: 'y',
				containment: 'parent',
				forcePlaceholderSize: true,
				handle: '.name',
				items: '.category',
				placeholder: 'placeholder',
				tolerance: 'pointer'
			}
		},

		track: Wikia.Tracker.buildTrackingFunction( Wikia.trackEditorComponent, {
			action: Wikia.Tracker.ACTIONS.CLICK,
			category: 'category-tool',
			trackingMethod: 'analytics'
		})
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
