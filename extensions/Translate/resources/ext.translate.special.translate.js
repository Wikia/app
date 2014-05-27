jQuery( function( $ ) {
	"use strict";
	var mw = mediaWiki;

	// BC for MW < 1.18
	if ( !mw.util.wikiScript ) {
		mw.util.wikiScript = function( str ) {
			return mw.config.get( 'wgScriptPath' ) + '/' + ( str || 'index' ) + mw.config.get( 'wgScriptExtension' );
		};
	}

	var $submit = $( "input#mw-translate-workflowset" );
	var $select = $( "#mw-sp-translate-workflow select" );
	$select.find( "option[value=]" ).attr( "disabled", "disabled" );

	var submitFunction = function( event ) {
		var successFunction = function( data, textStatus ) {
			if ( data.error ) {
				$submit.val( mw.msg( "translate-workflow-set-do" ) );
				$submit.attr( "disabled", false );
				alert( data.error.info );
			} else {
				$submit.val( mw.msg( "translate-workflow-set-done" ) );
				$select.find( "option[selected]" ).attr( "selected", false );
				$select.find( "option[value=" + event.data.newstate +"]" ).attr( "selected", "selected" );
			}
		};

		$submit.attr( "disabled", "disable" );
		$submit.val( mw.msg( "translate-workflow-set-doing" ) );
		var params = {
			action: "groupreview",
			token: $submit.data( "token" ),
			group: $submit.data( "group" ),
			language: $submit.data( "language" ),
			state: event.data.newstate,
			format: "json"
		};
		$.post( mw.util.wikiScript( "api" ), params, successFunction );
	};

	$select.change( function( event ) {
		var current = $(this).find( "option[selected]" ).val();
		var tobe = event.target.value;

		$submit.val( mw.msg( "translate-workflow-set-do" ) );
		$submit.unbind( "click" );
		if ( current !== tobe ) {
			$submit.css( "visibility", "visible" );
			$submit.attr( "disabled", false );
			$submit.click( { newstate: tobe }, submitFunction );
		} else {
			$submit.attr( "disabled", "disabled" );
		}
	} );
} );
