<?php

if( !defined( 'MEDIAWIKI' ) )
	die();

class TodoTemplate extends QuickTemplate {
	function execute() {
	global $wgOut, $tododetail, $todosummary, $todoemail, $todosubmit;
	$todosummary = wfMsg('todo-issue-summary');
	$tododetail=wfMsg('todo-form-details');
	$todoemail=wfMsg('todo-form-email');
	$todosubmit=wfMsg('todo-form-submit');
	$wgOut->addHtml("
<style type=\"text/css\">
.mwTodoNewForm {
	border: solid 1px #ccc;
	background-color: #eee;
	width: 40em;
	padding-left: 2em;
	padding-right: 2em;
}
.mwTodoTitle {
	font-weight: bold;
}
</style>");
?>
<script type="text/javascript" src="<?php $this->text('script') ?>"></script>

<form action="<?php $this->text('action') ?>" method="post">
	<input type="hidden" name="wpNewItem" value="1" />
		<p>
<?php
$wgOut->addHtml("
		<div class=\"mwTodoNewForm\">
			<label for=\"wpSummary\">{$todosummary}</label>
			<br />
			<input id=\"wpSummary\" name=\"wpSummary\" size=\"40\" />
		</p>

		<p>
			<label for=\"wpComment\">{$tododetail}</label>
			<br />
			<textarea id=\"wpComment\" name=\"wpComment\" cols=\"40\" rows=\"6\" wrap=\"virtual\"></textarea>
		</p>

		<p>
			<label for=\"wpEmail\">{$todoemail}</label>
			<br />
			<input id=\"wpEmail\" name=\"wpEmail\" size=\"30\" />
		</p>

		<p>
			<input type=\"submit\" value=\"{$todosubmit}\" />
		</p>
	</div>
</form>"
	);
	}
}
