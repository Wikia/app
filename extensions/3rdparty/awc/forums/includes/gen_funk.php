<?PHP
/**
* AWC`s Mediawiki Forum Extension
* 
* License: <br />
* Another Web Compnay (AWC) 
* 
* All of Another Web Company's (AWC) MediaWiki Extensions are licensed under<br />
* Creative Commons Attribution-Share Alike 3.0 United States License<br />
* http://creativecommons.org/licenses/by-sa/3.0/us/
* 
* All of AWC's MediaWiki extension's can be freely-distribute, 
*  no profit of any kind is allowed to be made off of or because of the extension itself, this includes Donations.
* 
* All of AWC's MediaWiki extension's can be edited or modified and freely-distribute <br />
*  but these changes must be made public and viewable noting the changes are not original AWC code. <br />
*  A link to http://anotherwebcom.com must be visable in the source code 
*  along with being visable in render code for the public to see.
* 
* You are not allowed to remove the Another Web Company's (AWC) logo, link or name from any source code or rendered code.<br /> 
* You are not allowed to create your own code which will remove or hide Another Web Company's (AWC) logo, link or name.
* 
* This License can and will be change with-out notice. 
* 
* All of Another Web Company's (AWC) software/code/programs are distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
* 
* 4/2008 Another Web Compnay (AWC)<br />
* The above text must stay intact and not edited in any way.
* 
* @filepath /extensions/awc/includes/gen_funk.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();



function awcf_hide_code($txt, $id = "ENCODED"){ 
/**
     * Determines wether we need to hide content from the Parser or not.
     *
     * @return string
     * 
     * 
This idea was takin from:
Federico Cargnelutti's Issue Tracking System Extension.

There are a few places in the forum where text being passed should not be phase
so they are base64_encode where needed and then this function will convert them all back in the end.
*/
   $test = "@$id@".base64_encode($txt)."@$id@";
   return $test;
}



function awcf_unhide_code ($text, $id = "ENCODED") {
/*
This idea was takin from:
Federico Cargnelutti's Issue Tracking System Extension.

There are a few places in the forum where text being passed should not be phase
so they are base64_encode where needed and then this function will convert them all back in the end.
*/
    $text = preg_replace('/'."@$id@".'([0-9a-zA-Z\\+\\/]+=*)'."@$id@".'/e', 'base64_decode("$1")',  $text );
    return $text;
}

   function awcf_hide_code2($post, $todo = 'hide'){
                                               
  #  return $post;
  
      #$post = preg_replace("#<pre(.+?)<\/pre>#is", "@ENCODED@" . 'base64_encode("$1")' . "@ENCODED@", $post ); 
      
      # $post = preg_replace('/@ENCODED@([0-9a-zA-Z\\+\\/]+=*)@ENCODED@/e','base64_decode("$1")', $post ); 
        
            if (preg_match_all("#<pre(.+?)<\/pre>#is", $post, $found)){
                foreach($found[0] as $k => $v){
                   $post = str_replace($v, awcf_hide_code($v), $post);
                } 
            }
            
            
            if (preg_match_all("#<source(.+?)<\/source>#is", $post, $found)){
                foreach($found[0] as $k => $v){
                   $post = str_replace($v, awcf_hide_code($v), $post);
                }   
            } 
            
                        
            if (preg_match_all("#<nowiki(.+?)<\/nowiki>#is", $post, $found)){
                foreach($found[0] as $k => $v){
                   $post = str_replace($v, awcf_hide_code($v), $post);
                } 
            }
            
            
            return $post;
            
    }


function awcsf_encode_password($pw = null){
    $pw = base64_encode($pw);
    return $pw;
}    

