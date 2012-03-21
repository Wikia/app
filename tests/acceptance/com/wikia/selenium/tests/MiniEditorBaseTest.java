package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertEquals;

public class MiniEditorBaseTest extends BaseTest {
	private static final String TEST_ARTICLE_TITLE_PREFIX = "WikiaMiniEditorTest ";
	private static final String existingMessage = "<span style=\"font-weight: bold;\">This is an existing message</span>";
	protected boolean minieditor = true;
	
	protected void loadEditor(String parent, boolean meticulously) throws Exception {
		
		if (meticulously) {
			assertTrue(session().isElementPresent(parent + "//div[@class='editarea']/textarea"));
			assertFalse(session().isVisible(parent + "//div[@class='editarea']/div[@class='loading-indicator']"));
			assertFalse(session().isVisible(parent + "//div[@class='toolbar']"));
			assertFalse(session().isVisible(parent + "//div[@class='buttons']"));
			assertFalse(session().isVisible(parent + "//div[@class='editarea']/div[@class='loading-indicator']"));
		}

		session().click(parent + "//div[@class='editarea']/textarea");
		
		waitForMiniEditor(parent);
		
		if (meticulously) {
			if (minieditor) {
				assertTrue(session().isElementPresent(parent + "//div[@class='editarea']/div[contains(@class,'cke_skin_wikia')]"));
			}
			assertTrue(session().isVisible(parent + "//div[@class='buttons']"));
			assertFalse(session().isVisible(parent + "//div[@class='editarea']/div[@class='loading-indicator']"));
			if (minieditor) {
				assertFalse(session().isVisible(parent + "//div[@class='editarea']/textarea"));
			} else {
				assertTrue(session().isVisible(parent + "//div[@class='editarea']/textarea"));
			}
		}
	}
	
	protected void waitForMiniEditor(String parent)  throws Exception {
		waitForElement(parent + "//div[@class='toolbar']//span[contains(@class,'cke_buttons')]");
	}
	
	protected String getMiniEditorText(String parent) throws Exception {
		return session().getValue(parent + "//div[@class='cke_contents']/textarea");
	}
	
	protected void miniEditorType(String parent, String value) throws Exception {
		session().type(parent + "//div[@class='cke_contents']/textarea", value);		
	}
	
	protected void assetEditorLoads(String parent) throws Exception {
		loadEditor(parent, true);
	}
	
	
	protected void switchToSourceMode(String parent) throws Exception {
		session().click(parent + "//div[@class='toolbar']//span[contains(@class,'cke_button_ModeSource')]/a");
		waitForElement(parent + "//div[@class='cke_contents']/textarea");
		assertFalse(session().isElementPresent(parent + "//div[@class='cke_contents']/iframe"));
	}

	protected void switchToVisualMode(String parent) throws Exception {
		session().click(parent + "//div[@class='toolbar']//span[contains(@class,'cke_button_ModeWysiwyg')]/a");
		waitForElement(parent + "//div[@class='cke_contents']/iframe");
		assertFalse(session().isElementPresent(parent + "//div[@class='cke_contents']/textarea"));
	}


	protected void disableVisualMode() {
		session().open("/wiki/Special:Preferences");
		session().waitForPageToLoad(this.getTimeout());
		if (!session().getValue("//input[@id='mw-input-enablerichtext']").equals("off")) {
			session().uncheck("//input[@id='mw-input-enablerichtext']");
			session().click("//input[@id='prefcontrol']");
			session().waitForPageToLoad(this.getTimeout());		
		}
		this.minieditor = false;
	}
	
	protected void enableVisualMode() {
		session().open("/wiki/Special:Preferences");
		session().waitForPageToLoad(this.getTimeout());
		if (!session().getValue("//input[@id='mw-input-enablerichtext']").equals("on")) {
			session().check("//input[@id='mw-input-enablerichtext']");
			session().click("//input[@id='prefcontrol']");
			session().waitForPageToLoad(this.getTimeout());	
		}
		this.minieditor = true;
	}
	
}