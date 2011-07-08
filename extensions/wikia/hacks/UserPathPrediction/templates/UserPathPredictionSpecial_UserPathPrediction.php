<header>
	<h1><?= $header ?></h1>
	<p>This is a demonstration of prediction of users' paths.</p>
	<br>
</header>

<section id="sectionUserPathPrediction">
<nav>
	<form id="wikiForm">
		<label for="articleId">Article:
			<select id="selectBy">
				<option value="byId">ID</option>
				<option value="byTitle">Title</option>
			</select>
			<span id="articlePlace"><input id="article" type="number" value="202575" /></span>
		</label>
		<label for="nodeCount">Node count:
			<input id="nodeCount" type="number" value="10" />
		</label>
		<label for="dateSpan">Last:
			<input id="dateSpan" type="number" value="30" />
		</label> days
	<button type="submit" onclick="return UserPathPrediction.load()">Load</button>
	</form>
</nav>
<div id="table">
	<table id="articleTable" class="tablesorter">
		<thead>
			<tr>
				<th>From:</th>
				<th>To:</th>
				<th>Clicks:</th>
			</tr>
		</thead>
		<tbody id="nodes">
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