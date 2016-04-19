<table width="100%" style="font: 18px normal Helvetica, Arial;" cellpadding="10">
	<tr>
		<td>
		<table align="center" bgcolor="ffffff" cellpadding="0" cellspacing="0"
			width="570" style="border: 2px solid #2c85d7">
			<tr>
				<td bgcolor="88c440" height="5" colspan="3" style="font-size: 1px"></td>
			</tr>
			<tr>
				<td bgcolor="88c440" width="5" style="font-size: 1px"></td>
				<td>
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td><!-- content start -->
						<table cellpadding="0" cellspacing="0" align="right">
							<tr>
								<td colspan="2" height="20">&nbsp;</td>
							</tr>
							<tr>
								<td><img alt="Wikia"
									src="http://images3.wikia.nocookie.net/wikianewsletter/images/2/28/Wikialogo.png">
								</td>
								<td width="30">&nbsp;</td>
							</tr>
						</table>
						
						<table cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td colspan="3" height="10" style="font-size: 1px">&nbsp;</td>
							</tr>
							<tr>
								<td width="17">&nbsp;</td>
								<td>
								<table cellpadding="7" cellspacing="0" width="100%">
									<tr>
										<td style="color: #2c85d5; font-size: 20px; font-weight: bold">
											<?php echo wfMsgForContent($data['$MSG_KEY_GREETING'], [ '$1' => $data['$WATCHER'] ] ); ?>
										</td>
									</tr>
									<tr>
										<td style="color: #3a3a3a; font-size: 14px;line-height: 22px;">
											<?php echo $data['$SUBJECT']; ?>
										</td>
									</tr>
									<tr>
										<td style="color: #2c85d5; font-size: 20px; font-weight: bold">
											<?php echo $data['$METATITLE']; ?>
										</td>
									</tr>
									<tr>
										<td style="color: #3a3a3a; font-size: 14px;line-height: 22px;">
											<?php echo $data['$MESSAGE_HTML']; ?>
										</td>
									</tr>
									<tr>
										<td style="color: #3a3a3a; font-size: 14px; line-height: 20px">
											-- <?= $data['$AUTHOR_SIGNATURE']; ?>
										</td>
									</tr>
									
									<tr>
										<td><a href="<?php echo $data['$MESSAGE_LINK']; ?>" style="text-decoration: none">
										<table style="background-color: #2C85D5;" cellpadding="0" cellspacing="0" height="39">
											<tr valign="middle" align="center">
												<td height="39" width="5"
													background="http://images4.wikia.nocookie.net/wikianewsletter/images/5/55/Ctaleft.png"></td>
												<td style="color: #fff; font-size: 14px; padding: 0 10px;"
													background="http://images2.wikia.nocookie.net/wikianewsletter/images/5/53/Ctacenter.png">
													<?php echo wfMsgForContent('mail-notification-html-button'); ?>
												</td>
												<td height="39" width="5"
													background="http://images3.wikia.nocookie.net/wikianewsletter/images/e/e4/Ctaright.png"></td>
											</tr>
										</table>
										</a></td>
									</tr>
								</table>
								</td>
								<td width="17">&nbsp;</td>
							</tr>
						</table>
						
						<!-- content end -->
						<table cellpadding="0" cellspacing="0" width="100%"
							style="background: #f6f6f6">
							<tr>
								<td height="18">&nbsp;</td>
							</tr>
							<tr>
								<td align="center"
									style="font-size: 11px; color: #3a3a3a; line-height: 16px"><?= wfMsgForContent('mail-notification-html-footer-line1') ?>
								<br>
								<?= wfMsgForContent('mail-notification-html-footer-line2') ?></td>
							</tr>
							<tr>
								<td align="center" valign="middle" height="50"><?= wfMsgForContent('mail-notification-html-footer-line3') ?>
								</td>
							</tr>
						</table>
						
						</td>
					</tr>
				</table>
				</td>
				<td bgcolor="88c440" width="5" style="font-size: 1px">&nbsp;</td>
			</tr>
			<tr>
				<td bgcolor="88c440" height="5" colspan="3" style="font-size: 1px">&nbsp;</td>
			</tr>
		</table>
		
		</td>
	</tr>
</table>