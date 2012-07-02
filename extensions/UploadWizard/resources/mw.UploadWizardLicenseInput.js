/**
 * Create a group of radio buttons for licenses. N.b. the licenses are named after the templates they invoke.
 * Note that this is very anti-MVC. The values are held only in the actual form elements themselves.
 *
 * @param {String|jQuery} selector to place license input 
 * @param {Array} 	  license key name(s) to activate by default
 * @param {Array}	  configuration of licenseInput. Must have following properties
 *				'type' = ("and"|"or") -- whether inclusive or exclusive license allowed
 *				'defaults' => array of template string names (can be empty array), 
 *				'licenses' => array of template string names (matching keys in mw.UploadWizard.config.licenses)
 *				optional: 'licenseGroups' => groups of licenses, with more explanation
 *				optional: 'special' => String -- indicates, don't put licenses here, instead use a special widget
 * @param {Number}	  count of the things we are licensing (it matters to some texts)
 * @param {mw.Api}	  api object; useful for previews
 */

( function( mw, $j, undefined ) {

var catNsId 		= mw.config.get( 'wgNamespaceIds' ).category,
	templateNsId 	= mw.config.get( 'wgNamespaceIds' ).template;

mw.UploadWizardLicenseInput = function( selector, values, config, count, api ) {
	var _this = this;
	_this.count = count;
	
	_this.api = api;

	if ( config.type === undefined 
		 || config.defaults === undefined 
		 || ( config.licenses === undefined && config.licenseGroups === undefined ) ) {
		throw new Error( 'improper initialization' );
	}

	_this.$selector = $j( selector );
	_this.$selector.append( $j( '<div class="mwe-error mwe-error-main"></div>' ) );

	_this.type = config.type === 'or' ? 'radio' : 'checkbox';

	_this.defaults = config.defaults;

	mw.UploadWizardLicenseInput.prototype.count++;
	_this.name = 'license' + mw.UploadWizardLicenseInput.prototype.count;

	// the jquery wrapped inputs (checkboxes or radio buttons) for this licenseInput.
	_this.inputs = [];

	// create inputs and licenses from config
	if ( config['licenseGroups'] === undefined ) {
		_this.createInputs( _this.$selector, config );
	} else {
		_this.createGroupedInputs( _this.$selector, config['licenseGroups'] );
	}

	// set values of the whole license input
	if ( values ) {
		_this.setValues( values );
	}

	// set up preview dialog		
	_this.$previewDialog = $j( '<div></div> ')
		.css( 'padding', 10 )
		.dialog( {
			autoOpen: false,
			width: 800,
			zIndex: 200000,
			modal: true
		} );
		
	_this.$spinner = $j( '<div></div>' )
		.addClass( 'mwe-upwiz-status-progress mwe-upwiz-file-indicator' )
		.css( { 'width': 200, 'padding': 20, 'float': 'none', 'margin': '0 auto' } );

	return _this;
};

mw.UploadWizardLicenseInput.prototype = {
	count: 0,

	/**
	 * Creates the license input interface in toggleable groups.
	 * @param jQuery selector
	 * @param license input configuration groups
	 */
	createGroupedInputs: function( $el, configGroups ) {
		var _this = this;
		$j.each( configGroups, function( i, group ) { 
			var $body, $toggler;
			var $group = $j( '<div></div>' ).addClass( 'mwe-upwiz-deed-license-group' );
			if ( group['head'] === undefined ) {
				// if there is no header, just append licenses to the group div.
				$body = $group;
			} else {
				// if there is a header, make a toggle-to-expand div and append inputs there.
				var $head = $j( '<div></div>' ).append( 
					$j( '<a>' )
						.addClass( 'mwe-upwiz-deed-license-group-head mwe-upwiz-toggler' )
						.msg( group.head, _this.count )
				);
				$body = $j( '<div></div>' ).addClass( 'mwe-upwiz-toggler-content' ).css( { 'marginBottom': '1em' } );
				$toggler = $group.append( $head, $body ).collapseToggle();

			}
			if ( group['subhead'] !== undefined ) {
				$body.append( $j( '<div></div>' ).addClass( 'mwe-upwiz-deed-license-group-subhead' ).msg( group.subhead, _this.count ) );
			}
			var $licensesDiv = $j( '<div></div>' ).addClass( 'mwe-upwiz-deed-license' );
			_this.createInputs( $licensesDiv, group, $toggler );
			$body.append( $licensesDiv );
			_this.$selector.append( $group );
		} );
	},

	/**
	 * append defined license inputs to element.
	 * SIDE EFFECT: also records licenses and inputs in _this
	 *
	 * Abstracts out simple lists of licenses, more complex groups with layout
	 * @param {jQuery} selector to add inputs to
	 * @param {Array} license configuration, which must have a 'licenses' property, which is an array of license names
	 * 			it may also have: 'prependTemplates' or 'filterTemplate', which alter the final wikitext value 
	 *			'prependTemplates' will prepend Templates. If prependTemplates were [ 'pre', 'pended' ], then...
	 *				[ 'fooLicense' ] -> "{{pre}}{{pended}}{{fooLicense}}"
	 *			'filterTemplates' will filter Templates, as in "own work". If 'filterTemplate' was 'filter', then...
	 *				[ 'fooLicense', 'barLicense' ] -> {{filter|fooLicense|barLicense}}
	 * @param {jQuery} optional - jquery-wrapped element created by $j.fn.collapseToggle(), which has 'close' and 'open' 
	 *			methods in its data.
	 *
	 */
	createInputs: function( $el, config, $groupToggler ) {
		var _this = this;
		if ( config['licenses'] === undefined || typeof config['licenses'] !== 'object' ) {
			throw new Error( "improper license config" );
		}
		$j.each( config['licenses'], function( i, licenseName ) {
			if ( mw.UploadWizard.config.licenses[licenseName] !== undefined ) {
				var license = { name: licenseName, props: mw.UploadWizard.config.licenses[licenseName] };
				
				var templates = license.props['templates'] === undefined ? [ license.name ] : license.props.templates.slice(0);

				var $input = _this.createInputElement( templates, config );
				_this.inputs.push( $input );

				var $label = _this.createInputElementLabel( license, $input );

				$el.append( $input, $label, $j( '<br/>' ) ); 
				// TODO add popup help?

				// this is so we can tell if a particular license ought to be set in setValues()
				$input.data( 'licenseName', licenseName );

				// this is so if a single input in a group changes, we open the entire "toggler" that was hiding them
				$input.data( 'groupToggler', $groupToggler );

				if ( config['special'] === 'custom' ) {
					var $customDiv = _this.createCustomWikiTextInterface( $input );
					$el.append( $customDiv );
					$input.data( 'textarea', $customDiv.find( 'textarea' ) ); 
				}
			}
		} );
	},

	/**
	 * License templates are these abstract ideas like cc-by-sa. In general they map directly to a license template.
	 * However, configuration for a particular option can add other templates or transform the templates, 
	 * such as wrapping templates in an outer "self" template for own-work
	 * @param {Array} of license template names
	 * @param {Object}, license input configuration
	 * @return {String} of wikitext
	 */
	createInputValueFromTemplateConfig: function( templates, config ) {
		if ( config['prependTemplates'] !== undefined ) {
			$j.each( config['prependTemplates'], function( i, template ) {
				templates.unshift( template );
			} );
		}
		if ( config['filterTemplate'] !== undefined ) {
			templates.unshift( config['filterTemplate'] );
			templates = [ templates.join( '|' ) ];
		}
		var wikiTexts = $j.map( templates, function(t) { return '{{' + t + '}}'; } );
		return wikiTexts.join( '' );
	},

	/**
	 * Return a radio button or checkbox with appropriate values, depending on config
	 * @param {Array} of template strings
	 * @param {Object} config for this license input
	 * @return {jQuery} wrapped input
	 */
	createInputElement: function( templates, config ) {
		var _this = this;
					
		var attrs = {
			id:  _this.name + '_' + _this.inputs.length, // unique id
			name: _this.name, // name of input, shared among all checkboxes or radio buttons.
			type: _this.type, // kind of input
			value: _this.createInputValueFromTemplateConfig( templates, config )
		};

		var inputHtml = '<input ' + 
			$j.map( attrs, function(val, key) { 
				return key + '="' + val.toString().replace( '"', '' ) + '"'; 
			} ).join( " " ) 
		+ ' />';

		// Note we aren't using $('<input>').attr( { ... } ) .  We construct a string of HTML.
		// IE6 is idiotic about radio buttons; you have to create them as HTML or clicks aren't recorded	
		return $j( inputHtml ).click( function() { 
			_this.$selector.trigger( 'changeLicenses' ); 
		} );
	},

	/**
	 * Get a label for the form element
	 * @param {Object} license definition from global config. Will tell us the messages, and maybe icons.
	 * @param {jQuery} wrapped input
	 * @return {jQuery} wrapped label referring to that input, with appropriate HTML, decorations, etc.
	 */
	createInputElementLabel: function( license, $input ) {	
		var messageKey = license.props['msg'] === undefined ? '[missing msg for ' + license.name + ']' : license.props.msg;

		// The URL is optional, but if the message includes it as $2, we surface the fact
		// that it's misisng.
		var licenseURL = license.props['url'] === undefined ? '#missing license URL' : license.props.url;
		var licenseLink = $j( '<a>' ).attr( { 'target': '_blank', 'href': licenseURL } );
		var $icons = $j( '<span></span>' );
		if ( license.props['icons'] !== undefined ) {
			$j.each( license.props.icons, function( i, icon ) { 
				$icons.append( $j( '<span></span>' ).addClass( 'mwe-upwiz-license-icon mwe-upwiz-' + icon + '-icon' ) );		
			} );
		}
		return $j( '<label />' )
			.attr( { 'for': $input.attr('id') } )
			.msg( messageKey, this.count, licenseLink )
			.append( $icons );
	},

	/**
	 * Given an input, return another textarea to be appended below.
	 * When text entered here, auto-selects the input.
	 * @param {jQuery} wrapped input
	 * @return {jQuery} wrapped textarea
	 */
	createCustomWikiTextInterface: function( $input ) {
		var _this = this, 
			keydownTimeout;

		var nameId = $input.attr( 'id' ) + '_custom';
		var $textarea = $j( '<textarea></textarea>' )
				.attr( { id: nameId, name: nameId } )
				.growTextArea()
				.focus( function() { _this.setInput( $input, true ); } )
				.keydown( function() { 
					window.clearTimeout( keydownTimeout );
					keydownTimeout = window.setTimeout( 
						function() { _this.$selector.trigger( 'changeLicenses' ); },
						2000
					);
				} )
				.css( { 
					'width': '100%', 
					'font-family': 'monospace' 
				} );

		var $button = $j( '<span></span>' )
				.button( { label: gM( 'mwe-upwiz-license-custom-preview' ) } )
				.css( { 'width': '8em' } )
				.click( function() { _this.showPreview( $textarea.val() ); } );

		return $j( '<div></div>' ).css( { 'width': '100%' } ).append(
			$j( '<div><label for="' + nameId + '" class="mwe-error mwe-error-textarea"></label></div>' ),
			$j( '<div></div>' ).css( { 'float': 'right', 'width': '9em', 'padding-left': '1em' } ).append( $button ),
			$j( '<div></div>' ).css( { 'margin-right': '10em' } ).append( $textarea ),
			$j( '<div></div>' ).css( { 'clear':'both' } )
		);
	},

	/* ---- end creational stuff ----- */

	// Set the input value. If it is part of a group, and this is being turned on, pop open the group so we can see this input.
	setInput: function( $input, val ) {
		var _this = this;
		var oldVal = $input.attr( 'checked' );
		// !! to ensure boolean.
		var bool = !!val;
		$input.attr( 'checked', bool );
		if ( bool !== oldVal ) {
			_this.$selector.trigger( 'changeLicenses' );
		}

		// pop open the 'toggle' group if is now on. Do nothing if it is now off.
		if ( bool && $input.data( 'groupToggler' ) ) {
			$input.data( 'groupToggler' ).data( 'open' )();
		}
	},

	// this works fine for blanking all of a radio input, or for checking/unchecking individual checkboxes
	setInputsIndividually: function( values ) { 
		var _this = this;
		$j.each( _this.inputs, function( i, $input ) {
			var licenseName = $input.data( 'licenseName' );
			_this.setInput( $input, values[licenseName] );
		} );
	},

	/**
	 * Sets the value(s) of a license input. This is a little bit klugey because it relies on an inverted dict, and in some
	 * cases we are now letting license inputs create multiple templates.
	 * @param object of license-key to boolean values, e.g. { 'cc_by_sa_30': true, 'gfdl': true, 'flickrreview|cc_by_sa_30': false }
	 */
	setValues: function( values ) {
		var _this = this;
		// ugly division between radio and checkbox, because in jquery 1.6.4 if you set any element of a radio input to false, every element
		// is set to false! Unfortunately the incoming data structure is a key-val object so we have to make extra sure it makes sense for 
		// a radio button input.

		if ( _this.type === 'radio' ) {

			// check if how many license names are set to true in the values requested. Should be 0 or 1
			var trueCount = 0;
			var trueLicenseName = undefined;
			$j.each( values, function( licenseName, val ) { 
				if ( val === true ) { 
					trueCount++;
					trueLicenseName = licenseName;
				}
			} );

			if ( trueCount === 0 ) {
				_this.setInputsIndividually( values );
			} else if ( trueCount === 1 ) {
				// set just one of the radio inputs and don't touch anything else
				$j.each( _this.inputs, function( i, $input ) { 
					var licenseName = $input.data( 'licenseName' );
					// !! to ensure boolean.
					if ( licenseName === trueLicenseName ) {
						_this.setInput( $input, true );
					}
				} );
			} else {
				mw.log( "too many true values for a radio button!");
			}
							
		} else if ( _this.type === 'checkbox' ) {
			_this.setInputsIndividually( values );
		} else {
			mw.log( "impossible? UploadWizardLicenseInput type neither radio nor checkbox" );
		}
		// we use the selector because events can't be unbound unless they're in the DOM.
		_this.$selector.trigger( 'changeLicenses' );
	},

	/**
	 * Set the default configured licenses
	 */
	setDefaultValues: function() {
		var _this = this;
		var values = {};
		$j.each( _this.defaults, function( i, lic ) {
			values[lic] = true;
		} );
		_this.setValues( values );
	},

	/**
	 * Gets the wikitext associated with all selected inputs. Some inputs also have associated textareas so we append their contents too.
	 * @return string of wikitext (empty string if no inputs set)
	 */
	getWikiText: function() {
		var _this = this;
		var wikiTexts = this.getSelectedInputs().map( 
			function() { 
				return _this.getInputWikiText( this );
			} 
		);
		// need to use makeArray because a jQuery-returned set of things won't have .join
		return $j.makeArray( wikiTexts ).join( '' );
	},

	/**
	 * Get the value of a particular input
	 */
	getInputWikiText: function( $input) {
		return $input.val() + "\n" + this.getInputTextAreaVal($input);
	},

	/**
	 * Get the value of the associated textarea, if any
	 * @return {String}
	 */
	getInputTextAreaVal: function( $input ) {
		var extra = ''; 
		if ( $input.data( 'textarea' ) ) {
			extra = $j.trim( $input.data( 'textarea' ).val() );
		}
		return extra;
	},

	/**
	 * Gets which inputs have user-entered values
	 * @return {jQuery Array} of inputs
	 */
	getSelectedInputs: function() {
		// not sure why filter(':checked') doesn't work
		return $j( this.inputs ).filter( function(i, $x) { return $x.is(':checked'); } );
	},

	/**
	 * Check if a valid value is set, also look for incompatible choices. 
	 * Side effect: if no valid value, add error notices to the interface. Add listeners to interface, to revalidate and remove notices
	 * If I was sufficiently clever, most of these could just be dynamically added & subtracted validation rules.
	 * Instead this is a bit of a recapitulation of jquery.validate
	 * @return boolean; true if a value set and all is well, false otherwise
	 */
	valid: function() {
		var _this = this;

		var errors = [];

		var selectedInputs = this.getSelectedInputs();

		if ( selectedInputs.length === 0 ) {
			errors.push( [ this.$selector.find( '.mwe-error-head' ), 'mwe-upwiz-deeds-need-license' ] );

		} else {
			// It's pretty hard to screw up a radio button, so if even one of them is selected it's okay.
			// But also check that associated textareas are filled for if the input is selected, and that 
			// they are the appropriate size.
			$j.each( selectedInputs, function(i, $input) {
				if ( ! $input.data( 'textarea' ) ) {
					return;
				}
			
				var textAreaName = $input.data( 'textarea' ).attr( 'name' );
				var $errorEl = $( 'label[for=' + textAreaName + '].mwe-error' );

				var text = _this.getInputTextAreaVal( $input );
				
				if ( text === '' ) {
					errors.push( [ $errorEl, 'mwe-upwiz-error-license-wikitext-missing' ] );
				} else if ( text.length < mw.UploadWizard.config.minCustomLicenseLength ) {
					errors.push( [ $errorEl, 'mwe-upwiz-error-license-wikitext-too-short' ] );
				} else if ( text.length > mw.UploadWizard.config.maxCustomLicenseLength ) {
					errors.push( [ $errorEl, 'mwe-upwiz-error-license-wikitext-too-long' ] );
				} else if ( !_this.validateWikiText( text ) ) {
					errors.push( [ $errorEl, 'mwe-upwiz-error-license-wikitext-invalid' ] );
				}

			} );
		}
		
		// clear out the errors if we are now valid
		if ( errors.length === 0 ) {
			this.$selector.find( '.mwe-error' ).fadeOut();
		} else {
			// show the errors
			$j.each( errors, function( i, err ) { 
				var $el = err[0],
					msg = err[1];
				$el.msg( msg ).show();
			} );

			// and watch for any change at all in the license to revalidate.
			_this.$selector.bind( 'changeLicenses.valid', function() {
				_this.$selector.unbind( 'changeLicenses.valid' );
				_this.valid();
			} );
		}

		return errors.length === 0;
	},


	/**
  	 * Returns true if any license is set
	 * @return boolean
	 */
	isSet: function() {
		return this.getSelectedInputs().length > 0;
	},


	/**
	 * Attempt to determine if wikitext parses... and maybe does it contain a license tag
	 * @return boolean
	 */
	validateWikiText: function( text ) {
		var parser = new mw.jqueryMsg.parser(),
			_this = this,
			ast;	

		try { 
			ast = parser.wikiTextToAst( text );
		} catch (e) {
			mw.log( e.message );
			return false;
		}
	
		function accumTemplates( node, templates ) {
			if ( typeof node === 'object' ) {
				var nodeName = node[0];
				var lcNodeName = nodeName.toLowerCase();
				// templates like Self are special cased, as it is not a license tag and also reparses its string arguments into templates
				// e.g.  {{self|Cc-by-sa-3.0}}  --> we should add 'Cc-by-sa-3.0' to the templates
				if ( mw.UploadWizard.config.licenseTagFilters 
						&& 
					 mw.UploadWizard.config.licenseTagFilters.indexOf( lcNodeName ) !== -1 ) {
					// upgrade all the arguments to be nodes in their own right (by making them the first element of an array)
					// so, [ "self", "Cc-by-sa-3.0", "GFDL" ] --> [ "self", [ "Cc-by-sa-3.0" ], [ "GFDL" ] ];
					// $.map seems to strip away arrays of one element so have to use an array within an array.
					node = $j.map( node, function( n, i ) {
						return i == 0 ? n : [[n]];	
					} );
				} else if ( typeof mw.jqueryMsg.htmlEmitter.prototype[lcNodeName] !== 'function' ) {
					templates.push( nodeName );
				}
				$j.map( node.slice( 1 ), function( n ) {
					accumTemplates( n, templates );
				} );
			}
		}
		var templates = [];
		accumTemplates( ast, templates );

		// TODO caching
		var found = false;
		function recurseCategories( desiredCatTitle, title, depthToContinue ) {
			if ( depthToContinue === 0 ) {
				return;
			}
			var ok = function(cats) { 
				if ( cats !== false ) {
					$.each( cats, function( i, catTitle ) { 
						if ( catTitle.getNameText() === desiredCatTitle.getNameText() ) {
							found = true;
							return false;
						}
						recurseCategories( desiredCatTitle, catTitle, depthToContinue - 1 );
						return true;
					} );
				}
			};
			var err = function() {};
			// this proceeds synchronously, so we pick up in the next line
			_this.api.getCategories( title, ok, err, false );
		}

		var licenseCategory = new mw.Title( mw.UploadWizard.config.licenseCategory, catNsId );

		$.each( templates, function( i, t ) { 		
			var title = new mw.Title( t, templateNsId );
			recurseCategories( licenseCategory, title, 5 );
			if ( found ) {
				return false;
			}
		} );
	
		return found;
	},

	/**
	 * Preview wikitext in a popup window
	 * @param {String} wikitext
	 */
	showPreview: function( wikiText ) {	

		this.$previewDialog.html( this.$spinner ).dialog( 'open' );

		var _this = this;
		function show( html ) {
			_this.$previewDialog.html( html );
			_this.$previewDialog.dialog( 'open' );
		}

		var error = function( error ) { 
			show( $j( '<div></div>' ).append( 
				$j( '<h3></h3>' ).append( error['code'] ),
				$j( '<p></p>' ).append( error['info'] ) 
			) );
		};

		this.api.parse( wikiText, show, error );
	}


};

} )( window.mediaWiki, jQuery );
