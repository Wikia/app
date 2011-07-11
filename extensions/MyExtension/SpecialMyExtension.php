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
		global $wgRequest, $wgOut/*, $wgUser*/;
		/*
	if ( !$this->userCanExecute($wgUser) ) {
                $this->displayRestrictionError();
                return;
        }*/
		$this->setHeaders();
		$wgOut->setPagetitle("Pepson");
		$param = $wgRequest->getText('param');
		$output = "Hello world!";
		$wgOut->addWikiText($output);
		$wgOut->addHTML(sandboxParse("A teraz tekst powinien byc '''sformatowany''' poprawnie."));
		$wgOut->addHTML('<b>Pogrubiebie..</b>');
		//$wgOut->addHTML("jakis '''podobno''' sformatowany tekst");
		$wgOut->addWikiText("Tekst pisany ''kursywa'', odnosnik do [[Lego_NXT_Wiki]], odnosnik do [[strony]], 
		ktorej nie ma,  inne  '''pogrubienie''', wszystko cacy.");
		$wgOut->addWikiText('* Item 1');
		$wgOut->addWikiText('* Item 2');
		$wgOut->addWikiText('* Item 3');
		//$wgOut->showErrorPage('error','badarticleerror');
	}
}