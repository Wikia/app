( function( $ ) {
	$.TradeTrack = {
		
		'fn' : {
			'init': function( $$options ) {
				$j( '.tradetrack-field-hint' ).tipsy( { gravity : 'se', opacity: '0.9' } );
				$j( '#tradetrack-elements-usage-textarea' ).NobleCount('#tradetrack-elements-usage-count', { 
					max_chars: 5000,
					on_positive: function(t_obj, char_area, c_settings, char_rem){
						$(char_area).removeClass( 'tradetrack-toomany' );
					},
					on_negative: function(t_obj, char_area, c_settings, char_rem){
						$(char_area).addClass( 'tradetrack-toomany' );
					}
				});
				$j( '#tradetrack-elements-mailingaddress-textarea' ).NobleCount('#tradetrack-elements-mailingaddress-count', { 
					max_chars: 5000,
					on_positive: function(t_obj, char_area, c_settings, char_rem){
						$(char_area).removeClass( 'tradetrack-toomany' );
					},
					on_negative: function(t_obj, char_area, c_settings, char_rem){
						$(char_area).addClass( 'tradetrack-toomany' );
					}
				});
			},
		}
	};
	$( document ).ready( function () {
		$.TradeTrack.fn.init( );
	} ); //document ready
} )( jQuery );
