/*@@TODO should be set by mediaWiki so it uses wfMsg */
var global_loading_txt = 'loading<blink>...</blink>';

/*
* adds adjustment hooks
* @mvd_id  set to the mvd_id  
*/


//alert(typeof js_log);
//logging:
function js_log(string){
  if( window.console ){
        console.log(string);
   }else{
     /*
      * IE and non-firebug debug append text box:
      */
      /* var log_elm = document.getElementById('mv_js_log');
     if(!log_elm){
     	document.write('<textarea id="mv_js_log" cols="80" rows="6"></textarea>');
     	var log_elm = document.getElementById('mv_js_log');
     }
     if(log_elm){
     	log_elm.value+=string+"\n";
     }*/
   }
}
