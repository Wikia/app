<? global $wgStylePath ?>

<section class="lvs-callout">
	<button class="close wikia-chiclet-button">
		<img src="<?= $wgStylePath ?>/oasis/images/icon_close.png">
	</button>
	<h1><?= wfMessage('lvs-callout-header')->text() ?></h1>
	<ul>
		<li>- <?= wfMessage('lvs-callout-reason-licensed')->text() ?></li>
		<li>- <?= wfMessage('lvs-callout-reason-quality')->text() ?></li>
		<li>- <?= wfMessage('lvs-callout-reason-collaborative')->text() ?></li>
		<li>- <?= wfMessage('lvs-callout-reason-more')->text() ?></li>
	</ul>
</section>

<p><?= wfMessage('lvs-instructions')->text() ?></p>

<div class="ContentHeader sort-form">
	<label><?= wfMsg('specialvideos-sort-by') ?></label>


	<div class="WikiaDropdown MultiSelect" id="sorting-dropdown">
		<div class="selected-items">
			<span class="selected-items-list"><?= $sortMsg ?></span>
			<img class="arrow" src="<?= $wg->BlankImgUrl ?>" />
		</div>
		<div class="dropdown">
			<ul class="dropdown-list">
				<? foreach($sortOptions as $sortBy => $option): ?>
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

