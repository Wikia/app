/**
 * The Core timed Text interface object
 *
 * handles class mappings for:
 * 	menu display ( jquery.ui themeable )
 * 	timed text loading request
 *  timed text edit requests
 * 	timed text search & seek interface ( version 2 )
 *
 * @author: Michael Dale
 *
 */
( function( mw, $ ) {

	// Merge in timed text related attributes:
	mw.mergeConfig( 'EmbedPlayer.SourceAttributes', [
  	   'srclang',
  	   'kind',
	   'label'
	]);
	
	/**
	 * Timed Text Object
	 * @param embedPlayer Host player for timedText interfaces
	 */
	mw.TimedText = function( embedPlayer, options ) {
		return this.init( embedPlayer, options);
	};
	
	mw.TimedText.prototype = {

		/**
		* Preferences config order is presently:
		* 1) user cookie
		* 2) defaults provided in this config var:
		*/
		config: {
			// Layout for basic "timedText" type can be 'ontop', 'off', 'below'
			'layout' : 'ontop',

			//Set the default local ( should be grabbed from the browser )
			'userLanguage' : 'en',

			//Set the default kind of timedText to display ( un-categorized timed-text is by default "subtitles" )
			'userKind' : 'subtitles'
		},
		// The bind prefix:
		bindPostFix: '.timedText',
		
		// Default options are empty
		options: {},
		
		/**
		 * The list of enabled sources
		 */
		enabledSources: [],

		/**
		 * The current language key
		 */
		currentLangKey : null,

		/**
		 * Stores the last text string per kind to avoid dom checks
		 * for updated text
		 */
		prevText: [],

		/**
		* Text sources ( a set of textSource objects )
		*/
		textSources: null,

		/**
		* Valid "Track" categories
		*/
		validCategoriesKeys: [
			"CC",
			"SUB",
			"TAD",
			"KTV",
			"TIK",
			"AR",
			"NB",
			"META",
			"TRX",
			"LRC",
			"LIN",
			"CUE"
		],

		/**
		 * @constructor
		 * @param {Object} embedPlayer Host player for timedText interfaces
		 */
		init: function( embedPlayer, options ) {
			var _this = this;
			mw.log("TimedText: init() ");
			this.embedPlayer = embedPlayer;	
			if( options ){
				this.options = options;
			}
			// Load user preferences config:
			var preferenceConfig = $.cookie( 'TimedText.Preferences' );
			if( preferenceConfig !== "false" && preferenceConfig != null ) {
				this.config = JSON.parse(  preferenceConfig );
			}
			// remove any old bindings on change media: 
			$( this.embedPlayer ).bind('onChangeMedia', function(){
				_this.destroy();
			});
			// Remove any old bindings before we add the current bindings: 
			_this.destroy();
			// Add player bindings
			this.addPlayerBindings();
		},
		destroy:function(){
			// remove any old player bindings; 
			$( this.embedPlayer ).unbind( this.bindPostFix );
		},
		/**
		 * Add timed text related player bindings
		 * @return
		 */
		addPlayerBindings: function(){
			var _this = this;
			var embedPlayer = this.embedPlayer;
			
			// Check for timed text support:
			$( embedPlayer ).bind( 'addControlBarComponent' + this.bindPostFix, function(event, controlBar ){
				if( embedPlayer.hasTextTracks() ){
					controlBar.supportedComponents['timedText'] = true;
					controlBar.components['timedText'] = _this.getTimedTextButton();					
				}
			});
			
			$( embedPlayer ).bind( 'monitorEvent'+ this.bindPostFix, function() {
				_this.monitor();
			} );

			$( embedPlayer ).bind( 'onplay'+ this.bindPostFix, function() {
				// Will load and setup timedText sources (if not loaded already loaded )
				_this.setupTextSources();
				// Hide the caption menu if presently displayed
				$( '#textMenuContainer_' + embedPlayer.id ).parent().remove();
			} );
			
			// Resize the timed text font size per window width
			$( embedPlayer ).bind( 'onCloseFullScreen'+ this.bindPostFix + ' onOpenFullScreen'+ this.bindPostFix, function() {
				// Check if we are in fullscreen or not, if so add an additional bottom offset of 
				// double the default bottom padding. 
				var textOffset = _this.embedPlayer.controlBuilder.fullscreenMode ? 
						mw.getConfig("TimedText.BottomPadding") *2 : 
						mw.getConfig("TimedText.BottomPadding");
						
				var textCss = _this.getInterfaceSizeTextCss({
					'width' :  embedPlayer.$interface.width(),
					'height' : embedPlayer.$interface.height()
				});
				
				mw.log( 'TimedText::set text size for: : ' + embedPlayer.$interface.width() + ' = ' + textCss['font-size'] );
				
				embedPlayer.$interface.find( '.track' )
				.css( textCss )
				.css({
					// Get the text size scale then set it to control bar height + TimedText.BottomPadding; 
					'bottom': ( _this.embedPlayer.controlBuilder.getHeight() + textOffset ) + 'px'
				});
			});
			
			// Update the timed text size
			$( embedPlayer ).bind( 'onResizePlayer'+ this.bindPostFix, function(event, size, animate) {
				// If the the player resize action is an animation, animate text resize, 
				// else instantly adjust the css. 
				var textCss = _this.getInterfaceSizeTextCss( size );
				mw.log( 'TimedText::onResizePlayer: ' + textCss['font-size']);
				if ( animate ) {
					embedPlayer.$interface.find( '.track' ).animate( textCss);
				} else {
					embedPlayer.$interface.find( '.track' ).css( textCss );
				}
			});

			// Setup display binding
			$( embedPlayer ).bind( 'onShowControlBar'+ this.bindPostFix, function(event, layout ){
				// Move the text track if present
				embedPlayer.$interface.find( '.track' )
				.stop()
				.animate( layout, 'fast' );
			});
			
			$( embedPlayer ).bind( 'onHideControlBar'+ this.bindPostFix, function(event, layout ){
				// Move the text track down if present
				embedPlayer.$interface.find( '.track' )
				.stop()
				.animate( layout, 'fast' );
			});
		},

		/**
		 * Get the current language key
		 * @return 
		 * @type {string}
		 */
		getCurrentLangKey: function(){
			return this.currentLangKey;
		},
		
		/**
		 * The timed text button to be added to the interface
		 */
		getTimedTextButton: function(){
			var _this = this;
			/**
			* The closed captions button
			*/
			return {
				'w': 28,
				'o': function( ctrlObj ) {
					var $textButton = $( '<div />' )
						.attr( 'title', gM( 'mwe-embedplayer-timed_text' ) )
						.addClass( "ui-state-default ui-corner-all ui-icon_link rButton timed-text" )
						.append(
							$( '<span />' )
							.addClass( "ui-icon ui-icon-comment" )
						)
						// Captions binding:
						.buttonHover();
					_this.bindTextButton( $textButton );
					return $textButton;
						
				}
			};
		},
		
		bindTextButton: function($textButton){
			var _this = this;
			$textButton.unbind('click.textMenu').bind('click.textMenu', function() {
				_this.showTextMenu();
			} );
		},
		
		/**
		* Get the fullscreen text css
		*/
		getInterfaceSizeTextCss: function( size ) {			
			//mw.log(' win size is: ' + $( window ).width() + ' ts: ' + textSize );
			return {
				'font-size' : this.getInterfaceSizePercent( size ) + '%'
			};
		},
		
		/**
		* Show the text interface library and show the text interface near the player.
		*/
		showTextMenu: function() {
			var embedPlayer = this.embedPlayer;
			var loc = embedPlayer.$interface.find( '.rButton.timed-text' ).offset();
			mw.log('showTextInterface::' + embedPlayer.id + ' t' + loc.top + ' r' + loc.right);

			var $menu = $( '#timedTextMenu_' + embedPlayer.id );
			if ( $menu.length != 0 ) {
				// Hide show the menu:
				if( $menu.is( ':visible' ) ) {
					$menu.hide( "fast" );
				}else{
					// move the menu to proper location
					$menu.show("fast");
				}
			}else{				
				// Bind the text menu:
				this.bindMenu( true );
			}
		},
		getTextMenuContainer: function(){
			var textMenuId = 'textMenuContainer_' + this.embedPlayer.id;
			if( !$( '#' + textMenuId ).length ){
				//Setup the menu:
				$('body').append(
					$('<div>')
						.addClass('ui-widget ui-widget-content ui-corner-all')
						.attr( 'id', textMenuId )
						.css( {
							'position' 	: 'absolute',
							'z-index' 	: 10,
							'height'	: '180px',
							'width' 	: '180px',
							'font-size'	: '12px',
							'display' : 'none'
						} )
	
				);
			}
			return $( '#' + textMenuId );
		},
		/**
		 * Gets a text size percent relative to about 30 columns of text for 400 
		 * pixel wide player, at 100% text size.  
		 * 
		 * @param size {object} The size of the target player area width and height
		 */
		getInterfaceSizePercent: function( size ) {
			var textSize = size.width / 4;
			if( textSize < 95 ){
				textSize = 95;
			}
			if( textSize > 200 ){
				textSize = 200;
			}
			return textSize;
		},

		/**
		* Setups available text sources
		*   loads text sources
		* 	auto-selects a source based on the user language
		* @param {Function} callback Function to be called once text sources are setup.
		*/
		setupTextSources: function( callback ) {
			mw.log( 'mw.TimedText::setupTextSources');
			var _this = this;
			// Load textSources
			_this.loadTextSources( function() {
				// Enable a default source and issue a request to "load it"
				_this.autoSelectSource();

				// Load and parse the text value of enabled text sources:
				_this.loadEnabledSources();

				if( callback ) {
					callback();
				}
			} );
		},

		/**
		* Binds the timed text menu
		* and updates its content from "getMainMenu"
		*
		* @param {Object} target to display the menu
		* @param {Boolean} autoShow If the menu should be displayed
		*/
		bindMenu: function( autoShow) {
			var _this = this;
			var $menuButton = this.embedPlayer.$interface.find( '.timed-text' );

			var positionOpts = { };
			if( this.embedPlayer.supports[ 'overlays' ] ){
				positionOpts = {
					'directionV' : 'up',
					'offsetY' : this.embedPlayer.controlBuilder.getHeight(),
					'directionH' : 'left',
					'offsetX' : -28
				};
			}

			// Else bind and show the menu
			// We already have a loader in embedPlayer so the delay of
			// setupTextSources is already taken into account
			_this.setupTextSources( function() {
				// NOTE: Button target should be an option or config
				$menuButton.unbind().menu( {
					'content'	: _this.getMainMenu(),
					'zindex' : mw.getConfig( 'EmbedPlayer.FullScreenZIndex' ) + 2,
					'crumbDefaultText' : ' ',
					'autoShow': autoShow,
					'targetMenuContainer' : _this.getTextMenuContainer(),
					'positionOpts' : positionOpts,
					'backLinkText' : gM( 'mwe-timedtext-back-btn' ),
					'createMenuCallback' : function(){
						_this.embedPlayer.controlBuilder.showControlBar( true );
					},
					'closeMenuCallback' : function(){
						_this.embedPlayer.controlBuilder.keepControlBarOnScreen = false;
					}
				} );
			});
		},

		/**
		* Monitor video time and update timed text filed[s]
		*/
		monitor: function( ) {
			//mw.log(" timed Text monitor: " + this.enabledSources.length );
			var embedPlayer = this.embedPlayer;
			// Setup local reference to currentTime:
			var currentTime = embedPlayer.currentTime;

			// Get the text per kind
			var textCategories = [ ];

			for( var i = 0; i < this.enabledSources.length ; i++ ) {
				var source = this.enabledSources[ i ];
				if( source ) {
					this.updateSourceDisplay( source, currentTime );
				}
			}
		},

		/**
		 * Load all the available text sources from the inline embed
		 * @param {Function} callback Function to call once text sources are loaded
		 */
		loadTextSources: function( callback ) {
			var _this = this;
			// check if text sources are already loaded ( not null )
			if( this.textSources !== null ){
				callback( this.textSources );
				return ;
			}
			this.textSources = [];
			// load inline text sources:
			$.each( this.embedPlayer.getTextTracks(), function( inx, textSource ){
				_this.textSources.push( new mw.TextSource( textSource ) );
			});
			// return the callback with sources
			callback( _this.textSources );
		},

		/**
		* Get the layout mode
		*
		* Takes into consideration:
		* 	Playback method overlays support ( have to put subtitles below video )
		*
		*/
		getLayoutMode: function() {
		 	// Re-map "ontop" to "below" if player does not support
		 	if( this.config.layout == 'ontop' && !this.embedPlayer.supports['overlays'] ) {
		 		this.config.layout = 'below';
		 	}
		 	return this.config.layout;
		},

		/**
		* Auto selects a source given the local configuration
		*
		* NOTE: presently this selects a "single" source.
		* In the future we could support multiple "enabled sources"
		*/
		autoSelectSource: function() {
			var _this = this;
			this.enabledSources = [];
			// Check if any source matches our "local" pref
			$.each( this.textSources, function(inx, source){
				if(	_this.config.userLanguage == source.srclang.toLowerCase() 
					&& 
					_this.config.userKind == source.kind
				) {
					_this.enableSource( source );
					return ;
				}
			});
			// Check if any source is marked default:
			$.each( this.textSources, function(inx, source){
				if( source['default'] ){
					_this.enableSource( source );
					return ;
				}
			});
					
			// If no userLang, source try enabling English:
			if( this.enabledSources.length == 0 ) {
				for( var i=0; i < this.textSources.length; i++ ) {
					var source = this.textSources[ i ];
					if( source.srclang.toLowerCase() == 'en' ) {
						_this.enableSource( source );
						return ;
					}
				}
			}
			// If still no source try the first source we get;
			if( this.enabledSources.length == 0 ) {
				for( var i=0; i < this.textSources.length; i++ ) {
					var source = this.textSources[ i ];
					_this.enableSource( source );
					return ;
				}
			}
		},
		/**
		 * Enable a source and update the currentLangKey 
		 * @param {object} source
		 * @return
		 */
		enableSource: function( source ){
			this.enabledSources.push( source );
			this.currentLangKey = source.srclang;
		},

		/**
		 * Get the current source sub captions
		 * @param {function} callback function called once source is loaded
		 */
		loadCurrentSubSource: function( callback ){
			mw.log("loadCurrentSubSource:: enabled source:" + this.enabledSources.length);
			for( var i =0; i < this.enabledSources.length; i++ ){
				var source = this.enabledSources[i];
				if( source.kind == 'SUB' ){
					source.load( function(){
						callback( source);
						return ;
					});
				}
			}
			return false;
		},

		/**
		 * Get sub captions by language key:
		 * 
		 * @param {string} langKey Key of captions to load
		 * @pram {function} callback function called once language key is loaded
		 */
		getSubCaptions: function( langKey, callback ){
			for( var i=0; i < this.textSources.length; i++ ) {
				var source = this.textSources[ i ];
				if( source.srclang.toLowerCase() === langKey ) {
					var source = this.textSources[ i ];
					source.load( function(){
						callback( source.captions );
					});
				}
			}
		},

		/**
		* Issue a request to load all enabled Sources
		*  Should be called anytime enabled Source list is updated
		*/
		loadEnabledSources: function() {
			$.each( this.enabledSources, function( inx, enabledSource ) {
				enabledSource.load();
			});
		},

		/**
		* Selection of a menu item
		*
		* @param {Element} item Item selected
		*/
		selectMenuItem: function( item ) {
			mw.log("selectMenuItem: " + $( item ).find('a').attr('class') );
			//this.currentLangKey = ''
		},

		/**
		* Checks if a source is "on"
		* @return {Boolean}
		* 	true if source is on
		* 	false if source is off
		*/
		isSourceEnabled: function( source ) {
			$.each( this.enabledSources, function( inx, enabledSource ) {
				if( source.id ) {
					if( source.id === enabledSource.id ){
						return true;
					}
				}
				if( source.srclang ) {
					if( source.srclang === enabledSource.srclang ){
						return true;
					}
				}
			});
			return false;
		},

		/**
		* Get a source object by language, returns "false" if not found
		* @param {string} langKey The language key filter for selected source
		*/
		getSourceByLanguage: function ( langKey ) {
			for(var i=0; i < this.textSources.length; i++) {
				var source = this.textSources[ i ];
				if( source.srclang == langKey ){
					return source;
				}
			}
			return false;
		},

		/**
		* Builds the core timed Text menu and
		* returns the binded jquery object / dom set
		*
		* Assumes text sources have been setup: ( _this.setupTextSources() )
		*
		* calls a few sub-functions:
		* Basic menu layout:
		*		Chose Language
		*			All Subtiles here ( if we have categories list them )
		*		Layout
		*			Bellow video
		*			Ontop video ( only available to supported plugins )
		* TODO features:
		*		[ Search Text ]
		*			[ This video ]
		*			[ All videos ]
		*		[ Chapters ] seek to chapter
		*/
		getMainMenu: function() {
			var _this = this;
			
			// Build the source list menu item:
			var $menu = $( '<ul>' );
			
			// Show text menu item with layout option (if not fullscren ) 
			if( _this.textSources.length !== 0 ) {
				$menu.append(
					$.getLineItem( gM( 'mwe-timedtext-choose-text'), 'comment' ).append(
						_this.getLanguageMenu()
					)					
				);
			} 
			
			// Layout Menu option if not in an iframe and we can expand video size: 

			$menu.append(
				$.getLineItem( gM( 'mwe-timedtext-layout' ), 'image' ).append(
					_this.getLayoutMenu()
				)
			);
			
			if(  _this.textSources.length == 0 ){
				$menu.append(
					$.getLineItem( gM( 'mwe-timedtext-no-subs'), 'close' )
				);
			}

			// Put in the "Make Transcript" link if config enabled and we have an api key
			if( mw.getConfig( 'TimedText.ShowAddTextLink' ) && _this.embedPlayer.apiTitleKey ){
				$menu.append(
					_this.getLiAddText()
				);
			}

			// Allow other modules to add to the timed text menu:
			$( _this.embedPlayer ).trigger( 'TimedText.BuildCCMenu', $menu ) ;

			// Test if only one menu item move its children to the top level
			if( $menu.children('li').length == 1 ){
				$menu.find('li > ul > li').detach().appendTo( $menu );  
				$menu.find('li').eq(0).remove();
			}
			
			return $menu;
		},

		/**
		* Utility function to assist in menu build out:
		* Get menu line item (li) html: <li><a> msgKey </a></li>
		*
		* @param {String} msgKey Msg key for menu item
		*/

		/**
		 * Get the add text menu item:
		 */
		getLiAddText: function() {
			var _this = this;
			return $.getLineItem( gM( 'mwe-timedtext-upload-timed-text'), 'script', function() {
				_this.showTimedTextEditUI( 'add' );
			});
		},

		/**
		* Get line item (li) from source object
		* @param {Object} source Source to get menu line item from
		*/
		getLiSource: function( source ) {
			var _this = this;
			//See if the source is currently "on"
			var source_icon = ( this.isSourceEnabled( source ) )? 'bullet' : 'radio-on';

			if( source.title ) {
				return $.getLineItem( source.title, source_icon, function() {
					_this.selectTextSource( source );
				});
			}	
			if( source.srclang ) {
				var langKey = source.srclang.toLowerCase();
				return $.getLineItem(
					gM('mwe-timedtext-key-language', langKey, _this.getLanguageName ( langKey ) ),
					source_icon,
					function() {
						_this.selectTextSource( source );
					}
				);
			}
		},

		/**
	 	 * Get language name from language key
	 	 * @param {String} lang_key Language key
	 	 */
	 	getLanguageName: function( lang_key ) {
	 		if( mw.Language.names[ lang_key ]) {
	 			return mw.Language.names[ lang_key ];
	 		}
	 		return false;
	 	},

		/**
		* Builds and returns the "layout" menu
		* @return {Object}
		* 	The jquery menu dom object
		*/
		getLayoutMenu: function() {
			var _this = this;
			var layoutOptions = [ ];

			//Only display the "ontop" option if the player supports it:
			if( this.embedPlayer.supports[ 'overlays' ] ){
				layoutOptions.push( 'ontop' );
			}

			//Add below and "off" options:
			if( ! mw.getConfig('EmbedPlayer.IsIframeServer') ){
				layoutOptions.push( 'below' );
			}
			layoutOptions.push( 'off' );

			$ul = $('<ul>');
			$.each( layoutOptions, function( na, layoutMode ) {
				var icon = ( _this.config.layout == layoutMode ) ? 'bullet' : 'radio-on';
				$ul.append(
					$.getLineItem(
						gM( 'mwe-timedtext-layout-' + layoutMode),
						icon,
						function() {
							_this.selectLayout( layoutMode );
						} )
					);
			});
			return $ul;
		},

		/**
		* Select a new layout
		* @param {Object} layoutMode The selected layout mode
		*/
		selectLayout: function( layoutMode ) {
			var _this = this;
			if( layoutMode != _this.config.layout ) {
				// Update the config and redraw layout
				_this.config.layout = layoutMode;						
				
				// Update the display:
				_this.updateLayout();
			}
		},
		toggleCaptions: function(){
			if( this.config.layout == 'off' ){
				this.selectLayout( 'ontop' );
			} else {
				this.selectLayout( 'off' );
			}
		},
		/**
		* Updates the timed text layout ( should be called when config.layout changes )
		*/
		updateLayout: function() {
			var $playerTarget = this.embedPlayer.$interface;
			$playerTarget.find('.track').remove();
			this.refreshDisplay();
		},

		/**
		* Select a new source
		*
		* @param {Object} source Source object selected
		*/
		selectTextSource: function( source ) {
			var _this = this;
			mw.log("mw.TimedText:: selectTextSource: select lang: " + source.srclang );
			
			// For some reason we lose binding for the menu ~sometimes~ re-bind
			this.bindTextButton( this.embedPlayer.$interface.find('timed-text') );
			
			this.currentLangKey =  source.srclang;
			
			// Update the config language if the source includes language
			if( source.srclang )
				this.config.userLanguage = source.srclang;

			if( source.kind )
				this.config.userKind = source.kind;

			// (@@todo update kind & setup kind language buckets? )

			// Remove any other sources selected in sources kind
			this.enabledSources = [];

			this.enabledSources.push( source );
			
			// Set any existing text target to "loading"
			if( !source.loaded ) {
				var $playerTarget = this.embedPlayer.$interface;
				$playerTarget.find('.track').text( gM('mwe-timedtext-loading-text') );
				// Load the text:
				source.load( function() {
					// Refresh the interface:
					_this.refreshDisplay();
				});
			} else {
				_this.refreshDisplay();
			}

			// Trigger the event
			$( this.embedPlayer ).trigger( 'TimedText_ChangeSource' );
		},

		/**
		* Refresh the display, updates the timedText layout, menu, and text display
		* also updates the cookie preference. 
		* 
		* Called after a user option change
		*/
		refreshDisplay: function() {
			// Update the configuration object
			$.cookie( 'TimedText.Preferences',  JSON.stringify( this.config ) );
			
			// Empty out previous text to force an interface update:
			this.prevText = [];
			
			// Refresh the Menu (if it has a target to refresh)
			if( this.menuTarget ) {
				mw.log('bind menu refresh display');
				this.bindMenu( this.menuTarget, false );
			}
			
			// Issues a "monitor" command to update the timed text for the new layout
			this.monitor();
		},

		/**
		* Builds the language source list menu
		* Cehck if the "track" tags had the "kind" attribute.
		* 
		* The kind attribute forms "categories" of text tracks like "subtitles", 
		*  "audio description", "chapter names". We check for these categories 
		*  when building out the language menu. 
		*/
		getLanguageMenu: function() {
			var _this = this;

			// See if we have categories to worry about
			// associative array of SUB etc categories. Each kind contains an array of textSources.
			var categorySourceList = {};
			var sourcesWithCategoryCount = 0;

			// ( All sources should have a kind (depreciate )
			var sourcesWithoutCategory = [ ];
			for( var i=0; i < this.textSources.length; i++ ) {
				var source = this.textSources[ i ];
				if( source.kind ) {
					var categoryKey = source.kind ;
					// Init Category menu item if it does not already exist:
					if( !categorySourceList[ categoryKey ] ) {
						// Set up catList pointer:
						categorySourceList[ categoryKey ] = [ ];
						sourcesWithCategoryCount++;
					}
					// Append to the source kind key menu item:
					categorySourceList[ categoryKey ].push(
						_this.getLiSource( source )
					);
				}else{
					sourcesWithoutCategory.push( _this.getLiSource( source ) );
				}
			}
			var $langMenu = $('<ul>');
			// Check if we have multiple categories ( if not just list them under the parent menu item)
			if( sourcesWithCategoryCount > 1 ) {
				for(var categoryKey in categorySourceList) {
					var $catChildren = $('<ul>');
					for(var i=0; i < categorySourceList[ categoryKey ].length; i++) {
						$catChildren.append(
							categorySourceList[ categoryKey ][i]
						);
					}
					// Append a cat menu item for each kind list
					$langMenu.append(
						$.getLineItem( gM( 'mwe-timedtext-textcat-' + categoryKey.toLowerCase() ) ).append(
							$catChildren
						)
					);
				}
			} else {
				for(var categoryKey in categorySourceList) {
					for(var i=0; i < categorySourceList[ categoryKey ].length; i++) {
						$langMenu.append(
							categorySourceList[ categoryKey ][i]
						);
					}
				}
			}
			// Add any remaning sources that did nto have a category
			for(var i=0; i < sourcesWithoutCategory.length; i++) {
				$langMenu.append( sourcesWithoutCategory[i] );
			}

			//Add in the "add text" to the end of the interface:
			if( mw.getConfig( 'TimedText.ShowAddTextLink' ) && _this.embedPlayer.apiTitleKey ){
				$langMenu.append(
					_this.getLiAddText()
				);
			}
			
			return $langMenu;
		},

		/**
		 * Updates a source display in the interface for a given time
		 * @param {object} source Source to update
		 * @param {number} time Caption time used to add and remove active captions.   
		 */
		updateSourceDisplay: function ( source, time ) {
			var _this = this;
			if( this.timeOffset ){
				time = time + parseInt( this.timeOffset );
			}
			
			// Get the source text for the requested time:
			var activeCaptions = source.getCaptionForTime( time );
			var addedCaption = false;
			// Show captions that are on: 
			$.each(activeCaptions, function( capId, caption){
				if( _this.embedPlayer.$interface.find( '.track[data-capId="' + capId +'"]').length == 0){
					_this.addCaption( source, capId, caption );
					addedCaption = true;
				}
			});
			
			// hide captions that are off: 
			_this.embedPlayer.$interface.find( '.track' ).each(function( inx, caption){
				if( !activeCaptions[ $( caption ).attr('data-capId') ] ){
					if( addedCaption ){
						$( caption ).remove();
					} else {
						$( caption ).fadeOut( mw.getConfig('EmbedPlayer.MonitorRate'), function(){ $(this).remove();} );
					}
				}
			});
		},
		getCaptionsTarget: function(){
			var $capTarget = this.embedPlayer.$interface.find('.captionsLayoutTarget');
			var layoutCss = {
				'left' : 0,
				'top' :0,
				'right':0,
				'position': 'absolute'
			};
			if( this.embedPlayer.controlBuilder.isOverlayControls() || 
				!mw.getConfig( 'EmbedPlayer.OverlayControls')  )
			{
				layoutCss['bottom'] = 0;				
			} else {
				layoutCss['bottom'] = this.embedPlayer.controlBuilder.getHeight();
			}
			
			if( $capTarget.length == 0 ){
				$capTarget = $( '<div />' )
				 	.addClass( 'captionsLayoutTarget' )
					.css( layoutCss );
				this.embedPlayer.$interface.append( $capTarget );
			}
			return $capTarget;
		},
		addCaption: function( source, capId, caption ){
			if( this.getLayoutMode() == 'off' ){
				return ;
			}
			// use capId as a class instead of id for easy selections and no conflicts with 
			// multiple players on page. 
			var $textTarget = $('<div />')
				.addClass( 'track' )
				.attr( 'data-capId', capId )
				.hide();
			
			// Update text ( use "html" instead of "text" so that subtitle format can
			// include html formating 
			// TOOD we should scrub this for non-formating html ( note all text in mediaWiki loader
			// comes from the mediaWiki html render so does not represent an XSS, but in principal, 
			// we only want formating html here. 
			$textTarget.append( 
				$('<span />')
					.css( this.getCaptionCss() )
					.html( caption.content )
			);


			// Add/update the lang option
			$textTarget.attr( 'lang', source.srclang.toLowerCase() );
			
			// Update any links to point to a new window
			$textTarget.find( 'a' ).attr( 'target', '_blank' );
			
			// Apply any custom style ( if we are ontop of the video )
			if( this.getLayoutMode() == 'ontop' ){
				if( caption.css ){
					$textTarget.css( caption.css );
				} else {
					$textTarget.css( this.getDefaultStyle() );
				}
				this.getCaptionsTarget().append( 
					$textTarget	
				);
			} else {
				// else apply the default layout system:
				this.addTextToDefaultLocation( $textTarget );
			}
			// apply any interface size adjustments: 
			$textTarget.css( this.getInterfaceSizeTextCss({
					'width' :  this.embedPlayer.$interface.width(),
					'height' : this.embedPlayer.$interface.height()
				})
			);
			
			
			// Update the style of the text object if set
			if( caption.styleId ){
				var capCss = source.getStyleCssById( caption.styleId );
				$textTarget.find('span').css(
					capCss
				);
			}
		
			$textTarget.fadeIn('fast');
		},
		getDefaultStyle: function(){ 
			var baseCss =  {
					'position':'absolute',
					'bottom': 10,
					'width': '100%',
					'display': 'block',
					'opacity': 0.8,
					'text-align': 'center',
					'z-index': 2
				};
			baseCss =$.extend( baseCss, this.getInterfaceSizeTextCss({
				'width' :  this.embedPlayer.$interface.width(),
				'height' : this.embedPlayer.$interface.height()
			}));
			return baseCss;
		},
		/**
		 * Applies the default layout for a text target
		 */
		addTextBelowVideo: function( $textTarget ) {
			var $playerTarget = this.embedPlayer.$interface;
			// Get the relative positioned player class from the controlBuilder:
			this.embedPlayer.controlBuilder.keepControlBarOnScreen = true;
			// Set the belowBar size to 60 pixels:
			var belowBarHeight = mw.getConfig('TimedText.BelowVideoBlackBoxHeight');
			
			// Append before controls:
			$playerTarget.find( '.control-bar' ).before(
				$('<div>').addClass( 'captionContainer' )
					.css({
						'position' : 'absolute',
						'top' : this.embedPlayer.getHeight(),
						'display' : 'block',
						'width' : '100%',
						'height' : belowBarHeight + 'px',
						'background-color' : '#000',
						'text-align' : 'center',
						'padding-top' : '5px'
					} ).append(
						$textTarget.css( {
							'color':'white'
						} )
					)
			);
			
			// Add some height for the bar and interface
			var height = ( belowBarHeight + 8 ) + this.embedPlayer.getHeight() + this.embedPlayer.controlBuilder.getHeight();
			
			// Resize the interface for layoutMode == 'below' ( if not in full screen)
			if( ! this.embedPlayer.controlBuilder.fullscreenMode ){
				this.embedPlayer.$interface.animate({
					'height': height
				});
			}
			mw.log( 'TimedText:: height of ' + this.embedPlayer.id + ' is now: ' + $( '#' + this.embedPlayer.id ).height() );
		},
		/**
		 * Build css for caption using this.options
		 */
		getCaptionCss: function() {
			var options = this.options;
			var style = {'display': 'inline'};

			if( options.bg ) {
				style["background-color"] = this.getHexColor( options.bg );
			}
			if( options.fontColor ) {
				style["color"] = this.getHexColor( options.fontColor );
			}
			if( options.fontFamily ){
				style["font-family"] = options.fontFamily;
			}
			if( options.fontsize ) {
				// Translate to em size so that font-size parent percentage
				style[ "font-size" ] = ( options.fontsize > 24 ) ? '1.5em' :  Math.round( options.fontsize * 0.0625 * 1000 ) / 1000 + 'em';
			}
			
			if( options.useGlow && options.glowBlur && options.glowColor ) {
				style["text-shadow"] = '0 0 ' + options.glowBlur + 'px ' + this.getHexColor( options.glowColor );
			}

			return style;
		},

		getHexColor: function(color) {
			if( color.substr(0,2) == "0x" ) {
				return color.replace('0x', '#');
			} else {
				color = parseInt( color );
				color = color.toString(16);
				var len = 6 - color.length;
				if( len > 0 ) {
					var pre = '';
					for( var i=0; i<len; i++) {
						pre += '0';
					}
					color = pre + color;
				}
				return '#' + color;
			}
		}
	};

	
} )( window.mediaWiki, window.jQuery );
