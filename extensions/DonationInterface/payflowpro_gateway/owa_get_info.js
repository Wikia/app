window.get_owa_information = function() {
	if(OWA.util.getState){
		jQuery("input[name=owa_session]").val( OWA.util.getState('s', 'sid') );
		   jQuery("input[name=owa_ref]").val( escape(window.location) );
	}
};
if(jQuery){jQuery(document).ready(get_owa_information);}
