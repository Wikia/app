
	function ViewPage(pg,id,options){
		var url = wgServer + "/index.php?title=Special:ListPagesAction";
		var pars = 'pg=' + pg
		for(name in options){pars+= "&" + name + "=" + options[name]}
		var callback = {
			success: function( oResponse ) {
				$("ListPages" + id).innerHTML = oResponse.responseText
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}		

	function getContent(url,pars,layerTo){
		$(layerTo).innerHTML = "<table height=150 cellpadding=0 cellspacing=0><tr><td valign=top><span style='color:#666666;font-weight:800'>Loading...</span></td></tr></table><br><br>";
		var callback = {
			success: function( oResponse ) {
				$(layerTo).innerHTML = oResponse.responseText
			}
		};	
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}	
