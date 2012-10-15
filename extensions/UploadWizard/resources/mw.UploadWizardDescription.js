	
/**
 * Object that represents an indvidual language description, in the details portion of Upload Wizard
 * @param languageCode -- string 
 * @param firstRequired -- boolean -- the first description is required and should be validated and displayed a bit differently
 */
mw.UploadWizardDescription = function( languageCode, required ) {
	var _this = this;
	mw.UploadWizardDescription.prototype.count++;
	_this.id = 'description' + mw.UploadWizardDescription.prototype.count;

	// XXX for some reason this display:block is not making it into HTML
	var errorLabelDiv = $j(   '<div class="mwe-upwiz-details-input-error">'
				+   '<label generated="true" class="mwe-validator-error" for="' + _this.id + '" />'
				+ '</div>' );

	var fieldnameDiv = $j( '<div class="mwe-upwiz-details-fieldname" />' );
	if ( required ) {
		fieldnameDiv.requiredFieldLabel();
	}
	
	fieldnameDiv.append( gM( 'mwe-upwiz-desc' ) ).addHint( 'description' );

	// Logic copied from MediaWiki:UploadForm.js
	// Per request from Portuguese and Brazilian users, treat Brazilian Portuguese as Portuguese.
	if (languageCode == 'pt-br') {
		languageCode = 'pt';
	// this was also in UploadForm.js, but without the heartwarming justification
	} else if (languageCode == 'en-gb') {
		languageCode = 'en';
	}

	_this.languageMenu = mw.LanguageUpWiz.getMenu( 'lang', languageCode );
	$j(_this.languageMenu).addClass( 'mwe-upwiz-desc-lang-select' );

	_this.input = $j( '<textarea name="' + _this.id  + '" rows="2" cols="36" class="mwe-upwiz-desc-lang-text"></textarea>' )
				.attr( 'title', gM( 'mwe-upwiz-tooltip-description' ) )
				.growTextArea();

	// descriptions
	_this.div = $j('<div class="mwe-upwiz-details-descriptions-container ui-helper-clearfix"></div>' )
			.append( errorLabelDiv, fieldnameDiv, _this.languageMenu, _this.input );

};

mw.UploadWizardDescription.prototype = {

	/* widget count for auto incrementing */
	count: 0,

	/**
	 * Obtain text of this description, suitable for including into Information template
	 * @return wikitext as a string
	 */
	getWikiText: function() {
		var _this = this;
		var description = $j.trim( $j( _this.input ).val() );
		// we assume that form validation has caught this problem if this is a required field
		// if not, assume the user is trying to blank a description in another language
		if ( description.length === 0 ) {	
			return '';
		}
		var language = $j.trim( $j( _this.languageMenu ).val() );
		var fix = mw.UploadWizard.config[ "languageTemplateFixups" ];
		if (fix[language]) {
			language = fix[language];
		}
		return '{{' + language + '|1=' + description + '}}';
	},

	/**
	 * defer adding rules until it's in a form 
	 * @return validator
 	 */
	addValidationRules: function( required ) {
		// validator must find a form, so we add rules here
		return this.input.rules( "add", {
			minlength: mw.UploadWizard.config[  'minDescriptionLength'  ],
			maxlength: mw.UploadWizard.config[  'maxDescriptionLength'  ],
			required: required,
			messages: { 
				required: gM( 'mwe-upwiz-error-blank' ),
				minlength: gM( 'mwe-upwiz-error-too-short', mw.UploadWizard.config[  'minDescriptionLength'  ] ),
				maxlength: gM( 'mwe-upwiz-error-too-long', mw.UploadWizard.config[  'maxDescriptionLength'  ] )
			}		
		} );
	}	
};
