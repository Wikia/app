	function requestResponse(response,id){
		var url = "index.php?action=ajax&rs=wfRelationshipRequestResponse&rsargs[]=" + response + "&rsargs[]=" + id;
		$( '#request_action_' + id ).hide();

		$.ajax({ url: url, context: document.body, success: function( data ) {
				$( '#request_action_' + id ).html( data );
				$( '#request_action_' + id ).show( 2 );
			}
		});
	}	
	
