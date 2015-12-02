/* global define */
define('wikia.toolsCustomization', [
	'wikia.window',
	'wikia.browserDetect',
	'jquery',
	'wikia.ui.factory',
	'mw',
	'BannerNotification'
], function(win, browserDetect, $, uiFactory, mw, BannerNotification) {
	'use strict';

		win.ToolbarCustomize = win.ToolbarCustomize || {};

		var TC = win.ToolbarCustomize,
			isIPad = false,
			wgBlankImgUrl = win.wgBlankImgUrl,
			bannerNotification = new BannerNotification().setType('error');

			isIPad = browserDetect.isIPad();

		TC.OptionsTree = $.createClass( win.Observable, {

			constructor: function( el ) {
				TC.OptionsTree.superclass.constructor.call( this );
				this.el = el;

				if ( !isIPad ) {
					this.el.sortable( {
						axis: 'y',
						handle: '.drag',
						opacity: 0.8,
						update: $.proxy( this.updateLevels, this )
					} );
				}
			},

			/* assumes one my tools menu */
			updateLevels: function() {
				var $all = this.el.children( 'li' ),
					level = 0,
					$ind;

				$all.removeClass( 'list-item-indent-1' );

				$all.each( function( index, element ) {
					if ( $( element ).hasClass( 'list-item-menu' ) ) {
						level++;
					} else if ( level > 0 ) {
						$( element ).addClass( 'list-item-indent-' + level );
					}
				} );

				this.el.find( '.tree-visual' ).remove();
				$ind = this.el.children( 'li.list-item-indent-1' );
				$ind.prepend( '<span class="tree-visual tree-line"></span><span class="tree-visual tree-dash"></span>' );
				$ind.last().find( '.tree-visual' ).remove();
				$ind.last().prepend(
					'<span class="tree-visual tree-line-last"></span><span class="tree-visual tree-dash"></span>'
				);

				this.fire( 'update', this );
			},

			buildItem: function( item, level ) {
				var type = ( item.id.substr( 0, 5 ) === 'Menu:' ) ? 'menu' : 'item',
					cl = level ? 'list-item-indent-' + level : '',
					html,
					itemEl;

				if ( type === 'menu' ) {
					cl += ' list-item-menu';
				}
				html = '<li' +
					' data-tool-id="' + $.htmlentities( item.id ) + '"' +
					' data-default-caption="' + $.htmlentities( item.defaultCaption ) + '"' +
					' data-caption="' + $.htmlentities( item.caption ) + '"' +
					( cl ? ' class="' + cl + '"' : '' ) + '>';
				if ( type === 'menu' ) {
					html += '<img src="' + wgBlankImgUrl + '" class="folder-icon" height="16" width="16" />';
				}
				html += '<span class="name">' + $.htmlentities( item.caption ) + '</span>';
				if ( type === 'item' ) {
					html += this.addIcons();
				}
				html += '</li>';

				itemEl = $( html );
				this.fire( 'itembuild', this, item, itemEl );
				return itemEl;
			},

			addIcons: function() {
				var html = [
					'<img src="' + wgBlankImgUrl + '" class="sprite edit-pencil">',
					'<img src="' + wgBlankImgUrl + '" class="sprite trash">'
				];

				if ( !isIPad ) {
					html.push( '<img src="' + wgBlankImgUrl + '" class="sprite drag">' );
				}

				return html.join( '' );
			},

			loadLevel: function( els, level ) {
				var i;
				for ( i = 0; i < els.length; i++ ) {
					this.el.append( this.buildItem( els[i], level ) );
					if ( els[i].items ) {
						this.loadLevel( els[i].items, level + 1 );
					}
				}
			},

			load: function( data ) {
				this.el.empty();
				this.loadLevel( data, 0 );
				this.updateLevels();
			},

			save: function() {
				var $all = this.el.children( 'li' ),
					stack = [
						[]
					],
					level = 0;
				$all.each( function( index, element ) {
					element = $( element );
					var o = {
						id: element.attr( 'data-tool-id' ),
						defaultCaption: element.attr( 'data-default-caption' ),
						caption: element.attr( 'data-caption' )
					};
					stack[level].push( o );
					if ( element.hasClass( 'list-item-menu' ) ) {
						level = 1;
						o.items = [];
						o.isMenu = true;
						stack[level] = o.items;
					}
				} );
				return stack[0];
			},

			update: function() {
				this.updateLevels();
			},

			add: function( item, level ) {
				// add to my tools
				var itemEl = this.buildItem( item, level || 0 ),
					$mytools;
				if ( level === 0 ) {
					$mytools = this.el.children( '.list-item-menu' );
					if ( $mytools ) {
						$mytools.before( itemEl );
					} else {
						this.el.append( itemEl );
					}
				} else {
					this.el.append( itemEl );
				}
				this.scrollToItem( itemEl );
				this.updateLevels();
			},

			scrollToItem: function( itemEl ) {
				var scroll = this.el.scrollTop(),
					delta = itemEl.offset().top - this.el.offset().top,
					max = this.el.innerHeight() - itemEl.outerHeight(),
					move = 0;
				if ( delta > max ) {
					move = delta - max;
				}
				if ( delta < 0 ) {
					move = delta;
				}
				if ( move !== 0 ) {
					this.el.scrollTop( scroll + move );
				}
			}
		} );

		TC.OptionLinks = $.createClass( win.Observable, {

			constructor: function( el ) {
				TC.OptionLinks.superclass.constructor.call( this );
				this.el = el;
			},

			onItemClick: function( event ) {
				event.preventDefault();
				this.fire( 'itemclick', this, $( event.target ).attr( 'data-tool-id' ) );
				return false;
			},

			buildItem: function( item ) {
				var html =
						'<li>' +
							'<a href="#" data-tool-id="' + $.htmlentities( item.id ) + '">' +
							$.htmlentities( item.defaultCaption ) +
							'</a></li>',
					itemEl = $( html );

				itemEl.find( 'a' ).click( $.proxy( this.onItemClick, this ) );
				return itemEl;
			},

			load: function( els ) {
				var i;
				this.el.empty();
				for ( i = 0; i < els.length; i++ ) {
					this.el.append( this.buildItem( els[i] ) );
				}
			}
		} );

		TC.Toggle = $.createClass( Object, {
			constructor: function( target, buttons, cls ) {
				this.target = target;
				this.buttons = buttons;
				this.cls = cls;
				this.state = false;

				this.hide();
				this.buttons.bind( 'click.toggle', $.proxy( this.toggle, this ) );
			},

			hide: function() {
				this.target.hide();
				this.buttons.hide();
				this.buttons.filter( '.' + this.cls ).show();
			},

			show: function() {
				this.target.show();
				this.buttons.hide();
				this.buttons.not( '.' + this.cls ).show();
			},

			toggle: function( event ) {
				if ( $( event.currentTarget ).hasClass( this.cls ) ) {
					this.show();
				} else {
					this.hide();
				}
			}
		} );

		TC.Configuration = $.createClass( Object, {

			toolbar: false,
			data: false,

			w: false,
			tree: false,
			popular: false,
			toggle: false,

			constructor: function( toolbar ) {
				TC.Configuration.superclass.constructor.call( this );
				this.toolbar = toolbar;
			},

			show: function() {
				// load CSS, JS libraries and make AJAX request in one request
				$.when(
						$.loadJQueryAutocomplete(),
						$.loadJQueryUI(),
						$.getResources( [
							$.getSassCommonURL(
								'extensions/wikia/UserTools/styles/UserTools.scss'
							)
						] ),
						$.nirvana.sendRequest( {
							controller: 'UserTools',
							method: 'ToolbarConfiguration',
							callback: $.proxy( this.onDataLoaded, this )
						} )
					).
					done( $.proxy( this.checkLoad, this ) ).
					fail( $.proxy( this.onLoadFailure, this ) );
			},

			onDataLoaded: function( data ) {
				this.data = data;
			},

			onLoadFailure: function( req, textStatus, errorThrown ) {
				bannerNotification.setContent(errorThrown).show();
			},

			checkLoad: function() {
				var self = this;
					uiFactory.init( ['modal'] ).then( function( uiModal ) {
						var messages = self.data.messages,
							toolsConfigurationConfig = {
								vars: {
									id: 'MyToolsConfigurationWrapper',
									size: 'small',
									content: self.data.configurationHtml,
									title: messages['user-tools-edit-title'],
									buttons: [
										{
											vars: {
												value: messages['user-tools-edit-save'],
												classes: ['button', 'primary'],
												data: [
													{
														key: 'event',
														value: 'save'
													}
												]
											}
										},
										{
											vars: {
												value: messages['user-tools-edit-cancel'],
												data: [
													{
														key: 'event',
														value: 'close'
													}
												]
											}
										}
									]
								}
							};
						uiModal.createComponent( toolsConfigurationConfig, function( toolsConfigModal ) {
							self.w = toolsConfigModal.$content;
							self.modal = toolsConfigModal;

							var $optionList = self.w.find( '.options-list' ),
								$group = self.w.find( '.popular-tools-group'),
								$searchInput = self.w.find( '.search' );

							// Toolbar list

							self.tree = new TC.OptionsTree( $optionList );

							// temporary fix drag and drop issues on iPad
							// TODO: drag and drop functionality should be refactored when replacing this modal
							if ( isIPad ) {
								$optionList.addClass( 'on-ipad' );
							} else {
								$optionList.addClass( 'no-ipad' );
							}
							self.tree.on( 'itembuild', $.proxy( self.initItem, self ) );
							self.tree.load( self.data.options );
							self.w.find( '.reset-defaults a' ).click( $.proxy( self.loadDefaults, self ) );

							// Find a tool
							$searchInput.placeholder();
							$searchInput.pluginAutocomplete( {
								lookup: self.getAutocompleteData(),
								onSelect: $.proxy( self.addItemFromSearch, self ),
								selectedClass: 'selected',
								appendTo: self.w.find( '.search-box' ),
								width: '300px',
								maxHeight: 'auto'
							} );
							self.w.find( '.advanced-tools a' ).attr( 'target', '_blank' );

							// Popular tools
							self.popular = new TC.OptionLinks( self.w.find( '.popular-list' ) );
							self.popular.load( self.data.popularOptions );
							self.popular.on( 'itemclick', $.proxy( self.addPopularOption, self ) );

							self.toggle = new TC.Toggle( $group.children( '.popular-list' ),
								$group.children( '.popular-toggle' ), 'toggle-1' );

							self.w.find( '.popular-toggle' ).click( $.proxy( self.togglePopular, self ) );

							toolsConfigModal.bind( 'save', function( event ) {
								event.preventDefault();
								toolsConfigModal.deactivate();
								self.save( toolsConfigModal );
							} );

							toolsConfigModal.show();
						} );
					} );
			},

			getAutocompleteData: function() {
				var suggestions = [],
					data = [],
					length = this.data.allOptions.length,
					i;
				for ( i = 0; i < length; i++ ) {
					suggestions.push( this.data.allOptions[i].caption );
					data.push( this.data.allOptions[i].id );
				}
				return {
					suggestions: suggestions,
					data: data
				};
			},

			findOptionByName: function( id ) {
				var length = this.data.allOptions.length,
					i;
				for ( i = 0; i < length; i++ ) {
					if ( this.data.allOptions[i].id === id ) {
						return this.data.allOptions[i];
					}
				}
				return false;
			},

			findOptionByCaption: function( caption ) {
				var length = this.data.allOptions.length,
					i;
				for ( i = 0; i < length; i++ ) {
					if ( this.data.allOptions[i].caption === caption ) {
						return this.data.allOptions[i];
					}
				}
				return false;
			},

			addItemFromSearch: function( value, data ) {
				var item = this.findOptionByName( data );
				if ( item ) {
					this.tree.add( item, 0 );
				}
				this.w.find( '.search' ).val( '' );
			},

			addPopularOption: function( popular, id ) {
				var item = this.findOptionByName( id );
				if ( item ) {
					this.tree.add( item, 0 );
				}
				return false;
			},

			loadDefaults: function() {
				this.tree.load( this.data.defaultOptions );
				return false;
			},

			initItem: function( tree, item, el ) {
				// add highlighting on iPad
				if ( isIPad ) {
					el.click( function( event ) {
						tree.el.children().removeClass( 'hover' );
						$( event.currentTarget ).addClass( 'hover' );
					} );
				}
				el.find( '.edit-pencil' ).click( $.proxy( this.renameItem, this ) );
				el.find( '.trash' ).click( $.proxy( this.deleteItem, this ) );
			},

			renameItem: function( event ) {
				var self = this,
					$item = $( event.currentTarget ).closest( 'li' );

				event.preventDefault();

					uiFactory.init( ['modal'] ).then( function( uiModal ) {
						var messages = self.data.messages,
							renameItemConfig = {
								vars: {
									id: 'MyToolsRenameItem',
									size: 'small',
									content: self.data.renameItemHtml,
									title: messages['user-tools-edit-rename'],
									buttons: [
										{
											vars: {
												value: messages['user-tools-edit-save'],
												classes: ['button', 'primary'],
												data: [
													{
														key: 'event',
														value: 'save'
													}
												]
											}
										},
										{
											vars: {
												value: messages['user-tools-edit-cancel'],
												data: [
													{
														key: 'event',
														value: 'close'
													}
												]
											}
										}
									]
								}
							};

						uiModal.createComponent( renameItemConfig, function( renameItemModal ) {
							var $inputBox = renameItemModal.$content.find( '.input-box' );

							$inputBox.val( $item.data( 'caption' ) );

							renameItemModal.bind( 'save', function( event ) {
								event.preventDefault();
								var value = $inputBox.val();
								$item.attr( 'data-caption', value );
								$item.find( '.name' ).text( value );
								renameItemModal.trigger( 'close' );
							} );

							renameItemModal.show();
						} );
					} );
				return false;
			},

			deleteItem: function( event ) {
				$( event.currentTarget ).closest( 'li' ).remove();
				this.tree.update();
				return false;
			},

			save: function( toolsConfigModal ) {
				var toolbar = this.tree.save();
				$.nirvana.sendRequest( {
					controller: 'UserTools',
					method: 'ToolbarSave',
					data: {
						title: win.wgPageName,
						toolbar: toolbar,
						token: mw.user.tokens.get('editToken')
					},
					callback: $.proxy( function( data, status ) {
						this.afterSave( toolsConfigModal, data, status );
					}, this )
				} );
			},

			afterSave: function( toolsConfigModal, data, status ) {
				toolsConfigModal.activate();
				if ( status === 'success' ) {
					$('body').trigger('userToolsItemAdded', [data.toolbar]);
					this.modal.trigger( 'close' );
				} else {
					bannerNotification.setContent(status).show();
				}
			}

		} );

		win.ToolbarCustomize = TC;

	return {
		ToolsCustomization: TC.Configuration
	};

});
