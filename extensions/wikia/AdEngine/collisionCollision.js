/* Detect mis matches in the javascript-based collision detection logic
 * vs the PHP-based collision detection logic and do reporting on it.
 */

try {

  // Make a request to a squid box 
  function collisionRequest (js, php){
	  var url = "/rx?collisionTest=nick;"; // Use this url because squid won't send to apache
	  url += "js=" +  js + ';';
	  url += "php=" +  php + ';';
	  url += "width=" + escape(document.body.clientWidth) + ';';
	  YAHOO.util.Connect.asyncRequest('GET', url, null, null); 
  }
  if (FASTisCollisionTop() == isBoxAdArticle == true ){
	  // Yay.
	  collisionRequest("true", "true");
  } else if (FASTisCollisionTop() == isBoxAdArticle == false ){
	  // woo hoo
	  collisionRequest("false", "false");
  } else if (FASTisCollisionTop() == true && isBoxAdArticle == false ){
	  // Uh oh, this page is ugly.
	  collisionRequest("true", "false");
  } else if (FASTisCollisionTop() == false && isBoxAdArticle == true ){
	  // Js is more aggressive than PHP. 
	  collisionRequest("false","true");
  } 


} catch (e) {
	// Silently fail to make sure we don't cause problems on the live site for this test.
	//alert(e.message);
}
