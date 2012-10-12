package com.wikia.webdriver.TestCases.MessageWallTests;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.MessageWallHistoryPageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.MessageWallPageObject;

public class MessageWallTests extends TestTemplate
{
	protected String url = "http://www.youtube.com/watch?v=LQjkDW3UPVk";
	
	@Test(groups = {"MessageWall001", "MessageWall"}) 
	public void MessageWall_001_WriteMessage()
	{
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		String message = "QAMessage" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessage(title, message);
		wall.clickPostButton();
		wall.verifyPostedMessageWithTitle(title, message);
		wall.removeMessage("reason");
	}
	
	@Test(groups = {"MessageWall002", "MessageWall"}) 
	public void MessageWall_002_WriteMessageNoTitle()
	{
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String message = "QAMessage" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessageNoTitle(message);
		wall.clickPostNotitleButton();
		wall.verifyPostedMessageWithoutTitle(Properties.userName, message);
		wall.removeMessage("reason");
	}
	
	@Test(groups = {"MessageWall003", "MessageWall"}) 
	public void MessageWall_003_WriteMessageImage()
	{
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessageImage(title);
		wall.clickPostButton();
		wall.verifyPostedMessageImage(title);
		wall.removeMessage("reason");
	}
	
	@Test(groups = {"MessageWall004", "MessageWall"}) 
	public void MessageWall_004_WriteMessageVideo()
	{
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessageVideo(title, url);
		wall.clickPostButton();
		wall.verifyPostedMessageVideo(title);
		wall.removeMessage("reason");
	}
	
	@Test(groups = { "MessageWall005", "MessageWall" })
	public void MessageWall_005_WriteMessageImagePreview() {
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessageImage(title);
		wall.clickPreviewButton();
		wall.clickPublishButton();
		wall.verifyPostedMessageImage(title);
		wall.removeMessage("reason");
	}
	
	@Test(groups = {"MessageWall006", "MessageWall"}) 
	public void MessageWall_006_WriteMessagePreview()
	{
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		String message = "QAMessage" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessage(title, message);
		wall.clickPreviewButton();
		wall.clickPublishButton();
		wall.verifyPostedMessageWithTitle(title, message);
		wall.removeMessage("reason");
	}
	
	@Test(groups = {"MessageWall007", "MessageWall"}) 
	public void MessageWall_007_WriteMessageWithLink()
	{
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		String Externallink = "www.wikia.com";
		String Internallink = "Formatting";
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessageWithLink(Internallink, Externallink, title);
		wall.clickPostButton();
		wall.verifyPostedMessageWithLinks(Internallink, Externallink);
		wall.removeMessage("reason");
	}
	
	@Test(groups = {"MessageWall008", "MessageWall"}) 
	public void MessageWall_008_WriteMessageVideoPreview()
	{
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessageVideo(title, url);
		wall.clickPreviewButton();
		wall.clickPublishButton();
		wall.verifyPostedMessageVideo(title);
		wall.removeMessage("reason");
	}
	
	@Test(groups = {"MessageWall009", "MessageWall"}) 
	public void MessageWall_009_WriteMessageWithLinkPreview()
	{
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		String Externallink = "www.wikia.com";
		String Internallink = "Formatting";
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessageWithLink(Internallink, Externallink, title);
		wall.clickPreviewButton();
		wall.clickPublishButton();
		wall.verifyPostedMessageWithLinks(Internallink, Externallink);
		wall.removeMessage("reason");
	}
	
	@Test(groups = {"MessageWall011", "MessageWall"}) 
	public void MessageWall_011_WriteNonLatinMessage()
	{
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		String message = "Гсторыя śćąęłńó" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessage(title, message);
		wall.clickPostButton();
		wall.verifyPostedMessageWithTitle(title, message);
		wall.removeMessage("reason");
	}
	
	@Test(groups = {"MessageWall010", "MessageWall"}) 
	public void MessageWall_010_SortMessageWall()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title1 = "QATitle1"+timeStamp;
		String message1 = "QAMessage1" + timeStamp;
		String title2 = "QATitle2"+timeStamp;
		String message2 = "QAMessage2" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		
		wall.writeMessage(title1, message1);
		wall.clickPostButton();
		wall.verifyPostedMessageWithTitle(title1, message1);
		
		wall.writeMessage(title2, message2);
		wall.clickPostButton();
		wall.verifyPostedMessageWithTitle(title2, message2);
		