function awcsf_decode_password($pw = null){
   // $pw = preg_replace('/([0-9a-zA-Z\\+\\/]+=*)/e','base64_decode("$1")', $pw);
    $pw = base64_decode($pw);
    return $pw;
} 
    
    
function awcf_redirect($info){
global $tplt, $wgOut, $awcs_forum_config;    


        $msg = get_awcsforum_word($info['msg']);
        if($msg == '') $msg = $info['msg'] ;
        
        $word = array('redirecting' => get_awcsforum_word('word_redirecting'), 
                        'click_here' => get_awcsforum_word('word_redirecting_click_here'),
                        'msg' => $msg. '<hr />');
                       
                        
        Set_AWC_Forum_SubTitle($word['redirecting'], ''); 
         
        $word['redirecting'] = '';
                        
        $to_tplt['url_redirect'] = $info['url'];        
        $to_tplt['redirect'] = '<noscript><meta http-equiv="Refresh" content="'.$awcs_forum_config->cf_redirect_delay.'; URL='.$info['url'].'" /></noscript>';
        $out = $tplt->phase($word, $to_tplt, 'redirect', true);
        
        //Set_AWC_Forum_SubTitle($word['redirecting'] . '...', '', '');
        
        $wgOut->addScript('<meta http-equiv="Refresh" content="'.$awcs_forum_config->cf_redirect_delay.'; URL='.$info['url'].'" />');
        
        $wgOut->addHTML($out);

}


// 2.4.3
function GetWiki_ToolBar(){
global $wgVersion;
/*
        if ( !file_exists($IP . '/includes/AutoLoader.php')){
            require_once($IP . '/includes/EditPage.php');
        }
            
        */    
        if(version_compare($wgVersion, '1.13.0', '>=')){
            global $wgOut;
            $wgOut->addScriptFile('edit.js');
        }
        
        $toolbar = EditPage::getEditToolbar();
        
        return $toolbar ;
        
}


 
function remove_forum_tag_from_post($post){
 
 $f = array('<forum_info', '</forum_info>', '<forum_poll', '</forum_poll>');
 $r = array('&lt;forum_info', '&lt;/forum_info&gt;', '&lt;forum_poll', '&lt;/forum_poll&gt;');   
 
 //$post = str_replace('<forum_info', '&lt;forum_info',$post) ;
 //$post = str_replace('</forum_info>', '&lt;/forum_info&gt;',$post) ;
 
 $post = str_replace($f, $r, $post) ;
 
 return $post;       
    
    $match = "#<forum_info(.+?)<\/forum_info>#is";
            if (preg_match_all($match, $post, $found)){
                   $pre_holder = $found[0] ; 
                  foreach($pre_holder as $k => $v){
                          $post = str_replace($v, "<nowiki>".$v."</nowiki>", $post); 
                  }  
            }
            
            return $post;
            
}

function convert_remove_pre($post){
global $pre_replaces;

# return $post;

            $pre_holder= null;
            $pre_replaces = array();
            $match = "#<pre(.+?)<\/pre>#is";
            if (preg_match_all($match, $post, $found)){
                   $pre_holder = $found[0] ; 
                  foreach($pre_holder as $k => $v){
                       $pre_replaces['pre'][$v] = $v;
                       #$post = str_replace($v, awcf_hide_code($v), $post); 
                       $post = str_replace($v, "<|pre|,p,l,a,c,e,,h,o,l,d,e,r,".$k."|h,o,l,d,e,r,|t,a,g,/>", $post); 
                  }  
            }
            
            $match = "#<source(.+?)<\/source>#is";
            if (preg_match_all($match, $post, $found)){
                   $pre_holder = $found[0] ; 
                  foreach($pre_holder as $k => $v){
                       $pre_replaces['source'][$k] = $v;
                       #$post = str_replace($v, awcf_hide_code($v), $post);
                       $post = str_replace($v, "<|source|,p,l,a,c,e,,h,o,l,d,e,r,".$k."|h,o,l,d,e,r,|t,a,g,/>", $post); 
                  }  
            } 
            
                        
            $match = "#<nowiki(.+?)<\/nowiki>#is";
            if (preg_match_all($match, $post, $found)){
                   $pre_holder = $found[0] ; 
                  foreach($pre_holder as $k => $v){
                       $pre_replaces['nowiki'][$k] = $v;
                       #$post = str_replace($v, awcf_hide_code($v), $post);
                       $post = str_replace($v, "<|nowiki|,p,l,a,c,e,,h,o,l,d,e,r,".$k."|h,o,l,d,e,r,|t,a,g,/>", $post); 
                  }  
            }
            
            
            return $post;           
}


