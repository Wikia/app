/*
 * JavaScript functions for AjaxTest extension
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler <duesentrieb@brightbyte.de>
 * @copyright © 2006 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

    sajax_debug = true;

    function clearAjaxTest() {
	document.getElementById('ajaxtest_out').value= '';
	document.getElementById('ajaxtest_area').innerHTML= '';
	document.getElementById('sajax_debug').innerHTML= '';
    }

    function doAjaxTest() {
      sajax_debug_mode = true;

      var t = document.getElementById('ajaxtest_target').value;
      var tgt;

      if ( t == 'element' ) {
	tgt = document.getElementById('ajaxtest_area');
      }
      else if ( t == 'input' ) {
	tgt = document.getElementById('ajaxtest_out');
      }
      else {
	tgt = function ( request ) {
		result= request.responseText;
		if (request.status != 200) result= "ERROR: " + request.status + " " + request.statusText + ": " + result + "";

		alert(result);
	}
      }

      //alert(tgt);

      var usestring = document.getElementById('usestring').checked ? 1 : 0;
      var httpcache = document.getElementById('httpcache').checked ? 1 : 0;
      var lastmod = document.getElementById('lastmod').checked ? 1 : 0;
      var error = document.getElementById('error').checked ? 1 : 0;
      var text = document.getElementById('ajaxtest_text').value;

      sajax_do_call( "efAjaxTest", [ text, usestring, httpcache, lastmod, error], tgt );
    }
