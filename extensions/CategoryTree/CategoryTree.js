/*
 * JavaScript functions for the CategoryTree extension, an AJAX based gadget
 * to display the category structure of a wiki
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2006 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 *
 * NOTE: if you change this, increment $wgCategoryTreeVersion 
 *       in CategoryTree.php to avoid users getting stale copies from cache.
*/

// Default messages if new code loaded with old cached page
var categoryTreeErrorMsg = "Problem loading data.";
var categoryTreeRetryMsg = "Please wait a moment and try again.";

    function categoryTreeNextDiv(e) {
      var n= e.nextSibling;
      while ( n && ( n.nodeType != 1 || n.nodeName != 'DIV') ) {
          //alert('nodeType: ' + n.nodeType + '; nodeName: ' + n.nodeName);
          n= n.nextSibling;
      }

      return n;
    }

    function categoryTreeExpandNode(cat, options, lnk) {
      var div= categoryTreeNextDiv( lnk.parentNode.parentNode );

      div.style.display= 'block';
      lnk.innerHTML= categoryTreeCollapseBulletMsg;
      lnk.title= categoryTreeCollapseMsg;
      lnk.onclick= function() { categoryTreeCollapseNode(cat, options, lnk) }

      if (!lnk.className.match(/(^| )CategoryTreeLoaded($| )/)) {
        categoryTreeLoadNode(cat, options, lnk, div);
      }
    }

    function categoryTreeCollapseNode(cat, options, lnk) {
      var div= categoryTreeNextDiv( lnk.parentNode.parentNode );

      div.style.display= 'none';
      lnk.innerHTML= categoryTreeExpandBulletMsg;
      lnk.title= categoryTreeExpandMsg;
      lnk.onclick= function() { categoryTreeExpandNode(cat, options, lnk) }
    }

    function categoryTreeLoadNode(cat, options, lnk, div) {
      div.style.display= 'block';
      lnk.className= 'CategoryTreeLoaded';
      lnk.innerHTML= categoryTreeCollapseBulletMsg;
      lnk.title= categoryTreeCollapseMsg;
      lnk.onclick= function() { categoryTreeCollapseNode(cat, options, lnk) }

      categoryTreeLoadChildren(cat, options, div)
    }

	// FIXME Why can't this just use uneval()?
    function categoryTreeEncodeValue(value) {
          switch (typeof value) {
              case 'function': 
                  throw new Error("categoryTreeEncodeValue encountered a function");
                  break;

              case 'string': 
                  s = '"' + value.replace(/([\\"'])/g, "\\$1") + '"';
                  break;

              case 'number':
              case 'boolean':
              case 'null':
                  s = String(value);
                  break;

              case 'object':
                  if ( !value ) {
                      s = 'null';
                  }
                  else if (typeof value.length === 'number' && !(value.propertyIsEnumerable('length'))) {
                      s = '';
                      for (i = 0; i<value.length; i++) {
                          v = value[i];
                          if ( s!='' ) s += ', ';
                          s += categoryTreeEncodeValue( v );
                      }
                      s = '[' + s + ']';
                  }
                  else {
                      s = '';
                      for (k in value) {
                          v = value[k];
                          if ( s!='' ) s += ', ';
                          s += categoryTreeEncodeValue( k );
                          s += ': ';
                          s += categoryTreeEncodeValue( v );
                      }
                      s = '{' + s + '}';
                  }
                  break;
              default:
                  throw new Error("categoryTreeEncodeValue encountered strange variable type " + (typeof value));
          }

      return s;
    }

    function categoryTreeLoadChildren(cat, options, div) {
      div.innerHTML= '<i class="CategoryTreeNotice">' + categoryTreeLoadingMsg + '</i>';

      if ( typeof options == "string" ) { //hack for backward compatibility
          options = { mode : options };
      }

      function f( request ) {
          if (request.status != 200) {
              div.innerHTML = '<i class="CategoryTreeNotice">' + categoryTreeErrorMsg + ' </i>';
              var retryLink = document.createElement('a');
              retryLink.innerHTML = categoryTreeRetryMsg;
              retryLink.onclick = function() {
                  categoryTreeLoadChildren(cat, options, div, enc);
              }
              div.appendChild(retryLink);
              return;
          }

          result= request.responseText;
          result= result.replace(/^\s+|\s+$/, '');

          if ( result == '' ) {
                    result= '<i class="CategoryTreeNotice">';

                    if ( options.mode == 0 ) result= categoryTreeNoSubcategoriesMsg;
                    else if ( options.mode == 10 ) result= categoryTreeNoPagesMsg;
                    else if ( options.mode == 100 ) result= categoryTreeNoParentCategoriesMsg;
                    else result= categoryTreeNothingFoundMsg;

                    result+= '</i>';
          }

          result = result.replace(/##LOAD##/g, categoryTreeExpandMsg);
          div.innerHTML= result;

          categoryTreeShowToggles();
      }

      var opt = categoryTreeEncodeValue(options);
      sajax_do_call( "efCategoryTreeAjaxWrapper", [cat, opt, 'json'] , f );
    }

    function categoryTreeShowToggles() {
      var toggles = getElementsByClassName( document, 'span', 'CategoryTreeToggle' );

      for( var i = 0; i<toggles.length; ++i ) {
        toggles[i].style.display = 'inline';
      }
    }

    // Re-show the CategoryTreeToggles
    addOnloadHook(categoryTreeShowToggles);
