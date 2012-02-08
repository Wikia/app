<!-- <p><strong>Search Wikia</strong></p>-->
<form class="WikiaSearch" id="search-v2-form" action="<?=$pageUrl;?>">
	Rank Expr:
	<select name="rankExpr">
		<option value="-indextank" <?= (empty($rankExpr) || ($rankExpr == '-indextank')) ? 'selected' : ''; ?> >indextank</option>
		<option value="-bl" <?= ($rankExpr == '-bl') ? 'selected' : ''; ?> >backlinks</option>
	</select>
	<input type="text" name="query" value="<?=$query;?>" /><a class="wikia-button" id="search-v2-button">Search</a><br />
	<input type="checkbox" name="crossWikia" value="1" <?= ( $crossWikia ? 'checked' : '' ); ?>/> Search all of Wikia
</form>
<br />
<?php if( $results !== false ): ?>
	<?php if( $results->found > 0 ): ?>
		<strong>Search results:</strong>&nbsp;<strong><?= $results->start+1; ?> - <?= (($results->start+$resultsPerPage) < $results->found) ? ($results->start+$resultsPerPage) : $results->found; ?></strong> of <strong><?= $results->found; ?></strong> document(s)<br />
		<?= $paginationLinks; ?>
		<?php $pos = 0; ?>
		<?php foreach( $results->hit as $hit ): ?>
			<?php
				$pos++;
				if( $debug ) {
					echo "<pre>";
					var_dump($hit);
					exit;
				}
			?>
			<?php if(isset($hit->data->canonical)): ?>
				<strong><?=$pos + (($currentPage - 1) * $resultsPerPage); ?>. <a href="<?= $hit->data->url; ?>"><?=$hit->data->title;?></a></strong> (Redirect: <?=$hit->data->canonical;?>)<br />
			<?php else: ?>
				<strong><?=$pos + (($currentPage - 1) * $resultsPerPage); ?>. <a href="<?= $hit->data->url; ?>"><?=$hit->data->title;?></a></strong><br />
			<?php endif; ?>
			<div style="width: 50%">
				<?= substr( $hit->data->text, 0, 250 ); ?>...
			</div>
			<a href="<?= $hit->data->url; ?>"><?=$hit->data->url;?></a><br />
			<?php
				switch($rankExpr) {
					case '-indextank':
						$rankValue = $hit->data->indextank;
						break;
					case '-bl':
						$rankValue = $hit->data->bl;
						break;
					default:
						$rankValue = '?';
				}
			?>
			<i>[id: <?=$hit->id;?>, text_relevance: <?=$hit->data->text_relevance;?>, rank: <?= $rankValue; ?>]</i><br />
			<br />
			<?php ?>
		<?php endforeach; ?>
		<?= $paginationLinks; ?>
	<?php else: ?>
		<i>No results found.</i>
	<?php endif; ?>
<?php endif; ?>
