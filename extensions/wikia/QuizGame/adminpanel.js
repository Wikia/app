			
				function deleteById(id, key){
					YAHOO.widget.Effects.Hide('items[' + id + ']');
					
					var url = "index.php?action=ajax";
					var pars = 'rs=wfQuestionGameAdmin&rsargs[]=deleteItem&rsargs[]=' + key + '&rsargs[]=' + id;
	
					var callback = {
						success:function(t){	
							$('ajax-messages').innerHTML = t.responseText;	
						},
						failure:function(t) { 
							alert('Error was: ' + t.responseText);
						}
					};
					var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
				}
				
				function unflagById(id, key){
					YAHOO.widget.Effects.Hide('items[' + id + ']');
					
					var url = "index.php?action=ajax";
					var pars = 'rs=wfQuestionGameAdmin&rsargs[]=unflagItem&rsargs[]=' + key + '&rsargs[]=' + id;
	
					var callback = {
						success:function(t){	$('ajax-messages').innerHTML = t.responseText;},
						failure:function(t) { alert('Error was: ' + t.responseText); }
					};
					
					var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
				}
				
				function unprotectById(id, key){
					YAHOO.widget.Effects.Hide('items[' + id + ']');
					
					var url = "index.php?action=ajax";
					var pars = 'rs=wfQuestionGameAdmin&rsargs[]=unprotectItem&rsargs[]=' + key + '&rsargs[]=' + id;
					
					var callback = {
						success:function(t){	$('ajax-messages').innerHTML = t.responseText;},
						failure:function(t) { alert('Error was: ' + t.responseText); }
					};
					
					var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
				}

				function protectById(id, key){
					var url = "index.php?action=ajax";
					var pars = 'rs=wfQuestionGameAdmin&rsargs[]=protectItem&rsargs[]=' + key + '&rsargs[]=' + id;
					
					var callback = {
						success:function(t){	$('ajax-messages').innerHTML = t.responseText;},
						failure:function(t) { alert('Error was: ' + t.responseText); }
					};
					
					var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
				}

