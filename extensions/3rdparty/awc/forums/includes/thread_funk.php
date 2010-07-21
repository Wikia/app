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
* @filepath /extensions/awc/forums/includes/thread_funk.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();

// require(awc_dir . 'functions/thread_funk.php');

function GetWikiPageOK($post_txt){
global $awcs_forum_config;

            $post_txt = str_replace('&lt;wiki&gt;', '<wiki>', $post_txt);
            $post_txt = str_replace('&lt;/wiki&gt;', '</wiki>', $post_txt);
            
            
            $match = "#<wiki>(.*)<\/wiki>#siU";
            if(preg_match($match, $post_txt, $found) && $awcs_forum_config->cf_wiki_pages == '1'){
             
                $match2 = "#<nowiki>(.*)<wiki>(.*)<\/wiki>(.*)<\/nowiki>#isU" ;
                if(preg_match($match2, $post_txt, $found2)) return ;
                
                $match2 = "#<pre>(.*)<wiki>(.*)<\/wiki>(.*)<\/pre>#isU" ;
                if(preg_match($match2, $post_txt, $found2)) return ;
                   
                $match3 = "#\[quote(.*)\](.*)<wiki>(.*)<\/wiki>(.*)\[/quote\]#isU" ;
                if(!preg_match($match3, $post_txt, $found2)) return true;
                    
            }
            
 return ;
}
    
    
function ClearNewPost($id){
global $awc_cookie;

// awc_pdie($_SESSION);

   if(is_array($_SESSION['awc_rActive'])){
            if(!in_array($id, $_SESSION['awc_rActive'], false)) {
                $_SESSION['awc_rActive'][$id] = $id;
                unset($_SESSION['awc_nActive'][$id]);
            }
    } 
}

 
  
 function wiki_links($post, $wiki_page_titles){ 
 global $wgMetaNamespace;
     
    #die(print_r($wgMetaNamespace));
   # return $post;
    $out = $post;
  #  die($post);
  # die(print_r($wiki_page_titles));
  
  if(!isset($wiki_page_titles) OR empty($wiki_page_titles)) return $post;
  
       # $post = convert_remove_pre($post);
       # DIE($post);
       
       
            // remove any  [[quote]], place in hold and put back later...
            $forum_wikitage_holder= null;
            $forum_wikitage_bracket_holder = array();
            $match = "#\<wiki\>(.+?)\</wiki\>#is";
            if (preg_match_all($match, $post, $found)){
               # die();
                   $forum_wikitage_holder = $found[0] ; 
                  foreach($forum_wikitage_holder as $k => $v){
                       $forum_wikitage_bracket_holder[$k] = $v;
                          $post = str_replace($v, "<|forum_wikitag|".$k."|h,o,l,d,e,r,|t,a,g,/>", $post); 
                  }  
            }
            
            
            // remove any  [[quote]], place in hold and put back later...
            $quote_holder= null;
            $quote_bracket_holder = array();
            $match = "#\[quote(.+?)\[/quote\]#is";
            if (preg_match_all($match, $post, $found)){
                   $quote_holder = $found[0] ; 
                  foreach($quote_holder as $k => $v){
                       $quote_bracket_holder[$k] = $v;
                          $post = str_replace($v, "<|quote_wikiwords|".$k."|h,o,l,d,e,r,|t,a,g,/>", $post); 
                  }  
            }
            
           

            // remove any  [[tags]], place in hold and put back later...
            $double_holder= null;
            $double_bracket_holder = array();
            $match = "#\[\[(.+?)\]\]#is";
            if (preg_match_all($match, $post, $found)){
                   $double_holder = $found[0] ; 
                  foreach($double_holder as $k => $v){
                       $double_bracket_holder[$k] = $v;
                          $post = str_replace($v, "<|double_wikiwords|".$k."|h,o,l,d,e,r,|t,a,g,/>", $post); 
                  }  
            }
            
            // remove any wiki [url] tags, place in hold and put back later...
            $single_holder= null;
            $single_bracket_holder = array();
            $match = "#\[(.+?)\]#is";
            if (preg_match_all($match, $post, $found)){
                   $single_holder = $found[0] ; 
                  foreach($single_holder as $k => $v){
                       $single_bracket_holder[$k] = $v;
                          $post = str_replace($v, "<|single_wikiwords|".$k."|h,o,l,d,e,r,|t,a,g,/>", $post); 
                  }  
            }
            
            
            
            // remove any wiki templates...
            $template_holder= null;
            $template_bracket_holder = array();
            $match = "#\{\{(.+?)\}\}#is";
            if (preg_match_all($match, $post, $found)){
                   $template_holder = $found[0] ; 
                  foreach($template_holder as $k => $v){
                       $template_bracket_holder[$k] = $v;
                          $post = str_replace($v, "<t,e,m,p,l,a,t,e,".$k."|h,o,l,d,e,r,|t,a,g,/>", $post); 
                  }  
            }
            
            
           
            // remove any url...
            $url_holder= null;
            $url_bracket_holder = array();
            $match = '#(?:(?:https?|ftps?)://[^.\s]+\.[^\s]+|(?:[^.\s/]+\.)+(.+?)(?:[:/][^\s]*)?)#is';
            $match = "#((?:http|https|ftp|nntp)://[^ ]+)#";
            if (preg_match_all($match, $post, $found)){
                 #  DIE();
                $url_holder = $found[0] ; 
                  foreach($url_holder as $k => $v){
                       $url_bracket_holder[$k] = $v;
                          $post = str_replace($v, "<u,r,l,p,l,a,t,e,".$k."|h,o,l,d,e,r,|t,a,g,/>", $post); 
                  }  
            }
            
           #  awc_pdie(">". $post);
            
            
            #$double_holder2= null;
            
            $double_holder2 = null;
            $double_bracket_holder2 = array();
            $double_bracket_count = 0;
            
            // die(print_r($wiki_page_titles));
          #  die($post);
          #awc_pdie($wiki_page_titles);
            foreach($wiki_page_titles as $pageid => $titles){
                    
               
                    $title = $titles['title'];
                    $ns = $titles['ns'] ;
                    
                    # [^a-zA-Z0-9]
                      $express = '/\b('.preg_quote($title, '/').')\b/i';
                      
                     # die($post);
                     # print($express . "<br />");
                    # $express = '/\b('.preg_quote($title, '/').')\s/i';
                    # $express = '/(?<=.\W|\b|^\W)(' . preg_quote($title, '/') . ')(?=\W)(?=.\s)/';
                    # $express = '/(?<=.\W|\b|^\W)(' . preg_quote($title, '/') . ')(?=.\W|\s)/i';
                    
                    switch ($ns) {
                    
                        case NS_MAIN:
                            $post = preg_replace( $express, "[[$title|$1]]", $post );
                          break;
                          
                        case NS_TALK:
                            $post = preg_replace ( $express, "[[Talk:$title|$1]]", $post );
                        break;
                        
                        case NS_USER:
                            $post = preg_replace ( $express, "[[User:$title|$1]]", $post );
                        break;
                        
                        case NS_USER_TALK:
                            $post = preg_replace ( $express, "[[User_talk:$title|$1]]", $post );
                        break;
                        
                        case NS_PROJECT:
                            $post = preg_replace ( $express, "[[$wgMetaNamespace:$title|$1]]", $post );
                        break;
                        
                        case NS_PROJECT_TALK:
                            $post = preg_replace ( $express, "[[$wgMetaNamespace_talk:$title|$1]]", $post );
                        break;
                        
                        case NS_IMAGE:
                            $post = preg_replace ( $express, "[[Image:$title|$1]]", $post );
                        break;
                        
                        case NS_IMAGE_TALK:
                            $post = preg_replace ( $express, "[[Image_talk:$title|$1]]", $post );
                        break;
                        
                        case NS_MEDIAWIKI:
                             $post = preg_replace ( $express, "[[MediaWiki:$title|$1]]", $post );
                        break;
                        
                        case NS_MEDIAWIKI_TALK:
                            $post = preg_replace ( $express, "[[MediaWiki_talk:$title|$1]]", $post );
                        break;
                        
                        case NS_TEMPLATE:
                            $post = preg_replace ( $express, "[[Template:$title|$1]]", $post );
                        break;
                        
                        case NS_TEMPLATE_TALK:
                            $post = preg_replace ( $express, "[[Template_talk:$title|$1]]", $post );
                        break;
                        
                        case NS_HELP:
                            $post = preg_replace ( $express, "[[Help:$title|$1]]", $post );
                        break;
                        
                        case NS_HELP_TALK:
                            $post = preg_replace ( $express, "[[Help_talk:$title|$1]]", $post );
                        break;
                        
                        case NS_CATEGORY:
                            $post = preg_replace ( $express, "[[:Category:$title|$1]]", $post );
                        break;
                        
                        case NS_CATEGORY_TALK:
                            $post = preg_replace ( $express, "[[:Category_talk:$title|$1]]", $post );
                        break;
                        
                        default:
                          break;
                    
                    }
                    
                    
                    
                    // remove any  [[tags]] which where JUST added, so not to duplacate them...
                    $match = "#\[\[(.+?)\]\]#is";
                    if (preg_match_all($match, $post, $found)){
                           $double_holder2[] = $found[0] ; 
                           
                        #   die(print_r($double_holder2));
                           
                          foreach($double_holder2 as $k => $v){
                               
                               foreach($v as $kk => $vv){
                                 #  die(print_r($kk));
                                    ++ $double_bracket_count; 
                                     $double_bracket_holder2[$double_bracket_count] = $vv;
                                     $post = str_replace($vv, "<b,o,u,b,l,e,,b,r,a,c,k,t,".$double_bracket_count."|h,o,l,d,e,r,|t,a,g,2/>", $post); 
                               }
                                 
                          }
                           
                    }
            
                    
            }
           # die(); 

          #   $post = convert_add_back_pre($post);
             
            
            
            if(isset($quote_holder)){
                foreach($quote_holder as $k => $v){
                    $post = str_replace( "<|quote_wikiwords|".$k."|h,o,l,d,e,r,|t,a,g,/>", $quote_bracket_holder[$k] , $post); 
                }
                unset($quote_bracket_holder,$k,$v,$quote_holder);
            } 
            
            if(isset($double_holder)){
                foreach($double_holder as $k => $v){
                    $post = str_replace( "<|double_wikiwords|".$k."|h,o,l,d,e,r,|t,a,g,/>", $double_bracket_holder[$k] , $post); 
                }
                unset($double_bracket_holder,$k,$v,$double_holder);
            } 
            

            if(isset($template_holder)){
                foreach($template_holder as $k => $v){
                    $post = str_replace( "<t,e,m,p,l,a,t,e,".$k."|h,o,l,d,e,r,|t,a,g,/>", $template_bracket_holder[$k] , $post); 
                }
                unset($template_bracket_holder,$k,$v,$template_holder);
            }            

            
            if(isset($url_holder)){
                foreach($url_holder as $k => $v){
                    $post = str_replace( "<u,r,l,p,l,a,t,e,".$k."|h,o,l,d,e,r,|t,a,g,/>", $url_bracket_holder[$k] , $post); 
                }
                unset($url_holder,$k,$v,$url_bracket_holder);
            }
             
           # die(print_r($double_bracket_holder2));
            if(isset($double_bracket_holder2)){
                       for( $i = 1; $i < $double_bracket_count +1; ++$i ) {
                            $post = str_replace( "<b,o,u,b,l,e,,b,r,a,c,k,t,".$i."|h,o,l,d,e,r,|t,a,g,2/>", $double_bracket_holder2[$i] , $post); 
                       }
                unset($double_bracket_holder2);
                unset($double_holder2);
            }
            
            
            
              
            if(isset($forum_wikitage_holder)){
                foreach($forum_wikitage_holder as $k => $v){
                    $post = str_replace( "<|forum_wikitag|".$k."|h,o,l,d,e,r,|t,a,g,/>", $forum_wikitage_bracket_holder[$k] , $post); 
                }
                unset($forum_wikitage_bracket_holder,$k,$v,$forum_wikitage_holder);
            } 
            
            if(isset($single_holder)){
                foreach($single_holder as $k => $v){
                    $post = str_replace( "<|single_wikiwords|".$k."|h,o,l,d,e,r,|t,a,g,/>", $single_bracket_holder[$k] , $post); 
                }
                unset($single_bracket_holder,$k,$v,$single_holder);
            } 
            
           # die($post);

return $post;

}

function HighLightSearchWord($haystack, $needle){
# http://us2.php.net/str_replace
        $pos=null;
        $h=strtoupper($haystack);
        $n=strtoupper(' ' . $needle . ' ');
        if($n) $pos=strpos($h,$n);
        if ($pos !== false) {
            $var=substr($haystack,0,$pos)."<font class='highlightsearchword'>".substr($haystack,$pos,strlen($needle))."</font>";
            $var.=substr($haystack,($pos+strlen($needle)));
            $haystack=$var;
        }
        
        return $haystack;
}
    
    