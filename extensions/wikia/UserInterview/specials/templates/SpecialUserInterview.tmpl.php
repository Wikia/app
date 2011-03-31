<!--<h3><a href="add a new question"></a></h3>-->

<p>Click on "Add a Question", type in the questions you would like to ask the user and click on "Save questions".<br/>You can add multiple questions by clicking repeatedly on the "Add a question button."</p>
<form action="<?= $formURL ?>" id="user-interview-form" method="post">
	<table class="user-interview-container">
		<!-- Template -->
		<tr>
			<th><span class="remove sprite error"></span></th>
			<td><input type="text" />
		</tr>
		<?php 
if (isset($adminQuestions)) {
	foreach ($adminQuestions as $adminQuestion) {
		?>
		<tr>
			<th><span class="remove sprite error"></span></th>
			<td><input type="text" name="<?= $adminQuestion['id'] ?>" value="<?= $adminQuestion['question']  ?>" />
		</tr>
		<?php
	}
	
}
		?>
		<tr class="submit-column">
			<th></th>
			<td>
				<a class="wikia-button addInterviewQuestion">Add a Question</a>
				<input type="submit" id="FacebookProfileSyncSave" value="Save Questions" />
			</td>
		</tr>
	</table>
	<input id="user-interview-questions" name="questions" type="hidden">
</form>




