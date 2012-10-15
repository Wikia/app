
	function ViewPage(pg,id,options){
		var url = "index.php?title=Special:ListPagesAction";
		var pars = 'pg=' + pg
		for(name in options){pars+= "&" + name + "=" + options[name]}

		var myAjax = new Ajax.Updater(
			"ListPages" + id, 
			url, 
			{
				method: 'post', 
				parameters: pars
			});
	}		

	function getContent(url,pars,layerTo){
		//window.location.hash = "pageToolsTop"
		$(layerTo).innerHTML = "<table height=150 cellpadding=0 cellspacing=0><tr><td valign=top><span style='color:#666666;font-weight:800'>Loading...</span></td></tr></table><br><br>";
		var myAjax = new Ajax.Updater(
			layerTo, 
			url, 
			{
				method: 'post', 
				parameters: pars
			});
	}	
