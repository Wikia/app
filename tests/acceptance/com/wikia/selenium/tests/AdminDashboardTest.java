package com.wikia.selenium.tests;

import org.testng.annotations.Test;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

public class AdminDashboardTest extends BaseTest {

	@Test(groups={"CI"})
	public void testAdminDashboardPage() throws Exception {

		loginAsSysop();

		session().open("/wiki/Special:AdminDashboard");
		session().waitForPageToLoad(this.getTimeout());

		// basic structure
		assertTrue(session().isVisible("//*[@id='WikiaArticle']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardRail']"));
		assertFalse(session().isVisible("//*[@id='FounderProgressList']"));
		assertTrue(session().isElementPresent("//*[@id=\"AdminDashboardHeader\"]"));

		// control center - basic structure
		assertTrue(session().getText("//*[@id=\"AdminDashboardHeader\"]/h1").matches("[\\s\\S]*Admin Dashboard$"));
		assertEquals(session().getText("css=section.control-section.wiki > header"), "Wiki");
		assertEquals(session().getText("css=section.control-section.community > header"), "Community");
		assertEquals(session().getText("css=section.control-section.content > header"), "Content");

		// progress bar - basic structure
		assertTrue(session().isElementPresent("//*[@id=\"FounderProgressWidget\"]"));
		assertTrue(session().getText("css=#FounderProgressWidget > h1").matches("[\\s\\S]*'s Progress$"));
		assertEquals(session().getText("css=section.preview > header > h1"), "Accomplished tasks");
		assertEquals(session().getText("css=span.see-full-list"), "See full list");

		assertTrue(session().isVisible("css=ul.activities > li.activity.active > div.label"));
		assertTrue(session().isVisible("css=ul.activities > li.activity.active > div.description"));
		assertTrue(session().isVisible("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[1]/div"));
		assertTrue(session().isVisible("//section[@id='FounderProgressWidget']/section/ul/li[2]/div[1]/div"));

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
		assertTrue(session().isVisible("//*[@id='WikiaArticle']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardRail']"));
		assertFalse(session().isVisible("//*[@id='FounderProgressList']"));
		assertTrue(session().isElementPresent("//*[@id=\"AdminDashboardHeader\"]"));
		session().click("css=span.see-full-list");
		assertFalse(session().isVisible("//*[@id='WikiaArticle']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardRail']"));
		assertTrue(session().isVisible("//*[@id='FounderProgressList']"));
		assertTrue(session().isElementPresent("//*[@id=\"AdminDashboardHeader\"]"));

		// control center (show full list)
		assertEquals(session().getText("link=Back to Dashboard"), "Back to Dashboard");
		assertTrue(session().getText("css=#FounderProgressList > header > h1").matches("[\\s\\S]*'s Tasks$"));
		assertEquals(session().getText("//section[@id='FounderProgressList']/ul/li[1]/div"), "Tasks");
		assertTrue(session().getText("//section[@id='FounderProgressList']/ul/li[2]/div").matches("^Skipped Tasks [\\s\\S]*$"));
		assertTrue(session().getText("//section[@id='FounderProgressList']/ul/li[3]/div").matches("^Bonus Tasks [\\s\\S]*$"));
		assertTrue(session().isVisible("css=section.FounderProgressList > ul.tasks > li.task > div.task-group"));
		assertFalse(session().isVisible("css=section.FounderProgressList > ul.tasks > li.task.skipped > div.task-group"));
		assertFalse(session().isVisible("css=section.FounderProgressList > ul.tasks > li.task.bonus > div.task-group"));

		// control center (show full list) - toggle task group
		session().click("css=li.task > div.task-label");
		assertFalse(session().isVisible("css=section.FounderProgressList > ul.tasks > li.task > div.task-group"));
		session().click("css=li.task.skipped > div.task-label");
		assertTrue(session().isVisible("css=section.FounderProgressList > ul.tasks > li.task.skipped > div.task-group"));
		session().click("css=li.task.bonus > div.task-label");
		assertTrue(session().isVisible("css=section.FounderProgressList > ul.tasks > li.task.bonus > div.task-group"));

		// progress bar - skip task
		assertEquals(session().getText("link=Skip for now"), "Skip for now");
		String skippedTask = session().getText("//section[@id='FounderProgressList']/ul/li[1]/div[2]/ul[1]/li[2]/div[1]");
		String newTask = session().getText("//section[@id='FounderProgressList']/ul/li[1]/div[2]/ul[1]/li[3]/div[1]");
		System.out.println("Skipped Task: "+skippedTask);
		System.out.println("New Task: "+newTask);

		session().click("css=li.task.skipped > div.task-label");
		assertFalse(session().isVisible("css=section.FounderProgressList > ul.tasks > li.task.skipped > div.task-group"));
		assertFalse(session().isElementPresent("//section[@id='FounderProgressList']/ul/li[2]/div[2]/ul/li/div[1]"));
		assertEquals(session().getText("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[1]/div"), skippedTask);

		session().click("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[2]/div/a[1]");
		assertTrue(session().isVisible("css=section.FounderProgressList > ul.tasks > li.task.skipped > div.task-group"));
		assertTrue(session().isElementPresent("//section[@id='FounderProgressList']/ul/li[2]/div[2]/ul/li/div[1]"));
		assertEquals(session().getText("//section[@id='FounderProgressList']/ul/li[2]/div[2]/ul/li/div[1]"), skippedTask);
		assertEquals(session().getText("//section[@id='FounderProgressList']/ul/li[1]/div[2]/ul[1]/li[2]/div[1]"), newTask);
		assertEquals(session().getText("//section[@id='FounderProgressWidget']/section/ul/li[1]/div[1]/div"), newTask);

		// control center - back to dashboard link
		session().click("link=Back to Dashboard");
		assertTrue(session().isVisible("//*[@id='WikiaArticle']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardRail']"));
		assertFalse(session().isVisible("//*[@id='FounderProgressList']"));
		assertTrue(session().isElementPresent("//*[@id=\"AdminDashboardHeader\"]"));

		// control center - show/hide tooltip
		assertFalse(session().getText("//*[@id='AdminDashboardGeneral']/section/header/span").matches("^[\\s\\S][\\s\\S]*$"));
		session().mouseOver("//*[@id='AdminDashboardGeneral']/section/ul/li[2]/a");
		assertTrue(session().getText("//*[@id='AdminDashboardGeneral']/section/header/span").matches("^[\\s\\S][\\s\\S]*$"));

		// unset skipped task (task_id=20 -> Customize your theme)
		session().open("/wikia.php?controller=FounderProgressBar&method=SkipTask&task_id=20&task_skipped=0&format=raw");
		session().waitForPageToLoad(this.getTimeout());
	}

}
