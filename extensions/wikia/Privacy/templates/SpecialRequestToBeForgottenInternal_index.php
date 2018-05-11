<section>
	<form method="post">
		<label for="username">Username</label>
		<input id="username" type="text" name="username" required>
		<input type="submit" value="Submit">
	</form>
	<? if(!empty($message)): ?>
		<span><?= $message ?></span>
	<? endif ?>
</section>