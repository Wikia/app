<?
/* @var $sortingOptions array */
/* @var $sortMsg string */
/* @var $wg object */
/* @var $isRemovalAllowed bool */
/* @var $showAddVideoBtn bool */
/* @var $pagination string */
?>

<div class="ContentHeader sort-form">
	<label><?= wfMsg('specialvideos-sort-by') ?></label>


	<div class="WikiaDropdown MultiSelect" id="sorting-dropdown">
		<div class="selected-items">
			<span class="selected-items-list"><?= $sortMsg ?></span>
			<img class="arrow" src="<?= $wg->BlankImgUrl ?>" />
		</div>
		<div class="dropdown">
			<ul class="dropdown-list">
				<? foreach ( $sortingOptions as $sortBy => $option ): ?>
					<? if ( $sortMsg != $option ): ?>
						<?
							$parts = explode( ':', $sortBy );
							$sortType = empty( $parts[0] ) ? '' : $parts[0];
							$category = empty( $parts[1] ) ? '' : $parts[1];
						?>
						<li class="dropdown-item">
							<label data-sort="<?= $sortType ?>" data-category="<?= $category ?>"><?= $option ?></label>
						</li>
					<? endif; ?>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
</div>


<ul class="special-videos-grid small-block-grid-3 large-block-grid-3 x-large-block-grid-4">
	<?php $counter = 0 ?>
	<?php foreach( $videos as $video ): ?>
		<?php $alpha = $counter % 3 == 0 ? ' alpha' : ''; ?>

		<li itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
			<?= $video['thumbnail'] ?>
			<div class="info">
				<p class="title">
					<a href="<?= $video['fileUrl'] ?>" title="<?= $video['title'] ?>"><?= $video['title'] ?></a>
				</p>
				<p class="by-views">
					<?= $video['byUserMsg'] ?>
					<span class="diamond">&diams;</span>
					<span class="views"><?= $video['viewTotal'] ?></span>
				</p>
				<div class="posted-in">
					<a class="ellipses" href="<?= $video['seeMoreLink'] ?>"><?= wfMessage('lvs-posted-in-more')->plain() ?></a>
					<? if ( count($video['truncatedList']) ): ?>
						<?= wfMessage('specialvideos-posted-in-label')->plain() ?>
						<ul>
							<? foreach( $video['truncatedList'] as $article ): ?>
								<li><a href="<?= $article['url'] ?>"><?= $article['titleText'] ?></a></li>
							<? endforeach; ?>
						</ul>
					<? endif; ?>
				</div>
			</div>
			<? if($isRemovalAllowed): ?>
				<a class="remove">
					<img class="sprite trash" src="<?= wfBlankImgUrl() ?>" title="<?= wfMsg('specialvideos-remove-modal-title') ?>">
				</a>
			<? endif; ?>
		</li>

		<?php $counter++; ?>
	<?php endforeach; ?>
	<?php if (!empty($addVideo)): ?>
		<?php $alpha = $counter % 3 == 0 ? 'alpha' : ''; ?>

		<!-- Check user permissions, only admins may upload videos, hide element for non-admins -->
		<? if ($showAddVideoBtn): ?>
			<li class="add-video">
				<div class="add-video-placeholder addVideo"></div>
					<p><a href="#" class="addVideo"><?= wfMessage('special-videos-add-video')->text(); ?></a></p>
			</li>
		<? endif; ?>
		<?php endif; ?>
</ul>
<?= $pagination ?>
<div class="errorWhileLoading messageHolder"><?=wfMsg('videos-error-while-loading');?></div>
