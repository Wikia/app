
<div class="ContentHeader sort-form">
	<label><?= wfMsg('specialvideos-sort-by') ?></label>
	
	
<div class="WikiaDropdown MultiSelect" id="sorting-dropdown">
	<div class="selected-items">
		<span class="selected-items-list"><?= $sortMsg ?></span> <? // TODO: value should be dynamic ?>
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


<div class="WikiaGrid VideoGrid" itemscope itemtype="http://schema.org/VideoGallery">
	<?php $counter = 0 ?>
	<?php foreach( $videos as $video ) { ?>
		<?php $alpha = $counter % 3 == 0 ? 'alpha' : ''; ?>

		<div class="grid-2 <?= $alpha ?>" itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
			<a href="<?= $video['fileUrl'] ?>" class="image video" data-video-name="<?= $video['fileTitle'] ?>">
				<?= $video['videoPlayButton'] ?>
				<img itemprop="thumbnail" alt="<?= $video['fileTitle'] ?>" src="<?= $video['thumbUrl'] ?>" width="320" height="205" data-video="<?= $video['fileTitle'] ?>" class="Wikia-video-thumb thumbimage">
				<?= $video['videoOverlay'] ?>
			</a>
			<p><?= $video['byUserMsg'] ?></p>
			<p itemprop="uploadDate"><?= wfTimeFormatAgo($video['timestamp']) ?></p>
			<p class="posted-in"><?= $video['postedInMsg']; ?></p>

		</div>

		<?php $counter++; ?>
	<?php } ?>
</div>
<?= $pagination ?>