<div id="Feedback" class="Feedback noprint">
	<!--Start Kampyle Feedback Form Button-->
	<div id='k_close_button' class='k_float kc_top_sl kc_left'></div>
	<div>
		<a href='http://www.kampyle.com/feedback_form/ff-feedback-form.php?site_code=<?= $siteCode ?>&amp;lang=en&amp;form_id=55403'  target='kampyleWindow' id='kampylink' class='k_float k_top_sl k_left' onclick="javascript:k_button.open_ff('site_code=<?= $siteCode ?>&amp;lang=en&amp;form_id=55403');return false;"><img src="http://cf.kampyle.com/buttons/en/green/en-green-corner-up-left.gif" alt="Feedback Form" border="0"/></a>
	</div>

	<div id='k_slogan' class='k_float k_top k_left'>
		<a href='http://www.kampyle.com/' target='_blank'>Feedback</a> Analytics
	</div>

	<script src="http://cf.kampyle.com/k_button.js" type="text/javascript"></script>
	<script src="http://cf.kampyle.com/k_push.js" type="text/javascript"></script>
	<script type="text/javascript">k_button.extra_params = <?= Wikia::json_encode($userData) ?>;</script>
	<!--End Kampyle Feedback Form Button-->
</div>