function convert_add_back_pre($post){
global $pre_replaces;

           # return $post;
            
            if(isset($pre_replaces)){
                if(isset($pre_replaces['pre'])){
                    foreach($pre_replaces['pre'] as $k => $v){
                        $post = str_replace( "<|pre|,p,l,a,c,e,,h,o,l,d,e,r,".$k."|h,o,l,d,e,r,|t,a,g,/>", $pre_replaces['pre'][$k] , $post); 
                    }
                    unset($pre_replaces['pre']);                
                }
                
                
                if(isset($pre_replaces['source'])){
                    foreach($pre_replaces['source'] as $k => $v){
                        $post = str_replace( "<|source|,p,l,a,c,e,,h,o,l,d,e,r,".$k."|h,o,l,d,e,r,|t,a,g,/>", $pre_replaces['source'][$k] , $post); 
                    }
                    unset($pre_replaces['source']);                
                }
                
                
                if(isset($pre_replaces['nowiki'])){
                    foreach($pre_replaces['nowiki'] as $k => $v){
                        $post = str_replace( "<|nowiki|,p,l,a,c,e,,h,o,l,d,e,r,".$k."|h,o,l,d,e,r,|t,a,g,/>", $pre_replaces['nowiki'][$k] , $post); 
                    }
                    unset($pre_replaces['nowiki']);                
                }
                
             unset($pre_replaces);  
            }
            
            return $post;
            

}




function br_convert($post_1){

            $post = $post_1;
            #$post = convert_remove_pre($post);
            
            #$post = str_replace("\r", "\r\n", $post ) ;
            #$post = str_replace("\r\n", "\n", $post ) ;
           # $post = str_replace("\r", "\r\n", $post ) ;
            $post = str_replace("\r", "<br />", $post);
            $post = str_replace("=<br />", "=\r", $post);
            
          # $post = convert_add_back_pre($post);
            
            return $post;            
}
                    
                    
                    





function add_other_ext_header(){
global $wgParser, $wgOut; 

        foreach($wgParser->mOutput->mHeadItems as $k_ID => $mHeadItems){
            $wgOut->addHeadItem($k_ID, $mHeadItems);
        }
}


function add_tmpl_to_skin($tmp){
 global $wgOut, $wgCanonicalNamespaceNames ;
    
            $tmplt = $tmp;
            $tmplt = awc_wikipase($tmplt, $wgOut) ;
            
            $edit = str_replace('{{:', '', $tmp);
           // $edit = str_replace('{{:', 'Template:', $edit);
            $edit = str_replace('{{', $wgCanonicalNamespaceNames[10].':', $edit);
            $edit = str_replace('}}', '', $edit);
            
            return '<a href="'.awcsf_wiki_url.$edit.'">*</a> '.  $tmplt ;

}

function awcs_forum_error($err){
global $wgOut, $awcs_forum_config, $wgSitename, $tplt;


        awcsforum_funcs::get_page_lang(array('lang_txt_errormsg')); // get lang difinitions... 
        
        $tplt->add_tplts(array("'error_table'",), true );
     
        $Tforum_name = str_replace('|$|', ' ' . $wgSitename . ' ', $awcs_forum_config->name);

        Set_AWC_Forum_SubTitle($Tforum_name, get_awcsforum_word('word_Error'));
      
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('word_Error'), true);
        
        
      $error = get_awcsforum_word($err);
      if($error == '')$error = $err;
          
          $info['error'] = $error;
          $word['word_Error'] = get_awcsforum_word('word_Error');
          
          $html = $tplt->phase($word, $info, 'error_table',true);

        $wgOut->addHTML($html);
    
    
}

function awc_clean_wikipase($out){
    
    $out = str_replace("<p>", "", $out);
    $out = str_replace("</p>", "", $out);
    
    return $out;
        
}

function awc_wikipase($info, $wiki_Out){
   return awc_clean_wikipase($wiki_Out->parse($info));
}

function awcsf_CheckYesNo($c, $v, $get = true){

    if($get){
        if ($v == '1'){
            $out = get_awcsforum_word('word_yes') . '<input type="radio" name="'.$c.'" value="1" checked> ';
            $out .= get_awcsforum_word('word_no') . '<input type="radio" name="'.$c.'" value="0"> ';
        } else {
            $out = get_awcsforum_word('word_yes') . '<input type="radio" name="'.$c.'" value="1" > ';
            $out .= get_awcsforum_word('word_no') . '<input type="radio" name="'.$c.'" value="0" checked> ';
        }
       # $out = get_awcsforum_word('word_yes') . '<input type="radio" name="'.$c.'" value="1"> ' . get_awcsforum_word('word_no') . '<input type="radio" name="'.$c.'" value="0">';
    } else {
            $out = get_awcsforum_word('word_yes') . '<input type="radio" name="'.$c.'" value="1"> ';
            $out .= get_awcsforum_word('word_no') . '<input type="radio" name="'.$c.'" value="0"> ';
    }
    
    return $out ;
    
}


