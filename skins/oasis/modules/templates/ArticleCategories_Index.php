<?php
	if (!empty($categories)) {
?>
<aside id="WikiaArticleCategories" class="WikiaArticleCategories">
	<h1><?= $categoriesLink ?>:</h1>
<?php
		foreach($categories as $category) {
			echo $category;
		}
?>
</aside>
<?php
	}
?>
