<? if ( isset( $videoDetails['username'], $videoDetails['userUrl'], $videoDetails['userAvatarUrl'] ) ): ?>
	<div class="attribution-container">
		<img class="attribution-avatar" src="<?= Sanitizer::encodeAttribute( $videoDetails['userAvatarUrl'] ) ?>"/>
		<a class="attribution-username" href="<?= Sanitizer::encodeAttribute( $videoDetails['userUrl'] ) ?>" target="_blank">
			<?= wfMessage( 'articlevideo-attribution-from' )->escaped() ?>
			<?= Sanitizer::encodeAttribute( $videoDetails['username'] ) ?>
		</a>
		<a class="attribution-icon" href="<?= Sanitizer::encodeAttribute( $videoDetails['userUrl'] ) ?>" target="_blank">
			<?= DesignSystemHelper::renderSvg( 'wds-icons-out-arrow-tiny', 'wds-icon wds-icon-tiny' ) ?>
		</a>
	</div>
<?endif;?>
