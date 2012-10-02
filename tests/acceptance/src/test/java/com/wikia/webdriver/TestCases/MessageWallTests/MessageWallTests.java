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
	
//	@Test
//	public void MessageWall_002_WriteEditMessage()
//	{
//		
//		CommonFunctions.logOut(Properties.userName, driver);
//		MessageWallPageObject wall = new MessageWallPageObject(driver, Global.DOMAIN);
//		String timeStamp = wall.getTimeStamp();
//		String title = "QATitle"+timeStamp;
//		String message = "QAMessage" + timeStamp;
//		String titleEdit = "QATitle"+timeStamp+"edit";
//		String messageEdit = "QAMessage" + timeStamp+"edit";
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
