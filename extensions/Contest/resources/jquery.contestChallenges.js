/**
 * JavasSript for the Contest MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

( function ( $, mw ) { $.fn.contestChallenges = function( challenges, config ) {

	this.challenges = challenges;
	this.config = config;

	var _this = this;
	var $this = $( this );

	this.challengesList = null;

	this.addChallenge = function( challenge ) {
		this.challengesList
			.append(
				$( '<li class="mw-codechallenge-box-outside"></li>' )
					.click( function( e ) {
						var box = $(this);
						if ( !box.hasClass( 'mw-codechallenge-box-selected' ) ) {
							$( '.mw-codechallenge-popup' ).not( box ).fadeOut( 'fast' );
							$( '.mw-codechallenge-box-selected' ).removeClass( 'mw-codechallenge-box-selected' );
							box
								.addClass( 'mw-codechallenge-box-selected' )
								.find( '.mw-codechallenge-popup' )
								.fadeIn( 'fast' );
							$(document).one( 'click', function() {
								box
									.removeClass( 'mw-codechallenge-box-selected' )
									.find( '.mw-codechallenge-popup' )
									.fadeOut( 'fast' );
							} );
							e.stopPropagation();
						}
					} )
					.append(
						$( '<div class="mw-codechallenge-box-inside"></div>' )
							.append( '<div class="mw-codechallenge-box-top"></div>' )
							.append(
								$('<div class="mw-codechallenge-box-text"></div>' )
									.append(
										$( '<h4 class="mw-codechallenge-box-title"></h4>' )
											.text( challenge.title )
									)
									.append(
										$( '<p class="mw-codechallenge-box-desc">' )
											.text( challenge.oneline )
									)
							)
							.append(
								$( '<div class="mw-codechallenge-popup"><div>' )
									.click( function( e ) {
										e.stopPropagation();
									} )
									.append( '<div class="mw-codechallenge-popup-callout"></div>' )
									.append( challenge.text )
									.append(
										$( '<div class="mw-codechallenge-popup-buttons"></div>' )
											.append(
												$( '<button class="ui-button-green"></button>' )
													// TODO: Internationalize this!
													.text( mw.msg( 'contest-welcome-accept-challenge' ) )
													.button()
													.click( function() {
														window.location = challenge.target;
													} )
											)
									)
							)
					)
			);
	}

	this.initChallenges = function() {
		this.challengesList = $( '<ul />' ).attr( 'id', 'contest-challenges-list' );

		for ( var i in this.challenges ) {
			this.addChallenge( this.challenges[i] );
		}
	};

	this.init = function() {
		$this.html( $( '<h3 />' ).text( mw.msg( 'contest-welcome-select-header' ) ) );

		this.initChallenges();

		$this.append( this.challengesList );
	};

	this.init();

	return this;

}; } )( window.jQuery, window.mediaWiki );
