	function requestResponse_old(response,id) {
		var url = "/index.php?title=Special:UserRelationshipAction&action=1";
		var pars = 'response=' + response + '&id=' + id
		Element.hide('request_action_'+id)
		var myAjax = new Ajax.Updater (
			'request_action_'+id, url, {
				method: 'post', 
				parameters: pars,
				onSuccess: function(originalRequest) {
					Effect.Appear('request_action_'+id,{duration:2.0} );
			}
		});
	}

	function requestResponse(response,id) {
		var url = "/index.php?title=Special:UserRelationshipAction&action=1";
		var params = 'response=' + response + '&id=' + id

		var callback = {
			success: function( oResponse ) {
				var div = document.getElementById( 'request_action_'+id );
				div.innerHTML = oResponse.responseText;
			},		
    		failure: function( oResponse ) {
				var div = document.getElementById( 'request_action_'+id );
				div.innerHTML = 'Failed: ' + oResponse.responseText;
    		}
		};

        var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, params);
	}
