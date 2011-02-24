package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.closeSeleniumSession;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

import java.io.*;

/**
 * Prototype of crusecontrol and javascript unit testing, using browser as javascript environment
 */
public class JavaScriptTest extends BaseTest {
	protected String[] javascriptTests = new String[] {
		"extensions/wikia/JavascriptTestRunner/js/tests/DummyTest.js",
		"extensions/wikia/JavascriptTestRunner/js/tests/RTETest.js"
	};

	@Test(groups={"broken", "javascript"})
	public void testFoo() throws Exception {
		runJavaScriptTests();
	}
	
	public void runJavaScriptTests() throws Exception {
		boolean result = true;
		for (String testPath : javascriptTests) {
			closeSeleniumSession();
			startSession(this.seleniumHost, this.seleniumPort, this.browser, this.webSite, this.timeout, this.noCloseAfterFail);
			loginAsStaff();
			session().open("wiki/Special:JavascriptTestRunner?test="+testPath+"&autorun=1&output=mwarticle,selenium");
			session().waitForPageToLoad(this.getTimeout());
			session().waitForCondition("typeof window.jtr_xml != 'undefined';", this.getTimeout());

			String reportText = session().getEval("window.jtr_xml");
			result &= session().getEval("window.jtr_status").equals("OK");

			String jsTestName = testPath.substring(testPath.lastIndexOf("/") + 1);
			String filename = "jstest_" + this.getClass().getName() + "_" + jsTestName + ".xml";

			File file = new File(System.getenv("BUILDLOGS") + "/xml", filename);
			file.createNewFile();
			FileOutputStream out;
			PrintStream p;
			out = new FileOutputStream(System.getenv("BUILDLOGS") + "/xml/" + filename);
			p = new PrintStream(out);
			p.print(reportText);
			p.close();

		}
		assertTrue("A JavaScript test failed", result);
	}
}
