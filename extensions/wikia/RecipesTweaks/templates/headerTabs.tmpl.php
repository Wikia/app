		<div id="recipes_toolbar" class="reset clearfix">
			<div id="recipes_search">
				<form id="recipes_searchform" action="<?= htmlspecialchars($searchAction) ?>" class="reset">
					<fieldset>
						<legend><?= wfMsg('recipes-search-label') ?></legend>
						<input id="search_field" name="search" type="text" value="<?= wfMsg('recipes-search-label') ?>" maxlength="200" onfocus="sf_focus(event);" alt="<?= wfMsg('recipes-search-label') ?>" autocomplete="off"<?= $skin->tooltipAndAccesskey('search'); ?> />
						<input type="submit" id="recipes_search_button" value="" title="<?= wfMsgHtml('searchbutton') ?>" />
					</fieldset>
				</form>
			</div>

			<ul id="recipe_tabs">
<?php
	if (!empty($rating)) {
?>
				<li id="rate_recipe_tab" class="recipe_tab">
					<span class="recipe_tab_wrapper">
						<strong><?= wfMsg('recipes-rating') ?></strong>
						<ul id="star-rating" class="star-rating<?= ($rating['voted'] ? ' star-rating-voted' : '') ?>" rel="<?=STAR_RATINGS_WIDTH_MULTIPLIER;?>">
							<li style="width: <?= $rating['pixels'] ?>px;" id="current-rating" class="current-rating"><span><?= $rating['stars'] ?>/5</span></li>
							<li><a rel="nofollow" class="star one-star" id="star1" title="1/5"><span>1</span></a></li>
							<li><a rel="nofollow" class="star two-stars" id="star2" title="2/5"><span>2</span></a></li>
							<li><a rel="nofollow" class="star three-stars" id="star3" title="3/5"><span>3</span></a></li>
							<li><a rel="nofollow" class="star four-stars" id="star4" title="4/5"><span>4</span></a></li>
							<li><a rel="nofollow" class="star five-stars" id="star5" title="5/5"><span>5</span></a></li>
						</ul>
					</span>
				</li>
<?php
	}
?>
				<li id="add_recipe_tab" class="recipe_tab">
					<span class="recipe_tab_wrapper">
						<a href="<?= htmlspecialchars($newRecipeAction) ?>"><img src="<?= htmlspecialchars($blank) ?>" class="sprite add" alt="."/></a>
						<a href="<?= htmlspecialchars($newRecipeAction) ?>"><?= wfMsg('recipes-add-new-recipe') ?></a>
					</span>
				</li>
			</ul>
		</div>

		<div id="search_box"><!-- search suggest placeholder --></div>
