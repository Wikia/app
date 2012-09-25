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
	@Test
	public void MessageWall_WriteMessage()
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
	}
	
	
	@Test
	public void MessageWall_WriteEditMessage()
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
	}
}
