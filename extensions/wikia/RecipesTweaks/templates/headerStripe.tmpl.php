			<div id="recipes_header_stripe" class="reset clearfix">
				<h1>
					<span id="recipe_title"><?= htmlspecialchars($title) ?></span>
<?php
	if (!empty($showContrib)) {
?>
					<span id="recipes_contributed_by"><?= wfMsg('recipes-contributed-by', $avatar, $userLink) ?></span>
<?php
	}
?>
				</h1>
			</div>
