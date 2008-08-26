	function requestResponse(response,id){
		var url = "index.php?action=ajax";
		var pars = 'rs=wfRelationshipRequestResponse&rsargs[]=' + response + '&rsargs[]=' + id
		YAHOO.widget.Effects.Hide('request_action_'+id);
		var callback = {
			success: function( oResponse ) {
				$('request_action_'+id).innerHTML = oResponse.responseText;
				YAHOO.widget.Effects.Appear('request_action_'+id,{duration:2.0} );
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);

	}
