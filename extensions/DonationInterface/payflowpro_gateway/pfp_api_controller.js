( function( $ ) {     
		$.getDynamicFormElements = function(){
                var tracking_data = {"url": escape(window.location), "pageref": escape(document.referrer)};

                var processFormElements = function (data, status){
                        $('input[name=order_id]').val(data['dynamic_form_elements']['order_id']);
                        $('input[name=token]').val(data['dynamic_form_elements']['token']);
                        $('input[name=contribution_tracking_id]').val(data['dynamic_form_elements']['contribution_tracking_id']);
                        $('input[name=utm_source]').val(data['dynamic_form_elements']['tracking_data']['utm_source']);
                        $('input[name=utm_medium]').val(data['dynamic_form_elements']['tracking_data']['utm_medium']);
                        $('input[name=utm_campaign]').val(data['dynamic_form_elements']['tracking_data']['utm_campaign']);
                        $('input[name=referrer]').val(data['dynamic_form_elements']['tracking_data']['referrer']);
                        $('input[name=language]').val(data['dynamic_form_elements']['tracking_data']['language']);
                };

                $.post( wgScriptPath + '/api.php?' + Math.random() , {
                            'action' : 'pfp',
                            'dispatch' : 'get_required_dynamic_form_elements',
                            'format' : 'json',
                            'tracking_data' : '{"url": "'+escape(window.location)+
								'", "pageref": "'+escape(document.referrer)+ 
								'", "gateway": "'+escape(document.gateway)+
								'", "payment_method": "'+escape(document.payment_method)+
								'"}'
                        }, processFormElements, 'json' );
        };

        return $( this );

} )( jQuery );

// Do not fire the AJAX request if _nocache_ is set or we are not using a single-step form (known by lack of utm_source_id)
if( String(window.location).indexOf( '_cache_' ) != -1 && String(window.location).indexOf( 'utm_source_id' ) != -1){
	jQuery( document ).ready( jQuery.getDynamicFormElements );
}