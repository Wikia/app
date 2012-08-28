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
	@FindBy(css="li.private")
	private WebElement privateMassageButton;
	@FindBy(css="li.private-allow")
	private WebElement allowPrivateMassageButton;
	
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
	
	public void selectPrivateMessage(WebDriver driver)
	{
		waitForElementByElement(privateMassageButton);
		Point p = privateMassageButton.getLocation();
		CommonFunctions.MoveCursorToElement(p, driver);
		CommonFunctions.ClickElement();
		PageObjectLogging.log("selectPrivateMessage", "private message selected from dropdown", true, driver);
	}
	
	
	public void blockPrivateMessageFromUser(String userName, WebDriver driver)
	{
		clickOnDifferentUser(userName, driver);
		selectPrivateMessage(driver);
		
		By privateMessagesUserButton = By.xpath("//li[@id='priv-user-"+userName+"']/span");
		waitForElementByBy(privateMessagesUserButton);
		WebElement e = driver.findElement(privateMessagesUserButton);
		Point p = e.getLocation();
		CommonFunctions.MoveCursorToElement(p, driver);		
		CommonFunctions.ClickElement();
		CommonFunctions.ClickElement();
		waitForElementByBy(userContextMenu);
		PageObjectLogging.log("blockPrivateMessageFromUser", "private messages from "+userName+" are blocked now", true, driver);
	}
	
	public void allowPrivateMessageFromUser(String userName, WebDriver driver)
	{
		Point p = allowPrivateMassageButton.getLocation();
		CommonFunctions.MoveCursorToElement(p, driver);
		CommonFunctions.ClickElement();
		waitForElementByBy(By.xpath("//li[@id='priv-user-"+userName+"']"));
		PageObjectLogging.log("allowPrivateMessageFromUser", "private messages from "+userName+" are allowed now", true, driver);
	}
	
	/*change to private if public*/
	private  List<WebElement> getDropDownListOfElements()
	{
		List<WebElement> list = driver.findElements(userContextMenu); 
		return list;		
	}
	
	public void verifyNormalUserDropdown()
	{
		List<WebElement> list = getDropDownListOfElements();
		for (int i=0; i<list.size(); i++)
		{
			System.out.println(list.get(i).getAttribute("class"));	
		}
		CommonFunctions.assertString("message-wall", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("contribs", list.get(1).getAttribute("class"));
		CommonFunctions.assertString("private", list.get(2).getAttribute("class"));	
	}
	
	public void verifyBlockedUserDropdown()
	{
		List<WebElement> list = getDropDownListOfElements();
		for (int i=0; i<list.size(); i++)
		{
			System.out.println(list.get(i).getAttribute("class"));	
		}
		CommonFunctions.assertString("message-wall", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("contribs", list.get(1).getAttribute("class"));
		CommonFunctions.assertString("private-allow", list.get(2).getAttribute("class"));	
	}
	
	

}