function GetWikiPage($page, $pID, $namespace = '', $memID = ''){
global $wgOut, $wgRequest, $wgContLang, $wgUser, $rev_timestamp, $wgParser; #, $wgTitle, $wgTitle;

#die(print_r($wgOut));

# name space
# forum preview
# adding wiki tabs across the top of the post

#die("GetWikiPage <br />" . $page);

            $page = str_replace('&lt;wiki&gt;', '<wiki>', $page);
            $page = str_replace('&lt;/wiki&gt;', '</wiki>', $page);
            
            
            $ns = null;
            if($namespace != ''){
                $ns = $namespace ;
                $namespace = " AND p.page_namespace=$namespace " ;
             
            } else {
                $namespace = " AND p.page_namespace=0 " ;
            }

            $match = "#<wiki>(.*)<\/wiki>#siU";
            if (preg_match($match, $page, $found)){

               
                $org_page = str_replace($found[0], '<_wiki_temp_page_holder_goes_here_for_replacing_>', $page);
                $title = str_replace(' ', '_', $found[1]);#  die($found[1]);
                
               # $org_page = $wgOut->parse($org_page) ;
               # $org_page = Convert($org_page); 
                 
                 $dbr = wfGetDB( DB_SLAVE );
                 $table_page = $dbr->tableName('page');
                 $table_rev = $dbr->tableName('revision');
                 $table_text = $dbr->tableName('text'); 
                 
                $sql = "SELECT t.old_text, r.rev_timestamp
                            FROM $table_page p
                            JOIN $table_rev r
                                ON p.page_id=r.rev_page
                            JOIN $table_text t
                                ON r.rev_text_id=t.old_id
                            WHERE p.page_title = '".$title."' $namespace ORDER BY r.rev_timestamp DESC LIMIT 1";
                                    
                $res = $dbr->query($sql); 
                $r = $dbr->fetchRow( $res );  
                //die($r['rev_timestamp']);
                $rev_timestamp = $r['rev_timestamp'] ;
                $page = $r['old_text'] ;  
                $dbr->freeResult( $res );
                
                
                if($ns == '8') return $page ;  // used for MediaWiki:Edittools
                
                #die($page);
                
               $mw = new MediaWiki();
               $action = $wgRequest->getVal('action', 'view');
               $wgTitle = $mw->checkInitialQueries( $title,$action,$wgOut, $wgRequest, $wgContLang );
               
               # $p = new Parser();
               # $p->clearState();
                
               $options = new ParserOptions;
               #$options->setTidy(false);
               
               # die($page);
              #  $page = awc_wikipase($page, $wgOut);
              # $out = $wgParser->parse($page, $wgTitle, $options, false, false);
               
              # $mText = $out->mText;
               $mText = $page;
               
               
               #awc_wikipase
               
              # die(print_r($ns));
              $link = str_replace('index.php/',  '', awcsf_wiki_url );
              $link = str_replace('index.php?title=',  '', $link );
                   
               if($ns == 0){ 
                   $link = $link . 'index.php?title=' . $title ;
                   $page = '<br /><br /><hr>' . get_awcsforum_word('word_wikipage') . ' <a href="'.$link.'&awc_redirect='.$pID.'&action=edit">'. get_awcsforum_word('word_editwikipage') . '</a><hr> <br />' . $mText  . '<hr><br />' ; 
                   $page = str_replace('<_wiki_temp_page_holder_goes_here_for_replacing_>', $page, $org_page);
                   $page = str_replace('&amp;action=edit&amp;section=', '&amp;awc_redirect='.$pID.'&amp;action=edit&amp;section=', $page);
               
               }  else {
                $page = $mText;
               # die($page);
               # $page = str_replace('title=', 'title=User:', $page);
                #$page = str_replace('&amp;action=edit&amp;section=', '&amp;awc_redirect='.$memID.'&amp;action=edit&amp;section=', $page);
               # $page = str_replace('&amp;action=edit&amp;section=', '&amp;awc_mem_redirect='.$title.'&amp;action=edit&amp;section=', $page); 
                
                
               }
               
               
            }
            
            
return $page;
            
}

