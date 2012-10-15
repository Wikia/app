/**
 * Javascript code to be used with input type datepicker.
 *
 * @author Stephan Gambke
 *
 */


function SFI_DTP_init ( inputId, params ) {

	var input = jQuery( '#' + inputId );
	
	var hiddenInput = jQuery( '<input type="hidden" >' );
	
	hiddenInput.attr( {
		id: inputId,
		name: input.attr( 'name' ),
		value: input.val()
	} );

	input.replaceWith( hiddenInput );
	input = hiddenInput;
	
	// create and insert subinput elements
	var subinputs = jQuery( params.subinputs );	
	input.before( subinputs );
	
	// call initialisation functions for subinputs
	for (var subinputId in params.subinputsInitData) {
		
		for ( var index in params.subinputsInitData[subinputId] ) {
			
			var fn = window[ params.subinputsInitData[subinputId][index]['name'] ];
			var param = JSON.parse( params.subinputsInitData[subinputId][index]['param'] );
		
			if ( typeof fn === 'function' )	{
				fn( subinputId, param );
			}
		}
	}
		
	var dp = jQuery( '#' + inputId + '_dp_show' ); // datepicker element
	var tp = jQuery( '#' + inputId + '_tp_show' ); // timepicker element

	dp.add(tp)
	.change (function(){
		
		var date;
		
		// try parsing the date value
		try {
			
			date = jQuery.datepicker.parseDate( dp.datepicker( 'option', 'dateFormat' ), dp.val(), null );				
			date = jQuery.datepicker.formatDate( dp.datepicker( 'option', 'altFormat' ), date );
			
		} catch ( e ) {
			// value does not conform to specified format
			// just return the value as is
			date = dp.val();
		}
		
		input.val( jQuery.trim( date + ' ' + tp.val() ) );
		
	});

	if ( params.resetButtonImage  ) {

		if ( params.disabled ) {
			
			// append inert reset button if image is set
			tp.parent().append('<button type="button" class="ui-datetimepicker-trigger' + params.userClasses + '" disabled><img src="' + params.resetButtonImage + '" alt="..." title="..."></button>');
			
		} else {
			
			var resetbutton = jQuery('<button type="button" class="ui-datetimepicker-trigger ' + params.userClasses + '" ><img src="' + params.resetButtonImage + '" alt="..." title="..."></button>');
			input.before( resetbutton );
			
			resetbutton.click( function(){
				
				dp.datepicker( 'setDate', null);
				tp.val( '' );
				input.val( '' );
				
			});
		}
	}

}