package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import com.thoughtworks.selenium.Wait;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;

public class ListUsersAjaxTest extends BaseTest {

	@Test(groups={"CI"})
	public void testListUsersAjax() throws Exception {
		session().open("index.php?title=Special:ListUsers&group=bot");
		session().waitForPageToLoad(TIMEOUT);
		session().type("lu_search", getTestConfig().getString("ci.user.wikiabot.username"));
		session().select("lu_contributed", "label=all users");
		session().click("lu-showusers");
		new Wait("Couldn't find " + getTestConfig().getString("ci.user.wikiabot.username")) {
			@Override
			public boolean until() {
				return session()
						.getTable("lu-table.1.0")
						.equals("WikiaBot\n(Talk) · (Contribs) · (Edit stats)");
			}
		};
	}
}
