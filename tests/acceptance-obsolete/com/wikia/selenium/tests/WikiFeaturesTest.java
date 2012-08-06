package com.wikia.selenium.tests;

import org.testng.annotations.Test;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

public class WikiFeaturesTest extends BaseTest {

	@Test(groups={"CI", "legacy"})
	public void testWikiFeaturesPage() throws Exception {

		// not login
		logout();
		session().open("/wiki/Special:WikiFeatures");
		session().waitForPageToLoad(this.getTimeout());
		assertEquals(session().getText("css=#WikiaPageHeader > h1"), "Permission error");

		// login as regular user
		loginAsRegular();
		session().open("/wiki/Special:WikiFeatures");
		session().waitForPageToLoad(this.getTimeout());

		assertEquals(session().getText("//*[@id='WikiFeatures']/h2[1]"), "Features");
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/p[1]"));
		assertEquals(session().getText("//*[@id='WikiFeatures']/h2[2]"), "Labs");
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/p[2]"));

		assertFalse(session().isElementPresent("//section[@id='WikiFeatures']/ul[@class='features']/li[@class='feature']/div[@class='actions']/span[contains(@class,'slider')]"));

		assertTrue(session().getText("//section[@id='WikiFeatures']/ul[2]/li[@class='feature']/div[@class='actions']/div[@class='active-on']").matches("Active on[\\s\\S]*wikis$"));
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/ul[2]/li[@class='feature']/div[@class='actions']/button[@class='secondary feedback']"));
		assertEquals(session().getText("//section[@id='WikiFeatures']/ul[2]/li[@class='feature']/div[@class='actions']/button[@class='secondary feedback']"), "Give Feedback");

		session().click("css=button.secondary.feedback");
		assertEquals(session().getText("css=#FeedbackDialogWrapper > h1"), "Feedback");
		session().click("css=button.close.wikia-chiclet-button");

		logout();

		// login as sysop
		loginAsSysop();

		session().open("/wiki/Special:WikiFeatures");
		session().waitForPageToLoad(this.getTimeout());

		// basic structure
		assertTrue(session().isVisible("//*[@id='WikiHeader']"));
		assertTrue(session().isVisible("link=Random Page"));
		assertTrue(session().isVisible("link=Wiki Activity"));
		assertTrue(session().isVisible("//form[@id='WikiaSearch']/input"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardHeader']"));
		assertTrue(session().isVisible("//*[@id='AdminDashboardTabs']"));
		assertTrue(session().isVisible("//*[@id='WikiaArticle']"));

		// structure - AdminDashboardTabs
		assertTrue(session().isVisible("link=Advanced"));
		assertEquals(session().getText("link=Advanced"), "Advanced");
		assertTrue(session().isVisible("link=General"));
		assertEquals(session().getText("link=General"), "General");

		// structure - WikiFeatures
		assertTrue(session().isVisible("//*[@id='WikiFeatures']"));
		assertEquals(session().getText("link=Admin Dashboard"), "Admin Dashboard");
		assertEquals(session().getText("css=div.AdminDashboardGeneralHeader.AdminDashboardArticleHeader > h1"), "WikiFeatures");
		assertEquals(session().getText("//*[@id='WikiFeatures']/h2[1]"), "Features");
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/p[1]"));
		assertEquals(session().getText("//*[@id='WikiFeatures']/h2[2]"), "Labs");
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/p[2]"));
		assertTrue(session().isVisible("css=section#WikiFeatures > ul.features > li.feature img"));
		assertTrue(session().isVisible("css=section#WikiFeatures > ul.features > li.feature > div.details > h3"));
		assertTrue(session().isVisible("css=section#WikiFeatures > ul.features > li.feature > div.details > p"));
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/ul[@class='features']/li[@class='feature']/div[@class='actions']/span[contains(@class,'slider')]"));
		//assertEquals(session().getText("css=span.texton"), "Enabled");
		//assertEquals(session().getText("css=span.textoff"), "Disabled");
		assertEquals(session().getText("//section[@id='WikiFeatures']/ul[@class='features']/li[@class='feature']/div[@class='actions']/span[contains(@class,'slider')]/span[@class='texton']"), "Enabled");
		assertEquals(session().getText("//section[@id='WikiFeatures']/ul[@class='features']/li[@class='feature']/div[@class='actions']/span[contains(@class,'slider')]/span[@class='textoff']"), "Disabled");

		// Wikia Labs
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/ul[2]/li[@class='feature']//img"));
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/ul[2]/li[@class='feature']/div[@class='details']/h3"));
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/ul[2]/li[@class='feature']/div[@class='details']/p"));
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/ul[2]/li[@class='feature']/div[@class='actions']/span[contains(@class,'slider')]"));
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/ul[2]/li[@class='feature']/div[@class='actions']/div[@class='active-on']"));
		assertTrue(session().getText("//section[@id='WikiFeatures']/ul[2]/li[@class='feature']/div[@class='actions']/div[@class='active-on']").matches("Active on[\\s\\S]*wikis$"));
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/ul[2]/li[@class='feature']/div[@class='actions']/button[@class='secondary feedback']"));
		assertEquals(session().getText("//section[@id='WikiFeatures']/ul[2]/li[@class='feature']/div[@class='actions']/button[@class='secondary feedback']"), "Give Feedback");
		
		// Wikia Labs - feedback
		String featureName = session().getText("//section[@id='WikiFeatures']/ul[2]/li[@class='feature'][1]/div[@class='details']/h3");
		session().click("css=button.secondary.feedback");
		assertEquals(session().getText("css=#FeedbackDialogWrapper > h1"), "Feedback");
		assertEquals(session().getText("css=section.modalContent > #FeedbackDialog > div.feature-highlight > h2"), featureName);
		assertTrue(session().isVisible("css=section.modalContent > #FeedbackDialog > form > p"));
		assertTrue(session().isVisible("css=section.modalContent > #FeedbackDialog > div.feature-highlight > h2"));
		assertTrue(session().isVisible("css=section.modalContent > #FeedbackDialog > div.feature-highlight > img"));
		assertTrue(session().getText("css=section.modalContent > #FeedbackDialog > form > div.input-group > label").matches("^What's this about[\\s\\S]$"));
		assertTrue(session().isVisible("css=section.modalContent > #FeedbackDialog > form > div.input-group > select[name=feedback]"));
		assertEquals(session().getText("css=section.modalContent > #FeedbackDialog > form > div.comment-group > label"), "Leave us a comment:");
		assertTrue(session().isVisible("css=section.modalContent > #FeedbackDialog > form > div.comment-group > textarea[name=comment]"));
		assertTrue(session().isVisible("css=section.modalContent > #FeedbackDialog > form > input[type=submit]"));
		session().click("css=button.close.wikia-chiclet-button");

		// Wikia Labs - toggle feature
		assertEquals(session().getText("//section[@id='WikiFeatures']/ul[1]/li[1]/div/span/span"), "");
		assertEquals(session().getText("//section[@id='WikiFeatures']/ul[1]/li[1]/div/span/span[3]"), "Enabled");
		assertEquals(session().getText("//section[@id='WikiFeatures']/ul[1]/li[1]/div/span/span[2]"), "Disabled");

		Integer default_show = 3;	// default to enabled
		Integer default_hide = 2;	// default to disabled
		if (session().isVisible("//section[@id='WikiFeatures']/ul[1]/li[1]/div/span/span[2]")) {
			default_show = 2;
			default_hide = 3;
		}

		assertTrue(session().isVisible("//section[@id='WikiFeatures']/ul[1]/li[1]/div/span/span["+default_show+"]"));
		assertFalse(session().isVisible("//section[@id='WikiFeatures']/ul[1]/li[1]/div/span/span["+default_hide+"]"));
		session().click("//section[@id='WikiFeatures']/ul[1]/li[1]/div[@class='actions']/span[contains(@class,'slider')]/span[@class='button']");
		if (default_show == 3) {
			waitForElement("DeactivateDialogWrapper");
			session().click("//section[@id='DeactivateDialogWrapper']//button[@class='confirm']");
			waitForElementNotPresent("DeactivateDialogWrapper");
		}
		assertFalse(session().isVisible("//section[@id='WikiFeatures']/ul[1]/li[1]/div/span/span["+default_show+"]"));
		assertTrue(session().isVisible("//section[@id='WikiFeatures']/ul[1]/li[1]/div/span/span["+default_hide+"]"));
		session().click("//section[@id='WikiFeatures']/ul[1]/li[1]/div[@class='actions']/span[contains(@class,'slider')]/span[@class='button']");
		if (default_show == 2) {
			waitForElement("DeactivateDialogWrapper");
			session().click("//section[@id='DeactivateDialogWrapper']//button[@class='confirm']");
			waitForElementNotPresent("DeactivateDialogWrapper");
		}

		logout();
	}

}
