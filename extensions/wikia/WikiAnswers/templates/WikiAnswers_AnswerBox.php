<div id="answer_level">
	<div id="answer_box" class="accent">
		<h1 id="answer_heading"><?= wfMessage( 'answer_this_question' )->escaped(); ?></h1>
		<?php if ( !$wgUser->isBlocked( true ) ): // check whether current user is blocked (RT #48058) ?>
			<form id="answer-box-form">
				<textarea name="article" class="answer-input" rows="7" id="article_textarea"></textarea><br/>
				<span style="float:right"><input type="submit" value="<?= wfMessage( 'wiki-answers-save' )->escaped(); ?>" id="article_save_button" /></span>
			</form>
		<?php endif; ?>
	</div>
</div>
