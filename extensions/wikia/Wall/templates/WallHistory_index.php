<div class="WallHistory">
<? if( empty($wallmessageNotFound) ): ?>
	<?
		echo F::App()->getView('Wall', 'brickHeader', array(
			'path' => $path
		))->render();
	?>

	<div class="SortingBar">
		<div id="pageTitle">
			<?= $pageTitle; ?>
		</div>
		<div class="SortingMenu">
			<span class="SortingSelected"><?= $sortingSelected; ?></span>
			<ul class="SortingList">
				<? foreach($sortingOptions as $option): ?>
					<li class="<? if (!empty($option['selected'])): ?>current<? endif ?> <?= $option['id']; ?>">
						<a href="<?= $option['href'] ?>" class="sortingOption">
							<?= $option['text'] ?>
						</a>
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	</div>

	<?php if( !empty($wallHistory) ): ?>
		<?php if( $isThreadLevelHistory ): ?>
			<table id="WallThreadHistory">
				<?php foreach($wallHistory as $entry): ?>
					<tr>
						<td>
							<?php if( $entry['type'] == WH_NEW ): ?>
								<a class="msgid" href="<?= $entry['msgurl']; ?>">
									<sup>#</sup>
									<?= $entry['msgid']; ?>
								</a>
							<?php endif; ?>
						</td>
						<td>
							<a href="<?php echo $entry['authorurl'] ?>"><?= AvatarService::renderAvatar($entry['username'], 20); ?></a>
						</td>
						<td>
							<?= wfMessage( $wallHistoryMsg[$entry['prefix'].$entry['type']], array(
									'$1' => '',
									'$2' => $entry['displayname'],
									'$3' => Xml::element('a', array('href' => $entry['msguserurl']), $entry['msgusername']),
									'$4' => Xml::element('a', array('href' => $entry['msgurl'], 'class' => 'creation'), $entry['metatitle']),
									'$5' => '<a href="'.$entry['msgurl'] . '">#'. $entry['msgid']. '</a>'
							) )->text(); ?>

							<?php
								if( !empty($entry['actions']) ):
									$actions = array();
									foreach($entry['actions'] as $key => $action):
										$htmldata = $action;
										unset($htmldata['msg']);
										$actions[] = wfMessage( 'parentheses' )->rawParams( Xml::element('a', $htmldata , $action['msg']) )->plain();
									endforeach;
									echo Xml::openElement('span', array('class' => 'actions'));
									echo implode(' ',$actions);
									echo Xml::closeElement('span');
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
							<?php if( !empty($entry['reason']) ): ?>
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
							<?php
								if( $entry['type'] === WH_NEW ) {
									echo wfMessage( $wallHistoryMsg[$entry['type']], array(
										'$1' => Xml::element('a', array('href' => $entry['msgurl'], 'class' => 'creation'), $entry['metatitle']),
										'$2' => $entry['displayname'],
									) )->text();
								} else {
									echo wfMessage( $wallHistoryMsg[$entry['type']], array(
										'$1' => Xml::element('a', array('href' => $entry['msgurl']), $entry['metatitle']),
										'$2' => $entry['displayname'],
									) )->text();
								}
							?>
							<?php
								if( !empty($entry['actions']) ):
									$actions = array();
									foreach($entry['actions'] as $key => $action):
										$htmldata = $action;
										unset($htmldata['msg']);
										$actions[] = wfMessage( 'parentheses' )->rawParams( Xml::element('a', $htmldata , $action['msg']) )->plain();
									endforeach;
									echo Xml::openElement('span', array('class' => 'actions'));
									echo implode(' ',$actions);
									echo Xml::closeElement('span');
								endif;
							?>
							<span class="threadHistory"><?= wfMessage( 'parentheses' )->rawParams( $entry['historyLink'] )->plain(); ?></span>
						</td>
						<td>
							<span class='timestamp'>
								<?= $entry['usertimeago']; ?>
							</span>
						</td>
					</tr>
					<tr class="border">
						<td class="wrapper" colspan="2">
							<?php if( !empty($entry['reason']) ): ?>
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
			<?= $app->renderView('PaginationController', 'index', array('totalItems' => $totalItems, 'itemsPerPage' => $itemsPerPage, 'currentPage' => $currentPage, 'url' => $wallHistoryUrl)); ?>
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
				<? foreach($sortingOptions as $option): ?>
					<li class="<? if (!empty($option['selected'])): ?>current<? endif ?> <?= $option['id']; ?>">
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
