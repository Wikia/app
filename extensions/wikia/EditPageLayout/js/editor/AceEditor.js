define('wikia.editpage.ace.editor', ['wikia.ace.editor'], function(ace){
	'use strict';

	var theme = 'solarized_light',
	inputAttr = {
		name: 'wpTextbox1',
		id: 'wpTextbox1'
	},
	beforeInit = function(){
		$('.loading-indicator').remove();
		$( '#wpSave' ).removeAttr( 'disabled' );
	};

	function init() {
		checkTheme();
		initConfig();
		beforeInit();
		ace.init( 'editarea', inputAttr );
		initOptions();
		ace.setTheme( theme );
		ace.setMode( window.aceMode );

		initSubmit();
		initDiffModal();
	}

	function initConfig() {
		var config = {
				workerPath: window.aceScriptsPath
			};

		ace.setConfig( config );
	}

	function initOptions() {
		var options = {
			showPrintMargin: false
		};

		ace.setOptions( options );
	}

	function initSubmit() {
		$( '#editform' ).submit(function(e) {
			var $form = $( this ),
				hiddenInput = ace.getInput().val( ace.getContent() );

			$form.append( hiddenInput );
			$form.submit();

			e.preventDefault();
		});
	}

	function checkTheme() {
		if (window.wgIsDarkTheme) {
			theme = 'solarized_dark';
		}
	}

	function initDiffModal() {
		var previewModalConfig = {
				vars: {
					id: 'EditPageDialog',
					title: $.msg( 'editpagelayout-pageControls-changes' ),
					content: '<div class="ArticlePreview modalContent"><div class="ArticlePreviewInner">' +
						'</div></div>',
					size: 'large'
				}
			},
			modalCallback = function(previewModal) {
				previewModal.deactivate();

				previewModal.$content.bind( 'click', function( event ) {
					var target = $( event.target );
					target.closest( 'a' ).not( '[href^="#"]' ).attr( 'target', '_blank' );
				});

				prepareDiffContent(previewModal, ace.getContent());

				previewModal.show();
			};

		$('#wpDiff').click(function(){
			ace.showDiff(previewModalConfig, $.proxy(modalCallback, self));
		});
	}

	// send AJAX request
	function ajax( method, params, callback, skin ) {
		var url = window.wgEditPageHandler.replace( '$1', encodeURIComponent( window.wgEditedTitle ) );

		params = $.extend({
			page: window.wgEditPageClass ? window.wgEditPageClass : "",
			method: method,
			mode: 'ace'
		}, params );

		if ( skin ) {
			url += '&type=full&skin=' + encodeURIComponent( skin );
		}

		return jQuery.post( url, params, function ( data ) {
			if ( typeof callback === 'function' ) {
				callback( data );
			}
		}, 'json' );
	}

	function prepareDiffContent(previewModal, content) {
		var section = $.getUrlVar( 'section' ) || 0,
			extraData = {
				content: content,
				section: parseInt( section, 10 )
			};

		$.when(
			// get wikitext diff
			ajax( 'diff' , extraData ),

			// load CSS for diff
			window.mw.loader.use( 'mediawiki.action.history.diff' )
		).done(function( ajaxData ) {
			var data = ajaxData[ 0 ],
				html = '<h1 class="pagetitle">' + window.wgEditedTitle + '</h1>' + data.html;
			previewModal.$content.find( '.ArticlePreview .ArticlePreviewInner' ).html( html );
			previewModal.activate();
		});
	}

	return {
		init: init
	};
});
