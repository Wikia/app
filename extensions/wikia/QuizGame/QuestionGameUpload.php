<?

$wgExtensionFunctions[] = 'wfQuestionGameUpload';
$wgExtensionFunctions[] = 'wfQuizGameReadLang';

$wgAutoloadClasses['QuestionGameUploadForm'] = dirname( __FILE__ ) . '/QuestionGameUpload_body.php';

function wfQuestionGameUpload(){
	
	class QuestionGameUpload extends SpecialPage {
		
		function QuestionGameUpload(){
			parent::__construct("QuestionGameUpload");
		}
		
		function execute(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP;
			$wgOut->setArticleBodyOnly(true);
			$form = new QuestionGameUploadForm($wgRequest);
			$form->execute();
		}
		
	}
	
	SpecialPage::addPage( new QuestionGameUpload );
}