function convert_pre($txt){
    
   # die($txt);
    $txt = preg_replace( "#\[code\](.+?)\[/code\]#is", "<pre>\\1</pre>", $txt );
  #  $txt = preg_replace( "#\[code\](.+?)\[/code\]#is", "<pre>".htmlentities("\\1", ENT_NOQUOTES)."</pre>", $txt );
    $txt = preg_replace( "#\[php\](.+?)\[/php\]#is", "<pre>\\1</pre>", $txt );
    $txt = preg_replace( "#\[html\](.+?)\[/html\]#is", "<pre>\\1</pre>", $txt );
   # die($txt);
    
   #$txt = preg_replace( "#<pre(.+?)<\/pre>#is", 'awcf_hide_code("$1")', $txt );
   
   // find better way...   DONT DO THIS - WIKI WILL NOT PHASE PRE AND WIKI AND THINGS WILL BE SCREWED !
    if (preg_match_all("#<nowiki(.+?)<\/nowiki>#is", $txt, $found)){
        foreach($found[0] as $k => $v){
            #$txt = str_replace($v, awcf_hide_code($v), $txt); 
        }  
    }
    
    
    if (preg_match_all("#<pre(.+?)<\/pre>#is", $txt, $found)){
        foreach($found[0] as $k => $v){
          #  $txt = str_replace($v, awcf_hide_code($v), $txt); 
        }  
    }       
        
    return $txt;            
}



