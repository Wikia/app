<form id="act-form" action="<?= $url_form ?>">
	<?php if( !empty($usernameNotFound) ): ?>
		<p style="color: red"><?= wfMsg( 'act-username-not-found' ); ?></p>
	<?php endif; ?>
	<fieldset>
		<label for="act-username"><?= wfMsg( 'act-enter-username' ); ?></label>
		<input type="text" id="act-username" name="username" value="<?= $username; ?>" />
		<input type="submit" class="wikia-button" id="act-search-btn" value="<?= wfMsg( 'act-search' ); ?>" />
		<?php if( count( $accounts ) > 0 ): ?>
			<div>
			<?= wfMsg( 'act-actions-for-all-accounts' ); ?>:
			<ul>
				<li><a class="wikia-button" href="/wiki/Special:Tracker/block?username=<?= urlencode( $username ) ?>">Block users</a></li>
				<li><a class="wikia-button" href="/wiki/Special:Tracker/closewikis?username=<?= urlencode( $username ) ?>">Close wikis</a> (<?= $wikis_created ?> total)</li>
			</ul>
			</div>
		<?php endif; ?>
	</fieldset>
</form>

<?php if( count( $accounts ) > 0 ): ?>
	<br />
	<strong><?= wfMsg( 'act-list-of-accounts', array( count($accounts) ) ); ?></strong>
	<div style="display: table-cell">
	<table id="TrackedUsers">
		<thead>
			<th></th>
			<th>ID</th>
			<th>Username</th>
			<th>Connected by</th>
			<th>Connected with</th>
			<th>Connection</th>
		</thead>
		<tbody>
		<?php foreach( $accounts as $account ): ?>
			<tr>
				<td><input type="checkbox" /></td>
				<td><?= $account['user']->getId(); ?></td>
				<td><?= $account['user']->getName(); ?></td>
				<td><?= $account['reason']; ?></td>
				<td><?= $account['from']->getName(); ?></td>
				<td><?= $account['connection']; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	</div>
	
	<button id="FetchContributions"><?= wfMsg( 'act-fetch-contributions' ); ?></button>
	<br /><br />
	<div id="UserContributions"></div>
	<br /><br />
	<div id="PagesToNuke" style="display: none;"><?= wfMsg( 'act-pages-to-nuke-rollback' ); ?>:
		<table id="PagesToNukeDT">
			<thead>
				<tr>
					<th width="100">NUKE</th>
					<th width="100">User</th>
					<th width="100">Wiki</th>
					<th width="300">Page</th>
					<th width="100">Status</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
		<button id="NukeRollback"><?= wfMsg( 'act-nuke-rollback-contributions' ); ?></button>
	</div>
	
<?php elseif( !empty( $username) && empty( $usernameNotFound ) ): ?>
	<?= wfMsg( 'act-username-not-tracked', array( $username ) ); ?>
<?php endif; ?>
