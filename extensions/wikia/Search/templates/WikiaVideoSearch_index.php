<style type="text/css">

div.video-search-results {
	clear: both;
	float: none;
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
	margin-bottom: 20px;
	min-height: 270px;
	padding: 5px;
	width: 480px;
}

#video-search-form-wrapper {
	margin-bottom: 15px;
}

div.number {
	float: right;
	font-size: 16px;
	font-weight: bold;
}

</style>
<script type="text/javascript">
jQuery(document).ready( function() {
	var maxHeight = 0;
	$('.video-search-results section').each( function() {
		var height = $(this).height();
		maxHeight = maxHeight > height ? maxHeight : height;
	});
	$('.video-search-results section').height(maxHeight);
	var maxHeight = 0;
	$('section ul').each( function() {
		var height = $(this).height();
		maxHeight = maxHeight > height ? maxHeight : height;
	});
	$('section ul').height(maxHeight);
});
</script>


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
		<div class="number">I</div>
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
		<div class="description">
			These results use Solr's MoreLikeThis handler to compare interesting terms on the page to all videos on 
			this wiki and on the video wiki. This is the default behavior in the current VET search suggest.
		</div>
	</section>	
	
	<section>
		<div class="number">II</div>
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
		<div class="description">
			This searches this wiki and the video wiki for videos by using the provided page title as the search term.
			This is not used by itself anywhere.
		</div>
	</section>
</div>
<? endif; ?>
<div class="video-search-results">	
	<section>
		<div class="number">III</div>
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
		<div class="description">
			These results are found by matching the most interesting terms from all of the content pages on this wiki
			to videos on this wiki and the video wiki. This is used by VET as a back-off in cases where running this 
			against a single page returns no results.
		</div>
	</section>
	
	<section>
		<div class="number">IV</div>
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
		<div class="description">
			This is the result of searching for videos on this wiki and the video wiki, using the 
			name of the wiki (minus <i>wiki</i>) as a regular search term. It is not used by itself anywhere.
		</div>
	</section>
</div>
<div class ="video-search-results">
	<section>
		<div class="number">V</div>
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
		<div class="description">
			This is an experimental approach that takes the page title and the wiki title and uses them 
			as search terms for videos on this wiki and the video wiki.
		</div>
	</section>
	<section>
		<div class="number">VI</div>
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
		<div class="description">
			These results represent the complete behavior of the experimental behavior proposed for VET on the 
			10/26 related video meeting. First, we use MoreLikeThis against the page (Box I). If we have no results,
			we run MoreLikeThis against the wiki (Box III). For cases where we still have no results, or cases 
			where the wiki is not in English, and we cannot use MoreLikeThis, we use one of two back-off  methodologies.
			In a page context, we perform a video search against a page title (Box II); in a wiki context, we 
			search against the wiki name (Box IV).
		</div>
	</section>
</div>