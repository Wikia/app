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
	@FindBy(css="li.private-block")
	private WebElement blockPrivateMassageButton;
	@FindBy(css="div#Rail img.wordmark")
	private WebElement mainChatButton;
	@FindBy(css="h1[class='public wordmark selected']")
	private WebElement mainChatSelection;
	@FindBy(css="ul.PrivateChatList span.splotch")
	private WebElement privateMessageNotificator;
	
	By userContextMenu = By.cssSelector("ul.regular-actions li");
	By adminContextMenu = By.cssSelector("ul.admin-actions li");
	By privateMessageHeader = By.xpath("//h1[@class='private' and contains(text(), 'Private Messages')]");
	
	
	
	public ChatPageObject(WebDriver driver) 
	{
		super(driver);
		PageFactory.initElements(driver, this);
	}
	
	/**
	 * @author Karol Kujawiak
	 * opens chat page, should be launched when user is logged in
	 */
	public void openChatPage()
	{
		driver.get(Global.DOMAIN+"wiki/Special:Chat");
		PageObjectLogging.log("openChatPage", "Chat page "+Global.DOMAIN+"wiki/Special:Chat opened", true, driver);		
	}
	
	/**
	 * @author Karol Kujawiak
	 * verifies certain components on chat page, chat page should be opened
	 * 
	 */
	public void verifyChatPage()
	{
		waitForElementByElement(messageWritingArea);
		waitForElementByElement(welcomeMessage);
		waitForElementByElement(sideBar);
		waitForElementByElement(userName);
		waitForElementByElement(userAvatar);
		PageObjectLogging.log("verifyChatPage", "Chat page verified", true, driver);
	}
	
	/**
	 * @author Karol Kujawiak
	 * @param message
	 * writes on chat and submits message, 
	 * verifies if message is visible in chat area 
	 */
	public void writeOnChat(String message)
	{
		messageWritingArea.sendKeys(message);
		messageWritingArea.sendKeys(Keys.ENTER);
		PageObjectLogging.log("writeOnChat", "Message: "+message+" written", true, driver);
		waitForElementByBy(By.xpath("//span[@class='message' and contains(text(), '"+message+"')]"));
		PageObjectLogging.log("writeOnChat", "Message: "+message+" is visible on chat board", true, driver);
	}
	
	public void verifyMessageOnChat(String message)
	{
		waitForElementByBy(By.xpath("//span[@class='message' and contains(text(), '"+message+"')]"));
		PageObjectLogging.log("writeOnChat", "Message: "+message+" is visible on chat board", true, driver);
	}
	
	/**
	 * @author Karol
	 * @param userName
	 * verifies if in chat are appeared  a message "UserName has joined the chat."
	 */
	public void verifyUserJoinToChat(String userName)
	{
		waitForElementByXPath("//div[@class='Chat']/ul/li[contains(text(), '"+userName+" has joined the chat.')]");
		PageObjectLogging.log("verifyUserJoinToChat", userName+" has joined the chat.", true, driver);
	}
	
	public void verifyUserIsVisibleOnContactsList(String userName)
	{
		waitForElementByXPath("//li[@id='user-"+userName+"']");
		PageObjectLogging.log("verifyUserIsVisibleOnContactsList", userName+" is visible on contacts list", true, driver);
	}
	
	/**
	 * @author Karol Kujawiak
	 * @param userName
	 * @param driver
	 * clicks on user button which is placed in right hand sidebar, should trigger user drop-down occurrence
	 * method should be launched if another user has joined the chat
	 */
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
	
	
	/**
	 * @author Karol Kujawiak
	 * @param driver
	 * clicks on private message from user drop-down
	 * method should be triggered when user drop-down is visible (always after clickOnDifferentUser())
	 */
	public void selectPrivateMessage(WebDriver driver)
	{
		waitForElementByElement(privateMassageButton);
		Point p = privateMassageButton.getLocation();
		CommonFunctions.MoveCursorToElement(p, driver);
		CommonFunctions.ClickElement();
		PageObjectLogging.log("selectPrivateMessage", "private message selected from dropdown", true, driver);
		try {
			Thread.sleep(1500);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	/**
	 * @author Karol Kujawiak
	 * verifies if there is private message header in right hand sidebar
	 * method should be executed after selectPrivateMeaage()
	 */
	public void verifyPrivateMessageHeader()
	{
		waitForElementByBy(privateMessageHeader);
		PageObjectLogging.log("verifyPrivateMessageHeader", "private message header is visible", true, driver);
	}
	
	public void verifyPrivateMessageNotification()
	{
		waitForElementByElement(privateMessageNotificator);
		PageObjectLogging.log("verifyPrivateMessageNotification", "private message notification is visible", true, driver);
	}
	
	public void verifyPrivateMessageIsHighLighted(String user)
	{
		//li[@class='User selected' and @id='priv-user-QATestsUser']
		waitForElementByXPath("//li[@class='User selected' and @id='priv-user-"+user+"']");
		PageObjectLogging.log("verifyPrivateMessageIsHighLighted", "private message section is highlighted", true, driver);
	}
	
	public void verifyPrivateChatTitle(String userName)
	{
		waitForElementByXPath("//h1[@class='private' and contains(text(), 'Private chat with "+userName+"')]");
		PageObjectLogging.log("verifyPrivateChatTitle", "private chat title is correct", true, driver);
	}
	
	public void clickOnMainChat(WebDriver driver)
	{
		Point p = mainChatButton.getLocation();
		CommonFunctions.MoveCursorToElement(p, driver);
		CommonFunctions.ClickElement();
		PageObjectLogging.log("clickOnMainChat", "main chat is clicked", true, driver);
	}
	
	public void verifyMainChatIsHighLighted()
	{
		waitForElementByElement(mainChatSelection);
		PageObjectLogging.log("verifyPrivateMessageIsHighLighted", "private message section is highlighted", true, driver);
	}
	
	public void clickOnPrivateChat(String user, WebDriver driver)
	{
		By privateChatUserButton = By.xpath("//li[@id='priv-user-"+user+"']");
		Point p = driver.findElement(privateChatUserButton).getLocation();
		CommonFunctions.MoveCursorToElement(p, driver);
		CommonFunctions.ClickElement();
		verifyPrivateMessageIsHighLighted(user);
		PageObjectLogging.log("clickOnPrivateChat", "private chat is clicked", true, driver);
	}
	/**
	 * @author Karol Kujawiak
	 * @param userName
	 * @param driver
	 * clicks on user button which is in private message section, should trigger context drop-down related to user from private message section
	 * method should be executed after selectPrivateMessage()
	 */
	public void clickPrivateMessageUser(String userName, WebDriver driver)
	{
		By privateMessagesUserButton = By.xpath("//li[@id='priv-user-"+userName+"']/span");
		waitForElementByBy(privateMessagesUserButton);
		WebElement e = driver.findElement(privateMessagesUserButton);
		Point p = e.getLocation();
		CommonFunctions.MoveCursorToElement(p, driver);		
		CommonFunctions.ClickElement();
		CommonFunctions.ClickElement();
		waitForElementByBy(userContextMenu);
	}
	
	
	/**
	 * @author Karol Kujawiak
	 * @param driver
	 * clicks on block private message button, should be executed after clickPrivateMessageUser()
	 */
	public void blockPrivateMessage(WebDriver driver)
	{
		waitForElementByElement(blockPrivateMassageButton);
		Point p = blockPrivateMassageButton.getLocation();
		CommonFunctions.MoveCursorToElement(p, driver);		
		CommonFunctions.ClickElement();
		CommonFunctions.ClickElement();
		PageObjectLogging.log("blockPrivateMessageFromUser", "private messages from "+userName+" are blocked now", true, driver);
	}
	
	/**
	 * @author Karol Kujawiak
	 * @param userName
	 * @param driver
	 * clicks on allow private message button, should be executed after clickOnDifferentUser() method, if private messages from user were blocked in the past
	 */
	public void allowPrivateMessageFromUser(String userName, WebDriver driver)
	{
		
		Point p = allowPrivateMassageButton.getLocation();
		CommonFunctions.MoveCursorToElement(p, driver);
		CommonFunctions.ClickElement();
		waitForElementByBy(By.xpath("//li[@id='priv-user-"+userName+"']"));
		PageObjectLogging.log("allowPrivateMessageFromUser", "private messages from "+userName+" are allowed now", true, driver);
	}
	
	/**
	 * @author Karol
	 * @return
	 * method gathers all WebElements from user drop-down, and returns list of them
	 */
	private  List<WebElement> getDropDownListOfElements()
	{
		List<WebElement> list = driver.findElements(userContextMenu); 
		return list;		
	}

	/**
	 * @author Karol
	 * @return
	 * method gathers all WebElements from admin drop-down, and returns list of them
	 */
	private  List<WebElement> getAdminDropDownListOfElements()
	{
		List<WebElement> list = driver.findElements(adminContextMenu); 
		return list;		
	}
	
	/**
	 * @author Karol Kujawiak
	 * verifies user drop-down content, should be executed after clickOnDifferentUser() execution
	 */
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

	/**
	 * @author Karol Kujawiak
	 * verifies blocked user drop-down content, should be executed after clickOnDifferentUser() execution
	 */
	public void verifyBlockedUserDropdown(String userName)
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

	/**
	 * @author Karol Kujawiak
	 * verifies admin user drop-down content, should be executed after clickOnDifferentUser() execution
	 */
	public void verifyAdminUserDropdown()
	{
		List<WebElement> list = getDropDownListOfElements();
		for (int i=0; i<list.size(); i++)
		{
			System.out.println(list.get(i).getAttribute("class"));	
		}
		CommonFunctions.assertString("message-wall", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("contribs", list.get(1).getAttribute("class"));
		
		list = getAdminDropDownListOfElements();
		CommonFunctions.assertString("give-chat-mod", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("kick", list.get(1).getAttribute("class"));
		CommonFunctions.assertString("ban", list.get(2).getAttribute("class"));
	}
}
