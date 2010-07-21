<?PHP
if ( !defined( 'MEDIAWIKI' ) ) die();
/*
License:
Another Web Compnay (AWC) 

All of Another Web Company's (AWC) MediaWiki Extensions are licensed under<br />
Creative Commons Attribution-Share Alike 3.0 United States License<br />
http://creativecommons.org/licenses/by-sa/3.0/us/

All of AWC's MediaWiki extension's can be freely-distribute, 
 no profit of any kind is allowed to be made off of or because of the extension itself, this includes Donations.

All of AWC's MediaWiki extension's can be edited or modified and freely-distribute 
 but these changes must be made public and viewable noting the changes are not original AWC code. 
 A link to http://anotherwebcom.com must be visable in the source code 
 along with being visable in render code for the public to see.

You are not allowed to remove the Another Web Company's (AWC) logo, link or name from any source code or rendered code. 
You are not allowed to create your own code which will remove or hide Another Web Company's (AWC) logo, link or name.

This License can and will be change with-out notice. 

All of Another Web Company's (AWC) software/code/programs are distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

4/2008 Another Web Compnay (AWC)
The above text must stay intact and not edited in any way.

*/

        $Config_Settings['cfl_ThreadTitleLength'] = array('forum', 'txt', '32');
        $Config_Settings['cf_SigLength'] = array('mem', 'txt', '2000');
        $Config_Settings['cf_DateShort'] = array('general', 'txt', 'M jS g:i a');
        $Config_Settings['cf_DateLong'] = array('general', 'txt', "g:i:s A - D, M jS Y"); 
        $Config_Settings['cfl_Thread_DisplayLimit'] = array('forum', 'txt', "25");
        $Config_Settings['cfl_Thread_MaxTitleLength'] = array('forum', 'txt', "75");
        $Config_Settings['cfl_Thread_MaxTitleLength_LastPostCol'] = array('forum', 'txt', "25");
        $Config_Settings['cfl_Post_DisplayLimit'] = array('thread', 'txt', "15");
        $Config_Settings['cfl_Post_cookie_postcountexpire'] = array('thread', 'txt', "1");
        $Config_Settings['cfl_Post_box_height'] = array('thread', 'txt', "25");
        $Config_Settings['cfl_Post_quickpost_box_height'] = array('thread', 'txt', "10");
        $Config_Settings['cfl_ThreadPageBlockLimit'] = array('forum', 'txt', "7");
        $Config_Settings['cfl_PostPageBlockLimit'] = array('thread', 'txt', "5");
        $Config_Settings['cfl_PostPageBlockLimitThreadTitle'] = array('thread', 'txt', "2");
        $Config_Settings['cf_AvatraSize'] = array('mem', 'txt', "100x100");
        $Config_Settings['cf_showThreadCount'] = array('thread', 'yesno', "1");
        $Config_Settings['cf_showPostCount'] = array('thread', 'yesno', "1");
        $Config_Settings['wikieits'] = array('thread', 'yesno', "0");
        $Config_Settings['cf_forumTag_numthreads'] = array('forum_tag', 'txt', "7");
        $Config_Settings['cf_forumTag_whatforums'] = array('forum_tag', 'txt', "0");  
        $Config_Settings['cf_forumTag_titlecutoff'] = array('forum_tag', 'txt', "15");
        $Config_Settings['cf_SigGuestView'] = array('general', 'yesno', "1");
        $Config_Settings['cf_Search_ChrLimit'] = array('general', 'txt', "3");
        $Config_Settings['cf_AdvatarGuestView'] = array('general', 'yesno', "1");
        $Config_Settings['cf_setRobotpolicy'] = array('general', 'txt', "INDEX,FOLLOW");
        $Config_Settings['cf_advatar_no_url'] = array('mem', 'yesno', '1');
        $Config_Settings['cf_advatar_no_wiki'] = array('mem', 'yesno', '0');
        $Config_Settings['cf_advatar_no_upload'] = array('mem', 'yesno', '0');
        $Config_Settings['cf_advatar_upload_size'] = array('mem', 'txt', "35000");
        $Config_Settings['cf_advatar_upload_exe'] = array('mem', 'txt', "gif,jpg,jpeg");
        $Config_Settings['cf_forumversion'] = array('', '', "0");
        $Config_Settings['cf_forumlang'] = array('', '', "0");
        $Config_Settings['cf_wiki_titles'] = array('thread', 'yesno', '0');
        $Config_Settings['cf_wiki_pages'] = array('thread', 'yesno', '0');
        
        $Config_Settings['cf__forumname'] = array('general', 'txt', '|$| Forum'); # 2.3.5
        $Config_Settings['cf__forumsubtitle'] = array('general', 'txt', 'Hope you enjoy your stay');  # 2.3.5
        $Config_Settings['cf_mem_maxpmhave'] = array('mem', 'txt', '32');  # 2.3.5
        $Config_Settings['cf_mem_maxpmsendusers'] = array('mem', 'txt', '5');  # 2.3.5
        $Config_Settings['cf_mod_maxpmhave'] = array('mem', 'txt', '64');  # 2.3.5
        $Config_Settings['cf_mod_maxpmsendusers'] = array('mem', 'txt', '10');  # 2.3.5
        $Config_Settings['cf_displaysmiles'] = array('thread', 'yesno', '1'); # 2.3.5
        $Config_Settings['cf_FCKeditor'] = array('thread', 'yesno', '0'); # 2.3.5 
        $Config_Settings['cf_extrawikitoolbox'] = array('thread', 'yesno', '0'); # 2.3.5 
        $Config_Settings['cf_threadsubscrip'] = array('thread', 'yesno', '1'); # 2.3.5 
        $Config_Settings['cf_forumsubscrip'] = array('forum', 'yesno', '1'); # 2.3.5 
        
        $Config_Settings['cfl_Polls_enabled'] = array('thread', 'yesno', "1"); # 2.4.1
        $Config_Settings['cfl_Polls_max'] = array('thread', 'txt', "5"); # 2.4.1
        $Config_Settings['cf_wiki_title_search_len'] = array('thread', 'txt', "5"); # 2.4.1
        
        $Config_Settings['cf_chrset'] = array('general', 'drop', "iso-8859-1"); # 2.4.2
        
        $Config_Settings['cf_default_theme'] = array('general', 'txt', '1'); # 2.5.0
        $Config_Settings['cf_css_mem_select'] = array('mem', 'yesno', '0');  # 2.5.0
        $Config_Settings['cf_css_active_ids'] = array('general', 'txt', '1');  # 2.5.0
        $Config_Settings['cf_html_extension'] = array('general', 'txt', '.html');  # 2.5.0
        $Config_Settings['cf_css_fileorembed'] = array('general', 'yesno', '0');  # 2.5.0
        $Config_Settings['cf_redirect_delay'] = array('general', 'txt', '2');  # 2.5.0 
        
        $Config_Settings['cf_header_import'] = array('general', 'txt', '');  # 2.5.1 
        
        $Config_Settings['cf_add_post_text_to_wiki'] = array('thread', 'yesno', '0');  # 2.5.2 
        $Config_Settings['cf_default_forum_theme'] = array('dont_show', '', serialize(array('css'=> '2', 'tplt'=>'3')));  # 2.5.2
        $Config_Settings['cf_show_whoes_here'] = array('general', 'yesno', '1');  # 2.5.2 
        $Config_Settings['cf_use_forum_stats'] = array('general', 'yesno', '1');  # 2.5.2 
        $Config_Settings['cf_save_recent_in_dabase'] = array('general', 'yesno', '0');  # 2.5.2 
        
        $Config_Settings['cf_show_guest_ip'] = array('thread', 'yesno', '0');  # 2.5.3 
        
        $Config_Settings['cf_allow_multi_pols'] = array('thread', 'yesno', '0');  # 2.5.5 
        $Config_Settings['cf_send_pm_body_in_email'] = array('mem', 'yesno', '0');  # 2.5.5
        $Config_Settings['cf_send_post_body_in_email'] = array('thread', 'yesno', '0');  # 2.5.5
        $Config_Settings['cf_send_post_body_in_email_limit'] = array('thread', 'txt', '500');  # 2.5.5
        $Config_Settings['cf_send_thread_body_in_email'] = array('forum', 'yesno', '0');  # 2.5.5
        $Config_Settings['cf_send_thread_body_in_email_limit'] = array('forum', 'txt', '500');  # 2.5.5
        $Config_Settings['cf_send_email_html'] = array('general', 'yesno', '1');  # 2.5.5
        
        $Config_Settings['cf_display_mem_titles'] = array('thread', 'yesno', '1');  # 2.5.8
        $Config_Settings['cf_wiki_titles_namespaces'] = array('thread', 'txt', 'NS_MAIN');  # 2.5.8
        $Config_Settings['cf_wiki_title_search_max_len'] = array('thread', 'txt', '15');  # 2.5.8
        
        
        $Remove_Config_Settings[] = 'cf_forumdisplay_yes5_no4';  # 2.5.0
        $Remove_Config_Settings[] = 'cf_no_wiki_advatar';
        $Remove_Config_Settings[] = 'cf_no_url_advatar';
        $Remove_Config_Settings[] = 'cf_no_upload_advatar';
        $Remove_Config_Settings[] = 'cf_css_default';
