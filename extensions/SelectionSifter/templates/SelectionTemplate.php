<?php
if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

class SelectionTemplate extends QuickTemplate {
	public function execute() {
		$articles = $this->data['articles'];
		$name = $this->data['name'];
		$csv_link = $this->data['csv_link'];
?>

<div id="">
<?php if( count($articles) > 0 ) { ?>
<h3>Articles in Selection <?php echo htmlentities( $name ); ?></h3> <small><a href="<?php echo htmlentities( $csv_link ); ?>">Export CSV</a></small>
	<table>
	<tr>
		<th style="width:150px">Article</th>
		<th style="width:150px">Added on</th>
		<th style="width:75px">Revision</th>
		<th style="width:300px">Actions</th>
	</tr>	
	<?php foreach( $articles as $article ) { ?>
	<tr class="article-row" data-namespace="<?php echo htmlentities( $article['s_namespace'] ); ?>" data-article="<?php echo htmlentities( $article['s_article'] ); ?>">
	<td><a href="<?php echo $article['title']->getLinkURL(); ?>"><?php echo htmlentities( $article['s_article'] ); ?></a></td>
	<td><?php echo wfTimeStamp( TS_ISO_8601, $article['s_timestamp'] );	?></td>
	<td><?php if($article['s_revision'] != null) { ?>
		<a href="<?php echo htmlentities( $article['title']->getLinkUrl( array( 'oldid' => $article['s_revision'] ) ) ); ?>" class="revision-link"><?php echo htmlentities( $article['s_revision'] ); ?></a>
		<?php } ?>
	</td>
	<td>
		<div class="item-actions">
		<div class="revision-input" style="display:none">
			<input type="text" class="revision-id" placeholder="Enter revision id" value="<?php echo htmlentities( $article['s_revision'] ); ?>" />
			(<a href="#" class="revision-save">Save</a> | <a href="#" class="revision-cancel">Cancel</a>)
		</div>
		<a href="#" class="change-revision">Set Revision</a> |
		<a href="#" class="delete-article">Delete</a>
		</div>
	</td>
	</tr>
	<?php } ?>
	</table>
<?php } else { ?> 
<p>No such selection found</p>
<?php } ?>
</div>

		<script type="text/javascript">
		// Should this be a RL module?
		$(document).ready(function() {
			$(".change-revision").click(function() {
				var parent = $(this).parents(".article-row");
				var input_box = $(".revision-input", parent);
				input_box.fadeToggle();
				return false;
			});
			$(".revision-save").click(function() {
				var parent = $(this).parents(".article-row");
				var ns = parent.attr("data-namespace"),
					article = parent.attr("data-article");
				var input = $("input.revision-id", parent);
				var input_box = $(".revision-input", parent);
				var revlink = $(".revision-link", parent);

				var revid = input.val();

				$.post('', {
					action: 'setrevision',
					namespace: ns,
					article: article,
					revision: revid
				}, function(raw_data) {
					var data = $.parseJSON(raw_data)
					console.log(data);					
					input_box.fadeOut();
					revlink.hide();
					revlink.attr("href", data.revision_url).html(data.revision).fadeIn();
				});

				return false;
			});
			$(".delete-article").click(function() {
				var parent = $(this).parents(".article-row");
				var ns = parent.attr("data-namespace"),
					article = parent.attr("data-article");

				$.post('', {
					action: 'deletearticle',
					namespace: ns,
					article: article
				}, function() {
					parent.fadeOut();
				});

				return false;
			});

			$(".revision-cancel").click(function() {
				var parent = $(this).parents("div.item-actions");
				var input_box = parent.children(".revision-input");
				input_box.fadeOut();
			});
		});
		</script>

<?php
	} // execute()
} // class
