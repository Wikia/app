package com.wikia.webdriver.PageObjects.PageObject.ChatPageObject;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.Point;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.BasePageObject;

public class ChatPageObject extends BasePageObject
{

	/*
	 * https://internal.wikia-inc.com/wiki/Chat/UAT
	 * 
	 * 
	 */
	@FindBy(css="textarea[name='message']")
	private WebElement messageWritingArea;
	@FindBy(xpath="//div[@class='Chat']//li[contains(text(), 'Welcome to the Mediawiki 1.19 test Wiki chat')]")
	private WebElement welcomeMessage;
	@FindBy(css="div.Rail")
	private WebElement sideBar;
	@FindBy(css="h1[class=public wordmark''] img")
	private WebElement wordmark;
	@FindBy(css="div.User span.username")
	private WebElement userName;
	@FindBy(css="div.User img")
	private WebElement userAvatar;
	
	By userContextMenu = By.cssSelector("ul.regular-actions li");
	
	
	public ChatPageObject(WebDriver driver) 
	{
		super(driver);
		PageFactory.initElements(driver, this);
	}
	
	public void openChatPage()
	{
		driver.get(Global.DOMAIN+"wiki/Special:Chat");
		PageObjectLogging.log("openChatPage", "Chat page "+Global.DOMAIN+"wiki/Special:Chat opened", true, driver);		
	}
	
	public void verifyChatPage()
	{
		waitForElementByElement(messageWritingArea);
		waitForElementByElement(welcomeMessage);
		waitForElementByElement(sideBar);
//		waitForElementByElement(wordmark);
		waitForElementByElement(userName);
		waitForElementByElement(userAvatar);
		PageObjectLogging.log("verifyChatPage", "Chat page verified", true, driver);
	}
	
	public void writeOnChat(String message)
	{
		messageWritingArea.sendKeys(message);
		messageWritingArea.sendKeys(Keys.ENTER);
		PageObjectLogging.log("writeOnChat", "Message: "+message+" written", true, driver);
		waitForElementByBy(By.xpath("//span[@class='message' and contains(text(), '"+message+"')]"));
		PageObjectLogging.log("writeOnChat", "Message: "+message+" is visible on chat board", true, driver);
	}
	
	public void verifyUserJoinToChat(String userName)
	{
		waitForElementByXPath("//div[@class='Chat']/ul/li[contains(text(), '"+userName+" has joined the chat.')]");
		PageObjectLogging.log("verifyUserJoinToChat", userName+" has joined the chat.", true, driver);
	}
	
	public void clickOnDifferentUser(String userName, WebDriver driver)
	{
		By userButton = By.xpath("//div[@class='Rail']//li[@id='user-"+userName+"']/img");
		waitForElementByBy(userButton);
		
		WebElement e = driver.findElement(userButton);
		Point p = e.getLocation();
		CommonFunctions.MoveCursorToElement(p, driver);
		CommonFunctions.ClickElement();
		
		PageObjectLogging.log("clickOnDifferentUser", userName+" button clicked", true, driver);
	}
	
	/*change to private if public*/
	public List<WebElement> getDropDownListOfElements()
	{
		List<WebElement> list = driver.findElements(userContextMenu); 
		return list;		
	}
	
	public void verifyNormalUserDropdown(List<WebElement> list)
	{
		for (int i=0; i<list.size(); i++)
		{
			System.out.println(list.get(i));	
		}
	}
	
	

}
