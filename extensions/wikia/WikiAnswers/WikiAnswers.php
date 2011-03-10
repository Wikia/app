<?php

// override some variables
$wgDefaultSkin = 'oasis';
unset( $wgForceSkin );
$wgUseNewAnswersSkin = false;

// ask a question box
$wgAutoloadClasses['WikiAnswersModule'] = dirname( __FILE__ ) . '/WikiAnswersModule.php';

// add CSS
$wgHooks['BeforePageDisplay'][] = 'wfWikiAnswersAddStyle';
// remove Follow link on the main page
$wgHooks['FooterMenuAfterExecute'][] = 'wfWikiAnswersFooterMenu';
// replace create-a-wiki link with a create-answers-wiki link
$wgHooks['GlobalHeaderIndexAfterExecute'][] = 'wfWikiAnswersGlobalHeaderIndex';
// make "rephrase" action a default
$wgHooks['MenuButtonIndexAfterExecute'][] = 'wfWikiAnswersActionDropdown';
// append question mark to the title
$wgHooks['OutputPageParserOutput'][] = 'wfWikiAnswersPageTitle';
// show the answer box
$wgHooks['OutputPageBeforeHTML'][] = 'wfWikiAnswersAnswerBox';

function wfWikiAnswersAddStyle( &$out, &$sk ) {
	global $wgExtensionsPath, $wgStyleVersion;
	$out->addExtensionStyle( "$wgExtensionsPath/wikia/WikiAnswers/WikiAnswers.css?$wgStyleVersion" );
	return true;
}

function wfWikiAnswersFooterMenu( &$moduleObject, &$params ) {
	if( ArticleAdLogic::isMainPage() ) {
		foreach( $moduleObject->items as $idx=>$item ) {
			if( $item['type'] == 'follow' ) {
				unset( $moduleObject->items[$idx] );
				break;
			}
		}
	}
	return true;
}

function wfWikiAnswersGlobalHeaderIndex( &$moduleObject, &$params) {
	global $wgLang;
	$userlang = $wgLang->getCode();
	$userlang = $userlang == 'en' ? '' : "?uselang=$userlang";
	$moduleObject->createWikiUrl = "http://www.wikia.com/Special:CreateAnswers$userlang";
	$moduleObject->createWikiText = wfMsgHtml('createwikipagetitle');
	return true;
}

function wfWikiAnswersActionDropdown( &$moduleObject, &$params) {
	global $wgTitle;
	$answerObj = Answer::newFromTitle( $wgTitle );
	if( ArticleAdLogic::isMainPage() ) {
		$moduleObject->action = null;
	} elseif( $answerObj->isQuestion() && !$answerObj->isArticleAnswered() ) {
		if( isset( $moduleObject->dropdown['move'] ) ) {
			$moduleObject->action = $moduleObject->dropdown['move'];
			$moduleObject->actionName = 'move';
			unset( $moduleObject->dropdown['move'] );
		}
	}
	return true;
}

function wfWikiAnswersPageTitle( &$out, $parserOutput ) {
	$answerObj = Answer::newFromTitle( $out->getTitle() );
	if( $answerObj->isQuestion() ) {
		$parserOutput->setTitleText( $parserOutput->getTitleText() . wfMsg('?') );
	}
	return true;
}

function wfWikiAnswersAnswerBox( &$out, &$html ) {
	$answerObj = Answer::newFromTitle( $out->getTitle() );
	if( $answerObj->isQuestion() ) {
		if( in_array( ucfirst(Answer::getSpecialCategory("unanswered")), $out->getCategories() ) ) {
			//FIXME
			global $wgBlankImgUrl, $wgTitle, $wgStylePath, $wgUser;
			ob_start();
			?>
				<div id="answer_level">
				<div id="answer_box" class="accent">
				<span id="answer_heading" class="dark_text_1"><?php echo wfMsg('answer_this_question')?></span>
				<?php
				$title = $wgTitle;
			// check whether current user is blocked (RT #48058)
			$isUserBlocked = $wgUser->isBlockedFrom($title, false);

			if ($isUserBlocked) {
				echo $this->getBlockedInfo();
			} else {
				?>
					<script src="<?=$wgStylePath?>/../extensions/wikia/JavascriptAPI/Mediawiki.js"></script>
					<form onsubmit="return handleEditForm(this)">
					<textarea name="article" class="answer-input" rows="7" id="article_textarea"></textarea><br />
					<script>document.getElementById("article_textarea").focus();</script>
					<span style="float:right"><input type="submit" value="save" id="article_save_button"/></span>
					</form>

					<script>
					function handleEditForm(f) {
						<?php
							global $wgReadOnly;
						if ($wgReadOnly){?>
							alert("<?php echo addslashes($wgReadOnly)?>");
							return false;
							<?php } ?>
								try {
									$("#article_save_button").val($("#article_save_button").val() + "...");
									$("#article_save_button").attr("disabled","disabled");
									Mediawiki.editArticle({
											"title": "<?php echo addslashes($title->getText())?>",
											"prependtext": $("#article_textarea").val()}, editArticleSuccess, apiFailed);
								} catch (e) {
									alert(Mediawiki.print_r(e));
								}
							return false; // Return false so that the form doesn't submit
					}

				function editArticleSuccess(){
					window.location.href = "<?php echo addslashes($title->getFullUrl())?>?cb=<?php echo mt_rand(1,10420)?>";
				}
				function apiFailed(e){
					alert(Mediawiki.print_r(e));
				}

				</script>
					<?php
			}
			?>
				</div>
				</div><!-- answer_level -->
				<?php
				$html = ob_get_clean();
		}
	}
	return true;
}
