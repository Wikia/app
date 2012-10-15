( function ( $ ) {

	$.kieli = {
		loaded: false,
	
		setup: function() {
			$.kieli.addMenuLabel();
		},
	
		set: function( val ) {
			var recent = $.cookie( 'kieli-recent' ) || [];
			if ( typeof recent === "string" ) {
				recent = recent.split( "," );
			}
			recent.unshift( val );
			recent = recent.slice( 0, 5 );
			recent = recent.join( "," );
			
			$.cookie( 'kieli-recent', recent, { 'path': '/', 'expires': 30 } );
			var uri = new mw.Uri( window.location.href );
			uri.extend( { setlang: val } );
			window.location.href = uri.toString();
		},
	
		setCustom: function( event, data ) {
			$.kieli.set( data.item.value );
		},
	
		loadMenu: function() {
			if ( $.kieli.loaded ) {
				return;
			}
			$.kieli.loaded = true;
			
			var params = {
				action: "query",
				meta: "userinfo",
				uiprop: "acceptlang",
				format: "json"
			};
			$.get( mw.util.wikiScript( "api" ), params, $.kieli.buildMenu );
			
			params = {
				action: "query",
				meta: "siteinfo",
				siprop: "languages",
				format: "json"
			};
			$.get( mw.util.wikiScript( "api" ), params, $.kieli.buildLanguageInput );
		},
	
		buildLanguageInput: function( result ) {
			var langlist = [];
			var languages = result.query.languages;
			var localnames = mw.config.get( "wgKieliLanguages" );
			for ( var i = 0; i < languages.length; i++ ) {
				var name = languages[i]["*"];
				var code = languages[i].code;
				if ( localnames[code] && localnames[code] !== name  ) {
					var localnamecode = localnames[code] + " (" + code + ")";
					langlist.push( { label: localnamecode, value: code } );
				}
				var namecode = name + " (" + code + ")";
				langlist.push( { label: namecode, value: code } );
			}
			
			var $list = $( "#pt-kieli .lt-list ul" );
			var $input = $( "<input />" )
				.attr( "placeholder", "Search all languages..." );
			$input.autocomplete({
				source: langlist,
				select: $.kieli.setCustom
			});
			
			$list.prepend( $input );
		},
	
		buildMenu: function( result ) {
			var $menu = $( "#pt-kieli .lt-list" );
			var $list = $( "<ul />" );
			$menu.append( $list );
			
			var count = 1;
			var seen = [];
			
			var current = mw.config.get( "wgUserLanguage" );
			$list.append( $.kieli.createMenuItem( current ) );
			seen.push( current );
			
			var recent = $.cookie( "kieli-recent" ) || [];
			if ( typeof recent === "string" ) {
				recent = recent.split( "," );
			}
			for ( var i = 0; i < recent.length; i++ ) {
				var id = recent[i];
				if ( $.inArray( id, seen ) > -1 ) { continue; }
				seen.push( id );
				if ( count++ >= 5 ) { continue; }
				$list.append( $.kieli.createMenuItem( id ) );
			}
			
			var languages = result.query.userinfo.acceptlang;
			for ( var i = 0; i < languages.length; i++ ) {
				var id = languages[i]["*"];
				if ( $.inArray( id, seen ) > -1 ) { continue; }
				seen.push( id );
				if ( count++ >= 5 ) { continue; }
				$list.append( $.kieli.createMenuItem( id ) );
			}
			
			$list.delegate('input:radio', 'change', function( event ) {
				$.kieli.set( $(this).val() );
			});
		},
	
		createMenuItem: function( id ) {
			var current = mw.config.get( "wgUserLanguage" );
			var names = mw.config.get( "wgKieliLanguages" );
			var name = names && names[id] || id;
			
			var $link = $( '<input type="radio" name="language" />' )
				.val( id );
			if ( id === current ) {
				$link = $link.attr( "checked", true );
			}
			var $label =  $( "<label />" )
				.append( $link )
				.append( name );
			var $menuItem = $( "<li />" ).append( $label );
			return $menuItem;
		},

		addMenuLabel: function(config) {
			var $menuDiv = $( '<div />' )
				.addClass( 'menu' )
				.addClass( 'lt-list' )
				.append();

			var $div = $( '<div />' )
				.addClass( 'lt-menu-kieli' )
				.addClass( 'lt-menu' )
				.append( $('<a href="#" />').append(mw.msg("kieli-load")) )
				.append( $menuDiv )
				.hover( $.kieli.loadMenu );

			//this is the fonts link
			var $li = $( '<li />' ).attr('id','pt-kieli')
				.append( $div );

			//if rtl, add to the right of top personal links. Else, to the left
			var fn = $('body').hasClass( 'rtl' ) ? "append" : "prepend";
			$('#p-personal ul:first')[fn]( $li );
			//workaround for IE bug - activex components like input fields coming on top of everything.
			//TODO: is there a better solution other than hiding it on hover?
			if ( $.browser.msie ) { 
				$("#pt-kieli .lt-menu").hover(function(){
					$("#searchform").css({ visibility: "hidden" });
				},function(){
					$("#searchform").css({ visibility: "visible" });
				});
			}
		}
	};
	
	$( document ).ready( function() {
		$.kieli.setup();
	} );
	
} )( jQuery );