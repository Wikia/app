package com.wikia.webdriver.TestCases.MessageWallTests;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;
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
	
//	@Test(groups = {"MessageWall010", "MessageWall"}) 
//	public void MessageWall_010_WriteBoldMessage()
//	{
//		
//		CommonFunctions.logOut(Properties.userName, driver);
//		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
//		String timeStamp = wall.getTimeStamp();
//		String title = "QATitle"+timeStamp;
//		String message = "QAMessage" + timeStamp;
//		CommonFunctions.logIn(Properties.userName, Properties.password);
//		wall.openMessageWall(Properties.userName);
//		wall.writeBoldMessage(title, message);
//		wall.clickPostButton();
//		wall.verifyPostedBoldMessageWithTitle(title, message);
//		wall.removeMessage("reason");
//	}
	
	
	
//	@Test(groups = { "MessageWall00x", "MessageWall" })
//	public void MessageWall_00x_WriteAndEditMessage() {
//
//		CommonFunctions.logOut(Properties.userName, driver);
//		MessageWallPageObject wall = new MessageWallPageObject(driver,Global.DOMAIN);
//		String timeStamp = wall.getTimeStamp();
//		String title = "QATitle" + timeStamp;
//		String message = "QAMessage" + timeStamp;
//		String titleEdit = "QATitle" + timeStamp + "edit";
//		String messageEdit = "QAMessage" + timeStamp + "edit";
//		CommonFunctions.logIn(Properties.userName, Properties.password);
//		wall.openMessageWall(Properties.userName);
//		wall.writeMessage(title, message);
//		wall.clickPostButton();
//		wall.verifyPostedMessageWithTitle(title, message);
//		wall.editMessage(titleEdit, messageEdit);
//		wall.verifyPostedMessageWithTitle(titleEdit, messageEdit);
//
//	}
	
}
