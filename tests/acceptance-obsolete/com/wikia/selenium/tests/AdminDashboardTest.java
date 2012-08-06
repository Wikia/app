package com.wikia.selenium.tests;

import org.testng.annotations.Test;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

public class AdminDashboardTest extends BaseTest {

	@Test(groups={"CI"})
	public void testAdminDashboardPage() throws Exception {

		loginAsSysop();

		// reset all skipped tasks
		for (int i = 10; i <= 300; i=i+10) {
			session().open("/wikia.php?controller=FounderProgressBar&method=SkipTask&task_id="+i+"&task_skipped=0&format=raw");
		}

		session().open("/wiki/Special:AdminDashboard");
		session().waitForPageToLoad(this.getTimeout());

		// basic structure
		assertTrue(session().isVisible("//*[@id='WikiHeader']"));
		assertTrue(session().isVisible("link=Random Page"));
		assertTrue(session().isVisible("link=Wiki Activity"));
		assertTrue(session().isVisible("//form[@id='WikiaSearch']/input"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardHeader']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardTabs']"));
		assertTrue(session().isVisible("//*[@id='WikiaArticle']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardRail']"));
		assertFalse(session().isVisible("//*[@id='FounderProgressList']"));

		// control center - basic structure
		assertTrue(session().isVisible("//section[@id='AdminDashboard']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardGeneral']"));
		assertFalse(session().isVisible("//*[@id='AdminDashboardAdvanced']"));
		assertFalse(session().isVisible("//*[@id='AdminDashboardContentArea']"));
		assertTrue(session().getText("//*[@id='AdminDashboardHeader']/h1").matches("[\\s\\S]*Admin Dashboard$"));
		assertEquals(session().getText("css=section.control-section.wiki > header"), "Wiki");
		assertEquals(session().getText("css=section.control-section.community > header"), "Community");
		assertEquals(session().getText("css=section.control-section.content > header"), "Content");

		// control center - toggle tab
		assertTrue(session().isVisible("link=Advanced"));
		assertEquals(session().getText("link=Advanced"), "Advanced");
		assertTrue(session().isVisible("link=General"));
		assertEquals(session().getText("link=General"), "General");
		assertFalse(session().isVisible("link=Back to Dashboard"));

		session().click("link=Advanced");
		assertFalse(session().isVisible("//*[@id='AdminDashboardGeneral']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardAdvanced']"));
		assertFalse(session().isVisible("//*[@id='AdminDashboardContentArea']"));
		assertFalse(session().isVisible("link=Back to Dashboard"));

		session().click("link=General");
		assertTrue(session().isVisible("//*[@id='AdminDashboardGeneral']"));
		assertFalse(session().isVisible("//*[@id='AdminDashboardAdvanced']"));
		assertFalse(session().isVisible("//*[@id='AdminDashboardContentArea']"));
		assertFalse(session().isVisible("link=Back to Dashboard"));

		// progress bar - basic structure
		assertTrue(session().isElementPresent("//section[@id='FounderProgressWidget']"));
		assertTrue(session().getText("css=#FounderProgressWidget > h1").matches("[\\s\\S]*'s Progress$"));
		assertEquals(session().getText("css=section.preview > header > h1"), "Accomplished tasks");
		assertEquals(session().getText("css=span.see-full-list"), "See full list");

		assertTrue(session().isVisible("css=ul.activities > li.activity.active > div.label"));
		assertTrue(session().isVisible("css=ul.activities > li.activity.active > div.description"));
		assertTrue(session().isVisible("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[1]/div"));
		assertTrue(session().isVisible("//section[@id='FounderProgressWidget']/section/ul/li[2]/div[1]/div"));

		assertTrue(session().isVisible("//section[@id='QuickStatsWidget']"));
		assertTrue(session().getText("css=#QuickStatsWidget > h1").matches("Quick Stats"));
		assertEquals(session().getText("link=See more stats"), "See more stats");

		// progress bar - toggle Task
		assertTrue(session().isVisible("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[2]"));
		assertFalse(session().isVisible("//section[@id='FounderProgressWidget']/section/ul/li[2]/div[2]"));

		session().click("//section[@id='FounderProgressWidget']/section/ul/li[2]/div[1]/div");
		assertFalse(session().isVisible("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[2]"));
		assertTrue(session().isVisible("//section[@id='FounderProgressWidget']/section/ul/li[2]/div[2]"));

		session().click("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[1]/div");
		assertTrue(session().isVisible("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[2]"));
		assertFalse(session().isVisible("//section[@id='FounderProgressWidget']/section/ul/li[2]/div[2]"));

		// progress bar - toggle see-full-list and hide-full-list
		session().click("css=span.see-full-list");
		session().click("css=span.hide-full-list");
		assertTrue(session().isVisible("link=Random Page"));
		assertTrue(session().isVisible("link=Wiki Activity"));
		assertTrue(session().isVisible("//form[@id='WikiaSearch']/input"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardHeader']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardTabs']"));
		assertTrue(session().isVisible("//*[@id='WikiaArticle']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardRail']"));
		assertFalse(session().isVisible("//*[@id='FounderProgressList']"));
		assertFalse(session().isVisible("link=Back to Dashboard"));

		session().click("css=span.see-full-list");
		assertTrue(session().isVisible("link=Random Page"));
		assertTrue(session().isVisible("link=Wiki Activity"));
		assertTrue(session().isVisible("//form[@id='WikiaSearch']/input"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardHeader']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardTabs']"));
		assertFalse(session().isVisible("//*[@id='WikiaArticle']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardRail']"));
		assertTrue(session().isVisible("//*[@id='FounderProgressList']"));
		assertTrue(session().isVisible("link=Back to Dashboard"));

		// control center (show full list)
		assertEquals(session().getText("link=Back to Dashboard"), "Back to Dashboard");
		assertTrue(session().getText("css=#FounderProgressList > header > h1").matches("[\\s\\S]*'s Tasks$"));
		assertEquals(session().getText("//section[@id='FounderProgressList']/ul/li[1]/div"), "Tasks");
		assertTrue(session().getText("//section[@id='FounderProgressList']/ul/li[2]/div").matches("^Skipped Tasks [\\s\\S]*$"));
		assertTrue(session().getText("//section[@id='FounderProgressList']/ul/li[3]/div").matches("^Bonus Tasks [\\s\\S]*$"));
		assertTrue(session().isVisible("//section[@id='FounderProgressList']/ul/li[1]/div[2]"));
		assertFalse(session().isVisible("//section[@id='FounderProgressList']/ul/li[2]/div[2]"));
		assertFalse(session().isVisible("//section[@id='FounderProgressList']/ul/li[3]/div[2]"));

		// control center (show full list) - toggle task group
		session().click("//section[@id='FounderProgressList']/ul/li[1]/div[1]");
		assertFalse(session().isVisible("//section[@id='FounderProgressList']/ul/li[1]/div[2]"));

		session().click("//section[@id='FounderProgressList']/ul/li[2]/div[1]");
		assertTrue(session().isVisible("//section[@id='FounderProgressList']/ul/li[2]/div[2]"));

		session().click("//section[@id='FounderProgressList']/ul/li[3]/div[1]");
		assertTrue(session().isVisible("//section[@id='FounderProgressList']/ul/li[3]/div[2]"));

		// progress bar - skip task
		assertEquals(session().getText("link=Skip for now"), "Skip for now");
		String skippedTask = session().getText("//section[@id='FounderProgressList']/ul/li[1]/div[2]/ul[1]/li[2]/div[1]");
		String newTask = session().getText("//section[@id='FounderProgressList']/ul/li[1]/div[2]/ul[1]/li[3]/div[1]");
		System.out.println("Skipped Task: "+skippedTask);
		System.out.println("New Task: "+newTask);

		session().click("//section[@id='FounderProgressList']/ul/li[2]/div[1]");
		assertFalse(session().isVisible("//section[@id='FounderProgressList']/ul/li[2]/div[2]"));
		assertFalse(session().isElementPresent("//section[@id='FounderProgressList']/ul/li[2]/div[2]/ul/li/div[1]"));
		assertEquals(session().getText("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[1]/div"), skippedTask);

		session().click("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[2]/div/a[1]");
		assertTrue(session().isVisible("//section[@id='FounderProgressList']/ul/li[2]/div[2]"));
		assertTrue(session().isElementPresent("//section[@id='FounderProgressList']/ul/li[2]/div[2]/ul/li/div[1]"));
		assertFalse(session().getText("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[1]/div").equals(skippedTask));

		assertEquals(session().getText("//section[@id='FounderProgressList']/ul/li[2]/div[2]/ul/li/div[1]"), skippedTask);
		assertEquals(session().getText("//section[@id='FounderProgressList']/ul/li[1]/div[2]/ul[1]/li[2]/div[1]"), newTask);

		// control center - back to dashboard link
		session().click("link=Back to Dashboard");
		assertTrue(session().isVisible("link=Random Page"));
		assertTrue(session().isVisible("link=Wiki Activity"));
		assertTrue(session().isVisible("//form[@id='WikiaSearch']/input"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardHeader']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardTabs']"));
		assertTrue(session().isVisible("//*[@id='WikiaArticle']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardRail']"));
		assertFalse(session().isVisible("//*[@id='FounderProgressList']"));

		// control center - show/hide tooltip
		assertFalse(session().getText("//*[@id='AdminDashboardGeneral']/section/header/span").matches("^[\\s\\S][\\s\\S]*$"));
		session().mouseOver("//*[@id='AdminDashboardGeneral']/section/ul/li[2]/a");
		assertTrue(session().getText("//*[@id='AdminDashboardGeneral']/section/header/span").matches("^[\\s\\S][\\s\\S]*$"));

		// control center - special page from general tab & Admin Dashboard Header
		session().click("link=General");
		assertTrue(session().isVisible("//*[@id='AdminDashboardGeneral']"));
		assertFalse(session().isVisible("//*[@id='AdminDashboardAdvanced']"));

		session().click("css=span.icon.userrights");
		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().isVisible("link=Random Page"));
		assertTrue(session().isVisible("link=Wiki Activity"));
		assertTrue(session().isVisible("//form[@id='WikiaSearch']/input"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardHeader']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardTabs']"));
		assertTrue(session().isVisible("//*[@id='WikiaArticle']"));
		assertFalse(session().isElementPresent("//*[@id='AdminDashboardRail']"));
		assertFalse(session().isElementPresent("//*[@id='FounderProgressList']"));
		assertFalse(session().isElementPresent("//*[@id='AdminDashboardGeneral']"));
		assertFalse(session().isElementPresent("//*[@id='AdminDashboardAdvanced']"));

		session().click("link=Admin Dashboard");
		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().isVisible("link=Random Page"));
		assertTrue(session().isVisible("link=Wiki Activity"));
		assertTrue(session().isVisible("//form[@id='WikiaSearch']/input"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardHeader']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardTabs']"));
		assertTrue(session().isVisible("//*[@id='WikiaArticle']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardRail']"));
		assertFalse(session().isVisible("//*[@id='FounderProgressList']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardGeneral']"));
		assertFalse(session().isVisible("//*[@id='AdminDashboardAdvanced']"));

		// control center - special page from advanced tab & Admin Dashboard Header
		session().click("link=Advanced");
		assertFalse(session().isVisible("//*[@id='AdminDashboardGeneral']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardAdvanced']"));

		session().click("link=All pages");
		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().isVisible("link=Random Page"));
		assertTrue(session().isVisible("link=Wiki Activity"));
		assertTrue(session().isVisible("//form[@id='WikiaSearch']/input"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardHeader']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardTabs']"));
		assertTrue(session().isVisible("//*[@id='WikiaArticle']"));
		assertFalse(session().isElementPresent("//*[@id='AdminDashboardRail']"));
		assertFalse(session().isElementPresent("//*[@id='FounderProgressList']"));
		assertFalse(session().isElementPresent("//*[@id='AdminDashboardGeneral']"));
		assertFalse(session().isElementPresent("//*[@id='AdminDashboardAdvanced']"));

		session().click("link=Admin Dashboard");
		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().isVisible("link=Random Page"));
		assertTrue(session().isVisible("link=Wiki Activity"));
		assertTrue(session().isVisible("//form[@id='WikiaSearch']/input"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardHeader']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardTabs']"));
		assertTrue(session().isVisible("//*[@id='WikiaArticle']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardRail']"));
		assertFalse(session().isVisible("//*[@id='FounderProgressList']"));	
		assertFalse(session().isVisible("//*[@id='AdminDashboardGeneral']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardAdvanced']"));
	}

}
