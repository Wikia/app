define('wikia.editpage.ace.editor', ['wikia.ace.editor'], function(ace){
	'use strict';

	var theme = 'solarized_light',
		isEditorWide = false,
		inputAttr = {
			name: 'wpTextbox1',
			id: 'wpTextbox1'
		},
		$editPage = $('#EditPage'),
		$editPageToolbar = $('#EditPageToolbar'),
		wideClassName = 'editpage-sourcewidemode-on',
		narrowClassName = 'editpage-sourcewidemode-off',
		beforeEditorInit = function(){
			$('.loading-indicator').remove();
			$('#wpSave').removeAttr( 'disabled' );
			$editPage.addClass('editpage-sourcewidemode mode-source ' + narrowClassName);
		};

	function init() {
		chooseTheme();
		initConfig();
		beforeEditorInit();
		ace.init( 'editarea', inputAttr );
		initOptions();
		initStyles();
		ace.setTheme( theme );
		ace.setMode( window.codePageType );

		initEvents();
	}

	/**
	 * Init ace editor config
	 */
	function initConfig() {
		var config = {
				workerPath: window.aceScriptsPath
			};

		ace.setConfig( config );
	}

	/**
	 * Init ace editor options
	 */
	function initOptions() {
		var options = {
			showPrintMargin: false
		};

		ace.setOptions( options );
	}

	/**
	 * Init ace editor custom styles
	 */
	function initStyles() {
		var editor = ace.getEditor();

		editor.css('fontSize', '14px');
	}

	/**
	 * Init submit action
	 */
	function initSubmit() {
		$( '#editform' ).submit(function(e) {
			var $form = $( this ),
				hiddenInput = ace.getInput().val( ace.getContent() );

			$form.append( hiddenInput );
			$form.submit();

			e.preventDefault();
		});
	}

	/**
	 * Choose ace editor theme depending on wiki theme (light or dark)
	 */
	function chooseTheme() {
		if (window.wgIsDarkTheme) {
			theme = 'solarized_dark';
		}
	}

	/**
	 * Init modal showing difference between last saved and currently edited code
	 */
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
			ace.showDiff(previewModalConfig, modalCallback);
		});
	}

	/**
	 * Send AJAX request
	 */
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

	/**
	 * Prepare content with difference between last saved and currently edited code
	 *
	 * @param previewModal modal box instance
	 * @param content current edited content
	 */
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

	/**
	 * Change editor mode (narrow/wide)
	 */
	function editorModeChange() {
		if (isEditorWide) {
			$editPage.removeClass(wideClassName).addClass(narrowClassName);
			$editPageToolbar.removeClass('ace-editor-wide');
			ace.getEditorInstance().resize();
			isEditorWide = false;
		} else {
			$editPage.removeClass(narrowClassName).addClass(wideClassName);
			$editPageToolbar.addClass('ace-editor-wide');
			ace.getEditorInstance().resize();
			isEditorWide = true;
		}
	}

	/**
	 * Init ace editor events
	 */
	function initEvents() {
		initSubmit();
		initDiffModal();

		$('.editpage-widemode-trigger').click(editorModeChange);
	}

	return {
		init: init
	};
});
