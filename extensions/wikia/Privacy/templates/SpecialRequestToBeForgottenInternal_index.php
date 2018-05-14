<section>
	<form method="post">
		<label for="username">Username</label>
		<input id="username" name="username" required>
		<input name="editToken" type="hidden" value="<?= htmlspecialchars( $editToken ) ?>">
		<input type="submit" value="Submit">
	</form>
	<? if ( !empty( $message ) ): ?>
		<span><?= htmlspecialchars( $message ) ?></span>
	<? endif ?>
</section>