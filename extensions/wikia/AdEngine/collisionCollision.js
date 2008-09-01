/* Detect mis matches in the javascript-based collision detection logic
 * vs the PHP-based collision detection logic and do reporting on it.
 */

// Grabbed this function from http://images2.wikia.nocookie.net/common/extensions/wikia/FAST/FAST.js
function JSisCollisionTop() {
	var Dom = YAHOO.util.Dom;

	var tables = $('bodyContent').getElementsByTagName('table');
	for(var i = 0; i < tables.length; i++) {
		if(tables[i].id != 'toc' && Dom.getStyle(tables[i], 'float') == 'none' && ((FASTtoc && Dom.getY(tables[i]) > FASTtocY && Dom.getY(tables[i]) - FASTtocHeight < FASTcontentY + 300) || (Dom.getY(tables[i]) < FASTcontentY + 300))) {
			return true;
		}
	}
	return false;
}


// Make a request to a squid box 
function collisionRequest (js, php){
	  // var url = "/rx?collisionTest=nick;"; // Use this url because squid won't send to apache
	  var url = "http://nick.sullivanflock.com/rx?collisionTest=nick;"; // Use this url because squid won't send to apache
	  url += "js=" +  js + ';';
	  url += "php=" +  php + ';';
	  url += "width=" + escape(document.body.clientWidth) + ';';
	  document.write("<img src='" + url + "' style='display:none'>");
}

try {
  isJsCollision = JSisCollisionTop();
  if (isJsCollision == true && isPhpCollision == true ){
	  // Yay.
	  collisionRequest("true", "true");
  } else if (isJsCollision == false && isPhpCollision == false ){
	  // woo hoo
	  collisionRequest("false", "false");
  } else if (isJsCollision = true && isPhpCollision == false ){
	  // Uh oh, this page is ugly.
	  collisionRequest("true", "false");
  } else if (isJsCollision == false && isPhpCollision == true ){
	  // Js is more aggressive than PHP. 
	  collisionRequest("false","true");
  } 


} catch (e) {
	// Silently fail to make sure we don't cause problems on the live site for this test.
	//alert(e.message);
}

