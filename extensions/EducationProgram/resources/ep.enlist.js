/**
 * JavasSript for the Education Program MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Education_Program
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) {

	var ep = mw.educationProgram;

	$( document ).ready( function() {
		
		$( '.ep-remove-role' ).click( function( event ) {
			var $this = $( this ),
			courseId = $this.attr( 'data-courseid' ),
			courseName = $this.attr( 'data-coursename' ),
			userId = $this.attr( 'data-userid' ),
			userName = $this.attr( 'data-username' ),
			bestName = $this.attr( 'data-bestname' ),
			role = $this.attr( 'data-role' ),
			$dialog = undefined;
			
			var doRemove = function() {
				var $remove = $( '#ep-' + role + '-remove-button' );
				var $cancel = $( '#ep-' + role + '-cancel-button' );

				$remove.button( 'option', 'disabled', true );
				$remove.button( 'option', 'label', ep.msg( 'ep-' + role + '-removing' ) );

				ep.api.unenlistUser( {
					'courseid': courseId,
					'userid': userId,
					'reason': summaryInput.val(),
					'role': role
				} ).done( function() {
					$dialog.text( ep.msg( 'ep-' + role + '-removal-success' ) );
					$remove.remove();
					$cancel.button( 'option', 'label', ep.msg( 'ep-' + role + '-close-button' ) );
					$cancel.focus();

					$li = $this.closest( 'li' );
					$ul = $li.closest( 'ul' );
					$li.remove();

					if ( $ul.find( 'li' ).length < 1 ) {
						$ul.closest( 'div' ).text( mw.msg( 'ep-course-no-' + role ) );
					}
				} ).fail( function() {
					$remove.button( 'option', 'disabled', false );
					$remove.button( 'option', 'label', ep.msg( 'ep-' + role + '-remove-retry' ) );
					alert( ep.msg( 'ep-' + role + '-remove-failed' ) );
				} );
			};

			var summaryLabel = $( '<label>' ).attr( {
				'for': 'epenlistsummary'
			} ).msg( 'ep-' + role + '-summary' ).append( '&#160;' );
			
			var summaryInput = $( '<input>' ).attr( {
				'type': 'text',
				'size': 60,
				'maxlength': 250,
				'id': 'epenlistsummary'
			} );
			
			$dialog = $( '<div>' ).html( '' ).dialog( {
				'title': ep.msg( 'ep-' + role + '-remove-title' ),
				'minWidth': 550,
				'buttons': [
					{
						'text': ep.msg( 'ep-' + role + '-remove-button' ),
						'id': 'ep-' + role + '-remove-button',
						'click': doRemove
					},
					{
						'text': ep.msg( 'ep-' + role + '-cancel-button' ),
						'id': 'ep-' + role + '-cancel-button',
						'click': function() {
							$dialog.dialog( 'close' );
						}
					}
				]
			} );
			
			$dialog.append( $( '<p>' ).msg(
				'ep-' + role + '-remove-text',
				mw.html.escape( userName ),
				$( '<b>' ).text( bestName ),
				$( '<b>' ).text( courseName )
			) );

			//$dialog.append( $( '<p>' ).msg( 'ep-instructor-remove-title' ) );

			$dialog.append( summaryLabel, summaryInput );
			
			summaryInput.focus();
			
			summaryInput.keypress( function( event ) {
				if ( event.which == '13' ) {
					event.preventDefault();
					doRemove();
				}
			} );
		} );
		
		$( '.ep-add-role' ).click( function( event ) {
			var $this = $( this ), 
			_this = this,
			role = $this.attr( 'data-role' );
			
			this.courseId = $this.attr( 'data-courseid' );
			this.courseName = $this.attr( 'data-coursename' );
			this.selfMode = $this.attr( 'data-mode' ) === 'self';
			this.$dialog = undefined;
			
			this.nameInput = $( '<input>' ).attr( {
				'type': 'text',
				'size': 30,
				'maxlength': 250,
				'id': 'ep-' + role + '-nameinput',
				'name': 'ep-' + role + '-nameinput'
			} );
			
			this.summaryInput = $( '<input>' ).attr( {
				'type': 'text',
				'size': 60,
				'maxlength': 250,
				'id': 'ep-' + role + '-summaryinput',
				'name': 'ep-' + role + '-summaryinput'
			} );

			this.getName = function() {
				return this.selfMode ? mw.user.name : this.nameInput.val();
			};

			this.doAdd = function() {
				var $add = $( '#ep-' + role + '-add-button' );
				var $cancel = $( '#ep-' + role + '-add-cancel-button' );

				$add.button( 'option', 'disabled', true );
				$add.button( 'option', 'label', ep.msg( 'ep-' + role + '-adding' ) );

				ep.api.enlistUser( {
					'courseid': _this.courseId,
					'username': _this.getName(),
					'reason': _this.summaryInput.val(),
					'role': role
				} ).done( function() {
					_this.$dialog.text( ep.msg(
						_this.selfMode ? 'ep-' + role + '-addittion-self-success' : 'ep-' + role + '-addittion-success',
						_this.getName(),
						_this.courseName
					) );

					$add.remove();
					$cancel.button( 'option', 'label', ep.msg( 'ep-' + role + '-add-close-button' ) );
					$cancel.focus();

					// TODO: link name to user page and show control links
					$ul = $( '#ep-course-' + role ).find( 'ul' );

					if ( $ul.length < 1 ) {
						$ul = $( '<ul>' );
						$( '#ep-course-' + role ).html( $ul );
					}

					$ul.append( $( '<li>' ).text( _this.getName() ) )
				} ).fail( function() {
					// TODO: implement nicer handling for fails caused by invalid user name

					$add.button( 'option', 'disabled', false );
					$add.button( 'option', 'label', ep.msg( 'ep-' + role + '-add-retry' ) );
					alert( ep.msg( 'ep-' + role + '-addittion-failed' ) );
				} );
			};

			this.$dialog = $( '<div>' ).html( '' ).dialog( {
				'title': ep.msg( this.selfMode ? 'ep-' + role + '-add-self-title' : 'ep-' + role + '-add-title', this.getName() ),
				'minWidth': 550,
				'buttons': [
					{
						'text': ep.msg(
							this.selfMode ? 'ep-' + role + '-add-self-button' : 'ep-' + role + '-add-button',
							this.getName()
						),
						'id': 'ep-' + role + '-add-button',
						'click': this.doAdd
					},
					{
						'text': ep.msg( 'ep-' + role + '-add-cancel-button' ),
						'id': 'ep-' + role + '-add-cancel-button',
						'click': function() {
							_this.$dialog.dialog( 'close' );
						}
					}
				]
			} );
			
			this.$dialog.append( $( '<p>' ).text( gM(
				this.selfMode ? 'ep-' + role + '-add-self-text' : 'ep-' + role + '-add-text',
				this.courseName,
				this.getName()
			) ) );
			
			if ( !this.selfMode ) {
				this.$dialog.append(
					$( '<label>' ).attr( {
						'for': 'ep-' + role + '-nameinput'
					} ).text( ep.msg( 'ep-' + role + '-name-input' ) + ' ' ),
					this.nameInput,
					'<br />',
					$( '<label>' ).attr( {
						'for': 'ep-' + role + '-summaryinput'
					} ).text( ep.msg( 'ep-' + role + '-summary-input' ) + ' ' )
				);
			}
			
			this.$dialog.append( this.summaryInput );
			
			if ( this.selfMode ) {
				this.summaryInput.focus();
			}
			else {
				this.nameInput.focus();
			}
			
			var enterHandler = function( event ) {
				if ( event.which == '13' ) {
					event.preventDefault();
					_this.doAdd();
				}
			};
			
			this.nameInput.keypress( enterHandler );
			this.summaryInput.keypress( enterHandler );
		} );
		
	} );
	
})( window.jQuery, window.mediaWiki );