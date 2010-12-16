//add media wizard integration for mediaWiki

/* config */
//Setup your content providers (see the remoteSearchDriver::content_providers for all options)
var wg_content_proivers_config = {}; //you can overwrite by defining (after)

var wg_local_wiki_api_url = wgServer + wgScriptPath + '/api.php';

//if mv_embed is hosted somewhere other than near by the add_media_wizard you can define it here: 
var force_mv_add_media_wizard_path = false;
//var force_mv_add_media_wizard_path = 'http://metavid.org/w/extensions/MetavidWiki/skins/';

var force_mv_embed_path = false;
//var force_mv_embed_path = 'http://metavid.org/w/extensions/MetavidWiki/skins/mv_embed/mvwScriptLoader.php?class=mv_embed';

var MV_EMBED_VIDEO_HANDLER = true; // if we should use mv_embed for all ogg_hanlder video embeds.

//*code should not have to modify anything below*/


//copied utility functions from mv_embed (can remove once utility functions are in js core)
if(typeof gMsg == 'undefined'){
    gMsg = {};
}
if(typeof mw.addMessages == 'undefined'){  
    function mw.addMessages( msgSet ){
        for(var i in msgSet){
            gMsg[ i ] = msgSet[i];
        }
    }
}
mw.addMessages( { 
    'add_media_to_page' : "Add Media to this Page"
});

if( MV_EMBED_VIDEO_HANDLER ){
    var vidIdList = new Array();
    addOnloadHook( function(){        
        var divs = document.getElementsByTagName('div');    
        for(var i = 0; i < divs.length; i++){        
            if( divs[i].id.substring(0,11) == 'ogg_player_'){
                vidIdList.push( divs[i].getAttribute("id") );
            } 
        }            
        if( vidIdList.length > 0){
            load_mv_embed( function(){
                mvJsLoader.embedVideoCheck(function(){                                                    
                    //do utilty rewrite of oggHanlder content: 
                    rewrite_for_oggHanlder( vidIdList );                    
                });
            });
        }
    });
}

//check if we are on a edit page:
if( wgAction == 'edit' || wgAction == 'submit' ){	
    //add onPage ready request:
    addOnloadHook( function(){                        
        var imE = document.createElement('img');
        imE.style.cursor = 'pointer';    
        imE.id = 'mv-add_media';        
        imE.src = getAddMediaPath( 'mv_embed/images/Button_add_media.png' );
        imE.title = gMsg['add_media_to_page'];
        
        var toolbar = document.getElementById("toolbar");
        if(toolbar)
            toolbar.appendChild(imE);     
        
        addHandler( imE, 'click', function() {
            mv_do_load_wiz();
        });
    });
}
//add firefog support to Special Upload page:
if( wgPageName== "Special:Upload" ){    
    addOnloadHook( function(){        
        //(for commons force the &uploadformstyle=plain form
        /*var loc =  window.location.toString();
        if( loc.indexOf('commons.wikimedia.org')!==-1 ){
            if( loc.indexOf( '&uploadformstyle=plain') == -1){                
                window.location = loc + '&uploadformstyle=plain';
            }        
        }*/
        //alert("!!upload hook");
        load_mv_embed( function(){            
            //load jQuery and what not
            mvJsLoader.jQueryCheck(function(){
                mvJsLoader.doLoad( {
                    'mvFirefogg' : 'libAddMedia/mvFirefogg.js',    
                    'mvUploader' : 'libAddMedia/mvUploader.js'
                },function(){        
                    mvUp = new mvUploader( { 'api_url' : wg_local_wiki_api_url } );        
                });
            });
        });
    });
}

