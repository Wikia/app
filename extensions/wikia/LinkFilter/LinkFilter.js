function link_action(action,link_id){
	
	fadeOut = new YAHOO.widget.Effects.Fade( "action-buttons");
	var url = "index.php?action=ajax";
	var pars = 'rs=wfLinkFilterStatus&rsargs[]=' + link_id + '&rsargs[]=' + action;
	var callback = {
		success: function( oResponse ) {
			
			switch(action){
				case 1: 
					msg = _ACCEPT_SUCCESS;
					break;
				case 2:
					msg = _REJECT_SUCESS;
					break;
			}
			appear = new YAHOO.widget.Effects.Appear( "action-buttons-" + link_id);
			$("action-buttons-" + link_id).innerHTML = msg
		}
	};
	var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
}