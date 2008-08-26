var posted = 0;


function add_status(){
	if($("user_status_text").value && !posted){
		posted = 1;
		var url = "index.php?action=ajax";
		var pars = 'rs=wfAddUserStatusNetwork&rsargs[]=' + __sport_id__ + '&rsargs[]=' + __team_id__ + '&rsargs[]=' + escape($("user_status_text").value) + '&rsargs[]=' + __updates_show__

		var callback = {
			success: function( oResponse ) {
				posted = 0;
				window.location=__redirect_url__;
				 
			}
		}
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);	

	}
}
			

function delete_message(id){
	if(confirm('Are you sure you want to delete this status message?')){
		var url = "index.php?action=ajax";
		var pars = 'rs=wfDeleteUserStatus&rsargs[]=' + id

		var callback = {
			success: function( oResponse ) {
				window.location= wgArticlePath.replace("$1",'Special:UserStatus');
			}
		}

	}
	
	var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);	
	
}
