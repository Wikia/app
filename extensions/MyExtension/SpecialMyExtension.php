<?php

function sandboxParse($wikiText)
	{
		global $wgTitle, $wgUser;
		$myParser = new Parser();
		$myParserOptions = new ParserOptions();
		$myParserOptions->initialiseFromUser($wgUser);
		$result = $myParser->parse($wikiText, $wgTitle, $myParserOptions);
		return $result->getText();
	}
	
class SpecialMyExtension extends SpecialPage
{
	function __construct(){
		parent::__construct('MyExtension'/*, 'editinterface'*/);
		wfLoadExtensionMessages('MyExtension');
		//$this->mIncludable = true;
		//powy¿sze umo¿liwia wywo³anie $this->including()
	}
	function execute ($par)
	{
		global $wgRequest, $wgOut, $wgCityId, $wgTitle/*, $wgUser*/;
		
		$this->setHeaders();
		$param = $wgRequest->getText('param');
		$output = "Hello world!";
		$wgOut->addWikiText($_SERVER['HTTP_USER_AGENT']);
		$wgOut->addWikiText($output);
		$wgOut->addHTML(sandboxParse("A teraz tekst powinien byc '''sformatowany''' poprawnie."));
		$wgOut->addHTML('<b>Pogrubiebie..</b>');
		//$wgOut->addHTML("jakis '''podobno''' sformatowany tekst");
		$wgOut->addWikiText("Tekst pisany ''kursywa'', odnosnik do [[Lego_NXT_Wiki]], odnosnik do [[strony]], 
		ktorej nie ma,  inne  '''pogrubienie''', wszystko cacy.");
		$wgOut->addWikiText('* Item 1');
		$wgOut->addWikiText('* Item 2');
		$wgOut->addWikiText('* Item 3');
		$topTenViewers = new GetViewers();
		$topusers = $topTenViewers->GetTenTopUsers(intval($wgCityId));
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/Templates/" );
		$oTmpl->set_vars( array("users" => $topusers, "wikicity" => intval($wgCityId), "url" => $wgTitle->getFullUrl())
		);
		
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/MyExtension/css/myextension.scss'));
		//if (isset($_POST["add"])) unset($_POST["add"]); 
		$wgOut->addHTML( $oTmpl->execute('table.tmpl.php') );
		if (isset($_POST["add"])){
			//$_POST = $_SESSION["POSTDATA"];
			//if(!is_null($_POST["add"])){
				print_r($_POST["id"]);
				print_r($_POST["styled-textarea"]);
				//exit;
	  			$id = $_POST["id"];// BEZ SENSU, BO KOMENTARZE WRZUCA DO WSZYSTKICH I POWIELA OSTATNI PRZY ODSWIEZANIU STRONY
	  			$comment = $_POST["styled-textarea"];
	  			$topTenViewers->saveComment($id, $comment, $wgCityId); //
				$wgOut->redirect($wgTitle->GetFullURL());
			//}
			//header('Location: '.$_SERVER['PHP_SELF']);
			//unset($_SESSION["POSTDATA"]);
		}
		//$wgOut->showErrorPage('error','badarticleerror');
	}
}
