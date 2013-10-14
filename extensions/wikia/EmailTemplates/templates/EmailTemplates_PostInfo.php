<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
	<tr>
		<td width="50px" valign="top" style="padding:0 10px">
			<?= $avatar_url ?>
		</td>
		<td valign="top" style="padding:0 10px">
			<h2 style="margin:0"><a style="color:#2c85d5; font-size:20px; line-height:20px; text-decoration:none" href="<?= $post_url ?>"><?= $post_title ?></a></h2>
			<span style="font-size:12px">
				<? $userLink = Xml::element('a', array('href' => htmlspecialchars($user_page_url), 'style' => 'text-decoration:none'), $username, false); ?>
				<?= wfMessage('blog-by', $date, $userLink )->plain() ?>
			</span>
		</td>
	</tr>
	</tbody>
</table>
