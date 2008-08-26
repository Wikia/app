/*
 * JavaScript functions for the TalkHere extension; 
 * Implements AJAX based inline edit box for adding comments.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
*/
    
    function talkHereExpandEditor(lnk, div, page, section, returnto) {
      if (typeof lnk == 'string') lnk = document.getElementById(lnk);
      if (typeof div == 'string') div = document.getElementById(div);
      
      div.style.display= 'block';
      lnk.innerHTML= talkHereCollapseMsg;
      lnk.title= talkHereCollapseMsg;
      lnk.onclick= function() { talkHereCollapseEditor(lnk, div, page, section, returnto) }
        
      if (div.innerHTML.length < 200) {
        talkHereLoadEditor(lnk, div, page, section, returnto);
      }
    }
    
    function talkHereCollapseEditor(lnk, div, page, section, returnto) {
      if (typeof lnk == 'string') lnk = document.getElementById(lnk);
      if (typeof div == 'string') div = document.getElementById(div);
      
      div.style.display= 'none';
      lnk.innerHTML= talkHereExpandMsg;
      lnk.title= talkHereExpandMsg;
      lnk.onclick= function() { talkHereExpandEditor(lnk, div, page, section, returnto) }
    }
    
    function talkHereLoadEditor(lnk, div, page, section, returnto) {
      if (typeof lnk == 'string') lnk = document.getElementById(lnk);
      if (typeof div == 'string') div = document.getElementById(div);
      
      div.style.display= 'block';
      lnk.innerHTML= talkHereCollapseMsg;
      lnk.title= talkHereCollapseMsg;
      lnk.onclick= function() { talkHereCollapseEditor(lnk, div, page, section, returnto) }

      talkHereLoadEditorHTML(div, page, section, returnto)
    }
    
    function talkHereLoadEditorHTML(div, page, section, returnto) {
      div.innerHTML= '<i class="talkhere-notice">' + talkHereLoadingMsg + '</i>';
      
      function f( request ) {
          var result= request.responseText;
          result= result.replace(/^\s+|\s+$/, '');

          if ( request.status != 200 ) result= "<div class='error'>" + request.status + " " + request.statusText + ": " + result + "</div>";
          else if ( result == '' ) result= "<div class='error'>empty response!</div>";
          
          /*
          while (div.firstChild) div.removeChild(div.firstChild);
          var n = request.responseXML.firstChild;
          while (n) {
              div.appendChild( n );
              n = n.nextSibling;
          }
          */
          div.innerHTML= result;
          talkHereRunScripts(div);
          mwSetupToolbar();
      }
      
      sajax_do_call( "wfTalkHereAjaxEditor", [page, section, returnto], f );
    }

    function talkHereRunScripts(e) {
        if (e.nodeType != 1) return;

        if (e.tagName.toLowerCase() == 'script') {
		eval(e.text);
	}
	else {
		var n = e.firstChild;
		while ( n ) {
			if ( n.nodeType == 1 ) talkHereRunScripts( n );
			n = n.nextSibling;
		}
	}
    }
    
