<div id='profile-content'>
	<div id="profile-about-section" class="uppBox">
		<h1 class="color1">
			<?= wfMsg( 'userprofilepage-about-section-title', array( $userName ) ); ?>
			<a href="<?= $aboutSection['articleEditUrl']; ?>" class="wikia-button" id="profile-about-edit-button"><?= wfMsg( 'userprofilepage-edit-button' ); ?></a>
		</h1>
		<?= $aboutSection['body']; ?>
		<br />
		<br />
	</div>

	<div id="profile-editable-area" class="uppBox">
		<h1 class="color1">
			<?= wfMsg( 'userprofilepage-users-notes-title', array( $userName ) )?>
			<span class="editsection"><a href="<?=$userPageUrl;?>?action=edit" class="wikia-button"><?= wfMsg( 'userprofilepage-edit-button' ); ?></a></span>
		</h1>
		<?=$pageBody;?>
	</div>
</div>