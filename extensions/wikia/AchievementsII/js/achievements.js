/*
 *  This file is being used for Special:AchievementsCustomize
 *  There is also skins/oasis/js/Achievements.js
 */

var Achievements = {

	//hover delay (in ms)
	delay: 500,

	init: function () {
		var self = this;

		$( '#view-all' ).click( function () {
			var badgesTotal = $( "#badge-list" ).children().length,
				badgeHeight = Math.ceil( badgesTotal / 3 ) * 100;

			$( '#view-all' ).hide();
			$( '#view-less' ).show();
			$( '.article-sidebar #badges' ).animate( { height: badgeHeight + 'px' }, 'slow' );
		} );

		$( '#view-less' ).click( function () {
			$( '#view-less' ).hide();
			$( '#view-all' ).show();
			$( '.article-sidebar #badges' ).animate( { height: '200px' }, 'slow' );
		} );

		//Show badge description when hovering over the badge
		$( '#challenges li>img, #badge-list li>img, .recent-badges li>img' ).hover( function () {
			$( this ).css( 'position', 'absolute' );
			var badge = $( this ),
				hover = badge.prevAll( '.profile-hover' ),
				hoverPosition = {
				left: -hover.outerWidth() + badge.width() + badge.position().left,
				top: -hover.outerHeight() + badge.position().top + 10
			};

			badge.prev().css( 'right', badge.width() );
			self.timer = setTimeout( function () {
				badge.prevAll( '.profile-hover' )
					.css( 'left', hoverPosition.left )
					.css( 'top', hoverPosition.top )
					.show();
			}, self.delay );
		}, function () {
			$( this ).css( 'position', 'static' );
			clearTimeout( self.timer );
			$( this ).prevAll( '.profile-hover' ).hide();
		} );

		$( '#about-achievements' ).find( 'a' ).click( function ( e ) {
			if ( mw.config.get( 'wgUserName' ) == null ) {
				var callbackLink = $( e.target ).attr( 'href' );
				showComboAjaxForPlaceHolder( false, false, function () {
					AjaxLogin.doSuccess = function () {
						window.location = callbackLink;
					}
				} );
				return false;
			}
		} );
	},

	submitPicture: function ( form ) {
		var inputs = $( form ).find( 'button, input[type=file]' ),
			img = $( form ).prev().children().eq( 0 ),
			handler = form.onsubmit;

		$.AIM.submit( form, {onComplete: function ( response ) {
			$( '#body' ).removeClass( 'ajax' );
			// VOLDEV-50: Reenable buttons after upload is complete
			inputs.removeAttr( 'disabled' );
			form.onsubmit = handler;
			form.reset();

			if ( typeof response.error != 'undefined' ) {
				alert( response.error );
			} else {
				img.attr( 'src', response.output + '?cb=' + Math.random() );
			}
		}} );

		//unbind original html element handler to avoid loops
		form.onsubmit = null;

		$( form ).submit();

		$( '#body' ).addClass( 'ajax' );

		if ( !$.browser.webkit ) {
			inputs.attr( 'disabled', 'disabled' );
		}

		return false;
	},

	revert: function ( o, badge_type, badge_lap ) {
		var img, inputs = $( o ).parent().parent().next().find( 'button, input[type=file]' );
		$( '#body' ).addClass( 'ajax' );

		if ( !$.browser.webkit ) {
			inputs.attr( 'disabled', 'disabled' );
		}

		if ( badge_lap == null && typeof badge_lap === 'undefined' ) {
			badge_lap = '';
		}

		img = $( o ).parent().prev().prev();

		// VOLDEV-50: Reenable buttons after reversion is complete
		$.getJSON( mw.util.wikiScript(), {
				action: 'ajax',
				rs: 'AchAjax',
				method: 'resetBadge',
				'type_id': badge_type,
				lap: badge_lap
			},
			function ( json ) {
				img.attr( 'src', json.output );
				$( '#body' ).removeClass( 'ajax' );
				inputs.removeAttr( 'disabled' );
				alert( json.message );
			} );
	},

	AchPrepareData: function ( createInTrackEditPlusCategory, sectionId ) {
		var dataStore = {
			messages: {},
			statusFlags: {},
			sectionId: (typeof sectionId === 'undefined' ) ? '' : sectionId
		}, json, storeClass;

		$( '.c-message' ).each( function () {
			dataStore.messages[this.name] = this.value;
		} );

		$( '.c-enabled-flags' ).each( function () {
			dataStore.statusFlags[this.name] = this.checked;
		} );

		json = JSON.stringify( dataStore );
		storeClass = '.c-messages';

		if ( createInTrackEditPlusCategory == true ) {
			storeClass = '.c-messages-ec';
		}

		$( storeClass ).val( json );
		return false;
	}
};

wgAfterContentAndJS.push(
	function () {
		$( 'document' ).ready( function () {
			Achievements.init.call( Achievements );
		} );
	} );
