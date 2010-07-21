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
* @filepath /extensions/awc/forums/load/load_skin.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();


function awcs_forum_tplt_disaply_post(){
global $tplt;

        $tplt->add_tplts(array("'post_edited_on'", 
                                 "'post_title_row'", 
                                 "'post_table'", 
                                 "'link_profile'", 
                                 "'sig_display'", 
                                 "'post_avatar'",
                                 "'edit_buttons_row'",
                                 "'post_avatar'",
                                 "'link_wikiedits'",
                                 "'link_threads'",
                                 "'link_posts'",
                                 "'post:quote_button'",
                                 "'post:edit_button'",
                                 "'post:spltmerge_button'",
                                 "'post:delete_thread'",
                                 "'post:delete_post'", 
                                 "'link_send_pm_to'", 
                                 "'post:close_poll'",
                                 "'post:delete_poll'",
                                 "'post:open_poll'",
                                 "'post:poll'", 
                                 "'post:reopen_poll'",
        						 "'close_table'",
                                 ));

}


function awcs_forum_tplt_post_box(){
global $tplt;

            $tplt->add_tplts(array("'post_box'",
                                     "'mod_chks_ann'",
                                     "'mod_chks'",
                                     "'button:preview'",
                                     "'button:submit'",
                                     "'spam_fields'",
                                     "'forum_tool_bar'",
                                     "'forum_tool_bar_tags'",
                                     "'subscrib_chk'",
        						 "'close_table'", ));
                                     
                                     
}



