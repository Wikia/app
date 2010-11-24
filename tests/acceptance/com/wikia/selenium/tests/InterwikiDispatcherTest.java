package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;

import java.io.File;

import java.io.File;
import org.apache.commons.io.FileUtils;
import org.testng.annotations.Test;

public class InterwikiDispatcherTest extends BaseTest {

	@Test(groups="CI")
	public void testInterwikiDispatcher() throws Exception {
		File configFile = new File(System.getenv("TESTSCONFIG"));
		File dataFile = new File(configFile.getParentFile() + "/fixtures/DirectRedirectingArticleForTest.txt");
		String articleContent = FileUtils.readFileToString(dataFile);

		login();

		editArticle("Project:WikiaBotInterwikiDispatcherTest", articleContent);

		clickAndWait("link=exact:wikia:c:wiedzmin");
		String renderedUrl = "http://wiedzmin.wikia.com/wiki/Strona_g%C5%82%C3%B3wna";
		assertEquals(renderedUrl, session().getLocation());

		session().open("index.php?title=Project:WikiaBotInterwikiDispatcherTest");
		clickAndWait("link=exact:w:c:wiedzmin");
		assertEquals(renderedUrl, session().getLocation());

		session().open("index.php?title=Project:WikiaBotInterwikiDispatcherTest");
		clickAndWait("link=exact:w:c:wiedzmin:Geralt");
		renderedUrl = "http://wiedzmin.wikia.com/wiki/Geralt";
		assertEquals(renderedUrl, session().getLocation());

		session().open("index.php?title=Project:WikiaBotInterwikiDispatcherTest");
		clickAndWait("link=exact:w:c:wowwiki:Stormwind");
		renderedUrl = "http://www.wowwiki.com/Stormwind";
		assertEquals(renderedUrl, session().getLocation());

		session().open("index.php?title=Project:WikiaBotInterwikiDispatcherTest");
		clickAndWait("link=exact:w:c:plemiona:User:Adi3ek/Test");
		renderedUrl = "http://plemiona.wikia.com/wiki/U%C5%BCytkownik:Adi3ek/Test";
		assertEquals(renderedUrl, session().getLocation());

		session().open("index.php?title=Project:WikiaBotInterwikiDispatcherTest");
		clickAndWait("link=exact:w:c:memoryalpha:Julian_Bashir");
		renderedUrl = "http://memory-alpha.org/wiki/Julian_Bashir";
		assertEquals(renderedUrl, session().getLocation());
	}
}
