<?PHP
/*
License:
Another Web Compnay (AWC) 

All of Another Web Company's (AWC) MediaWiki Extensions are licensed under
Creative Commons Attribution-Share Alike 3.0 United States License
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


    	global $wgDBprefix, $wgUser, $delete_langs, $wgOut, $IP, $forumver, $wgOut;
    	
	    $awc_dir = awc_dir; # 
	    $awc_install_dir = awc_dir . "updates/install/"; # 
	    $awc_lang_dir = awc_dir . "languages/"; #
    
    
        $dbw =& wfGetDB( DB_MASTER );
        $dbr =& wfGetDB( DB_SLAVE );
        
        #$date_seperated = awcsforum_funcs::date_seperated(wfTimestampNow());
    	$date_seperated = $dbw->timestamp();
    
    
        /** @changeVer 2.5.8 changed to new table install, use .sql file */
        /** @todo work other dBases here too */
		require_once( awc_dir . 'dBase.php' );
		$installCLS = new awcforum_cls_dBase();
		$installCLS->testCreate();
		$installCLS->sourceFile($awc_install_dir, 'install_tables');
		
        require_once( $awc_install_dir . 'config.php' );
        
        foreach($Config_Settings as $q => $v){
            	
            	    $s = isset($v[0]) ? $v[0] : null;
            		$t = isset($v[1]) ? $v[1] : null;
            		$a = isset($v[2]) ? $v[2] : null;
                    
            		#print "typeis->{$t} | q=$q<br />";
            		#die("typeis->" . $q);
            		
                    $sql1 = "SELECT * FROM " . $wgDBprefix . "awc_f_config WHERE q = '". $q ."'";
                            $res1 = $dbr->query($sql1);
                            
                            if (! $dbw->fetchObject( $res1 )){
                             $wgOut->addHTML($wgDBprefix . "awc_f_config <b>Inserted: </b> " . $q . "<br>" );

                             $dbw->insert( 'awc_f_config', array(
                                    'q'        => $q,
                                    'a'           => $a,
                                    'typeis'           => $t,
                                    'section'           => $s,
                                ) );
                                
                            }
         }

         	unset($Config_Settings);
            $wgOut->addHTML("<hr>");
            
            
	        $sql = 'SELECT * FROM ' . $wgDBprefix . 'awc_f_cats';
	        $res = $dbr->query($sql);
	        
	        if (! $dbw->fetchObject( $res )){
	                               
	        		#$bs = $dbw->nextSequenceValue( 'awc_f_cats_cat_id_seq' );
	                $dbw->insert( 'awc_f_cats', array(
	                    'cat_name'        => "Test Category",
	                    'cat_desc'           => "The Description Would Go Here",
	                    'c_wiki_perm'        => "*",
	                    'cat_order'           => 0 ,
	                ) );
	                $id = awcsforum_funcs::lastID($dbw, 'awc_f_cats', 'cat_id');
	                
	                
	                #$bs = $dbw->nextSequenceValue( 'awc_f_forums_f_id_seq' );
	                $dbw->insert( 'awc_f_forums', array(
	                    'f_name'        => "Forum Name",
	                    'f_desc'           => "Description Goes Here...",
	                    'f_wiki_read_perm'           => "*",
	                    'f_wiki_write_perm'           => "user",
	                    'f_parentid'       => $id,
	                    'f_order'       => 0,
	                ) );
	                $f_id = awcsforum_funcs::lastID($dbw, 'awc_f_forums', 'f_id');
	                
	                
	               # $bs = $dbw->nextSequenceValue( 'awc_f_threads_t_id_seq' );
	                $dbw->insert( 'awc_f_threads', array(
	                    't_forumid'        	=> $f_id,
	                    't_name'           	=> "Test Thread",
	                    't_starter'       	=> $wgUser->getName(),
	                    't_starterid'   	=> $wgUser->mId,
	                    't_date'           	=> $date_seperated,
	                    't_lastdate'       	=> $date_seperated,
	                ) );
	                $tid = awcsforum_funcs::lastID($dbw, 'awc_f_threads', 't_id');
	                
	                
	                $dbw->insert( 'awc_f_posts', array(
	                    'p_threadid'        	=> $tid,
	                    'p_post'           	=> "Hello and welcome!",
	                    'p_user'           	=> $wgUser->getName(),
	                    'p_userid'      	=> $wgUser->mId, 
	                    'p_date'           	=> $date_seperated,
	                    'p_forumid'         	=> $f_id,
	                    'p_thread_start'    => '1',
	                ) );
	                
	                $dbw->update( 'awc_f_forums',
	                                array('f_threads'          => '1',
	                                      'f_lastdate'          => $date_seperated,
	                                      'f_lastuserid'          => $wgUser->mId,
	                                      'f_lastuser'          => $wgUser->getName(),
	                                      'f_threadid'          => $tid,
	                                      'f_lasttitle'          => "Test Thread",
	                                      ), 
	                                array('f_id' => $f_id),
	                                '' );
	                
	                $dbw->insert( 'awc_f_mems', array(
	                    'm_posts'           => "1",
	                    'm_topics'           => "1",
	                    'm_idname'           => $wgUser->getName(),
	                    'm_id'      => $wgUser->mId, 
	                ) );
	            $wgOut->addHTML("<hr>");
	             
	            
	             $dbw->insert( 'awc_f_langs',
	                                    array(  'lang_code'        => "en",
	                                            'lang_name'        => "English",
	                                            ) );
	                                            
	                                            
	                $dbw->insert( 'awc_f_stats', array(
	                    'stat_mems'         => "1",
	                    'stat_threads'      => "1",
	                    'stat_posts'        => "1",
	                    'stat_maxusers'     => "1",
	                ) );
	           
	        
	        }
        
        
	        $emotions = array();
	        $emotions[':)'] = 'smile.png';
	        $emotions[':('] = 'sad.gif';
	        $emotions[':D'] = 'biggrin.gif';
	        $emotions[':mad:'] = 'mad.gif';
	        $emotions[':eek:'] = 'bigeyed.png';
	        $emotions[':confused:'] = 'blink.gif';
	        $emotions[':o'] = 'blush.gif';
	        $emotions[';)'] = 'wink.gif';
	        $emotions[':heart:'] = 'heart.gif';
	        $emotions[':wub:'] = 'wub.gif';
	        $emotions[':p'] = 'tongue.gif';
	        $emotions[':lol:'] = 'laughingsmiley.gif';
	        $emotions[':roll:'] = 'rolleyes.gif';
	        $emotions[':thumbsdown:'] = 'thumbsdown.gif';
	        $emotions[':thumbsup:'] = 'thumbsup.gif';
	        
                $awc_f_emotions = $dbw->tableName( 'awc_f_emotions' ); 
                foreach ($emotions as $q => $a){
                    
                   # $res = $dbr->select( 'awc_f_emotions', 
                               # array( 'e_code' ), array('e_code' => $q) , __METHOD__);
                    
                    $r = $dbr->selectRow( 'awc_f_emotions', 
                                array( 'e_code' ), array('e_code' => $q) , __METHOD__);
                   # awc_pdie($r);                             
                    if (!$r){ 
                            $dbw->insert( 'awc_f_emotions', 
                                array('e_code' => $q,
                                        'e_pic' => $a,
                                        ) );
                    }
                }
                
        		require_once( awc_dir . 'admin.php' );
        		require_once( awc_dir . 'includes/admin/admin_memtitle.php' );
        		
				$memTitle_cls = new awcsf_admin_membertitle();
	            $memTitle_cls->insert_new('Just Got Here', '0');
	            $memTitle_cls->insert_new('Clicked A Few Times', '5');
	            $memTitle_cls->insert_new('Gets Around', '45');
	            $memTitle_cls->insert_new('Forum Regular', '175');
	            $memTitle_cls->insert_new('Forum Vet', '300');
        		
        		global $awcs_forum_config;
        		#require_once( awc_dir . 'admin.php' );
        		$awcs_forum_config = new awcf_fake_class();
        		$awcs_forum_config->thmn_id = 0;
        		
        		
	            require_once( awc_dir . 'includes/admin/admin_funk.php' );
	            require_once( awc_dir . 'includes/admin/admin_lang_funk.php' );  
	            require_once( awc_dir . 'includes/admin/admin_css_funk.php' );  
	            require_once( awc_dir . 'includes/admin/admin_tplt.php' );       
            	
	            $lang_cls = new awc_admin_lang_cls();
	        	$tplt_cls = new awc_admin_tplt_cls();
	        	$css_cls = new awc_admin_css_cls();
	        	
	            $lang_cls->lang_code = 'en';
	            $lang_cls->lang_do_import_lang($awc_install_dir . 'lang.txt');
	            $wgOut->addHTML("Language text added... <hr>");
            	
               	$tbl = $dbw->tableName('awc_f_theme_tplt');
                $sql = $installCLS->clearTable($tbl);
                $res = $dbw->query($sql);
                
                $tbl = $dbw->tableName('awc_f_theme');
                $sql = $installCLS->clearTable($tbl);
                $res = $dbw->query($sql);
                
                $tbl = $dbw->tableName('awc_f_theme_names');
                $sql = $installCLS->clearTable($tbl);
                $res = $dbw->query($sql);
                
                $tbl = $dbw->tableName('awc_f_theme_css');
                $sql = $installCLS->clearTable($tbl);
                $res = $dbw->query($sql);
                
                $dbw->commit();
                
                $dbw->begin();
                
                /*  $dbw->nextSequenceValue( 'awc_f_TABLE_COL-ID_seq' );
                 *  Needed for PostgreSQL
                 */
                #$thm_id = $dbw->nextSequenceValue( 'awc_f_theme_thm_id_seq' );
                $dbw->insert( 'awc_f_theme', array(
                    'thm_title'        => 'Default',
                    'thm_who'           => 'AWC',
                    'thm_css_id'           => '1',
                    'thm_tplt_id'           => '2',
                    'thm_where'           =>'wiki.anotherwebcom.com',
                    'thm_when'           => $date_seperated,
                ), __METHOD__ );
                $thm_id = awcsforum_funcs::lastID($dbw, 'awc_f_theme', 'thm_id');
                #print(">>thm_id= $thm_id <br>");
                
                
                $css_cls->thm_id = $thm_id;
                $css_cls->css_import($awc_install_dir . 'css.xml', '', true);
                $wgOut->addHTML("CSS added... <hr>");
                
                
                $tplt_cls->thm_id = $thm_id;
                $tplt_cls->import_xml($awc_install_dir . 'tplt.xml',null,false, true);
            	$wgOut->addHTML("Skin Templates added... <hr>");
            	
            	
            	
            	$res = $dbr->select( 'awc_f_theme_names', 
                             array( '*' ), '' , __METHOD__, array('OFFSET' => '0', 'LIMIT' => '2'));
               
                foreach($res as $r){
                	
                	if($r->thmn_what == 'css'){
		                $css_id = $r->thmn_id; 
		                $css_thmn_item_count = $r->thmn_item_count; 
		                $css_thmn_who = $r->thmn_who; 
		                $css_thmn_where = $r->thmn_where; 
                	}
                	
                	if($r->thmn_what == 'tplt'){
                		$tplt_id = $r->thmn_id;
                	}
                	   
		        }
                
                /*
                 * CRAP - find better way
                 */
                $dbw->update( 'awc_f_theme',
		                            array('thm_css_id' => $css_id, 
		                            	  'thm_tplt_id' => $tplt_id, ), 
		                            array('thm_id' => $thm_id),
		                            '' );
		                                          
                $dbw->update('awc_f_config',
                            array('a' => serialize(array('css'=> $css_id,
                                                         'tplt'=> $tplt_id,
                                                         'css_count'=> $css_thmn_item_count, 
                                                         'who'=> $css_thmn_who, 
                                                         'where'=> $css_thmn_where))
                                                         ), 
                            array('q' =>'cf_default_forum_theme'),'' );
                            
                            
                            
		                            
		        $dbw->update( 'awc_f_config',
		                            array('a'          => awcs_forum_ver,
		                                  ), 
		                            array('q' => 'cf_forumversion'),
		                            '' );
                            
            
            $wgOut->setPagetitle("Install Complete.");
            $wgOut->setSubtitle("Your done. Your AWC MediaWiki Forum Extention is all set up.<br /> Click <a href='?title=Special:AWCforum'>here</a> for your forum or go to your ACP for making changes: <a href='?title=Special:AWCforum/&action=admin'>Admin Control Panel</a>") ;
    
            $wgOut->addHTML('Your done. Your AWC MediaWiki Forum Extention is all set up.<br>');
                
            $page = $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
            $file = "http://anotherwebcom.com/app_count.php?app=WikiForum&url=$page" ;
            $file = @fopen ($file, "r");
             
             

class awcf_fake_class {


}             
             