if(version_compare(awcs_forum_ver_current, awcs_forum_ver, '=')){
    
    
    $tplt->add_tplts(array("'close_table'",
                                 "'footer_whoshere'", 
                                 "'breadcrumbs'",
                                 "'top_menu_top'",
                                 "'top_menu_user_links'",
                                 "'top_menu_search_link'",
                                 "'top_menu_admin_link'",
                                 "'top_menu_todays_posts_link'",
                                 "'top_search_box'",
        						 "'close_table'", ));
        
     
   
    switch( $action_url['what_file'] ) {
        
        // /
        case 'search': 
            $tplt->add_tplts(array("'bottom_page_jumps'",
                                     "'top_blocks'",
                                     "'bottom_blocks'",
        						 "'close_table'", )); 
            break;   
            case 'post':
               # $tplt->add_tplts(array("'post_date_link'", )); 
                break;
            
            case 'st': 
            case 'sp':
            $tplt->add_tplts(array("'subscrib_links'",
                                     "'options_dropdown'",
                                     "'top_page_jumps'",
                                     "'bottom_page_jumps'",
                                     "'thread_header'",
                                     "'top_blocks'",
                                     "'bottom_blocks'",
                                     "'mod_thread_dropdown'",
                                     "'mod_thread_dropdown_ann'", 
                                     "'post_date_link'",
        						 "'close_table'", ));
                                  
                            
                      if($awcUser->canRead){
                      	
                      	// go through this for MOD and ADMIN templates, dont load if not needed...
                        
							awcs_forum_tplt_disaply_post();
                            awcs_forum_tplt_post_box();
                            
		                      if(UserPerm >= 10){
		                      	
		                      	
		                      	
		                      }
		                      
		                      
		                      if(UserPerm >= 2){
		                      	
		                      	
		                      	
		                      }
		                      
                      
                      }                
                                     
                                         
                break;
                
            case 'delete_post':
            case 'delete_thread':                   
                break;

        
            case 'member_options': 
                    $tplt->add_tplts(array("'pm:save_pm'",
                                             "'bottom_page_jumps'",
                                             "'thread_header'",
                                             "'top_blocks'",
                                             "'bottom_blocks'",
                                             "'mod_thread_dropdown'",
                                             "'mod_thread_dropdown_ann'",
        						 "'close_table'", )); 
                   
                   awcs_forum_tplt_disaply_post();          
			       awcs_forum_tplt_post_box(); 
                   
                break;
                
                
            case 'pm':
              
                break; 
                
                
                
            case 'mem_profile':
                    $tplt->add_tplts(array("'mem_profile_table'",
        						 "'close_table'", )); 
                break; 

                
                
            case 'mem_profile':
            case 'credits':
            case 'whoshere':  
                break;          
            
            case 'sc':
            $tplt->add_tplts(array("'cat_list_forums_rows'",
                                 "'cat_open_table'", 
                                 "'cat_close_table'",
                                 "'cat_header'", 
                                 "'breadcrumbs '",
        						 "'close_table'",));
                                 
            case 'sf':
            $tplt->add_tplts(array("'thread_list_header'",
                                    "'thread_list_rows'",
                                    "'bottom_page_jumps'",
                                    "'top_page_jumps'",
                                    "'bottom_blocks'",
                                    "'top_blocks'",
                                    "'thread_list_header_menu'",
                                    "'forum:start_new_thread'",
                                    "'forum:subscrib_to_forum'",
                                    "'postblocks_threadlisting'",
        						 "'close_table'",
                                    ) );
                                    
            if((UserPerm >=2)){
               
                $tplt->add_tplts(array("'thread_listing_mod_drop'",
                                        "'thread_listing_mod_drop_ann'",
        						 "'close_table'",
                                        ) );
            }
           
            break;
            
            
            case 'subf':
            break;
            
            case 'mod':
            case 'admin':
            	
                    awcsforum_funcs::get_page_lang(array('lang_txt_redirects')); // get lang difinitions... 
                    $tplt->add_tplts(array("'redirect'",
        						 "'close_table'", ), true);
                break;
            
            
            default:
            
            $tplt->add_tplts(array("'cat_list_forums_rows'",
                                 "'cat_open_table'", 
                                 "'cat_close_table'",
                                 "'cat_header'",
                                 "'footer_forum_stats'", 
                                 "'breadcrumbs '",
        						 "'close_table'",));
                
                break;
    }
    
     $action_url['section'] = isset($action_url['section']) ? $action_url['section'] : '';
     
    // die($action_url['section'] );
     switch( $action_url['section'] ) {
         
         
             case 'GetEditThread':
             case 'quote':
             case 'GetEdit':
             case 'todo_edit_post':
             
                   awcs_forum_tplt_disaply_post();          
                   awcs_forum_tplt_post_box();
                                                     
                    $tplt->add_tplts(array("'pm:save_pm'",
                                             "'bottom_page_jumps'",
                                             "'thread_header'",
                                             "'top_blocks'",
                                             "'bottom_blocks'",
                                             "'mod_thread_dropdown'",
                                             "'mod_thread_dropdown_ann'",
        						 "'close_table'", )); 
            
             break;
             
             
            case 'recent':
            case 's':
            case 's_form':
            case 'memtopics':
            case 'memposts':
            case 'todate':
                awcs_forum_tplt_disaply_post();
                awcs_forum_tplt_post_box();
            $tplt->add_tplts(array("'thread_list_header'",
                                    "'thread_list_rows'",
                                    "'bottom_page_jumps'",
                                    "'top_page_jumps'",
                                    "'bottom_blocks'",
                                    "'top_blocks'",
                                    "'thread_list_header_menu'",
                                    "'forum:start_new_thread'",
                                    "'forum:subscrib_to_forum'",
                                    "'postblocks_threadlisting'",
                                    "'col_5_isSearch_forum_name'",
        						 "'close_table'",
                                    ) );
                                    
            $tplt->add_tplts(array("'subscrib_links'",
                                     "'options_dropdown'",
                                     "'top_page_jumps'",
                                     "'bottom_page_jumps'",
                                     "'thread_header'",
                                     "'top_blocks'",
                                     "'bottom_blocks'",
                                     "'mod_thread_dropdown'",
                                     "'mod_thread_dropdown_ann'", 
                                     "'post_date_link'",
        						 "'close_table'", ));
           
            break;
            
            
            case 'todo_new_t':
                    awcs_forum_tplt_post_box();
            break;
            
            case 'sub':
            case 'submit_poll':
            case 'create_cat_do':
            case 'fsub':
            case 'close_poll':
            case 'delete_poll':
            case 'reopen_poll':
            
                    awcsforum_funcs::get_page_lang(array('lang_txt_redirects')); // get lang difinitions... 
                    $tplt->add_tplts(array("'redirect'",
        						 "'close_table'", ), true);
            break;
            
            
            case 'todo_add_thread':
            case 'todo_add_post':   
                // need a preview check...
                   awcs_forum_tplt_disaply_post();          
                   awcs_forum_tplt_post_box();
                   
                    $tplt->add_tplts(array("'redirect'",
        						 "'close_table'", ));
                break;
                
            case 'edithistory':    
                // need a preview check...
                   awcs_forum_tplt_disaply_post();          
                break;
            
     }
    
    
    $tplt->get_tplts_html();
    
}