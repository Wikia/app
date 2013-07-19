
<div class="ContentHeader sort-form">
	<label><?= wfMsg('specialvideos-sort-by') ?></label>


	<div class="WikiaDropdown MultiSelect" id="sorting-dropdown">
		<div class="selected-items">
			<span class="selected-items-list"><?= $sortMsg ?></span>
			<img class="arrow" src="<?= $wg->BlankImgUrl ?>" />
		</div>
		<div class="dropdown">
			<ul class="dropdown-list">
				<? foreach($sortingOptions as $sortBy => $option): ?>
					<? if($sortMsg != $option): ?>
						<li class="dropdown-item">
							<label data-sort="<?= $sortBy ?>"><?= $option ?></label>
						</li>
					<? endif; ?>
				<? endforeach; ?>
			</ul>
		</div>
	</div>

</div>


<div class="WikiaGrid VideoGrid">
	<?php $counter = 0 ?>
	<?php foreach( $videos as $video ): ?>
		<?php $alpha = $counter % 3 == 0 ? ' alpha' : ''; ?>

		<div class="grid-2 video-element<?= $alpha ?>" itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
			<a href="<?= $video['fileUrl'] ?>" class="image video">
				<?= $video['videoPlayButton'] ?>
				<img itemprop="thumbnail" alt="<?= $video['fileTitle'] ?>" src="<?= $video['thumbUrl'] ?>" width="<?= $thumbWidth ?>" height="<?= $thumbHeight ?>" data-video-name="<?= htmlspecialchars($video['fileTitle']) ?>" data-video-key="<?= htmlspecialchars(urlencode($video['title'])) ?>" class="Wikia-video-thumb thumbimage">
				<?= $video['videoOverlay'] ?>
			</a>
			<p><?= $video['byUserMsg'] ?></p>
			<p itemprop="uploadDate"><?= wfTimeFormatAgo($video['timestamp']) ?></p>
			<p><?= $video['postedInMsg']; ?></p>
			<meta itemprop="embedUrl" content="<?= $video['embedUrl'] ?>" />
			<? if($isRemovalAllowed): ?>
				<a class="remove">
					<img class="sprite trash" src="<?= wfBlankImgUrl() ?>" title="<?= wfMsg('specialvideos-remove-modal-title') ?>">
				</a>
			<? endif; ?>
		</div>

		<?php $counter++; ?>
	<?php endforeach; ?>
	<?php if (!empty($addVideo)): ?>
		<?php $alpha = $counter % 3 == 0 ? 'alpha' : ''; ?>

		<!-- Check user permissions, only admins may upload videos, hide element for non-admins -->
		<? if ($showAddVideoBtn): ?>
			<div class="grid-2 <?= $alpha ?>">
				<div class="add-video-placeholder addVideo"></div>
					<p><a href="#" class="addVideo"><?= wfMessage('special-videos-add-video')->text(); ?></a></p>
			</div>
		<? endif; ?>
		<?php endif; ?>
</div>
<?= $pagination ?>
<div class="errorWhileLoading messageHolder"><?=wfMsg('videos-error-while-loading');?></div>
