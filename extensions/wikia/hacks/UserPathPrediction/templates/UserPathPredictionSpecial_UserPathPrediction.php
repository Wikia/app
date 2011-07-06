<header>
	<h1><?= $header ?></h1>
	<p>This is a demonstration of predeiction of users' paths.</p>
	<br>
</header>

<section id="sectionUserPathPrediction">
<nav>
	<form id="wikiForm">
		<label for="selectWiki">Select Wiki: 
		<select id="selectWiki">
			<? foreach ( $wikis as $wiki ) :?>
					<option value="<?= $wiki["db_name"] . '">' . $wiki["db_name"] ?></option>
			<? endforeach; ?>
		</select>
		</label>
		<label for="articleId">Article Id:
			<input id="articleId" type="number" />
		</label>
	<button type="submit" onclick="return UserPathPrediction.load()">Load</button>
	</form>
</nav>
<div id="table">
	<table id="articleTable" class="tablesorter">
		<thead>
			<tr>
				<th>A</th>
				<th>B</th>
				<th>C</th>
			</tr>
		</thead>
		<tbody>
		<? foreach ( $articles as $oneArticle ) :?>
			<tr>
				<td><?=$oneArticle["A"]["id"]. ": ". $oneArticle["A"]["text"];?></td>
				<td><?=$oneArticle["B"]["id"]. ": ". $oneArticle["B"]["text"];?></td>
				<td><?=$oneArticle["Count"]?></td>
			</tr>
		<? endforeach; ?>	
		</tbody>
	</table>
</div>
<canvas id="usersPath"></canvas>
</section>
<footer>
	Created by: 
		<ul>
			<li>
				<a href="mailto:bukaj.kelo@gmail.com">Jakub Olek</a>
			</li>
			<li>
				<a href="mailto:federico@wikia-inc.com">Federico "Lox" Lucignano</a>
			</li>
		</ul> 
</footer>