function Convert($txt){
    static $t = 0;
    $t++;
    if($t == 1){
    	#die($txt);
    }
            $txt = awcf_hide_code2($txt);
    
            $txt = preg_replace( "#\[b\](.+?)\[/b\]#is", "<b>\\1</b>", $txt );
            $txt = preg_replace( "#\[i\](.+?)\[/i\]#is", "<i>\\1</i>", $txt );
            $txt = preg_replace( "#\[u\](.+?)\[/u\]#is", "<u>\\1</u>", $txt );
            $txt = preg_replace( "#\[s\](.+?)\[/s\]#is", "<s>\\1</s>", $txt );
            
            $txt = preg_replace( "#\[search\](.+?)\[/search\]#is", "<a href='". awc_url ."search/s/?&kw=\\1'>\\1</a>", $txt );
           
            $txt = preg_replace( "#\[google\](.+?)\[/google\]#is", "<a href='http://www.google.com/search?q=\\1'>\\1</a>", $txt );
            $txt = preg_replace( "#\[yahoo\](.+?)\[/yahoo\]#is", "<a href='http://search.yahoo.com/search?p=\\1'>\\1</a>", $txt );
            
            
            $txt = preg_replace( "#\[size\s*=\s*(\S+?)\s*\](.*?)\[\/size\]#is"   , "<font size='\\1'>\\2</font>"  , $txt );
            $txt = preg_replace( "#\[size\s*=\s*(\S+?)\s*\](.*?)\<\/font>(.*?)\[\/size\]#is"   , "</font><font size='\\1'>\\2</font>"  , $txt ); 
            
            $txt = preg_replace( "#\[color\s*=\s*(\S+?)\s*\](.*?)\[\/color\]#is"   , "<font color='\\1'>\\2</font>"  , $txt );
            $txt = preg_replace( "#\[color\s*=\s*(\S+?)\s*\](.*?)\<\/font>(.*?)\[\/color\]#i"   , "</font><font color='\\1'>\\2</font>"  , $txt );
            
            
            $txt = preg_replace( "#\[center\](.+?)\[/center\]#is", "<center>\\1</center>", $txt );
            
             # needs work...
            $txt = preg_replace( "#\[right\](.+?)\[/right\]#is"   , "<div align='right'>\\1</div>"  , $txt );
            $txt = preg_replace( "#\[left\](.+?)\[/left\]#is"   , "<div align='left'>\\1</div>"  , $txt );
            
           

            # needs work...
            $txt = preg_replace( "#\[[hr]\]#is", "<hr>", $txt ); 
            
            
            #$txt = preg_replace( "#\[list\](.+?)\[\*\](.+?)\[/list\]#is"   , "<ul>\\1<li>\\2</li></ul>"  , $txt );
                    
            
            $match = "#\[list\](.+?)\[/list\]#is";
            if (preg_match_all($match, $txt, $found)){
                    
                 $txt = str_replace($found[0][0], "<ul>".$found[1][0]."</ul>", $txt);     
                    
                    $match2 = "#\[\*\](.+?)#U";
                    if (preg_match_all($match2, $txt, $found2)){
                        foreach($found2[1] as $k => $v){ 
                            $txt = str_replace($found2[0][$k], "<li>".$v."</li>", $txt);
                        }
                    }
                     
            }
            
            // cant do this, wiki phases urls before hand...
            #$txt = preg_replace( "#\[url\s*=\s*(\S+?)\s*\](.*?)\[\/url\]#is"   , "[\\1 \\2]"  , $txt );
            #$txt = preg_replace( "#\[URL\s*=\s*(\S+?)\s*\](.*?)\[\/URL\]#is"   , "[\\1 \\2]"  , $txt );
            
                                                   
            $txt = preg_replace( "#\[quote\]#is" ,"<div class='quote_title'>Quote:<div class='quote'>\\1"    , $txt );
            $txt = preg_replace( "#\[quote=([^\]]+?)\]#is","<div class='quote_title'>Quote:\\1<div class='quote'>\\2", $txt );
            $txt = preg_replace( "#\[/quote\]#is", '</div id="quote"></div id="quote">'          , $txt );
         
         
         /*
         2.5 change, no longer needed...
         
            $txt = str_replace("</li><br />", "</li>", $txt);
            $txt = str_replace("<ul><br />", "<ul>", $txt);
            $txt = str_replace("<br /><ul>", "<ul>", $txt);
            $txt = str_replace("</ul><br />", "</ul>", $txt);
            $txt = str_replace("</div><br />", "</div>", $txt);
            
            $txt = str_replace("<br /><tr>", '<tr>', $txt);
            $txt = str_replace("<br /><td>", '<td>', $txt);
            $txt = str_replace("<br /></p><br />", '<br />', $txt);
            $txt = str_replace("<br /><p>", '<br />', $txt);
            
            */
             #  die($txt);
            #$txt = preg_replace( "#\|emotion_tag\|(.+?)\|emotion_tag\|_end\|#is", "<img src=\"\\1\" />", $txt ); 
            $txt = preg_replace( "#\|emotion_tag\|(.+?)\|emotion_tag\|_end\|#is", "<img src=\"\\1\" />", $txt ); 
             
            
            #  trying to cut done on URL lenths...
            $match = "#<a(.+?)<\/a>#is";
            if (preg_match_all($match, $txt, $found)){
                
                    foreach($found[0] as $url_title){
                        
                        $match = "#\">(.+?)<\/a>#is";
                        if (preg_match_all($match, $url_title, $found2)){
                            
                            
                            $img_match = "#<img(.+?)>#is";
                            if (!preg_match_all($img_match, $found2[0][0], $found3)){
                           
                                
                                $replace = str_replace('">', '', $found2[0][0]);
                                $replace = str_replace('</a>', '', $replace);
                                
                                if(strlen($replace) > 90){
                                    $txt = str_replace($found2[0][0], '">'. awcsforum_funcs::awc_shorten($replace, 90)  .'...</a>', $txt);   
                                }
                                
                            }
                        }
                         
                    }
            }
            
            
            $f = array('&lt;/a&gt;', '&lt;a href', '"&gt;', "<a href=",);
            $r = array('</a>', '<a href', '">', "<a target='blank' href=", '',);
            $txt = str_replace($f, $r, $txt ) ;
            
            $txt = awcf_unhide_code($txt);
             
    return $txt ;
}


