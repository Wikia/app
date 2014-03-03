<header id="WikiaPageHeader" class="WikiaPageHeader">
    <h1><?= !empty($displaytitle) ? htmlspecialchars($title) : '' ?></h1>
	<?php if (!is_null($tallyMsg)) : ?>
		<div class="tally">
			<?= $tallyMsg ?>
        </div>
	<?php endif ?>
</header>
<?php if ($showSearchBox) : ?>
<section id="WikiaSearchHeader" class="WikiaSearchHeader">
	<?=  F::app()->renderView('Search', 'Index', array('searchFormId' => 'WikiaSearch')) ?>
</section>
<?php endif ?>
