<section id="sectionPathFinder">
<nav>
	<form id="wikiForm">
		<div id="commonOptions">
			<label for="articleId"><?= wfMsg( 'pathfinder-article' ); ?>:
				<select id="selectBy">
					<option value="byId"><?= wfMsg( 'pathfinder-id' ); ?></option>
					<option value="byTitle"><?= wfMsg( 'pathfinder-title' ); ?></option>
				</select>
				<span id="articlePlace"><input id="article" type="number" value="" min="0" /></span>
			</label>
			<label for="dateSpan"><?= wfMsg( 'pathfinder-last' ); ?>:
				<input id="dateSpan" type="number" value="30" min="1"/>
			</label> <?= wfMsg( 'pathfinder-days' ); ?>
			<label for="minCount"><?= wfMsg( 'pathfinder-minCount' ); ?>:
				<input id="minCount" type="number" value="10" min="1"/>
			</label>
		</div>
		<div id="pathsOptions">
			<label for="howManyPaths"><?= wfMsg( 'pathfinder-howManyPaths' ); ?>:
				<input id="howManyPaths" type="number" value="3" min="1"/>
			</label>
			<label for="nodeCount"><?= wfMsg( 'pathfinder-nodecount' ); ?>:
				<input id="nodeCount" type="number" value="10" min="1" />
			</label>
		</div>
		<div id="userHaveSeenOptions">
			<label for="userHaveSeenNumber"><?= wfMsg( 'pathfinder-userHaveSeenNumber' ); ?>:
				<input id="userHaveSeenNumber" type="number" value="3" min="1" />
			</label>
		</div>
	<button type="submit" onclick="return PathFinder.load()"><?= wfMsg( 'pathfinder-show' ); ?></button>
	
	</form>
</nav>

<div id="articles" <?= ( $par != NULL )  ? "data-page=\"".$par."\"" : "" ?>>
<span class="PFHeader"><?= wfMsg( 'pathfinder-preview' ); ?></span>
<iframe name="showArticle" id="showArticle" <?= ( $par != NULL )  ? "src=\"/wiki/".$par."\"" : "" ?>></iframe>
		<span class="PFHeader" id="relatedPages"><?= wfMsg( 'pathfinder-relatedPages' ); ?></span>
	<div id="relatedArticles">
	</div>
		<span class="PFHeader" id="possiblePath"><?= wfMsg( 'pathfinder-possiblePath' ); ?></span>
	<div id="navigationArticles">	
	</div>
</div>
<div id="noresult"><?= wfMsg( 'pathfinder-noresult' ); ?></div>
</section>
<footer>
	<?= wfMsg( 'pathfinder-createdby' ); ?>: 
		<ul>
			<li>
				<a href="mailto:bukaj.kelo@gmail.com">Jakub Olek</a>
			</li>
			<li>
				<a href="mailto:federico@wikia-inc.com">Federico "Lox" Lucignano</a>
			</li>
		</ul> 
</footer>