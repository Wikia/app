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
* @filepath /extensions/awc/forums/includes/smile.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

function GetEmotions(){
global $emotions_cls;

             if(!isset($emotions_cls)){
             			$emotions_cls = new awcs_forum_simlies();
             			$emotions_cls->GetEmotions();
             			return $emotions_cls->emo_array;
             	} else {
             		return $emotions_cls->emo_array;
             	}
}
 
function awcf_emotions($p, $e){

           if(empty($e)) return $p;
             	
             // remove any pre, code, nowiki, etc. tags
             #$p = convert_remove_pre($p);
             
            foreach($e as $k => $v){
                # AWC sucks at this so i stole this form the phpBB code, thanks phpBB :)
               # $orig[] = "/(?<=.\W|\W.|^\W)" . preg_quote($k, "/") . "(?=.\W|\W.|\W$)/";
              # $repl[] = '|emotion_tag|' . $path . $v . '|emotion_tag|_end|';
                
                #$icon_code = preg_quote($k, "/");
                #$orig[] = "!(?<=[^\w&;/])$icon_code(?=.\W|\W.|\W$)!i";
                
                
               # $orig[] = "/(?<=.\W|\w.|^\W)" . preg_quote($k, "/") . "(?=.\W|\W.|\W$)/i"; # working 2.5.7
                $orig[] = "/(?<=.\W|\w.|^\W)" . preg_quote($k, "/") . "(?=.\W|\W.|\W$)/"; # working 2.5.7
                #$orig[] = "/" . preg_quote($k, "/") . "/";
                $repl[] = '|emotion_tag|' . emo_path . $v . '|emotion_tag|_end|';
            }
            
           # die($p);
            $p = preg_replace($orig, $repl, ' ' . $p . ' ');
            $p = substr($p, 1, -1);
            
            
            // add back the pre, code, nowiki, etc. tags...
           # $p = convert_add_back_pre($p);

    return $p;
}


function EmotionsToToolbar($e, $t){
global $emotions_cls;

         if(!isset($emotions_cls)){
                     $emotions_cls = new awcs_forum_simlies();
                     $emotions_cls->GetEmotions();
                     return $emotions_cls->make_tool_bar() ;
             } else {
                 return $emotions_cls->make_tool_bar() ;
             }
                 
        
}


class awcs_forum_simlies{
	
	var $emo_array = array();
	static $GetEmotions_loaded = false;
	
		function GetEmotions(){
		
			if(awcs_forum_simlies::$GetEmotions_loaded) return;
			    
		        $dbr = wfGetDB( DB_SLAVE );
		        
		        $res = $dbr->select( 'awc_f_emotions', 
                            array( '*' ),'',
                             __METHOD__ );
                               
		         while ($r = $dbr->fetchObject( $res )) {
		              $this->emo_array[$r->e_code] = $r->e_pic ;
		          }
		        $dbr->freeResult( $res );
		        unset($sql, $res, $r);
		        
                
		   awcs_forum_simlies::$GetEmotions_loaded = true;
		}
		
		
		function make_tool_bar(){
        $emo = null;
    
        foreach($this->emo_array as $code => $pic){
            $c = str_replace('\'', "\'", $code);
            $emo .= '&nbsp;<a href="javascript:add_emotions(\' '.$c.' \')"><img src="'. emo_path . $pic.'" /></a>';
        }
        
        return '<table><tr><td>' . $emo  . '</td></tr></table>';
		}
		
	
	
	
	
	
	
	
}