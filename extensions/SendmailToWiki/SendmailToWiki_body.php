<?php
class SendmailToWiki extends UnlistedSpecialPage {

	function __construct() {
		parent::__construct( 'SendmailToWiki' );
		wfLoadExtensionMessages('SendmailToWiki');
	}
 
	function execute( $SPparams ) {
		global $wgRequest, $wgOut, $wgParser, $sendmailtowikiPrefix;
 
		$wgOut->disable();
		$wgParser->firstCallInit();
		$wgParser->mOptions = new ParserOptions();
		
		header( "Content-type: text/html; charset=utf-8" );
		
		$postTitle = $wgRequest->getText('posttitle');
		preg_match_all('/\s*\[([^\]]*)\]\s*/', $postTitle, $postOpts);
		if (isset($postOpts[0])) {
			$postTitle = str_replace($postOpts[0], '', $postTitle);
			$postOpts = $postOpts[1];
			foreach ($postOpts as &$postOpt)
				$postOpt = strtolower($postOpt);
		}

		if ($wgRequest->getText('postcontenttype') != 'text/plain' ) {
			$this->sendError(400, 'sendmailtowiki-err-onlyplain', !in_array('quiet', $postOpts));
			return;
		}


		$postSender = $wgRequest->getText('postsender');
		$postAccount = preg_split('/\./', preg_replace('/\+/', '.', $wgRequest->getText('postaccount')));

		if ($postAccount[0] != $sendmailtowikiPrefix) {
			$this->sendError(400, 'sendmailtowiki-err-wrongprefix', !in_array('quiet', $postOpts));
			return;
		} elseif (!is_numeric($postAccount[1]) || !is_numeric($postAccount[2])) {
			$this->sendError(400, 'sendmailtowiki-err-invalidaccount', !in_array('quiet', $postOpts));
			return;
		}
		
		$postUser = User::newFromId($postAccount[1]);
		if ($postUser->loadFromId() === FALSE) {
			$this->sendError(400, 'sendmailtowiki-err-invalidaccount', !in_array('quiet', $postOpts));
			return;
		} elseif ($postUser->mEmail !== $postSender && !preg_match('/<'.$postUser->mEmail.'>/', $postSender)) {
			$this->sendError(403, 'sendmailtowiki-err-invalidsender', !in_array('quiet', $postOpts));
			return;
		} elseif ($postUser->getOption('sendmailtowiki_inpin') !== $postAccount[2]) {
			$this->sendError(403, 'sendmailtowiki-err-invalidpin', !in_array('quiet', $postOpts));
			return;
		}

		$postTitleObj = Title::newFromText($postTitle);
		global $wgTitle;
		$wgTitle = $postTitleObj;
		if(in_array('createonly', $postOpts) && $postTitleObj->exists()) {
			$this->sendError(400, 'articleexists', !in_array('quiet', $postOpts));
			return;
		} elseif((in_array('source', $postOpts) || in_array('view', $postOpts) || in_array('nocreate', $postOpts)) && !$postTitleObj->exists()) {
			$this->sendError(404, 'nocreatetitle', !in_array('quiet', $postOpts));
			return;
		} 

		$postArticleObj = new Article($postTitleObj);
		if (in_array('source', $postOpts)) {
			echo $postArticleObj->getContent();
			return;
		}elseif (in_array('view', $postOpts)) {
			$this->sendOK($postArticleObj->getContent());
			return;
		}

		$errors = $postTitleObj->getUserPermissionsErrors('edit', $postUser);
		if(!$postTitleObj->exists())
			$errors = array_merge($errors, $postTitleObj->getUserPermissionsErrors('create', $postUser));
		if(count($errors)) {
			$this->sendError(403, $errors[0], !in_array('quiet', $postOpts));
			return;
		}

		$postContent = $wgRequest->getText('postcontent');
		$postArticleObj->doEdit($postContent, '', 0, false, $postUser);
				
		if (in_array('reply', $postOpts)) $this->sendOK($postContent);
	}

	function sendOK($content) {
		global $wgParser; 
		$out = $wgParser->internalParse($content);
		$wgParser->replaceLinkHolders($out, 0);
		echo $wgParser->doBlockLevels($out);
	}

	function sendError($code, $message, $sendback = false) {
		if (!$sendback)
			return;
			
		global $wgMessageCache, $wgParser;
		
		switch ($code) {
			case 400: header('HTTP/1.1 400 Bad Request'); break;
			case 403: header('HTTP/1.1 403 Forbidden'); break;
			case 404: header('HTTP/1.1 404 Not Found'); break;
		}
		
		$out = '';		
		$out .= "<h1>".$wgMessageCache->get('errorpagetitle').": $code</h1>\n";
		$out .= "<h2>".$wgMessageCache->get($message)."</h2>\n";
		
		echo $wgParser->replaceVariables($out);
	}
}

