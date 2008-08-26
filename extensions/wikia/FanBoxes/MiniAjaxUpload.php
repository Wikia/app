<?

$wgExtensionFunctions[] = 'wfSpecialFanBoxAjaxUpload';
$wgAutoloadClasses['FanBoxAjaxUploadForm'] = dirname( __FILE__ ) . '/MiniAjaxUpload_body.php';

function wfSpecialFanBoxAjaxUpload(){
	
	class FanBoxAjaxUpload extends SpecialPage {
		
		function FanBoxAjaxUpload(){
			UnlistedSpecialPage::UnlistedSpecialPage("FanBoxAjaxUpload");
		}
		

		
		function execute(){
			
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP;
			$wgOut->setArticleBodyOnly(true);
			$form = new FanBoxAjaxUploadForm($wgRequest);
			$form->execute();
		}
		
	}
	
	SpecialPage::addPage( new FanBoxAjaxUpload );
}
