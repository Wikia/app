/* firefox 3.6 drag-drop uploading
*
* Note: this file is still under development
*/
mw.addMessages( {
	"mwe-upload-multi" : "Upload {{PLURAL:$1|file|files}}",
	"mwe-review-upload": "Review file {{PLURAL:$1|upload|uploads}}"
} );

( function( $ ) {
	$.fn.dragDropFile = function () {
		mw.log( "drag drop: " + this.selector );
		// setup drag binding and highlight
		var dC = $( this.selector ).get( 0 );
		dC.addEventListener( "dragenter",
			function( event ) {
				$( dC ).css( 'border', 'solid red' );
				event.stopPropagation();
				event.preventDefault();
			}, false );
		dC.addEventListener( "dragleave",
			function( event ) {
				// default textbox css (should be an easy way to do this)
				$( dC ).css( 'border', '' );
				event.stopPropagation();
				event.preventDefault();
			}, false );
		dC.addEventListener( "dragover",
			function( event ) {
				event.stopPropagation();
				event.preventDefault();
			}, false );
		dC.addEventListener( "drop",
			function( event ) {
				doDrop( event );
				// handle the drop loader and call event
			}, false );
		function doDrop( event ) {
			var dt = event.dataTransfer,
				files = dt.files,
				fileCount = files.length;

			event.stopPropagation();
			event.preventDefault();

			$( '#multiple_file_input' ).remove();

			$( 'body' ).append(
				$('<div />')
				.attr( {
					'title' : gM( 'mwe-upload-multi', fileCount ),
					'id' : 'multiple_file_input'
				} )
				.css({
					'position' : 'absolute',
					'bottom' : '5em',
					'top' : '3em',
					'right' : '0px',
					'left' : '0px'
				})
			);


			var buttons = { };
			buttons[ gM( 'mwe-cancel' ) ] = function() {
				$( this ).dialog( 'close' );
			}
			buttons[ gM( 'mwe-upload-multi', fileCount ) ] = function() {
				alert( 'do multiple file upload' );
			}
			// open up the dialog
			$( '#multiple_file_input' ).dialog( {
				bgiframe: true,
				autoOpen: true,
				modal: true,
				draggable:false,
				resizable:false,
				buttons : buttons
			} );
			$( '#multiple_file_input' ).dialogFitWindow();
			$( window ).resize( function() {
				$( '#multiple_file_input' ).dialogFitWindow();
			} );
			// add the inital table / title:
			$( '#multiple_file_input' ).empty().html(
				$('<h3 />')
				.text( gM( 'mwe-review-upload' ) ),

				$( '<table />' )
				.attr({
					'width' : "100%",
					'border' : "1",
					'border' : 'none'
				})
				.addClass( 'table_list' )
			);

			$.each( files, function( i, file ) {
				if ( file.fileSize < 64048576 ) {
					$( '#multiple_file_input .table_list' ).append(
						$('<tr />').append(
							$('<td />').css({
								'width': '300px',
								'padding' : '5px'
							}).append(
								$('<img />').attr( {
									'width' : '250',
									'src' : file.getAsDataURL()
								} )
							),

							$('<td />')
							.attr('valign', 'top')
							.append(
								'File Name: <input name="file[' + i + '][title]" value="' + file.name + '"><br>' +
								'File Desc: <textarea style="width:300px;" name="file[' + i + '][desc]"></textarea><br>'
							)
						)
					)
					// do the add-media-wizard with the upload tab
				} else {
					alert( "file is too big, needs to be below 64mb" );
				}
			} );
		}
	}
} )( jQuery );
