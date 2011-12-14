<form id="act-form" action="<?= $url_form ?>">
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
<form>
	<fieldset>
		<ul>
			<li><a href="/wiki/Special:Tracker/block?target=<?= urlencode( $username ) ?>">Block users</a></li>
			<li><a href="/wiki/Special:Tracker/closewikis?target=<?= urlencode( $username ) ?>">Close wikis</a> (<?= $wikisCreated ?> total)</li>
			<li><a href="/wiki/Special:Tracker/nuke?target=<?= urlencode( $username ) ?>">Nuke edits</a></li>
	</fieldset>
</form>

	<strong><?= wfMsg( 'act-list-of-accounts', array( count($accounts) ) ); ?></strong>
	<div style="display: table-cell">
	<table id="TrackedUsers" class="">
		<thead>
			<th>ID</th>
			<th>Username</th>
			<th>Connected by</th>
			<th>Connected with</th>
		</thead>
		<tbody>
		<?php foreach( $accounts as $account ): ?>
			<tr>
				<td><?= $account['user']->getId(); ?></td>
				<td><?= $account['user']->getName(); ?></td>
				<td><?= $account['reason']; ?></td>
				<td><?= $account['from']->getName(); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	</div>
	
	<button id="FetchContributions"><?= wfMsg( 'act-fetch-contributions' ); ?></button>
	<br /><br />
	<div id="UserContributions"></div>
	
<?php elseif( !empty( $username) && empty( $usernameNotFound ) ): ?>
	<?= wfMsg( 'act-username-not-tracked', array( $username ) ); ?>
<?php endif; ?>
