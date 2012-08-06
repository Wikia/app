package com.wikia.selenium.tests;

import java.util.regex.*;
import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

public class AnswersTagsTest extends BaseTest {

	@Test(groups={"answers", "CI"})
	public void testStatsTag() throws Exception {
		login();
		String content = "<answers_stats/>";
		editArticle("Project:WikiaBotAutomatedTest", "*Tested: " + content
				+ " by [[wikia:user:" + getTestConfig().getString("ci.user.wikiabot.username") + "|" + getTestConfig().getString("ci.user.wikiabot.username") + "]]");
		assertTrue(session().isElementPresent("//div[@class='cathub-progbar-wrapper']"));
	}

	@Test( groups="answers" )
	public void testLeaderboardAllTag() throws Exception {
		login();
		String content = "<answers_leaderboard_all_time/>";
		editArticle("Project:WikiaBotAutomatedTest", "*Tested: " + content
				+ " by [[wikia:user:" + getTestConfig().getString("ci.user.wikiabot.username") + "|" + getTestConfig().getString("ci.user.wikiabot.username") + "]]");
		assertTrue(session().isElementPresent("//div[@class='tagTopContribsAllTime']"));
	}

	@Test(groups={"answers", "CI"})
	public void testLeaderboard7Tag() throws Exception {
		login();
		String content = "<answers_leaderboard_last_7_days/>";
		editArticle("Project:WikiaBotAutomatedTest", "*Tested: " + content
				+ " by [[wikia:user:" + getTestConfig().getString("ci.user.wikiabot.username") + "|" + getTestConfig().getString("ci.user.wikiabot.username") + "]]");
		assertTrue(session().isElementPresent("//div[@class='tagTopContribsRecent']"));
	}

	@Test(groups={"answers", "CI"})
	public void testTabsTag() throws Exception {
		login();
		String content = "<answers_tabs/>";
		editArticle("Project:WikiaBotAutomatedTest", "*Tested: " + content
				+ " by [[wikia:user:" + getTestConfig().getString("ci.user.wikiabot.username") + "|" + getTestConfig().getString("ci.user.wikiabot.username") + "]]");
		assertTrue(session().isElementPresent("tag-tabs"));
	}

	@Test(groups={"answers", "CI"})
	public void testSubcategoriesTag() throws Exception {
		login();
		String content = "<answers_subcategories/>";
		editArticle("Project:WikiaBotAutomatedTest", "*Tested: " + content
				+ " by [[wikia:user:" + getTestConfig().getString("ci.user.wikiabot.username") + "|" + getTestConfig().getString("ci.user.wikiabot.username") + "]]");
		assertTrue(session().isElementPresent("//div[@class='tags-hub-subcategories']"));
	}
}
