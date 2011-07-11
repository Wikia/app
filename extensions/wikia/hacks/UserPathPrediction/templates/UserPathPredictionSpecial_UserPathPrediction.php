<section id="sectionUserPathPrediction">
<nav>
	<form id="wikiForm">
		<label for="articleId"><?= wfMsg( 'userpathprediction-article' ); ?>:
			<select id="selectBy">
				<option value="byId"><?= wfMsg( 'userpathprediction-id' ); ?></option>
				<option value="byTitle"><?= wfMsg( 'userpathprediction-title' ); ?></option>
			</select>
			<span id="articlePlace"><input id="article" type="number" value="" /></span>
		</label>
		<label for="nodeCount"><?= wfMsg( 'userpathprediction-nodecount' ); ?>:
			<input id="nodeCount" type="number" value="10" />
		</label>
		<label for="dateSpan"><?= wfMsg( 'userpathprediction-last' ); ?>:
			<input id="dateSpan" type="number" value="30" />
		</label> <?= wfMsg( 'userpathprediction-days' ); ?>
	<button type="submit" onclick="return UserPathPrediction.load()"><?= wfMsg( 'userpathprediction-show' ); ?></button>
	</form>
</nav>
<div id="table" <?= ( $par != NULL )  ? "data-page=\"".$par."\"" : "" ?>>
	<table id="articleTable" class="tablesorter">
		<thead>
			<tr>
				<th><?= wfMsg( 'userpathprediction-from' ); ?>:</th>
				<th><?= wfMsg( 'userpathprediction-to' ); ?>:</th>
				<th><?= wfMsg( 'userpathprediction-clicks' ); ?>:</th>
			</tr>
		</thead>
		<tbody id="nodes">
		</tbody>
	</table>
</div>
<div id="noresult">No Result</div>
<canvas id="usersPath"></canvas>
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