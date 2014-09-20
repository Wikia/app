<!-- s:<?= __FILE__ ?> -->
<h2>
	Domain info &amp; setup
</h2>
<div id="wiki-factory-domains">
<?php
	if( !is_null( $info ) ):
		echo $info;
	endif;
?>

	<ul>
		<li>
			Domain in city_list is
			<strong>
				<a href="<?= $wiki->city_url ?>" target="_blank">
					<?php echo $wiki->city_url ?>
				</a>
			</strong>
		</li>
		<li>
			Wiki primary domain <strong>$wgServer</strong> is
			<?php
				$server = WikiFactory::getVarValueByName( "wgServer", $wiki->city_id );
				echo empty( $server )
					? "not set"
					: "set to <strong><a href=\"{$server}\" target=\"_blank\">{$server}</a></strong>";
			?>
			<div>
				Changing value of <strong>$wgServer</strong> will change domain in city_list as well!
			</div>
		</li>
		<!-- s:enabling/disabling/redirecting/protecting -->
		<li>
			<form action="<?php echo $title->getFullUrl() ?>" method="post">
				<input type="hidden" name="wpAction" value="status" />
				Change Wikia status to:
				<select name="wpWikiStatus">
				<?php
					foreach ( $statuses as $key => $value):
				?>
					<option value="<?php echo $key ?>" <?php echo ( $key == $wiki->city_public ) ? 'selected="selected"' : "" ?> ><?php echo $value?></option>
				<?php
					endforeach;
				?>
				</select>
				<input type="submit" name="wk-status-submit" value="Confirm change" />
			</form>
		</li>
		<li>
			<form action="<?php echo $title->getFullUrl() ?>" method="post">
				<input type="hidden" name="wpAction" value="protect" />
				<input type="checkbox" name="wpProtected" id="wp-protected" <?php echo $protected ? "checked" : "" ?> />
				<label for="wp-protected">Protect Site (never delete)</label>
				<input type="submit" name="wk-protect-submit" value="Confirm change" />
			</form>
		</li>
		<!-- e:enabling/disabling/redirecting -->
			<!-- s:configuring domains -->
			<li>
				Wiki Factory is configured for handling domains:
				<ol id="wk-domain-ol">
					<?php
					foreach( $domains as $key => $domain): ?>
					<li id="wk-domain-li-<?= $key ?>"><?= $domain ?>
						<a id="wk-domain-li-<?= $key ?>change" href="#" title="<?php echo wfMsg('wikifactory-domain-edit'); ?>">[change]</a>&nbsp;
						<a id="wk-domain-li-<?= $key ?>remove" href="#" title="<?php echo wfMsg('wikifactory-domain-remove'); ?>">[remove]</a>&nbsp;
						<a id="wk-domain-li-<?= $key ?>setmain" href="#" title="<?php echo wfMsg('wikifactory-domain-setmain'); ?>">[set main]</a>
						<script type="text/javascript">
						/*<![CDATA[*/
							$Factory.Domain.listEvents("<?= $domain?>", <?= $key ?>);
						/*]]>*/
						</script>
					</li>
					<?php endforeach ?>
				</ol>
				<div>
					<input type="text" size="24" maxlength="255" id="wk-domain-add" name="wk-domain-add" />
					<input type="button" id="wk-domain-add-submit" value="Add new domain" />
				</div>
			</li>
	</ul>
</div>
<!-- e:<?= __FILE__ ?> -->
