<div class="appreciation-diff-module">
	<span class="appreciation-cta"><?= wfMessage( 'appreciation-cta-text', $username )->escaped() ?></span>
	<span class="appreciation-feedback"><?= wfMessage( 'appreciation-feedback-text', $username )->escaped() ?></span>
	<button class="appreciation-button"
			data-revision="<?= $revision ?>"><?= wfMessage( 'appreciation-text' )->escaped() ?></button>
</div>
