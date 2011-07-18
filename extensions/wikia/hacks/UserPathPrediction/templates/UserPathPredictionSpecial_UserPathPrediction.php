<section id="sectionUserPathPrediction">
<nav>
	<form id="wikiForm">
		<div id="commonOptions">
			<label for="articleId"><?= wfMsg( 'userpathprediction-article' ); ?>:
				<select id="selectBy">
					<option value="byId"><?= wfMsg( 'userpathprediction-id' ); ?></option>
					<option value="byTitle"><?= wfMsg( 'userpathprediction-title' ); ?></option>
				</select>
				<span id="articlePlace"><input id="article" type="number" value="" min="0" /></span>
			</label>
			<label for="dateSpan"><?= wfMsg( 'userpathprediction-last' ); ?>:
				<input id="dateSpan" type="number" value="30" min="1"/>
			</label> <?= wfMsg( 'userpathprediction-days' ); ?>
		</div>
		<div id="pathsOptions">
			<label for="howManyPaths"><?= wfMsg( 'userpathprediction-howManyPaths' ); ?>:
				<input id="howManyPaths" type="number" value="3" min="1"/>
			</label>
			<label for="nodeCount"><?= wfMsg( 'userpathprediction-nodecount' ); ?>:
				<input id="nodeCount" type="number" value="10" min="1" />
			</label>
		</div>
		<div id="userHaveSeenOptions">
			<label for="userHaveSeenNumber"><?= wfMsg( 'userpathprediction-userHaveSeenNumber' ); ?>:
				<input id="userHaveSeenNumber" type="number" value="3" min="1" />
			</label>
		</div>
	<button type="submit" onclick="return UserPathPrediction.load()"><?= wfMsg( 'userpathprediction-show' ); ?></button>
	
	</form>
</nav>

<div id="articles" <?= ( $par != NULL )  ? "data-page=\"".$par."\"" : "" ?>>
<span class="UPPHeader"><?= wfMsg( 'userpathprediction-preview' ); ?></span>
<iframe name="showArticle" id="showArticle" <?= ( $par != NULL )  ? "src=\"/wiki/".$par."\"" : "" ?>></iframe>
		<span class="UPPHeader" id="relatedPages"><?= wfMsg( 'userpathprediction-relatedPages' ); ?></span>
	<div id="relatedArticles">
	</div>
		<span class="UPPHeader" id="possiblePath"><?= wfMsg( 'userpathprediction-possiblePath' ); ?></span>
	<div id="navigationArticles">	
	</div>
</div>
<div id="noresult"><?= wfMsg( 'userpathprediction-noresult' ); ?></div>
</section>
<footer>
	<?= wfMsg( 'userpathprediction-createdby' ); ?>: 
		<ul>
			<li>
				<a href="mailto:bukaj.kelo@gmail.com">Jakub Olek</a>
			</li>
			<li>
				<a href="mailto:federico@wikia-inc.com">Federico "Lox" Lucignano</a>
			</li>
		</ul> 
</footer>