		wall.verifyMessagesOrderIs(message2, message1);
		wall.sortThreads("OldestThreads");
		wall.verifyMessagesOrderIs(message1, message2);
		wall.sortThreads("NewestThreads");
		wall.verifyMessagesOrderIs(message2, message1);
		wall.removeMessage("reason");
		
	}
	
	@Test(groups = {"MessageWall012", "MessageWall"}) 
	public void MessageWall_012_WriteNonLatinMessagePreview()
	{
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		String message = "Гсторыя śćąęłńó" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessage(title, message);
		wall.clickPreviewButton();
		wall.clickPublishButton();
		wall.verifyPostedMessageWithTitle(title, message);
		wall.removeMessage("reason");
	}
	
	@Test(groups = {"MessageWall013", "MessageWall"}) 
	public void MessageWall_013_WriteMessageSourceMode()
	{
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		String sourceMessage = "'''bold" + timeStamp+"'''";
		String message = "bold" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessageSourceMode(title, sourceMessage);
		wall.clickPostButton();
		wall.verifyPostedBoldMessageWithTitle(title, message);
		wall.removeMessage("reason");
	}
	
	@Test(groups = {"MessageWall014", "MessageWall"}) 
	public void MessageWall_014_CheckHistory()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle"+timeStamp;
		String message = "QAMessage" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessage(title, message);
		wall.clickPostButton();
		wall.verifyPostedMessageWithTitle(title, message);
		MessageWallHistoryPageObject threadHistory = wall.openHistory();
		threadHistory.verifyThreadHistory();
		threadHistory.verifyThreadHistoryElements();
		wall = threadHistory.navigateBackToMessageWall();
		wall.removeMessage("reason");
	}
	
	
	@Test(groups = { "MessageWall015", "MessageWall" })
	public void MessageWall_015_WriteBoldMessage() {

		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver,Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle" + timeStamp;
		String message = "QAMessage" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeBoldMessage(title, message);
		wall.clickPostButton();
		wall.verifyPostedBoldMessageWithTitle(title, message);
		wall.removeMessage("reason");

	}
	
	@Test(groups = { "MessageWall016", "MessageWall" })
	public void MessageWall_016_WriteBoldMessagePreview() {
		
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver,Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle" + timeStamp;
		String message = "QAMessage" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeBoldMessage(title, message);
		wall.clickPreviewButton();
		wall.clickPublishButton();
		wall.verifyPostedBoldMessageWithTitle(title, message);	
		wall.removeMessage("reason");	}
	
	@Test(groups = { "MessageWall017", "MessageWall" })
	public void MessageWall_017_WriteItalicMessage() {
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver,Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle" + timeStamp;
		String message = "QAMessage" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeItalicMessage(title, message);
		wall.clickPostButton();
		wall.verifyPostedItalicMessageWithTitle(title, message);	
		wall.removeMessage("reason");	
	}
	
	@Test(groups = { "MessageWall018", "MessageWall" })
	public void MessageWall_018_WriteItalicMessagePreview() {
		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver,Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle" + timeStamp;
		String message = "QAMessage" + timeStamp;
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeItalicMessage(title, message);
		wall.clickPreviewButton();
		wall.clickPublishButton();
		wall.verifyPostedItalicMessageWithTitle(title, message);	
		wall.removeMessage("reason");	
	}
	
	
	@Test(groups = { "MessageWall019", "MessageWall" })
	public void MessageWall_019_WriteAndEditMessage() {

		CommonFunctions.logOut(Properties.userName, driver);
		MessageWallPageObject wall = new MessageWallPageObject(driver,Global.DOMAIN);
		String timeStamp = wall.getTimeStamp();
		String title = "QATitle" + timeStamp;
		String message = "QAMessage" + timeStamp;
		String titleEdit = "QATitle" + timeStamp + "edit";
		String messageEdit = "QAMessage" + timeStamp + "edit";
		CommonFunctions.logIn(Properties.userName, Properties.password);
		wall.openMessageWall(Properties.userName);
		wall.writeMessage(title, message);
		wall.clickPostButton();
		wall.verifyPostedMessageWithTitle(title, message);
		wall.editMessage(titleEdit, messageEdit);
		wall.verifyPostedMessageWithTitle(titleEdit, messageEdit);
		wall.removeMessage("reason");	

	}
	
}
