<?= $app->renderPartial( SpecialLookupByEmailController::class, 'form', [ 'targetName' => $targetName ] ); ?>
<ol>
	<? foreach ( $userList as $row ): ?>
		<li class="<?= $row['disabled'] ? 'disabled' : 'not-disabled' ?>">
			<a href="<?= Skin::makeSpecialUrl( 'Contributions', "target={$row['name']}" ); ?>" title="<?= Sanitizer::encodeAttribute( $row['name'] ); ?>">
				<?= htmlspecialchars( $row['name'] ); ?>
			</a>
		</li>
	<? endforeach; ?>
</ol>
