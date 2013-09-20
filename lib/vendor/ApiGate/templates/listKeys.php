<div class='sub_module'>
	<h3></h3>

	<?php
	if( count( $keyData ) > 0 ){
		?><table class='apiKeys'>
			<tr>
				<th><?= i18n( 'apigate-listkeys-th-keyname' ) ?></th>
				<th><?= i18n( 'apigate-listkeys-th-apikey' ) ?></th>
				<th><?= i18n( 'apigate-listkeys-th-username' ) ?></th>
				<th><?= i18n( 'apigate-listkeys-th-disabled' ) ?></th>
			</tr>
		<?php
		global $APIGATE_LINK_ROOT;
		foreach($keyData as $key){
			$apiKey = $key['apiKey'];
			$nickName = $key['nickName'];
			$enabled = $key['enabled'];
			$userName = $key['userName'];

			if($nickName == $apiKey){
				$nickName = ""; // so that explicitly-set nicknames stick out.
			}

			$rowClass = ($enabled ? "" : " class='disabled'");
			?><tr<?= $rowClass ?>>
				<td><a href='<?= $APIGATE_LINK_ROOT."/key?apiKey=$apiKey" ?>'><?= $nickName ?></a></td>
				<td><a href='<?= $APIGATE_LINK_ROOT."/key?apiKey=$apiKey" ?>'><?= $apiKey ?></a></td>
				<td><?= $userName ?></td>
				<td><?= ($enabled ? "" : "<a href='$APIGATE_LINK_ROOT/key?apiKey=$apiKey'>DISABLED</a>") ?></a></td>
			</tr><?php
		}
		?></table><?php

		// TODO: Pagination links.
		// TODO: Pagination links.
	} else {

		// TODO: No keys yet message.
		// TODO: No keys yet message.

	}
?>
</div>
