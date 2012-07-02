/**
 * JavasSript for the Contest MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) {

	function addChallengeToRemove( id ) {
		if ( !isNaN( id ) ) {
			var currentVal = $( '#delete-challenges' ).val();

			var currentIds = currentVal !== ''  ? currentVal.split( '|' ) : [];
			currentIds.push( id );

			$( '#delete-challenges' ).val( currentIds.join( '|' ) );
		}
	}

	$.fn.mwChallenge = function( options ) {

		var _this = this;
		var $this = $( this );
		this.options = options;

		this.titleInput = null;
		this.textInput = null;
		this.deleteButton = null;

		this.remove = function() {
			addChallengeToRemove( $this.attr( 'data-challenge-id' ) );

			$tr = $this.closest( 'tr' );
			$tr.slideUp( 'fast', function() { $tr.remove(); } );
		};

		this.init = function() {
			$this.html( '' );

			this.titleInput = $( '<input />' ).attr( {
				'type': 'text',
				'name': 'contest-challenge-' + $this.attr( 'data-challenge-id' ),
				'size': 45
			} ).val( $this.attr( 'data-challenge-title' ) );

			$this.append(
				$( '<div />' ).html(
					$( '<label />' )
						.text( mw.msg( 'contest-edit-challenge-title' ) )
						.attr( 'for', 'contest-challenge-' + $this.attr( 'data-challenge-id' ) )
				).append( '&#160;' ).append( this.titleInput )
			);

			this.onelineInput = $( '<input />' ).attr( {
				'type': 'text',
				'name': 'challenge-oneline-' + $this.attr( 'data-challenge-id' ),
				'size': 45,
				'style': 'margin-top: 3px'
			} ).val( $this.attr( 'data-challenge-oneline' ) );

			$this.append(
				$( '<div />' ).html(
					$( '<label />' )
						.text( mw.msg( 'contest-edit-challenge-oneline' ) )
						.attr( { 'for': 'contest-oneline-' + $this.attr( 'data-challenge-id' ) } )
				).append( '&#160;' ).append( this.onelineInput )
			);

			this.textInput = $( '<textarea />' ).attr( {
				'name': 'challenge-text-' + $this.attr( 'data-challenge-id' )
			} ).val( $this.attr( 'data-challenge-text' ) );

			$this.append(
				$( '<div />' ).html(
					$( '<label />' )
						.text( mw.msg( 'contest-edit-challenge-text' ) )
						.attr( 'for', 'challenge-text-' + $this.attr( 'data-challenge-id' ) )
				).append( '<br />' ).append( this.textInput )
			);

			if ( mw.config.get( 'ContestDeletionEnabled' ) ) {
				this.deleteButton = $( '<button />' )
					.button( { 'label': mw.msg( 'contest-edit-delete' ) } )
					.click( function() {
						if ( confirm( mw.msg( 'contest-edit-confirm-delete' ) ) ) {
							_this.remove();
							return false;
						}
					} );
				$this.append( this.deleteButton );
			}
		};

		this.init();

		return this;

	};

	var newNr = 0;
	var $table = null;

	function getNewChallengeMessage() {
		return mw.msg( 'contest-edit-add-' + ( $( '.contest-challenge-input' ).size() === 0 ? 'first' : 'another' ) );
	}

	function addChallenge( challenge ) {
		$challenge = $( '<div />' ).attr( {
			'class': 'contest-challenge-input',
			'data-challenge-id': challenge.id,
			'data-challenge-title': challenge.title,
			'data-challenge-text': challenge.text,
			'data-challenge-oneline': challenge.oneline
		} );

		$tr = $( '<tr />' );

		$tr.append( $( '<td />' ) );

		$tr.append( $( '<td />' ).html( $challenge ).append( '<hr />' ) );

		$( '.add-new-challenge' ).before( $tr );

		$challenge.mwChallenge();
	}

	$( document ).ready( function() {

		$( '#cancelEdit' ).click( function() {
			window.location = $( this ).attr( 'target-url' );
		} );

		$table = $( '#contest-name-field' ).closest( 'tbody' );

		$( '#bodyContent' ).find( '[type="submit"]' ).button();

		$table.append( '<tr><td colspan="2"><hr /></td></tr>' );

		$addNew = $( '<button />' ).button( { 'label': getNewChallengeMessage() } ).click( function() {
			addChallenge( {
				'id': 'new-' + newNr++ ,
				'title': '',
				'text': ''
			} );

			$( this ).button( { 'label': getNewChallengeMessage() } );

			return false;
		} );

		$table.append( $( '<tr />' ).attr( 'class', 'add-new-challenge' ).html( $( '<td />' ) ).append( $( '<td />' ).html( $addNew ) ) );

		$table.append( '<tr><td colspan="2"><hr /></td></tr>' );

		$( '.contest-challenge' ).each( function( index, domElement ) {
			$this = $( domElement );
			addChallenge( {
				'id': $this.attr( 'data-challenge-id' ),
				'title': $this.attr( 'data-challenge-title' ),
				'text': $this.attr( 'data-challenge-text' ),
				'oneline': $this.attr( 'data-challenge-oneline' )
			} );
		} );

		$( '#contest-edit-end' ).datetimepicker( {
			minDate: new Date(),
			dateFormat: 'yy-mm-dd'
		} );

	} );

})( window.jQuery, window.mediaWiki );
