<?php
global $wgTitle, $wgArticle, $wgOut, $wgRequest, $wgUser;

//if ($wgTitle->isContentPage() && !WikiaPageType::isMainPage()) {
if ( $wgTitle->exists() && $wgTitle->isContentPage() && !$wgTitle->isTalkPage() && $wgOut->isArticle()) {

	if( $wgTitle->getArticleID() == Title::newMainPage()->getArticleId() )return;

	$author = getOriginalAuthor();

	if( $wgUser->isAnon() && $wgRequest->getVal("state") == "asked" ){
		echo "<div class=\"clearfix\">
			<a href=\"" . htmlspecialchars(Title::newFromText("Userlogin", NS_SPECIAL)->getFullURL("type=signup")) . "\">Hey, why don't you create an account?</a>
			</div>";
	}

	echo "<div class=\"clearfix\">
		<a href=\"" . htmlspecialchars($author["title"]->getFullURL()) . "\">
			{$author["avatar"]}
		</a>
		Question asked by <a href=\"" . htmlspecialchars($author["title"]->getFullURL()) . "\">" . $author["user_name"] . "</a>
		</div><p>";

	if( !isAnswered() ){
		echo '<div class="clearfix"><a href="'. $wgTitle->getEditURL() .'" class="bigButton"><big>Answer this question</big><small></small></a></div>';
	}else{
		echo '<div class="clearfix"><a href="'. $wgTitle->getEditURL() .'" class="bigButton"><big>Improve this answer</big><small></small></a></div>';
		echo '<div class="answer_a">Answer:</div>';
	}
}
