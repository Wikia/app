<?php

require_once dirname( __FILE__ ) . "../GlobalWatchlist.bot.php";

class GlobalWatchlistTest extends WikiaBaseTest {

	public function testBlogsSection() {
		$bot = new GlobalWatchlistBot(true, array(), array());
		$mail = $bot->composeMail(null, null, null); // TODO: mocks for user and changed data
		// TODO: asserts

	}
}
