<!-- s:<?= __FILE__ ?> -->
<?=wfMsg('closewiki-check-and-confirm')?>
<div>
	<form action="<?php echo $title->getFullUrl( "step=2") ?>" method="post">
	<table class="filehistory" style="width: 100%">
	<tr>
		<th><?=wfMsg('allmessagesname')?></th>
		<th><?=wfMsg('wf_city_lang')?></th>
		<th><?=wfMsg('wf_city_created')?></th>
		<th><?=wfMsg('wf_city_founding_user')?></th>
<?php if( $action == CloseWikiPage::CLOSE_REDIRECT ): ?>
		<th><?=wfMsg('closewiki-redirect-to')?></th>
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
		<td>
			<ul>
				<li style="list-style:none;">
					<?php echo ( isset($wiki->city_founding_user) ) ? User::newFromId($wiki->city_founding_user)->getName() : wfMsg('closewiki-unknown') ?>
				</li>	
				<li style="list-style:none;">
					<?php echo $wiki->city_founding_email ?>
				</li>
			</ul>
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
				<label><em><?= wfMsg('closewiki-message', isset( $errors[ $wiki->city_id ] ) ? "is not valid" : "") ?></em></label>
			</div>
		</td>
<?php endif ?>
	</tr>
<?php endforeach ?>
	</table>
	<br />
	<input type="hidden" name="action" value="<?php echo $action ?>" />
	<input type="submit" name="submit" value="<?=wfMsg('closewiki-confirm-button', $actions[ $action ], wfMsg('closewiki-nbr-wiki', count( $wikis )) )?>" />
	</form>
</div>
<!-- e:<?= __FILE__ ?> -->
