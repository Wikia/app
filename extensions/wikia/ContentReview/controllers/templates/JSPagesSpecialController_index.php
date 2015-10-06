<p>
	<?php if ( $isTestModeEnabled ): ?>
		<button class="content-review-module-test-mode-disable secondary">
			<?= wfMessage( 'content-review-module-test-mode-disable' )->escaped() ?>
		</button>
	<?php else: ?>
		<button class="content-review-module-test-mode-enable secondary">
			<?= wfMessage( 'content-review-module-test-mode-enable' )->escaped() ?>
		</button>
	<?php endif ?>
</p>
<table class="article-table">
	<thead>
	<tr class="content-review-special-list-headers">
		<th><?= wfMessage( 'content-review-special-list-header-page-name' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-module-header-latest' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-module-header-last' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-module-header-live' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-actions' )->escaped() ?></th>
	</tr>
	</thead>
	<tbody>
		<?php foreach( $jsPages as $page ): ?>
			<tr>
				<td><?= $page['pageLink'] ?></td>
				<td><?= $page['latestRevision']['statusMessage'] ?></td>
				<td><?= $page['latestReviewed']['statusMessage'] ?></td>
				<td><?= $page['liveRevision']['statusMessage'] ?></td>
				<td>
					<?php if ( $page['submit'] ): ?>
						<button class="content-review-module-submit primary" data-page-name="<?= Sanitizer::encodeAttribute( $page['pageName'] ) ?>">
							<?= $submit ?>
						</button>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
