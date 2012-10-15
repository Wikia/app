function process (id, title, wiki){

//alert(id+" "+title+" "+wiki);
		var xhr_object = null;

	   if(window.XMLHttpRequest) // Firefox
	      xhr_object = new XMLHttpRequest();
	   else if(window.ActiveXObject) // Internet Explorer
	      xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	   else {
	      alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
	      return;
	   }

	   xhr_object.open("POST", document.URL+"?title="+title+"&action=admin", true);

	   xhr_object.onreadystatechange = function() {
	      if(xhr_object.readyState == 4) {
//alert(xhr_object.responseText);
	         eval(xhr_object.responseText);
		  }
	   };

	   xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	   // --- ICI TU PASSE TES ARGUMENTS AU SCRIPT :
	   var data = "id="+id+"&title="+title+"&wiki="+wiki;
	   xhr_object.send(data);


}


