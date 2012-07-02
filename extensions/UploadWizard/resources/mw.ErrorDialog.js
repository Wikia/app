( function( mw, $ ) {

	/**
	 * Thingy for collecting user feedback on a wiki page
	 * @param {mw.Api}  api properly configured to talk to this wiki
	 * @param {mw.Title} the title of the page where you collect feedback
	 */
	mw.ErrorDialog = function( errorMessage ) {
		this.errorMessage = errorMessage;
		this.setup();
	};

	mw.ErrorDialog.prototype = {
		setup: function() {
			var _this = this;

			// Set up buttons for dialog box. We have to do it the hard way since the json keys are localized
			_this.buttons = {};
			_this.buttons[ gM( 'mwe-upwiz-errordialog-ok' ) ] = function() { _this.ok(); };
				
			this.$dialog = 
				$( '<div style="position:relative;"></div>' ).append( 
					$( '<div class="mwe-upwiz-errordialog-mode mwe-upwiz-errordialog"></div>' ).append( 
						$( '<div style="margin-top:1em;"></div>' ).append( 
							_this.errorMessage,
							$( '<br/>' )
						)
					)
				).dialog({
					width: 600,
					autoOpen: false,
					title: gM( 'mwe-upwiz-errordialog-title' ),
					modal: true,
					buttons: _this.buttons
				}); 
		},

		ok: function() { 
			this.$dialog.dialog( 'close' );
		},

		launch: function() {
			this.$dialog.dialog( 'open' );
		}	

	};


} )( window.mediaWiki, jQuery );
