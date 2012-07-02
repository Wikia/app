/**
 * Client side framework of the InlineEditor. Facilitates publishing, previewing,
 * using specific editors, and undo/redo operations.
 */
( function( $ ) { $.inlineEditor = {
	editors: {},
	
	states: [], // history of all the states (HTML and original wikitexts)
	currentState: 0, // state that is currently viewed
	lastState: 0, // last state in the history
	publishing: false, // whether or not currently publishing
	
	/**
	 * Adds the initial state from the current HTML and a wiki string.
	 */
	addInitialState: function( state ) {
		$.inlineEditor.currentState = 0;
		$.inlineEditor.states[$.inlineEditor.currentState] = { 
			'object': state.object,
			'texts': state.texts,
			'html': $( '#editContent' ).html()
		};
	},
	
	/**
	 * Returns wikitext in the current state given an ID.
	 */
	getTextById: function( id ) {
		return $.inlineEditor.states[$.inlineEditor.currentState].texts[id];
	},
	
	/**
	 * Previews given a new text for a given field by ID.
	 */
	previewTextById: function( text, id ) {
		// send out an AJAX request which will be handled by addNewState()
		var data = {
				'object': $.inlineEditor.states[$.inlineEditor.currentState].object,
				'lastEdit': { 'id': id, 'text': text }
		};
		
		var args = [ $.toJSON( data ), wgPageName ];
		sajax_request_type = 'POST';
		sajax_do_call( 'InlineEditor::ajaxPreview', args, $.inlineEditor.addNewState );
	},
	
	/**
	 * Adds a new state from an AJAX request.
	 */
	addNewState: function( request ) {
		var state = $.parseJSON( request.responseText );
		
		// restore the html to the current state, instantly remove the lastEdit,
		// and then add the new html
		$( '#editContent' ).html( $.inlineEditor.states[$.inlineEditor.currentState].html );
		$( '.lastEdit' ).removeClass( 'lastEdit' );
		$( '#' + state.partialHtml.id ).replaceWith( state.partialHtml.html );
		
		// add the new state
		$.inlineEditor.currentState += 1;
		$.inlineEditor.states[$.inlineEditor.currentState] = { 
			'object': state.object,
			'texts': state.texts,
			'html': $( '#editContent' ).html()
		};
		
		// clear out all states after the current state, because undo/redo would be broken
		var i = $.inlineEditor.currentState + 1;
		while( i <= $.inlineEditor.lastState ) {
			delete $.inlineEditor.states[i];
			i += 1;
		}
		$.inlineEditor.lastState = $.inlineEditor.currentState;
		
		// reload the current editor and update the edit counter
		$.inlineEditor.reload();
		$.inlineEditor.updateEditCounter();
	},
	
	/**
	 * Cancels any open editor.
	 */
	cancel: function() {
		for( var optionNr in $.inlineEditor.editors ) {
			$.inlineEditor.editors[optionNr].cancel();
		}
	},
	
	/**
	 * Reloads the current editor and finish some things in the HTML.
	 */
	reload: function() {
		// cancel all editing
		$.inlineEditor.cancel();
		
		// reload the editors
		for( var optionNr in $.inlineEditor.editors ) {
			$.inlineEditor.editors[optionNr].reload();
		}
		
		// remove all lastEdit elements
		$('.lastEdit').removeClass( 'lastEdit' );
		
		// make the links in the article unusable
		$( '#editContent a' ).click( function( event ) { event.preventDefault(); } );
	},
	
	/**
	 * Moves back one state.
	 */
	undo: function( event ) {
		event.stopPropagation();
		event.preventDefault();
		
		// check if we can move backward one state and do it
		if( $.inlineEditor.currentState > 0 ) {
			$.inlineEditor.currentState -= 1;
			$( '#editContent' ).html( $.inlineEditor.states[$.inlineEditor.currentState].html );
			$.inlineEditor.reload();
		}
		
		// refresh the edit counter regardless of actually switching, this confirms
		// that the button works, even if there is nothing to switch to
		$.inlineEditor.updateEditCounter();
	},
	
	/**
	 * Moves forward one state.
	 */
	redo: function( event ) {
		event.stopPropagation();
		event.preventDefault();
		
		// check if we can move forward one state and do it
		if( $.inlineEditor.currentState < $.inlineEditor.lastState ) {
			$.inlineEditor.currentState += 1;
			$('#editContent').html( $.inlineEditor.states[$.inlineEditor.currentState].html );
			$.inlineEditor.reload();
		}
		
		// refresh the edit counter regardless of actually switching, this confirms
		// that the button works, even if there is nothing to switch to
		$.inlineEditor.updateEditCounter();
	},
	
	/**
	 * Updates the edit counter and makes it flash.
	 */
	updateEditCounter: function() {
		// update the value of the edit counter
		var $editCounter = $( '#editCounter' );
		$editCounter.text( '#' + $.inlineEditor.currentState );
		
		// remove everything from the editcounter, and have it fade again
		$editCounter.stop(true, true).hide().fadeIn('fast');
	},
	
	/**
	 * Show the interface for a particular element.
	 * @return Boolean Whether or not showing the interface was successful.
	 */
	show: function( id ) {
		// disable the existing editing field if necessary
		$.inlineEditor.editors.basic.cancel();
		
		// try the show function of all editors
		for( var optionNr in $.inlineEditor.editors ) {
			if( $.inlineEditor.editors[optionNr].show( id ) ) return true;
		}
		return false;
	},
	
	/**
	 * Submit event, adds the json to the hidden field
	 */
	submit: function( event ) {
		$.inlineEditor.publishing = true;
		
		// get the wikitext from the state as it's currently on the screen
		var data = {
				'object': $.inlineEditor.states[$.inlineEditor.currentState].object
		};
		var json = $.toJSON( data );
		
		// set and send the form
		$( '#json' ).val( json );
	},
	
	/**
	 * Publishes the document
	 */
	publish: function() {
		$( '#editForm' ).submit();
	},
	
	warningMessage: function( ) {	
		if ( $.inlineEditor.lastState > 0 && !$.inlineEditor.publishing ) {
			return mediaWiki.msg( 'vector-editwarning-warning' );
		}
	},
	
	enableEditWarning: function( ) {
		window.onbeforeunload = $.inlineEditor.warningMessage;
	},
	
	/**
	 * Initializes the editor.
	 */
	init : function() {
		$( '#editForm' ).submit( $.inlineEditor.submit );
		$( '#publish' ).click( $.inlineEditor.publish );
		mw.util.updateTooltipAccessKeys( $( '#publish' ) );
		
		if( $( '#advancedbox' ).size() > 0 ) {
			$( '#undo' ).click( $.inlineEditor.undo );
			mw.util.updateTooltipAccessKeys( $( '#undo' ) );
			
			$( '#redo' ).click( $.inlineEditor.redo );
			mw.util.updateTooltipAccessKeys( $( '#redo' ) );
		}
		
		// reload the current editor
		$.inlineEditor.reload();
	}

}; } ) ( jQuery );
