package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

import java.io.*;

/**
 * Prototype of crusecontrol and javascript unit testing, using browser as javascript environment
 */
public class JavaScriptTest extends BaseTest {
	@Test(groups={"broken"})
	public void testCreatePageDialog() throws Exception {
		//session().open("wiki/Special:JavascriptTestRunner?test=extensions/wikia/JavascriptTestRunner/js/tests/DummyTest.js&autorun=1&output=mwarticle");
		
		File file = new File(System.getenv("BUILDLOGS") + "/xml","jstest.xml");
		file.createNewFile();
		FileOutputStream out;
		PrintStream p;
		out = new FileOutputStream(System.getenv("BUILDLOGS") + "/xml/jstest.xml");
		p = new PrintStream(out);
		
		// report content should be read from browser using selenium
		// String reportText = session().getEval("windows.JUnitXmlReport");
		String reportText = "";
		reportText += "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		reportText += 	"<testsuite name=\"JUnityTest\" tests=\"1\" failures=\"1\" errors=\"0\" skipped=\"0\" time=\"10.673\">";
		reportText += 		"<properties />";
		reportText += 		"<testcase name=\"loremIpsum\" time=\"10.673\">";
		reportText += 		"<failure type=\"foo\" message=\"some error text\">";
		reportText += 			"<![CDATA[trace line one";
		reportText += 			"trace line two<br />";
		reportText += 			"trace line three";
		reportText += 			"]]>";
		reportText += 		"</failure>";
		reportText += 	"</testcase>";
		reportText += 	"</testsuite>";
		//out.write(reportText);
		//out.close();
		p.print(reportText);
		p.close();
	}
}
