<div id='ask-your-question-dialog'>
  <h1><?= wfMsg('ask-the-experts') ?></h1>
  <form method='get' action='<?= $specialPageLink ?>' name='CreateQuestionForm' id='CreateQuestionForm' class='WikiaSearch'>
    <input type='text' name='question' />
    <div class='neutral modalToolbar clearfix'>
      <input type='button' class='secondary' id='cancelAskTheQuestion' value='<?= wfMsgHtml('cancel') ?>' />
      <input type='submit' value='<?= wfMsgHtml('ask-button') ?>' />
    </div>
  </form>
</div>

<style type="text/css">
#ask-your-question-dialog input[type="text"] {
	width: 99%;
}
#ask-your-question-dialog .WikiaSearch input[type="submit"] {
	display: inline-block;
}
</style>
