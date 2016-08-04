<div class="wds-global-footer__licensing-and-vertical">
	<?php //TODO add links and use `type` field instead of assuming the type ?>
	<span><?= wfMessage( $model['description']['key'], $model['description']['params']['license']['title']['value'] )->escaped() ?></span>
</div>
