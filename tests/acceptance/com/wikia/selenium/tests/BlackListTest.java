package com.wikia.selenium.tests;

import java.util.Date;

import java.net.URL;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class BlackListTest extends BaseTest {

	@Test(groups={"CI"})
	public void testEnsureBlacklistedWebsitesAreNotBeingAccepted() throws Exception {
		String time = new Date().toString();
		String articleTitle = "Project:WikiaBotAutomatedTest1";

		login();

		String[] websites = getTestConfig().getStringArray("ci.extension.wikia.Phalanx.BlackList.website.url");
		assertTrue(websites.length > 0);

		for (String website: websites) {
			editArticle(articleTitle, website);
			assertTrue(session().isTextPresent("Spam protection filter"));
		}
	}

	@Test(groups={"CI"})
	public void testEnsureWhitelistedWebsitesAreBeingAccepted() throws Exception {
		String time = new Date().toString();
		String articleTitle = "Project:WikiaBotAutomatedTest1";
		login();

		String[] websites = getTestConfig().getStringArray("ci.extension.wikia.Phalanx.WhiteList.internalWebsite.url");
		assertTrue(websites.length > 0);

		for (String website: websites) {
		editArticle(articleTitle, website + "<br>" + time);
			String content = session().getHtmlSource();
			String pattern = "<a href=\"" + website + "\" class=\"free\" title=\"" + website + "\">" + website + "</a>";
			assertTrue(content.indexOf(pattern) > 0);
		}
		
		websites = getTestConfig().getStringArray("ci.extension.wikia.Phalanx.WhiteList.externalWebsite.url");
		assertTrue(websites.length > 0);

		for (String website: websites) {
			editArticle(articleTitle, website + "<br>" + time);
			String content = session().getHtmlSource();
			String pattern = "<a href=\"" + website + "\" class=\"external free\" title=\"" + website + "\" rel=\"nofollow\">" + website + "</a>";
			assertTrue(content.indexOf(pattern) > 0);
		}
	}

	@Test(groups={"CI"})
	public void testEnsureWhitelistedImagesAreBeingAccepted() throws Exception {
		String time = new Date().toString();
		String articleTitle = "Project:WikiaBotAutomatedTest1";

		login();

		String[] images = getTestConfig().getStringArray("ci.extension.wikia.Phalanx.WhiteList.internalImage.url");
		assertTrue(images.length > 0);

		for (String image: images) {
			editArticle(articleTitle, image + "<br>" + time);
			URL url = new URL(image);
			String file = url.getFile();
			file = file.substring(file.lastIndexOf("/") + 1);
			String content = session().getHtmlSource();
			String pattern = "<img src=\"" + image + "\" alt=\"" + file + "\">";
			assertTrue(content.indexOf(pattern) > 0);
		}

		images = getTestConfig().getStringArray("ci.extension.wikia.Phalanx.WhiteList.externalImage.url");
		assertTrue(images.length > 0);

		for (String image: images) {
			editArticle(articleTitle, image + "<br>" + time);
			String content = session().getHtmlSource();
			String pattern = "<a href=\"" + image + "\" class=\"external free\" title=\"" + image + "\" rel=\"nofollow\">" + image + "</a>";
			assertTrue(content.indexOf(pattern) > 0);
		}
	}
}
