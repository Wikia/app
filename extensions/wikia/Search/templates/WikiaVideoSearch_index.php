<style type="text/css">

div.video-search-results {
	clear: both;
	float: none;
	margin-top: 15px;
	min-height: 270px;
	width: 1000px;
}

.video-search-results section:first-child {
	margin-left: 0;
	float: left;
}

.video-search-results section {
	border: 1px solid #333333;
	float: right;
	margin-left: 10px;
	min-height: 270px;
	padding: 5px;
	width: 480px;
}

#vide-search-form-wrapper {
	margin-bottom: 15px;
}
</style>

<fieldset id="video-search-form-wrapper">
	<legend>Video Search</legend>
	<form id="video-search-form">
		<em>Choose One:</em><br>
		<label for="pageid">Page ID</label>
		<input id="video-search-pageid" name="pageid" value="<?= $submittedPageId ?>"><br>
		<label for="pageid">Page Title</label>
		<input id="video-search-pagetitle" name="pagetitle" value="<?= $submittedTitle ?>">
		<input type="submit">
	</form>
</fieldset>
<? if ( isset( $title ) ) : ?>
<div class="video-search-results">
	<section>
	<? if ( $mltResults ) : ?>
	
		<h3>MoreLikeThisResults for <?= $title ?></h3>
		<ul>
		<? foreach ( $mltResults as  $resultFields ) : ?>
			<li><a href="<?=$resultFields['url']?>"><?= $resultFields[WikiaSearch::field('title')] ?></a></li>
		<? endforeach; ?>
		</ul>
	<? else: ?>
		<h3>No Page-Based MoreLikeThis Results</h3>
	<? endif; ?>
	</section>	
	
	<section>
	<? if ( $searchResults ) : ?>
		<h3>Video Search Against <i><?= $title ?></i></h3>
		<ul>
		<? foreach ( $searchResults as  $resultFields ) : ?>
			<li><a href="<?=$resultFields['url']?>"><?= $resultFields[WikiaSearch::field('title')] ?></a></li>
		<? endforeach; ?>
		</ul>
	<? else: ?>
		<h3>No results for <i><?= $title ?></i> in video wiki</h3>
	<? endif; ?>
	</section>
</div>
<? endif; ?>
<div class="video-search-results">	
	<section>
	<? if ( $wikiMltResults ) : ?>
	
		<h3>Wiki-Based MoreLikeThisResults</h3>
		<ul>
		<? foreach ( $wikiMltResults as  $resultFields ) : ?>
			<li><a href="<?=$resultFields['url']?>"><?= $resultFields[WikiaSearch::field('title')] ?></a></li>
		<? endforeach; ?>
		</ul>
	<? else: ?>
		<h3>No Wiki-Based MoreLikeThis Results</h3>
	<? endif; ?>
	</section>
	
	<section>
	<? if ( $wikiSearchResults ) : ?>
		<h3>Video Search Against <i><?= $wikiQuery ?></i></h3>
		<ul>
		<? foreach ( $wikiSearchResults as  $resultFields ) : ?>
			<li><a href="<?=$resultFields['url']?>"><?= $resultFields[WikiaSearch::field('title')] ?></a></li>
		<? endforeach; ?>
		</ul>
	<? else: ?>
		<h3>No results for <i><?= $wikiQuery ?></i> in video wiki</h3>
	<? endif; ?>
	</section>
</div>
<div class ="video-search-results">
	<section>
	<? if ( $wikiMltResults ) : ?>
		<h3>Video Search Against <i><?= $combinedQuery ?></i></h3>
		<ul>
		<? foreach ( $combinedSearchResults as  $resultFields ) : ?>
			<li><a href="<?=$resultFields['url']?>"><?= $resultFields[WikiaSearch::field('title')] ?></a></li>
		<? endforeach; ?>
		</ul>
	<? else: ?>
		<h3>No Results for <i><?= $combinedQuery ?></i></h3>
	<? endif; ?>
	</section>
	<section>
	<? if ( $suggestedVideoResults ) : ?>
		<h3>Experimental VET Suggested Video Search Results</h3>
		<ul>
		<? foreach ( $suggestedVideoResults as  $resultFields ) : ?>
			<li><a href="<?=$resultFields['url']?>"><?= $resultFields[WikiaSearch::field('title')] ?></a></li>
		<? endforeach; ?>
		</ul>
	<? else: ?>
		<h3>No Results from Experimental VET Suggested Video Search</h3>
	<? endif; ?>
	</section>
</div>