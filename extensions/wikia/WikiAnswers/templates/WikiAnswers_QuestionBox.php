<section id="WikiAnswers" class="WikiAnswers">
<script type="text/javascript">/*<![CDATA[*/
// TODO - move this to .js file
function askQuestion(){
	var q = document.getElementById('answers_ask_field').value.replace(/\s/g,"_");
	if( !q ) { return false; }

	q = q.replace(/\?/g,""); //removes question mark
	q = q.replace(/_+/g,"_"); //we only want one space
	q = q.replace(/#/g,""); //we only want one space
	q = encodeURIComponent( q );

	var path = window.wgServer + window.wgArticlePath.replace("$1","");
	window.location = path + "Special:CreateQuestionPage?questiontitle=" + q.charAt(0).toUpperCase() + q.substring(1);
	return false;
}
/*]]>*/</script>
<div class="yui-skin-sam" id="ask_wrapper">
<div id="answers_ask">
<div id="answers_ask_heading" class="dark_text_2"><?php echo wfMsg("ask_a_question")?></div>
<form method="get" action="" onsubmit="return askQuestion();" name="ask_form" id="ask_form">
<input type="text" id="answers_ask_field" value="" class="header_field alt" />
<input type="submit" value="<?php echo htmlspecialchars(wfMsg("ask_button"))?>" id="ask_button"/>
</form>
<script>document.getElementById("answers_ask_field").focus();</script>
</div> <!-- answers_ask -->
<div id="answers_suggest"></div>
</div><!-- ask_wrapper -->
</section>
