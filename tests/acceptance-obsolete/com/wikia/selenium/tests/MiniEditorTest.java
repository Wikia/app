package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertEquals;

/*
 * testEditing
 * testEditorLoading
 * 
 */

public class MiniEditorTest extends MiniEditorBaseTest {
	private static final String existingMessage = "<span style=\"font-weight: bold;\">This is an existing message</span>";
	
	
	protected void doTestEditorLoading() throws Exception {
		assetEditorLoads("//div[@id='New']");
		
		// load other editor
		assetEditorLoads("//div[@id='Reply']");
		
		// check if the previous editor was unloaded
		assertTrue(session().isVisible("//div[@id='New']/div[@class='editarea']/textarea"));			
		assertFalse(session().isVisible("//div[@id='New']/div[@class='toolbar']"));
		assertFalse(session().isVisible("//div[@id='New']/div[@class='buttons']"));		
	}

	protected void clickTheEditButton() throws Exception {
		waitForElementVisible("//div[@id='Edit']");
	
		// click the edit button
		session().getEval("window.$('#Edit').mouseover();");  // show the button
		session().getEval("window.$('#Edit').find('.buttons').find('button').mouseover();");  // initialize the button
		// click and wait for the editor to load
		session().click("//div[@id='Edit']/div[@class='buttons']/button");

		// wait for editor to load
		waitForElementVisible("//div[@id='Edit']/div[@class='toolbar']");
		// wait for editor to load
		if (minieditor) {
			assertTrue(session().isElementPresent("//div[@id='Edit']/div[@class='editarea']/div[contains(@class,'cke_skin_wikia')]"));
		} else {
			assertTrue(session().isVisible("//div[@id='Edit']/div[@class='editarea']/textarea"));
		}
	}
	
	@Test(groups={"CI"})
	public void testEditorLoading() throws Exception {
		loginAsStaff();
		enableVisualMode();
		openAndWait("/wiki/Special:MiniEditorDemo");
		
		doTestEditorLoading();
	}
		
	@Test(groups={"CI"})
	public void testLoadingWithoutRTE() throws Exception {
		loginAsStaff();
		disableVisualMode();
		try {
			openAndWait("/wiki/Special:MiniEditorDemo");

			doTestEditorLoading();
			
		} finally {
			try {
				enableVisualMode();
			} catch (Exception e) {
				// it's not the part of the test, so if something goes wrong here - just ignore it
			}
		}
	}
	
	@Test(groups={"CI"})
	public void testEditing() throws Exception {
		loginAsStaff();
		enableVisualMode();
		openAndWait("/wiki/Special:MiniEditorDemo");
		
		clickTheEditButton();
		
		// check if we're in the visual mode
		assertTrue(session().isElementPresent("//div[@id='Edit']//div[@class='cke_contents']/iframe"));
		assertTrue(session().getAttribute("//div[@id='Edit']/div[@class='toolbar']//span[contains(@class,'cke_button_ModeSource')]@class").indexOf("cke_off") != -1);
		assertTrue(session().getAttribute("//div[@id='Edit']/div[@class='toolbar']//span[contains(@class,'cke_button_ModeWysiwyg')]@class").indexOf("cke_disabled") != -1);
		
		// switch to source and check the text
		switchToSourceMode("//div[@id='Edit']");
		assertEquals(session().getValue("//div[@id='Edit']//div[@class='cke_contents']/textarea"), existingMessage);
		
		// type something in and check if it does not change while switching modes
		String newValue = ":::*1\n:::**2\n:::#* 3\n:::#*#4";
		this.miniEditorType("//div[@id='Edit']", newValue);
		switchToVisualMode("//div[@id='Edit']");
		switchToSourceMode("//div[@id='Edit']");
		assertEquals(session().getValue("//div[@id='Edit']//div[@class='cke_contents']/textarea"), newValue);
	}
		
	@Test(groups={"CI"})
	public void testEditingWithoutRTE() throws Exception {
		loginAsStaff();
		disableVisualMode();
		try {
			openAndWait("/wiki/Special:MiniEditorDemo");

			assertTrue(session().isVisible("//div[@id='Edit']/div[@class='editarea']/div[@class='body']"));
			assertFalse(session().isElementPresent("//div[@id='Edit']/div[@class='editarea']/textarea"));
			
			clickTheEditButton();

			assertFalse(session().isVisible("//div[@id='Edit']/div[@class='editarea']/div[contains(@class, 'body')]"));

			assertEquals(session().getValue("//div[@id='Edit']/div[@class='editarea']/textarea"),
					"<p>" + existingMessage + "</p>");
			
		} finally {
			try {
				enableVisualMode();
			} catch (Exception e) {
				// it's not the part of the test, so if something goes wrong here - just ignore it
			}
		}		
	}
	
}
