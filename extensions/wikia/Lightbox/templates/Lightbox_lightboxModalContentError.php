<h1><?= htmlspecialchars( wfMessage( 'lightbox-no-media-error-header' )->plain() ) ?></h1>

<p><?= $error ?></p>

<div class="modalToolbar">
	<button id="close-lightbox" class="close"><?= htmlspecialchars( wfMessage( 'lightbox-no-media-error-close' )->plain() ) ?></button>
</div>
