package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;

import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.ArrayList;

import java.io.BufferedReader;
import java.io.FileReader;
import java.io.File;

public class SpecialPagesTest extends BaseTest {

	@Test(groups={"CI"})
	public void testNotRestrictedSpecialPages() throws Exception {
		List data = getData("SpecialPages.txt");
		Iterator<HashMap> iterator = data.iterator();
		
		while (iterator.hasNext()) {
			HashMap hm = iterator.next();
			session().open("index.php?title=Special:" + hm.get("specialPage"));
			assertFalse(hm.get("specialPage")+" is empty", session().getHtmlSource().equals(""));
			assertTrue("no '"+hm.get("phrase")+"' found on "+hm.get("specialPage"), session().isTextPresent(hm.get("phrase").toString()));
		}
	}

	@Test(groups={"CI"})
	public void testRestrictedSpecialPages() throws Exception {
		List data = getData("SpecialPagesRestricted.txt");
		Iterator<HashMap> iterator = data.iterator();
		
		loginAsStaff();
		
		while (iterator.hasNext()) {
			HashMap hm = iterator.next();
			session().open("index.php?title=Special:" + hm.get("specialPage"));
			assertFalse(hm.get("specialPage")+" is empty", session().getHtmlSource().equals(""));
			assertTrue("no '"+hm.get("phrase")+"' found on "+hm.get("specialPage"), session().isTextPresent(hm.get("phrase").toString()));
		}
	}
	
	private List getData(String fileName) throws Exception {
	    File configFile = new File(System.getenv("TESTSCONFIG"));
		BufferedReader in = new BufferedReader(new FileReader(configFile.getParentFile() + "/fixtures/" + fileName));
		List data = new ArrayList();
		String strLine;
		
		while ((strLine = in.readLine()) != null) {
			String[] field = strLine.split(",");
			HashMap hm = new HashMap();
			hm.put("specialPage", field[0]);
			hm.put("phrase", field[1]);
			data.add(hm);
		}
		in.close();
		
		return data;
	}
}