Function GetLimit($tmp, $todo){
global $action_url, $awcs_forum_config, $wgRequest, $LimitJump_bot, $LimitJump_top, $LimitJump, $wgTitle, $first_return, $tplt;

 # die(">". $todo);
  
        $TotalPosts = intval( $tmp['TotalPosts']);
        $last_id = '/#last';
        $url=null;
        $url_limit=null;
        $current_page_num=null;
        $tmp_top=null;
        $tmp_bot=null;
        $back_top=null;
        $back_bot=null;
        $HasLimit = false;
        $page_number =0;
        
        $w_next = get_awcsforum_word('word_next');
        $w_prev = get_awcsforum_word('word_prev');
        $w_last = get_awcsforum_word('word_last');
        
        switch( $todo ) {
            case 'search';
            case 'cat':
                $limit = $awcs_forum_config->cfl_Thread_DisplayLimit;
                $PageCutOff = $awcs_forum_config->cfl_ThreadPageBlockLimit;
            break;
            
            case 'thread':
                $limit = $awcs_forum_config->cfl_Post_DisplayLimit + 1;
                $PageCutOff = $awcs_forum_config->cfl_PostPageBlockLimit;
            break;
        }
        
        $total_page_count = intval($TotalPosts/$limit);

       # die(">". $TotalPosts);
        # loop through "action" and construct a new url also check for 'limit:' in current url
        
        $action = $wgRequest->action;
        $spl = explode("/", $action);
        foreach($spl as $k => $value){
           # print($value . '<br />');
            if (substr($value , 0, 6) == "limit:"){
                 $url_limit = $value;
                 $HasLimit = true;
            } else {
                $url .= urlencode($value) . '/';
            }
        }
        $url = str_replace('//', '/', $url) ; // do double replace before awc_url or http:// will mess up
        $url = awc_url . $url;
        $url = str_replace(' ', '_', $url) ; // test
         
            $s = 0; # carry this all the way down...
              if($HasLimit){
                  
                $HasLimit = false;
                $l = explode(":", $url_limit);
                $lm = explode(",", $l[1]);
                if(is_numeric($lm[0]) && is_numeric($lm[1])) {
                    
                     $s = $lm[0];
                     $tmp_limit = 'limit:' . $s . ',' . $limit ;
                     $sql_limit = 'LIMIT ' . $s . ',' . $lm[1] ;
                     
                     $current_page_num = $s ;
                     $HasLimit = true;
                     
                   #  die($current_page_num);
                     
                     if($lm[0] == '0') $HasLimit = false;
                
                } else { #if(is_numeric($lm[0]) && is_numeric($lm[1])) {
                        $sql_limit = "LIMIT $s,$limit";       
                }
              
              
            } else { #  if($HasLimit)
            
                if($limit) {
                     $sql_limit = "LIMIT $s,$limit";
                } else {
                    $sql_limit = '';
                }
                
                $first_return = true;        
            
            }
            
            $limit = intval($limit);
            $TotalPosts = intval($TotalPosts);
            #$page_number = intval($page_number);
            $PageCutOff = intval($PageCutOff);
            
            
            if($limit == $TotalPosts) $HasLimit = true;
            
            $page_number = (int)(($limit + $s) / $limit) ; # (int) will round the number down if its funky
            
            
           # die(">". $page_number);
            
            $sLoop = intval(($current_page_num + $limit) -1);
            $eLoop = intval(($PageCutOff + ($current_page_num + $limit )) -1) ;
            
           # die(">".$current_page_num );
            
            $sLimit = intval($s);
            $n=null;
            
            for( $i = 0; $i < $PageCutOff; ++$i ) {
               $n++;
               $sLimit = (($sLimit + $limit));
               
                if($sLimit > ($total_page_count*$limit)+1) break;
                $word['jump_to'] = null;
                $info['url'] = $url . 'limit:' . ($sLimit -1) .',' . $limit . $last_id;
                $info['click'] = ($n + $page_number) ;
                $tmp_top .= $tplt->phase($word, $info, 'top_blocks');
                $tmp_bot .= $tplt->phase($word, $info, 'bottom_blocks');
                
                #die(">". $limit);
                if($sLimit >= ($total_page_count*$limit)) break;          
            }

            $word['jump_to'] = null;    
            $info['url'] = $url . 'limit:' . (($total_page_count*$limit)-1) .',' . ($limit + 1) . $last_id;
            $info['click'] = $w_last ;
            $lastJump_top = $tplt->phase($word, $info, 'top_blocks');
            $lastJump_bot = $tplt->phase($word, $info, 'bottom_blocks');
                     
           if( isset($lm[0]) AND $lm[0] != '0'){
                $b = ($s-$limit);
                if (substr($b , 0, 1) == "-") $b = '0';
                
                $word['jump_to'] = null;
                $info['url'] = $url . 'limit:'. ($b) . ',' . $limit . $last_id ;
                $info['click'] = $w_prev . ' ' . $limit ;
                $back_top = $tplt->phase($word, $info, 'top_blocks');
                $back_bot = $tplt->phase($word, $info, 'bottom_blocks');
           } 
            
            $word['jump_to'] = null;
            $info['url'] = $url . 'limit:'. (($s+$limit)-1) . ',' . ($limit +1). $last_id ;
            $info['click'] = $w_next .' '.$limit ;
            $next_top = $tplt->phase($word, $info, 'top_blocks');
            $next_bot = $tplt->phase($word, $info, 'bottom_blocks');
            
                
            if($tmp_bot){
                
                $word['jump_to'] = get_awcsforum_word('word_JumpToPage') . ' ';
                $info['url'] = $url ;
                $info['click'] = '1' ;
                $LimitJump_top = $tplt->phase($word, $info, 'top_blocks');
                $LimitJump_bot = $tplt->phase($word, $info, 'bottom_blocks');
                
                 $LimitJump_bot .= $back_bot . $tmp_bot . $next_bot . $lastJump_bot;
                 $LimitJump_top .= $back_top . $tmp_top . $next_top . $lastJump_top;
            } else {
                
                $word['jump_to'] = get_awcsforum_word('word_JumpToPage') . ' ';
                $info['url'] = $url ;
                $info['click'] = '1' ;
                $LimitJump_top = $tplt->phase($word, $info, 'top_blocks');
                $LimitJump_bot = $tplt->phase($word, $info, 'bottom_blocks');
                
                $LimitJump_bot .= $back_bot ;
                $LimitJump_top .= $back_top ;
            }
            
            
           # die(">". $limit );
            if($TotalPosts < $limit){
             $LimitJump_top  = null;
             $LimitJump_bot  = null;
            }
            
          #die($sql_limit);
          return $sql_limit ; 
  }
  
  


  

