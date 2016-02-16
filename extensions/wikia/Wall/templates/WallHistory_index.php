<div class="WallHistory">
<? if ( empty( $wallmessageNotFound ) ): ?>
	<?= $app->renderView( 'Wall', 'brickHeader', [
			'path' => $path
		] );
	?>

	<div class="SortingBar">
		<div id="pageTitle">
			<?= $pageTitle; ?>
		</div>
		<div class="SortingMenu">
			<span class="SortingSelected"><?= $sortingSelected; ?></span>
			<ul class="SortingList">
				<? foreach ( $sortingOptions as $option ): ?>
					<li class="<? if ( !empty( $option['selected'] ) ): ?>current<? endif ?> <?= $option['id']; ?>">
						<a href="<?= $option['href'] ?>" class="sortingOption">
							<?= $option['text'] ?>
						</a>
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	</div>

	<?php if ( !empty( $wallHistory ) ): ?>
		<?php if( $isThreadLevelHistory ): ?>
			<table id="WallThreadHistory">
				<?php foreach ( $wallHistory as $entry ): ?>
					<tr>
						<td>
							<?php if ( $entry['type'] == WH_NEW ): ?>
								<a class="msgid" href="<?= $entry['msgurl']; ?>">
									<sup>#</sup>
									<?= $entry['msgid']; ?>
								</a>
							<?php endif; ?>
						</td>
						<td>
							<a href="<?= $entry['authorurl']; ?>"><?= AvatarService::renderAvatar($entry['username'], 20); ?></a>
						</td>
						<td>
							<?= wfMessage( $wallHistoryMsg[$entry['prefix'] . $entry['type']] )->rawParams( [
								'',
								$entry['displayname'],
								Xml::element( 'a', [ 'href' => $entry['msguserurl'] ], $entry['msgusername'] ),
								Xml::element( 'a', [ 'href' => $entry['msgurl'], 'class' => 'creation' ], $entry['metatitle'] ),
								'<a href="'.$entry['msgurl'] . '">#'. $entry['msgid']. '</a>'
							] )->escaped(); ?>

							<?php
								if ( !empty( $entry['actions'] ) ):
									$actions = [];
									foreach ( $entry['actions'] as $key => $action ):
										$htmldata = $action;
										unset($htmldata['msg']);
										$actions[] = wfMessage( 'parentheses' )->rawParams( Xml::element( 'a', $htmldata , $action['msg'] ) )->escaped();
									endforeach;
									echo Xml::openElement( 'span', [ 'class' => 'actions' ] );
									echo implode( ' ',$actions );
									echo Xml::closeElement( 'span' );
								endif;
							?>
						</td>
						<td>
							<span class='timestamp'>
								<span class="timeago-fmt"><?= $entry['usertimeago']; ?></span>
							</span>
						</td>
					</tr>
					<tr class="border">
						<td class="wrapper" colspan="4">
							<?php if ( !empty( $entry['reason'] ) ): ?>
								<div class="summaryBubble">
									<label><?= wfMessage( 'wall-history-summary-label' )->escaped(); ?></label>&nbsp;<?= Linker::formatComment( $entry['reason'] ); ?>
								</div>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php else: ?>
			<table id="WallHistory">
				<?php foreach($wallHistory as $entry): ?>
					<tr class="info-entry">
						<td>
							<?= wfMessage( $wallHistoryMsg[$entry['type']] )->rawParams( [
										Xml::element( 'a', [
											'href' => $entry['msgurl'],
											'class' => $entry['type'] === WH_NEW ? 'creation' : ''
										], $entry['metatitle'] ),
										$entry['displayname'],
									] )->escaped();
							?>
							<?php
								if ( !empty( $entry['actions'] ) ):
									$actions = [ ];
									foreach ( $entry['actions'] as $key => $action ):
										$htmldata = $action;
										unset( $htmldata['msg'] );
										$actions[] = wfMessage( 'parentheses' )->rawParams( Xml::element( 'a', $htmldata , $action['msg'] ) )->escaped();
									endforeach;
									echo Xml::openElement( 'span', [ 'class' => 'actions' ] );
									echo implode(' ',$actions);
									echo Xml::closeElement( 'span' );
								endif;
							?>
							<span class="threadHistory"><?= wfMessage( 'parentheses' )->rawParams( $entry['historyLink'] )->escaped(); ?></span>
						</td>
						<td>
							<span class='timestamp'>
								<?= $entry['usertimeago']; ?>
							</span>
						</td>
					</tr>
					<tr class="border">
						<td class="wrapper" colspan="2">
							<?php if ( !empty( $entry['reason'] ) ): ?>
								<div class="summaryBubble">
									<label><?= wfMessage( 'wall-history-summary-label' )->escaped(); ?></label>&nbsp;<?= Linker::formatComment( $entry['reason'] ); ?>
								</div>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>

		<?php if($showPager): ?>
			<?= $app->renderView( 'PaginationController', 'index', [ 'totalItems' => $totalItems, 'itemsPerPage' => $itemsPerPage, 'currentPage' => $currentPage, 'url' => $wallHistoryUrl ] ); ?>
		<?php endif;?>
	<?php endif; ?>
<?php else: ?>
	<div>
		<p><?= wfMessage( 'wall-message-not-found-in-db' )->escaped(); ?></p>
	</div>
	<div class="SortingBar">
		<div id="pageTitle">
			<?= $pageTitle; ?>
		</div>
		<div class="SortingMenu">
			<span class="SortingSelected"><?= $sortingSelected; ?></span>
			<ul class="SortingList">
				<? foreach ( $sortingOptions as $option ): ?>
					<li class="<? if ( !empty( $option['selected'] ) ): ?>current<? endif ?> <?= $option['id']; ?>">
						<a href="<?= $option['href'] ?>" class="sortingOption">
							<?= $option['text'] ?>
						</a>
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif; ?>
</div>
