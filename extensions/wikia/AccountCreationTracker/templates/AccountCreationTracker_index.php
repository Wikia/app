<form id="act-form">
	<?php if( !empty($usernameNotFound) ): ?>
		<p style="color: red"><?= wfMsg( 'act-username-not-found' ); ?></p>
	<?php endif; ?>
	<fieldset>
		<label for="act-username"><?= wfMsg( 'act-enter-username' ); ?></label>
		<input type="text" id="act-username" name="username" value="<?= $username; ?>" />
		<input type="submit" class="wikia-button" id="act-search-btn" value="<?= wfMsg( 'act-search' ); ?>" />
	</fieldset>
</form>

<?php if( count( $accounts ) > 0 ): ?>
	<strong><?= wfMsg( 'act-list-of-accounts', array( count($accounts) ) ); ?></strong>
	<ul>
		<?php foreach( $accounts as $account ): ?>
			<li><strong><?= $account->getName();?></strong> (ID: <?= $account->getId(); ?>)</li>
		<?php endforeach; ?>
	</ul>
<?php elseif( !empty( $username) && empty( $usernameNotFound ) ): ?>
	<?= wfMsg( 'act-username-not-tracked', array( $username ) ); ?>
<?php endif; ?>
