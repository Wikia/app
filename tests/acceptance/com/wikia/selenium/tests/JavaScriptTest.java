package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.closeSeleniumSession;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

import java.io.*;
import java.util.Date;

/**
 * Prototype of crusecontrol and javascript unit testing, using browser as javascript environment
 */
public class JavaScriptTest extends BaseTest {
	public void runJavaScriptTest(String testPath) throws Exception {
		boolean result = true;
		String  date   = (new Date()).toString();

		session().open("wiki/Special:JavascriptTestRunner?test="+testPath+"&autorun=1&output=mwarticle,selenium");
		session().waitForPageToLoad(this.getTimeout());
		session().waitForCondition("typeof window.jtr_xml != 'undefined';", this.getTimeout());

		String reportText = session().getEval("window.jtr_xml");
		result &= session().getEval("window.jtr_status").equals("OK");

		String jsTestName = testPath.substring(testPath.lastIndexOf("/") + 1);
		String filename = "jstest_" + this.getClass().getName() + "_" + jsTestName + "_" + date + ".xml";

		File file = new File(System.getenv("BUILDLOGS") + "/xml", filename);
		file.createNewFile();
		FileOutputStream out;
		PrintStream p;
		out = new FileOutputStream(System.getenv("BUILDLOGS") + "/xml/" + filename);
		p = new PrintStream(out);
		p.print(reportText);
		p.close();

		assertTrue("A JavaScript test failed", result);
	}

	/*
	@Test(groups={"broken", "javascript"})
	public void testDummyTest() throws Exception {
		runJavaScriptTest("extensions/wikia/JavascriptTestRunner/js/tests/DummyTest.js");
	}

	@Test(groups={"broken", "javascript"})
	public void testRTETest() throws Exception {
		runJavaScriptTest("extensions/wikia/JavascriptTestRunner/js/tests/RTETest.js");
	}
	*/
}
