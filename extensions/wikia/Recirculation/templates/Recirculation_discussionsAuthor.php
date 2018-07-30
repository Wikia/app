<div class="wds-avatar">
	<img class="wds-avatar__image"
		 src="<?= AvatarService::getAvatarUrl( !$post->authorIsAnon ? $post->author : null, 26 ) ?>">
</div>
<span class="mcf-card-discussions__user-subtitle"><?= !$post->authorIsAnon
		? Sanitizer::escapeHtmlAllowEntities( $post->author )
		: wfMessage( 'oasis-anon-user' )
			->inContentLanguage()
			->escaped() ?>
	• <time class="discussion-timestamp"
			datetime="<?= Sanitizer::encodeAttribute( $post->pub_date ) ?>"></time></span>
