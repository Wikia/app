<? if ( !empty( $videoDetails['username'] ) && !empty( $videoDetails['userUrl'] ) && !empty( $videoDetails['userAvatarUrl'] ) ): ?>
	<div class="featured-video__attribution-container">
		<img class="featured-video__attribution-avatar" src="<?= Sanitizer::encodeAttribute( $videoDetails['userAvatarUrl'] ) ?>"/>
		<a class="featured-video__attribution-username" href="<?= Sanitizer::encodeAttribute( $videoDetails['userUrl'] ) ?>" target="_blank">
			<?= wfMessage( 'articlevideo-attribution-from' )->escaped() ?>
			<?= Sanitizer::encodeAttribute( $videoDetails['username'] ) ?>
		</a>
		<a class="featured-video__attribution-icon" href="<?= Sanitizer::encodeAttribute( $videoDetails['userUrl'] ) ?>" target="_blank">
			<?= DesignSystemHelper::renderSvg( 'wds-icons-out-arrow-tiny', 'wds-icon wds-icon-tiny' ) ?>
		</a>
	</div>
<?endif;?>
