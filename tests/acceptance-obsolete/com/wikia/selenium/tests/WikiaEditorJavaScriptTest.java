package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.closeSeleniumSession;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

/**
 * Prototype of crusecontrol and javascript unit testing, using browser as javascript environment
 */
public class WikiaEditorJavaScriptTest extends JavaScriptTest {
	@Test(groups={"CI", "JavaScript", "legacy"})
	public void testDummyTest() throws Exception {
		runJavaScriptTest("extensions/wikia/EditPageLayout/js/tests/WikiaEditorTest.js");
	}
}
