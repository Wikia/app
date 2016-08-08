<span class="appreciation-history-link">
	<span class="appreciation-feedback"><?= wfMessage( 'appreciation-sent-text' )->escaped() ?></span>
	<a href="#" class="appreciation-link"
	   data-revision="<?= Sanitizer::encodeAttribute( $revision ) ?>"><?= wfMessage( 'appreciation-text' )->escaped() ?></a>
</span>
