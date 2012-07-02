/*
 * JavaScript functions for the Player extension, 
 * for support of the AJAX inline player functionality.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler <duesentrieb@brightbyte.de>
 * @copyright © 2006 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */
    
    function loadPlayer(file, opt, id) {
      var div = document.getElementById(id + '-container');
      var ovl = document.getElementById(id + '-overlay');

      if (ovl) ovl.style.backgroundImage= "url("+wgPlayerExtensionPath+"/loading.gif)";
      
      function f( request ) {
          var result= request.responseText;
          result= result.replace(/^\s+|\s+$/, '');

          if (request.status != 200) result= "<div class='error'> " + request.status + " " + request.statusText + ": " + result + "</div>";
          
          div.innerHTML= result;
      }
      
      sajax_do_call( "playerAjaxHandler", [file, opt], f );
    }
    
