<div class="grid-2 alpha wikiahubs-sponsored-video">
	<div class="title-wrapper">
		<h2>
			<span class="mw-headline" id="Video_of_the_Day"><?= $headline; ?></span>
		</h2>

		<?php if( !empty($sponsorThumb) ): ?>
			<span class="sponsorbox"><img src="<?= $sponsorThumb; ?>" /><ins></ins></span>
		<?php endif; ?>
	</div>

	<div class="sponsored-video-content">
		<figure class="thumb tright thumbinner" style="width:302px;">
			<a href="/File:Resident_Evil_6_(VG)_(2012)_-_SDCC_trailer" class="image video" data-video-name="Resident Evil 6 (VG) (2012) - SDCC trailer">
				<span class="Wikia-video-play-button mid" style="width: 300px; height: 168px;"></span>
				<img alt="Resident Evil 6 (VG) (2012) - SDCC trailer" src="http://images1.wikia.nocookie.net/__cb20120725202314/video151/images/thumb/6/62/Resident_Evil_6_%28VG%29_%282012%29_-_SDCC_trailer/300px-Resident_Evil_6_%28VG%29_%282012%29_-_SDCC_trailer.jpg" width="300" height="168" data-video="Resident Evil 6 (VG) (2012) - SDCC trailer" class="Wikia-video-thumb thumbimage" />
			</a>
			<a href="/File:Resident_Evil_6_(VG)_(2012)_-_SDCC_trailer" class="internal sprite details magnify" title="View photo details"></a>
			<figcaption class="thumbcaption"></figcaption>
		</figure>
		<h4>
			<span class="mw-headline" id="<?= $description['maintitle']; ?>"><b><?= $description['maintitle']; ?></b></span>
		</h4>
		<?= $description['subtitle']; ?> <a href="<?= $description['link']['href']; ?>"><?= $description['link']['anchor']; ?></a>
	</div>
</div>