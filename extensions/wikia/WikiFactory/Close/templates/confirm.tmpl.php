<?php
	print_pre( $errors );
?>
Check wikis and confirm operation
<div>
	<form action="<?php echo $title->getFullUrl( "step=2") ?>" method="post">
	<table class="filehistory" style="width: 100%">
	<tr>
		<th>
			Name
		</th>
		<th>
			Lang
		</th>
		<th>
			Created
		</th>
<?php if( $action == CloseWikiPage::CLOSE_REDIRECT ): ?>
		<th>
			Redirect to
		</th>
<?php endif ?>
	</tr>
<?php foreach( $wikis as $wiki ): ?>
	<tr>
		<td>
			<ul>
				<li style="list-style:none;">
					<strong><?php echo $wiki->city_title ?> <?php echo $wiki->city_id ?></strong></em>
				</li>
				<li style="list-style:none;">
					<a href="<?php echo $wiki->city_url ?>"><em><?php echo $wiki->city_url ?></em></a>
				</li>
				<li style="list-style:none;">
					<?php echo $wiki->city_description ?>
				</li>
			</ul>
			<input type="hidden" name="wikis[ ]" value="<?php echo $wiki->city_id ?>" />
		</td>
		<td>
			<?php echo $wiki->city_lang ?>
		</td>
		<td>
			<?php echo $wiki->city_created ?>
		</td>
<?php if( $action == CloseWikiPage::CLOSE_REDIRECT ): ?>
		<td style="padding: 5px;">
			<div class="center <?php echo isset( $errors[ $wiki->city_id ] ) ? "error" : "" ?>">
				<input
					type="text"
					name="redirects[<?php echo $wiki->city_id ?>]"
					value="<?php echo isset( $redirects[ $wiki->city_id ] ) ? $redirects[ $wiki->city_id ] : "" ?>"
					maxlenght="64" size="32" />
				<br />
				<label><em>domain name <?php echo isset( $errors[ $wiki->city_id ] ) ? "is not valid" : "" ?></em></label>
			</div>
		</td>
<?php endif ?>
	</tr>
<?php endforeach ?>
	</table>
	<input type="hidden" name="action" value="<?php echo $action ?>" />
	<input type="submit" name="submit" value="Confirm <?php echo $actions[ $action ] ?> of <?php echo count( $wikis ) ?> wikis." />
	</form>
</div>