var caret_pos={};
function mv_do_load_wiz(){
    caret_pos={};    
    var txtarea = document.editform.wpTextbox1;
    var getTextCusorStartPos = function (o){        
        if (o.createTextRange) {
                var r = document.selection.createRange().duplicate()
                r.moveEnd('character', o.value.length)
                if (r.text == '') return o.value.length
                return o.value.lastIndexOf(r.text)
            } else return o.selectionStart;
    }
    var getTextCusorEndPos = function (o){
        if (o.createTextRange) {
            var r = document.selection.createRange().duplicate();
            r.moveStart('character', -o.value.length);
            return r.text.length;
        } else{ 
            return o.selectionEnd;
        }
    }
    caret_pos.s = getTextCusorStartPos( txtarea );
    caret_pos.e = getTextCusorEndPos( txtarea );        
    caret_pos.text = txtarea.value;    
    //show the loading screen:
    var elm = document.getElementById('modalbox');
    if(elm){
        //use jquery to re-display the search
        if( typeof $j != 'undefined'){
            $j('#modalbox,#mv_overlay').show();
        }
    }else{
        var body_elm = document.getElementsByTagName("body")[0];
        body_elm.innerHTML = body_elm.innerHTML + ''+        
            '<div id="modalbox" style="background:#DDD;border:3px solid #666666;font-size:115%;'+
                'top:30px;left:20px;right:20px;bottom:30px;position:fixed;z-index:100;">'+            
                'loading external media wizard...'+            
            '</div>'+        
            '<div id="mv_overlay" style="background:#000;cursor:wait;height:100%;left:0;position:fixed;'+
                'top:0;width:100%;z-index:5;filter:alpha(opacity=60);-moz-opacity: 0.6;'+
                'opacity: 0.6;"/>';
    }
    //make sure the click action is still there
    var imE = document.getElementById('mv-add_media');    
    if(imE){
        addHandler( imE, 'click', function() {
            mv_do_load_wiz();
        });
    }
    //load mv_embed and do text search interface: 
    load_mv_embed( function(){
        //restore text value: 
        var txtarea = document.editform.wpTextbox1;        
        txtarea.value = caret_pos.text;
        //do the remote search interface:        
        mv_do_remote_search({
            'target_id':'modalbox',
            'profile':'mediawiki_edit',
            'target_textbox': 'wpTextbox1', 
            'caret_pos': caret_pos,            
            //note selections in the textbox will take over the default query
            'default_query': wgTitle,
            'target_title':wgPageName,
            'cpconfig':wg_content_proivers_config,
            'local_wiki_api_url': wg_local_wiki_api_url
        });
    });    
    return false;
}
function load_mv_embed( callback ){                    
    //inject mv_embed if needed:
    if( typeof mvEmbed == 'undefined'){        
        //get mv_embed path from _this_ file location:     
        if( force_mv_embed_path ){
            var mv_embed_url = force_mv_embed_path;
        }else{
            var mv_embed_url = getAddMediaPath( 'mv_embed/mv_embed.js' );
        }    
        //check if we are in debug mode (send a urid to mv_embed too)                     
        if( mv_embed_url.indexOf('debug=true') != -1 ){
            var d = new Date();
            mv_embed_url+='&urid=' + d.getTime();
        }                 
        var e = document.createElement("script");
        e.setAttribute( 'src', mv_embed_url );        
        e.setAttribute( 'type', "text/javascript" );
        document.getElementsByTagName("head")[0].appendChild(e);        
        check_for_mv_embed( callback ); 
    }else{        
        check_for_mv_embed( callback );
    }          
}

function check_for_mv_embed( callback ){
    if( typeof mvEmbed == 'undefined'){         
        setTimeout('check_for_mv_embed( ' + callback +');', 25);
    }else{        
        callback();
    }
}
function getAddMediaPath( replace_str ){
    if(!replace_str)
        replace_str = '';
    if( force_mv_add_media_wizard_path )
        return force_mv_add_media_wizard_path + replace_str;
            
    for(var i=0; i < document.getElementsByTagName('script').length; i++){
        var s = document.getElementsByTagName('script')[i];
        if( s.src.indexOf('add_media_wizard.js') != -1 ){
            //use the external_media_wizard path: 
            return s.src.replace('add_media_wizard.js', replace_str);
        }
    }    
}


