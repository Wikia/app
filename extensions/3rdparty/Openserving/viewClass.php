<?php
class SiteView{

	var $view_id = 0;
	var $view_domain_name = "";
	var $admin_user_id = 0;
	var $view_adsense_id = "";
	var $view_analytics_id = "";
	var $view_return_url = "";
	
	var $view_color_1 = "";
	var $view_color_2 = "";
	
	function SiteView() {
		$domain = explode(".",$_SERVER['HTTP_HOST']);
		if(count($domain) > 0){
			$this->view_domain_name = $domain[0];
			$this->read();
		}
	}
	
	function read(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT
					view_id, view_domain_name,admin_user_id,view_adsense_id,view_analytics_id,view_return_url,view_color_1,view_color_2,view_color_3,
					view_border_color_1, view_categories
					FROM site_view
					WHERE view_domain_name = '" . $this->view_domain_name . "' limit 0,1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$this->view_id = $row->view_id;
			$this->view_domain_name = $row->view_domain_name;
			$this->admin_user_id = $row->admin_user_id;
			$this->view_adsense_id = $row->view_adsense_id;
			$this->view_analytics = $row->view_analytics;
			$this->view_return_url = $row->view_return_url;
			$this->view_color_1 = $row->view_color_1;
			$this->view_color_2 = $row->view_color_2;
			$this->view_color_3 = $row->view_color_3;
			$this->view_border_color_1 = $row->view_border_color_1;
			$this->view_categories = $row->view_categories;

		}else{
			$this->view_domain_name = "";
			//redirect to destination site?
		}
	}
	
	function getLogo(){
		$files = glob(dirname( __FILE__ ) . "/../images/views/" . $this->view_domain_name . "_logo*");
		return basename($files[0]);
	}
	
	function getDomainName(){return $this->view_domain_name;}
	function getCategories(){return $this->view_categories;}
	function getAd_id(){return $this->view_adsense_id;}

	function getID(){ return $this->view_id;}
	
	function isUserAdmin(){
		global $wgUser;                 
		if( in_array('staff',($wgUser->getGroups())) ){
			return true;
		}else{
			return false;
		}
	}
	
	function isUserOwner(){
		global $wgUser;                 
		if( $wgUser->mId !=0 && $wgUser->mId == $this->admin_user_id ){
			return true;
		}else{
			return false;
		}
	}

}
?>