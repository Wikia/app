<?php

$wgExtensionFunctions[] = 'wfSpecialViewManager';


function wfSpecialViewManager(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class ViewManager extends SpecialPage {
	
		function ViewManager(){
			UnlistedSpecialPage::UnlistedSpecialPage("ViewManager");
		}
		
		function getOwnerID($domain){
			$dbr =& wfGetDB( DB_SLAVE );
			$s = $dbr->selectRow( 'site_view', array( 'admin_user_id' ), array( 'view_domain_name' => $domain ), $fname );
			if ( $s === false ) {
				return 0;
			} else {
				return $s->admin_user_id;
			}
		}
		
		function execute(){
			global $wgUser, $wgOut, $wgRequest, $wgSiteView;
			$wgOut->setPagetitle( "Openserving Manager" );
			if( !$wgUser->isLoggedIn()  || (!$wgSiteView->isUserAdmin() && !($wgUser->mId==$this->getOwnerID($wgRequest->getVal( 'name' )) )) ) {
				$wgOut->addHTML($wgSiteView->isUserAdmin() ."Invalid Page");
				return;
			}
			$css = "<style>
			.view-form {font-weight:800;font-size:12px;font-color:#666666}
			.view-status {font-weight:800;font-size:12px;background-color:#990000;color:#FFFFFF;padding:5px;margin-bottom:5px;}
			</style>";
			$wgOut->addHTML($css);
			
	 		if(count($_POST)){
				//$wgOut->setArticleBodyOnly(true);
				$this->setDomainName($_POST["domain"]);
				$this->setAdsenseID($_POST["adsense"]);
				$this->setAnalyticsID('test');
				$this->setReturnURL($_POST["url"]);
				$this->setCategories($_POST["ctg"]);
				$this->setColor1($_POST["color1"]);
				$this->setColor2($_POST["color2"]);
				$this->setColor3($_POST["color3"]);
				$this->setBorderColor1($_POST["bordercolor1"]);
				$this->setOwnerID($_POST["owner"]);
				if($_POST["id"] == ""){
					$this->addNotificationEmail();
					$wgOut->addHTML("<span class='view-status'>Added View</span><br><br>");
					$this->addView();
				}else{
					$wgOut->addHTML("<span class='view-status'>The settings have been saved</span><br><br>");
					if($wgSiteView->isUserAdmin()){
						$this->updateView($_POST["id"]);
					}else{
						$this->updateViewByOwner($_POST["id"]);
					}
				}
				if($wgSiteView->isUserAdmin()){
					$wgOut->addHTML($this->displayViewList());
				}else{
					$wgOut->addHTML("<a href=http://" . $wgSiteView->getDomainName() . ".openserving.com>Click here to return to your openserving homepage</a>");
				}
			}else{
				if($wgRequest->getVal( 'method' ) == "edit"){
					if($wgRequest->getVal( 'name' ) != "")$this->loadFromDatabase($wgRequest->getVal( 'name' ));
					if($wgSiteView->isUserAdmin()){
						$wgOut->addHTML("<span class=title>Add/Edit View</span><br> <a href=index.php?title=Special:ViewManager>Back to list</a><br><br>");
					}
					$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Openserving/viewManager.js\"></script>\n");
					$wgOut->addHTML($this->displayForm());
				}else{
		 			$wgOut->addHTML($this->displayViewList());
				}
			}
		}
		
		function setDomainName($domain_name){ $this->view_domain_name = $domain_name;}
		function setAdsenseID($adsense){ $this->view_adsense_id = $adsense;}
		function setAnalyticsID($analytics){ $this->view_analytics = $analytics;}
		function setReturnURL($url){ $this->view_return_url = $url;}
		function setCategories($ctg){ $this->view_categories = $ctg;}
		function setColor1($hex){ $this->view_color_1 = $hex;}
		function setColor2($hex){ $this->view_color_2 = $hex;}
		function setColor3($hex){ $this->view_color_3 = $hex;}
		function setBorderColor1($hex){ $this->view_border_color_1 = $hex;}
		function setOwnerID($username){
			$dbr =& wfGetDB( DB_SLAVE );
			$s = $dbr->selectRow( 'user', array( 'user_id' ), array( 'user_name' => $username ), $fname );
			if ( $s === false ) {
				$this->admin_user_id = 0;
			} else {
				$this->admin_user_id = $s->user_id;
			}
		}

		function updateView($id){
			$dbw =& wfGetDB( DB_MASTER );
				$dbw->update( '`site_view`',
				array( /* SET */
					'view_domain_name' => $this->view_domain_name,
					'view_categories' => $this->view_categories,
					'view_adsense_id' => $this->view_adsense_id,
					'view_analytics_id' => $this->view_analytics,
					'view_return_url' => $this->view_return_url,
					
					'view_color_1' => $this->view_color_1,
					'view_color_2' => $this->view_color_2,
					'view_color_3' => $this->view_color_3,
					
					'view_border_color_1' => $this->view_border_color_1,
					
					'admin_user_id' => $this->admin_user_id
				), array( /* WHERE */
					'view_id' => $id
				), ""
				);
		}
		
		function updateViewByOwner($id){
			$dbw =& wfGetDB( DB_MASTER );
				$dbw->update( '`site_view`',
				array( /* SET */
					
				
					'view_adsense_id' => $this->view_adsense_id,
					'view_analytics_id' => $this->view_analytics,
					'view_return_url' => $this->view_return_url,
					
					'view_color_1' => $this->view_color_1,
					'view_color_2' => $this->view_color_2,
					'view_color_3' => $this->view_color_3,
					
					'view_border_color_1' => $this->view_border_color_1
				), array( /* WHERE */
					'view_id' => $id
				), ""
				);
		}
		
		function addView() {
			$fname = 'ViewManager::addToDatabase';
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->insert( '`site_view`',
				array(
					'view_domain_name' => $this->view_domain_name,
					'view_adsense_id' => $this->view_adsense_id,
					'view_analytics_id' => $this->view_analytics,
					'view_return_url' => $this->view_return_url,
					'view_color_1' =>  $this->view_color_1 ,
					'view_color_2' => $this->view_color_2,
					'view_color_3' => $this->view_color_3,
					'view_border_color_1' => $this->view_border_color_1,
					'view_categories' => $this->view_categories,
					'admin_user_id' => $this->admin_user_id
				), $fname
			);

		}
		
		function loadFromDatabase($name){
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( '`site_view`', array( 'view_id', 'view_domain_name','view_return_url','view_adsense_id','view_analytics_id',
			  'view_categories', 'view_color_1','view_color_2','view_color_3','view_border_color_1','admin_user_id'),
		
			array( 'view_domain_name' => $name ), "" );
	
			if ( $s !== false ) {
				$this->view_domain_name = $s->view_domain_name;
				$this->view_return_url = $s->view_return_url;
				$this->view_adsense_id = $s->view_adsense_id;
				$this->view_analytics_id = $s->view_analytics_id;
				$this->view_categories = $s->view_categories;
				$this->view_color_1 = $s->view_color_1;
				$this->view_color_2 = $s->view_color_2;
				$this->view_color_3 = $s->view_color_3;
				$this->view_border_color_1 = $s->view_border_color_1;
				$this->admin_user_id = $s->admin_user_id;
				$this->view_id = $s->view_id;
			}
		
			$s = $dbr->selectRow( 'user', array( 'user_name' ), array( 'user_id' => $this->admin_user_id ), $fname );
			if ( $s === false ) {
				$this->owner_username = "";
			} else {
				$this->owner_username = $s->user_name;
			}
		}
		
		function displayViewList(){
			$dbr =& wfGetDB( DB_SLAVE );
			$sql = "SELECT view_id, view_domain_name, view_categories, view_adsense_id, view_analytics_id, view_return_url, view_color_1, view_color_2, view_color_3, view_border_color_1 FROM site_view order by view_domain_name";
			$res = $dbr->query($sql);
			$x = 0;
			while ($row = $dbr->fetchObject( $res ) ) {
				
				$output .= "<div class=Item id=item_" . $row->view_id . ">";
			
				$output .= "<a href=index.php?title=Special:ViewManager&method=edit&name=" . $row->view_domain_name . " class=title>" . $row->view_domain_name . "</a> | <a href=http://" . $row->view_domain_name . ".openserving.com target=_new>preview</a>";
				 
				$output .= "</div>";
			 
			 }
			
			$output .= "</div>";
			
		 
			return "<b>The following are view records contained in this destination *only*</b> <a style='padding-left:3px' href=index.php?title=Special:ViewManager&method=edit>+ add new</a><br><br><div id=views>" . $output . "</div>";
		}
		
		function addNotificationEmail(){
			global $wgDBname;
			$to = "david.pean@gmail.com";
			$headers = "From: openserving <support@openserving.com>";
			$subject = "Openserving Domain Add Request";
			$body = 'Please add the following subdomain: 
			
			name: "' . $this->view_domain_name . '" using [db:' . $wgDBname  . ']';
			mail($to, $subject, $body, $headers);
		}
		
		function displayForm(){
			global $wgRequest, $wgSiteView;
		if($wgSiteView->isUserAdmin()){	
		   $form =  '<form action=index.php?title=Special:ViewManager method=post enctype="multipart/form-data" name=form1>';
		}else{
			$form =  '<form action=index.php?title=Special:ViewManager&name=' . $this->view_domain_name . ' method=post enctype="multipart/form-data" name=form1>';
		}
	      $form .= '<table border="0" cellpadding="5" cellspacing="0" width="500">';
	     
	      if($wgSiteView->isUserAdmin()){ 
		 $form .= ' <tr>
		    <td width="200" class="view-form" class="text"><span class=req>*</span>view name</td>
			<td width="695">';
		if($wgRequest->getVal( 'method' ) == "edit"){
			$form .= '<input type="text" size="25" class="createbox" name=domain value="'. $this->view_domain_name . '"/>';
		}else{
			$form .=  $this->view_domain_name;
		}
			
		 $form .=  '</td>
		  </tr>
		  
		  <tr>
		    <td width="200" class="view-form">owner username</td>
			<td width="695"><input type="text" size="25" class="createbox" name=owner value="'. $this->owner_username . '"/></td>
		  </tr>';
	      }
		  
		   if($wgRequest->getVal( 'method' ) == "edit" && $this->view_domain_name){
		      	$form .= '<tr><td width="200" class="view-form" valign=top>Logo</td><td>';
		
			$files = glob(dirname( __FILE__ ) . "/../images/views/" . $this->view_domain_name . "*");
			$logo = basename($files[0]) ;
			if($logo ){
				$form .= "<img src=images/views/" . $logo . ">";
			}else{
				$form .= "No Current Logo";
			}
			$form .= "<br><a href=index.php?title=Special:ViewManagerLogo&name=" . $this->view_domain_name . ">Add/Update Logo</a><br>";
			$form .= "</td></tr>";
	      }
	      
		 $form .=  '<tr>
		 		<td width="200" class="view-form">return url</td>
			<td width="695"><input type="text" size="25" class="createbox" name=url value="'. $this->view_return_url . '"/></td>
		  </tr>
		  <tr>
		    <td width="200" class="view-form">adsense id</td>
			<td width="695"><input type="text" size="25" class="createbox" name=adsense value="'. $this->view_adsense_id . '"/></td>
		  </tr>';
		  
		  if($wgSiteView->isUserAdmin()){ 
		   $form .=  '<tr>
		    <td width="200" class="view-form" valign=top><span class=req>*</span>categories</td>
			<td width="695"><textarea name=ctg class="createbox" rows=2 cols=30>'. $this->view_categories . '</textarea></td>
		  </tr>';
		  }
		  
		    $form .=  '<tr>
		    <td width="200" class="view-form"><span class=req>*</span>color 1</td>
			<td width="695"><input type="text" class="createbox" size="6" name=color1 value="'. $this->view_color_1 . '"/></td>
		  </tr>
		    <tr>
		    <td width="200" class="view-form"><span class=req>*</span>color 2</td>
			<td width="695"><input type="text" class="createbox" size="6" name=color2 value="'. $this->view_color_2 . '"/></td>
		  </tr>
		    <tr>
		    <td width="200" class="view-form"><span class=req>*</span>color 3</td>
			<td width="695"><input type="text" class="createbox" size="6" name=color3 value="'. $this->view_color_3 . '"/></td>
		  </tr>
		    <tr>
		    <td width="200" class="view-form"><span class=req>*</span>border color 1</td>
			<td width="695"><input type="text" class="createbox" size="6" name=bordercolor1 value="'. $this->view_border_color_1 . '"/></td>
		  </tr>
		  <tr>
		    <td colspan="2">
			<input type=hidden name=id value=' . $this->view_id . '>
			<input type="button" class="createbox" value="submit" size="20" onclick=submitView() />
			</td>
		  </tr>
		  </table>
	</form>';
	return $form;
	}
	}

	SpecialPage::addPage( new ViewManager );
	global $wgMessageCache,$wgOut;
	
	$wgMessageCache->addMessage( 'viewmanager', 'just a test extension' );
}

?>