function awc_forum_wikititles(){
global $awcs_forum_config;

    
    $wiki_title_search_len = (int)isset($awcs_forum_config->cf_wiki_title_search_len) ? $awcs_forum_config->cf_wiki_title_search_len : 5;
	$wiki_title_search_max_len = (int)isset($awcs_forum_config->cf_wiki_title_search_max_len) ? $awcs_forum_config->cf_wiki_title_search_max_len : 15;
	
    $cf_wiki_titles_namespaces = isset($awcs_forum_config->cf_wiki_titles_namespaces) ? $awcs_forum_config->cf_wiki_titles_namespaces : 'NS_MAIN';
    
     		$dbr = wfGetDB( DB_SLAVE ); 
    
             $WikifyingNamespaces = array($cf_wiki_titles_namespaces);
             
              $wiki_page = $dbr->tableName('page');
              $sql = "SELECT page_namespace, page_title 
                        FROM $wiki_page 
                        WHERE page_namespace IN (".(int)implode(',', $WikifyingNamespaces).") 
                                AND (LENGTH(page_title) >= " . $wiki_title_search_len . " AND LENGTH(page_title) <= ".$wiki_title_search_max_len.") AND page_title NOT LIKE '%Special:AWCforum%' 
                        ORDER BY CHAR_LENGTH(page_title) DESC";
             # die($sql);
              $res = $dbr->query($sql); 
              
              $c = 0;
              while ($r = $dbr->fetchObject( $res )) {;
                  ++$c;
                     $wiki_titles[$c]['title'] = str_replace('_', ' ', $r->page_title) ;
                     $wiki_titles[$c]['ns'] = $r->page_namespace ;
              }
              
            $dbr->freeResult( $res );
            
            unset($dbr, $res, $r, $c, $WikifyingNamespaces, $cf_wiki_titles_namespaces, $wiki_page);
            
            return $wiki_titles;
              
}

# http://www.php.net/manual/en/function.microtime.php
function processing_time($START=false) {
    
    $an = 4;    // How much digit return after point

    if(!$START) return time() + microtime();
    $END = time() + microtime();
    $r = ($END - $START) ;
    return round($r, $an);
}

