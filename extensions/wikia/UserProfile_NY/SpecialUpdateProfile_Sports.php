<?php

$wgExtensionFunctions[] = 'wfSpecialUpdateProfileSports';


function wfSpecialUpdateProfileSports(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class UpdateProfileSports extends SpecialPage {
	
		var $favorite_counter = 1;
		
		function UpdateProfileSports(){
			UnlistedSpecialPage::UnlistedSpecialPage("UpdateFavoriteTeams");
		}
		
		function getSports(){
			$dbr =& wfGetDB( DB_MASTER );
			
			$sql = "SELECT  sport_id, sport_name FROM sport order by sport_order";
			$res = $dbr->query($sql);
		
			while ($row = $dbr->fetchObject( $res ) ) {
				$this->sports[] = array("id"=>$row->sport_id,"name"=>$row->sport_name);
			}
			return $this->sports;			
		}

		function getTeams($sport_id){
			$dbr =& wfGetDB( DB_MASTER );
			
			$sql = "SELECT team_id,team_name FROM sport_team WHERE team_sport_id ={$sport_id} order by team_name";
			$res = $dbr->query($sql);
			$teams = array();
			while ($row = $dbr->fetchObject( $res ) ) {
				$teams[] = array("id"=>$row->team_id,"name"=>$row->team_name);
			}
			return $teams;			
		}
		
		function getFavorites(){
			global $wgUser;
			$dbr =& wfGetDB( DB_MASTER );
			
			$sql = "SELECT sf_sport_id, sf_team_id FROM sport_favorite WHERE sf_user_id = {$wgUser->getID()} order by sf_order";
			$res = $dbr->query($sql);
			$favorites = array();
			while ($row = $dbr->fetchObject( $res ) ) {
				$favorites[] = array("sport_id"=>$row->sf_sport_id,"team_id"=>$row->sf_team_id);
			}
			return $favorites;				
			
		}
		
		function getSportsDropdown($selected_sport_id=0,$selected_team_id=0){
			
			//Set Current Sport Dropdown - show first one, or saved team
			if($this->favorite_counter==1 || $selected_sport_id>0){
				$style="display:block;";
			}else{
				$style="display:none;";
			}
			
			$output .= "";
			
			$remove_link = "";
			if($selected_sport_id || $selected_team_id){
				$remove_link = "<a href=\"javascript:void(0)\" onclick=\"javascript:remove_fan({$selected_sport_id},{$selected_team_id})\"><img src=\"images/common/closeIcon.gif\" border=\"0\"/></a>";
			}
			
			$output .= "<div id=\"fav_{$this->favorite_counter}\" style=\"{$style};padding-bottom:15px;\">
			<p class=\"profile-update-title\">Favorite #{$this->favorite_counter} {$remove_link}</p>
					<p class=\"profile-update-unit-left\"> " . wfMsg( 'user-profile-sports-sport' ) . " </p>
					<p class=\"profile-update-unit-right\"> <select name=\"sport_{$this->favorite_counter}\" id=\"sport_{$this->favorite_counter}\"
					onchange=\"update_combo('team_{$this->favorite_counter}','index.php?action=ajax&rs=wfGetSportTeams&rsargs[]='+this.value)\" />
					<option value=\"0\">-</option>
					</p>
					<div class=\"cleared\"></div>";
			
			//Build Sport Option HTML
			$sports = $this->sports;
			foreach($sports as $sport){
				$output .= "<option value=\"{$sport["id"]}\" "  . (($sport["id"] == $selected_sport_id)?"selected":"") . " >{$sport["name"]}</option>\n";
			}
			$output .= "</select>";
				
			
			
			//IF Loading Previously Saved Teams, We need to build the options for the associated sport to show the 
			//team they already have selected
			$team_opts = "";
			$teams = array();
			if($selected_team_id>0)$teams=$this->getTeams($selected_sport_id);
			foreach($teams as $team){
				$team_opts.= "<option value=\"{$team["id"]}\" ". (($team["id"]==$selected_team_id)?"selected":"") . " >{$team["name"]}</option>";
			}
			
			$output .= "<p class=\"profile-update-unit-left\"> 
					Team 
					</p>
					<p class=\"profile-update-unit\"><select name=\"team_{$this->favorite_counter}\" id=\"team_{$this->favorite_counter}\"
					onchange=\"show_next();\" />{$team_opts}</select>
				    </p>
					<div class=\"cleared\"></div>
					
				</div>";
					
			$this->favorite_counter++;
			
			return $output;
		}
		
		function execute(){
			global $wgUser, $wgOut, $wgRequest, $wgSiteView, $wgTitle, $wgStyleVersion;
	
			$this->getSports();
			
			$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsg('user-profile-sports-title') ) );
		
			if( !$wgUser->isLoggedIn() ) {
				$wgOut->setPagetitle( wfMsg( 'user-profile-sports-notloggedintitle')  );
				$wgOut->addHTML( wfMsg( 'user-profile-sports-notloggedintitle') );
				return;
			}
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/UserProfile/UserProfile.css?{$wgStyleVersion}\"/>\n");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/UserProfile/UpdateProfile.js?{$wgStyleVersion}\"></script>\n");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/DoubleCombo/DoubleCombo.js?{$wgStyleVersion}\"></script>\n");
			$js = "<script>
				var fav_count;
				function show_next(){
					YAHOO.widget.Effects.Hide(\$('add_more'));
					if( \$(\"fav_\"+(fav_count+1) ) ){
							if(\$D.getStyle(\"fav_\"+(fav_count+1),\"display\") == \"none\" ){
							//if(!Element.visible(\"fav_\"+(fav_count+1) ) ){
								YAHOO.widget.Effects.Show(\$(\"fav_\"+(fav_count+1) ))	
								fav_count++
							}
					}
				}
				function remove_fan(sid,tid){
					
					document.sports_remove.s_id.value = sid;
					document.sports_remove.t_id.value = tid;
					document.sports_remove.submit();
				}
				</script>";
				$wgOut->addHTML($js);
				
			$output = "<h1>".wfMsg('user-profile-sports-title')."</h1>";
			
			$output .= "<div class=\"profile-tab-bar\">";
				$output .= "<div class=\"profile-tab\">";
					$output .= "<a href=\"" . UpdateProfile::update_profile_link("Profile", "section=basic") ."\">" . wfMsg( 'user-profile-section-personal' ) . "</a>";
				$output .= "</div>";
				$output .= "<div class=\"profile-tab-on\">";
					$output .= "" . wfMsg( 'user-profile-section-sportsteams' ) . "";
				$output .= "</div>";
				$output .= "<div class=\"profile-tab\">";
					$output .= "<a href=\"" . UpdateProfile::update_profile_link("Profile", "section=sports") ."\">" . wfMsg( 'user-profile-section-sportstidbits' ) . "</a>";
				$output .= "</div>";
				$output .= "<div class=\"profile-tab\">";
					$output .= "<a href=\"" . UpdateProfile::update_profile_link("Profile", "section=personal") ."\">" . wfMsg( 'user-profile-section-interests' ) . "</a>";
				$output .= "</div>";
				$output .= "<div class=\"profile-tab\">";
					$output .= "<a href=\"" . UpdateProfile::upload_avatar_link() . "\">" . wfMsg( 'user-profile-section-picture' ) . "</a>";
				$output .= "</div>";
				$output .= "<div class=\"profile-tab\">";
					$output .= "<a href=\"" . UpdateProfile::update_profile_link("Profile", "section=preferences") ."\">" . wfMsg( 'user-profile-section-preferences' ) . "</a>";
				$output .= "</div>";
				
				$output .= "<div class=\"cleared\"></div>";
			$output .= "</div>";
			
			$output .= "<div class=\"profile-info\">";
			
			if($wgRequest->wasPosted()){
				$dbw =& wfGetDB( DB_MASTER );
				
				if( $wgRequest->getVal("action") == "delete" ){
					SportsTeams::removeFavorite($wgUser->getID(),$wgRequest->getVal("s_id"),$wgRequest->getVal("t_id") );
					SportsTeams::clearUserCache($wgUser->getID());
					$wgOut->addHTML("<span class='profile-on'>" . wfMsg( 'user-profile-sports-teamremoved' ) . "</span><br><br>");
				}
				
				if( $wgRequest->getVal("favorites") ){
					//CLEAR USER CACHE
					SportsTeams::clearUserCache($wgUser->getID());
					
					//RESET OLD FAVORITES
					$sql = "DELETE FROM sport_favorite WHERE sf_user_id={$wgUser->getID()}";
					$res = $dbw->query($sql);
		
					$items = split("\|",$wgRequest->getVal("favorites") );
					foreach($items as $favorite){ 
						if($favorite){
							$atts = split(",",$favorite);
							$sport_id = $atts[0];
							$team_id = $atts[1];
							
							if(!$team_id )$team_id==0;
							$s = new SportsTeams();
							$s->addFavorite($wgUser->getID(),$sport_id,$team_id);
						}
					}
					$wgOut->addHTML("<span class='profile-on'>" . wfMsg( 'user-profile-sports-teamsaved' ) . "</span><br><br>");
					
				}
					
			}
				$favorites = $this->getFavorites();
				foreach($favorites as $favorite){
					$output .= $this->getSportsDropdown($favorite["sport_id"],$favorite["team_id"]);
				}
				$output .= "<div >";
				if(count($favorites)>0){
					$output .= "<div style=\"display:block\" id=\"add_more\"></div>";
				}
				
				for($x = 0; $x <= (20-count($favorites)); $x++){
					$output .= $this->getSportsDropdown();
				}
				
				$output .= "<form action=\"\" name=\"sports\" method=\"post\">
				<input type=\"hidden\" value=\"\" name=\"favorites\">
				<input type=\"hidden\" value=\"save\" name=\"action\">";
				
				if(count($favorites)>0){
					$output .= "<input type=\"button\" class=\"profile-update-button\" onclick=\"show_next()\" value=\"" . wfMsg( 'user-profile-sports-addmore' ) . "\"> ";
				}
				
				
				$output .= "<input type=\"button\" class=\"profile-update-button\" value=\"Update\" onclick=\"save_teams()\">
				</form>
				<form action=\"\" name=\"sports_remove\" method=\"post\">
				<input type=\"hidden\" value=\"delete\" name=\"action\">
				<input type=\"hidden\" value=\"\" name=\"s_id\">
				<input type=\"hidden\" value=\"\" name=\"t_id\">
				</form>
				<script>
				fav_count=" . ((count($favorites))?count($favorites):1) . "
				</script>
				</div>
				</div>";
			
			$wgOut->addHTML($output);
	 		
		}

	}

	SpecialPage::addPage( new UpdateProfileSports );
}

?>
