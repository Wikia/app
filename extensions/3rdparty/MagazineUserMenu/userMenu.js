	
	function updateUserMenu(){
		var url = "index.php?title=Special:UserMenuAction";
		var myAjax = new Ajax.Updater(
			"",
			url, 
			{
				method: 'post', 
				parameters: Sortable.serialize('menu'),
				onComplete:reloadPage
			});
	}
	
	function reloadPage(){
		window.location.reload()
	}
	function clickButton (obj) {
	  // variables 
	  var checkedbox = eval("document.sports." + obj + ".checked");
	  var menu = document.getElementById('menu');
	  var li = document.createElement('li');
      var liText = document.createTextNode(obj);
	  
	  if (checkedbox) {
	  li.setAttribute("id","menu_" + obj)
	  li.appendChild(liText);
	  document.getElementById('menu').appendChild(li);
      Sortable.create("menu",{ghosting:true,constraint:false});     
	  } 
	  else {
	  removeButton(obj);
	  }
	 // updateUserMenu()
	 }
	 
	function removeButton(obj) {
	 var box = document.getElementById("menu_" + obj);
	 box.parentNode.removeChild(box);
	}