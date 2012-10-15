/**
 * Provides a basic editor with preview and cancel functionality.
 */
( function( $ ) { $.inlineEditor.editors.basic = {
	
	/**
	 * Creates a new hovering edit field.
	 */
	newField: function( $field, originalClickEvent ) {
		// create a new field
		var $newField = $( '<' + $field.get(0).nodeName + '/>' );
		$newField.addClass( 'editing' );
		
		// position the field floating on the page, at the same position the original field
		$newField.css( 'top', $field.position().top );
		
		// point to the original field using jQuery data 
		$newField.data( 'orig', $field );
		
		// make sure click and mousemove events aren't passed on
		$newField.click( function( event ) { event.stopPropagation(); } );
		$newField.mousemove( function( event ) { event.stopPropagation(); } );
		
		// add the field after the current field in code
		$field.after( $newField );
		return $newField;
	},
	
	/**
	 * Adds an edit bar to the field with preview and cancel functionality.
	 */
	addEditBar: function( $newSpan, wiki ) {
		// build the input field
		var $input = $( '<textarea></textarea>' );
		$input.text( wiki );
		
		// build preview and cancel buttons and add click events
		var $preview = $( '<input type="button" class="preview"/>' );
		$preview.attr( 'value', mediaWiki.msg( 'inline-editor-preview' ) );
		$preview.attr( 'accesskey', mediaWiki.msg( 'accesskey-inline-editor-preview' ) );
		$preview.attr( 'title', mediaWiki.msg( 'tooltip-inline-editor-preview' ) + 
			' [' + mediaWiki.msg( 'accesskey-inline-editor-preview' ) + ']' );
		$preview.click( $.inlineEditor.editors.basic.clickPreview );
		
		var $cancel = $( '<input type="button" class="cancel"/>' );
		$cancel.attr( 'value', mediaWiki.msg( 'inline-editor-cancel' ) );
		$cancel.attr( 'accesskey', mediaWiki.msg( 'accesskey-inline-editor-cancel' ) );
		$cancel.attr( 'title', mediaWiki.msg( 'tooltip-inline-editor-cancel' ) + 
			' [' + mediaWiki.msg( 'accesskey-inline-editor-cancel' ) + ']' );
		$cancel.click( $.inlineEditor.editors.basic.clickCancel );
		
		// fix access key tooltips
		mw.util.updateTooltipAccessKeys( $preview );
		mw.util.updateTooltipAccessKeys( $cancel );
		
		// build a div for the buttons
		var $buttons = $( '<div class="buttons"></div> ');
		$buttons.append( $preview );
		$buttons.append( $cancel );
		
		// build the edit bar from the input field and buttons
		var $editBar = $( '<div class="editbar"></div>' );
		$editBar.append( $input );
		$editBar.append( $buttons );
		
		// append the edit bar to the new span
		$newSpan.append( $editBar );
		
		// automatically resize the textarea using the Elastic plugin
		$input.elastic();
		
		// focus on the input so you can start typing immediately
		$input.focus();
		
		return $editBar;
	},
	
	/**
	 * Default click handler for simple editors.
	 */
	click: function( event ) {
		var $field = $(this);
		
		if( $field.hasClass( 'nobar' ) || event.pageX - $field.offset().left < 10 ) {
			// prevent clicks from reaching other elements
			event.stopPropagation();
			event.preventDefault();
			
			// disable the existing editing field if necessary
			$.inlineEditor.editors.basic.cancel();
			
			$.inlineEditor.editors.basic.show( $field.attr( 'id' ) );
		}
	},
	
	/**
	 * Actually handles showing the editing interface. Recommended to override.
	 * @return Boolean Whether or not showing the interface was successful.
	 */
	show: function( id ) {
		$field = $( '#' + id );
		
		// if the class is incorrect, terminate
		if( !$field.hasClass( 'inlineEditorBasic' ) ) return false;
		
		// find the element and retrieve the corresponding wikitext
		var wiki = $.inlineEditor.getTextById( $field.attr( 'id' ) );
		
		// create the edit field and build the edit bar
		var $newField = $.inlineEditor.editors.basic.newField( $field, $.inlineEditor.editors.basic.click );
		$.inlineEditor.editors.basic.addEditBar( $newField, wiki );
		
		// add the wikiEditor toolbar
		if( $.fn.wikiEditor ) {
			$textarea = $newField.find( 'textarea' );
			
			if( $.wikiEditor.modules.toolbar && $.wikiEditor.modules.toolbar.config && $.wikiEditor.isSupported( $.wikiEditor.modules.toolbar ) ) {
				$textarea.wikiEditor( 'addModule', $.wikiEditor.modules.toolbar.config.getDefaultConfig() );
			}
			
			if( $.wikiEditor.modules.dialogs && $.wikiEditor.modules.dialogs.config && $.wikiEditor.isSupported( $.wikiEditor.modules.dialogs ) ) {
				$.wikiEditor.modules.dialogs.config.replaceIcons( $textarea );
				$textarea.wikiEditor( 'addModule', $.wikiEditor.modules.dialogs.config.getDefaultConfig() );
			}
		}
		return true;
	},
	
	/**
	 * Cancels the current edit operation.
	 */
	clickCancel: function( event ) {
		// prevent clicks from reaching other elements
		event.stopPropagation();
		event.preventDefault();
		
		// find the outer span, three parents above the buttons
		var $span = $(this).parent().parent().parent();
		
		// find the span with the original value
		var $orig = $span.data( 'orig' );
		
		// convert the span to it's original state
		$orig.removeClass( 'orig' );
		$orig.removeClass( 'hover' );
		
		// place the original span after the current span and remove the current span
		$span.after( $orig );
		$span.remove();
		
		// reload the editor to fix stuff that might or might not be broken
		$.inlineEditor.reload();
	},
	
	/**
	 * Previews the current edit operation.
	 */
	clickPreview: function( event ) {
		// prevent clicks from reaching other elements
		event.stopPropagation();
		event.preventDefault();
		
		// find the span with class 'editbar'
		var $editbar = $(this).closest( '.editbar' );
		
		// the element is one level above the editbar
		var $element = $editbar.parent(); 
		
		// add a visual indicator to show the preview is loading 
		$element.addClass( 'saving' );
		var $overlay = $( '<div class="overlay"><div class="alpha"></div><img class="spinner" src="' + wgScriptPath + '/extensions/InlineEditor/ajax-loader.gif"/></div>' );
		$editbar.after( $overlay );
		
		// get the edited text and the id to save it to
		var text = $editbar.find( 'textarea' ).val();
		var id   = $element.data( 'orig' ).attr( 'id' );
		
		// let the inlineEditor framework handle the preview
		$.inlineEditor.previewTextById( text, id );
	},
	
	/**
	 * Reload the editor.
	 */
	reload: function() {
		$.inlineEditor.editors.basic.bindEvents( $( '.inlineEditorBasic' ) );
	},
	
	/**
	 * Cancel all basic editors.
	 */
	cancel: function() {
		$('.editing').find('.cancel').click();
	},
	
	/**
	 * Bind all required events.
	 */
	bindEvents: function( $elements ) {
		$elements.unbind();
		$elements.click( $.inlineEditor.editors.basic.click );
		$elements.mousemove( $.inlineEditor.editors.basic.mouseMove );
		$elements.mouseleave( $.inlineEditor.editors.basic.mouseLeave );
	},
	
	/**
	 * Do a javascript hover on the bars at the left.
	 */
	mouseMove: function( event ) {
		var $field = $( this );
		if( $field.hasClass( 'bar' ) ) {
			if( event.pageX - $field.offset().left < 10 ) {
				$field.addClass( 'hover' );
			}
			else {
				$field.removeClass( 'hover' );
			}
		}
	},
	
	/**
	 * Remove the hover class when leaving the element.
	 */
	mouseLeave: function( event ) {
		var $field = $( this );
		if( $field.hasClass( 'bar' ) ) {
			$field.removeClass( 'hover' );
		}
	}

}; } ) ( jQuery );
