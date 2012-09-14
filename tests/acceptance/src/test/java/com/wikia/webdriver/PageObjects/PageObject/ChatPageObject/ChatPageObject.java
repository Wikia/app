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
	
	@FindBy(css="form.Write")
	private WebElement messageForm;
	
	@FindBy(css="form[class='Write blocked']")
	private WebElement messageWriteAreaBlocked;//when user is disconnected
	
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
	
	@FindBy(css="li[class='User selected blocked']")
	private WebElement userDisconnectedButton;
	
	@FindBy(css="li.give-chat-mod span.label")
	private WebElement giveChatModStatusButton;
	
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
	
	public void verifyPrivateMessageNotification(int notificationNumber)
	{
		waitForElementByXPath("//span[@class='splotch' and contains(text(), '"+notificationNumber+"')]");
		PageObjectLogging.log("verifyPrivateMessageNotification", "private message notification number "+notificationNumber+" is visible", true, driver);
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
	
	public void verifyMainChatIsHighLighted()
	{
		waitForElementByElement(mainChatSelection);
		PageObjectLogging.log("verifyPrivateMessageIsHighLighted", "private message section is highlighted", true, driver);
	}
	
	/**
	 * @author Karol Kujawiak
	 * verifies user drop-down content, should be executed after clickOnDifferentUser() execution
	 */
	public void verifyNormalUserDropdown()
	{
		List<WebElement> list = getDropDownListOfElements();
		CommonFunctions.assertNumber(3, list.size(), "Checking number of elements in the drop-down");
		for (int i=0; i<list.size(); i++)
		{
			PageObjectLogging.log("verifyNormalUserDropdown", i+" item in drop-down is "+ list.get(i).getAttribute("class"), true);
		}
		CommonFunctions.assertString("message-wall", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("contribs", list.get(1).getAttribute("class"));
		CommonFunctions.assertString("private", list.get(2).getAttribute("class"));
	}

	/**
	 * @author Karol Kujawiak
	 * verifies blocked user drop-down content, should be executed after clickOnDifferentUser() execution
	 */
	public void verifyBlockingUserDropdown()
	{
		List<WebElement> list = getDropDownListOfElements();
		CommonFunctions.assertNumber(3, list.size(), "Checking number of elements in the drop-down");
		for (int i=0; i<list.size(); i++)
		{
			PageObjectLogging.log("verifyBlockingUserDropdown", i+" item in drop-down is "+ list.get(i).getAttribute("class"), true);
		}
		CommonFunctions.assertString("message-wall", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("contribs", list.get(1).getAttribute("class"));
		CommonFunctions.assertString("private-allow", list.get(2).getAttribute("class"));	
	}
	
	/**
	 * @author Karol Kujawiak
	 * verifies blocked user drop-down content, should be executed after clickOnDifferentUser() execution
	 */
	public void verifyBlockedUserDropdown()
	{
		List<WebElement> list = getDropDownListOfElements();
		CommonFunctions.assertNumber(2, list.size(), "Checking number of elements in the drop-down");
		for (int i=0; i<list.size(); i++)
		{
			PageObjectLogging.log("verifyBlockedUserDropdown", i+" item in drop-down is "+ list.get(i).getAttribute("class"), true);	
		}
		CommonFunctions.assertString("message-wall", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("contribs", list.get(1).getAttribute("class"));	
	}
	
	public void verifyBlockedUserMessage(String blockingUserName, String blockedUserName)
	{
		waitForElementByXPath("//li[@class='inline-alert' and contains(text(), '"+blockingUserName+" has blocked "+blockedUserName+".')]");
		PageObjectLogging.log("verifyBlockedUserMessage", "user is blocked message is visible: "+blockingUserName+" has blocked "+blockedUserName, true, driver);
	}
	
	/**
	 * @author Karol Kujawiak
	 * verifies private message user drop-down content, should be executed after clickPrivateMessageUser() execution
	 */
	public void verifyPrivateUserDropdown()
	{
		List<WebElement> list = getDropDownListOfElements();
		CommonFunctions.assertNumber(3, list.size(), "Checking number of elements in the drop-down");
		for (int i=0; i<list.size(); i++)
		{
			PageObjectLogging.log("verifyPrivateUserDropdown", i+" item in drop-down is "+ list.get(i).getAttribute("class"), true);
		}
		CommonFunctions.assertString("message-wall", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("contribs", list.get(1).getAttribute("class"));
		CommonFunctions.assertString("private-block", list.get(2).getAttribute("class"));	
	}

	/**
	 * @author Karol Kujawiak
	 * verifies admin user drop-down content, should be executed after clickOnDifferentUser() execution
	 */
	public void verifyAdminUserDropdown()
	{
		List<WebElement> list = getDropDownListOfElements();
		CommonFunctions.assertNumber(3, list.size(), "Checking number of elements in the drop-down");
		for (int i=0; i<list.size(); i++)
		{
			PageObjectLogging.log("verifyAdminUserDropdown", i+" item in drop-down is "+ list.get(i).getAttribute("class"), true);
		}
		CommonFunctions.assertString("message-wall", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("contribs", list.get(1).getAttribute("class"));
		CommonFunctions.assertString("private", list.get(2).getAttribute("class"));
		
		list = getAdminDropDownListOfElements();
		CommonFunctions.assertNumber(3, list.size(), "Checking number of elements in the drop-down");
		for (int i=0; i<list.size(); i++)
		{
			PageObjectLogging.log("verifyAdminUserDropdown", i+" item in drop-down is "+ list.get(i).getAttribute("class"), true);
		}
		CommonFunctions.assertString("give-chat-mod", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("kick", list.get(1).getAttribute("class"));
		CommonFunctions.assertString("ban", list.get(2).getAttribute("class"));
	}
	
	public void verifyChatModUserDropdown()
	{
		List<WebElement> list = getDropDownListOfElements();
		CommonFunctions.assertNumber(3, list.size(), "Checking number of elements in the drop-down");
		for (int i=0; i<list.size(); i++)
		{
			PageObjectLogging.log("verifyAdminUserDropdown", i+" item in drop-down is "+ list.get(i).getAttribute("class"), true);
		}
		CommonFunctions.assertString("message-wall", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("contribs", list.get(1).getAttribute("class"));
		CommonFunctions.assertString("private", list.get(2).getAttribute("class"));
		
		list = getAdminDropDownListOfElements();
		CommonFunctions.assertNumber(2, list.size(), "Checking number of elements in the drop-down");
		for (int i=0; i<list.size(); i++)
		{
			PageObjectLogging.log("verifyAdminUserDropdown", i+" item in drop-down is "+ list.get(i).getAttribute("class"), true);
		}
		CommonFunctions.assertString("kick", list.get(0).getAttribute("class"));
		CommonFunctions.assertString("ban", list.get(1).getAttribute("class"));
	}
	
	public void verifyUserIsGreyedOut()
	{
		waitForElementByElement(userDisconnectedButton);
		PageObjectLogging.log("verifyUserIsGreyedOut", "Verified user disconnected from the chat", true, driver);
	}
	
	public void verifyWritingAreaIsBlocked()
	{
		waitForElementByElement(messageWriteAreaBlocked);
		PageObjectLogging.log("verifyWritingAreaIsBlocked", "Verified user writing area is blocked", true, driver);
	}
	
	public void verifyUserLeftFromChatMessage(String userName)
	{
		waitForElementByXPath("//li[@class='inline-alert' and contains(text(), '"+userName+" has left the chat.')]");
		PageObjectLogging.log("verifyUserLeftFromChatMessage", "Verified user left message is visible", true, driver);
	}
	
	public void verifyChatModMessage(String userStaff, String userName)
	{
		waitForElementByXPath("//li[contains(text(), '"+userStaff+" has made')]");
		waitForElementByXPath("//li/strong[contains(text(), '"+userName+"')]");
	}
	
	public void disconnectFromChat()
	{
		driver.get(Global.DOMAIN);
		PageObjectLogging.log("disconnectFromChat", "User is disconnected from the chat", true, driver);
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
		messageForm.submit();
		PageObjectLogging.log("writeOnChat", "Message: "+message+" written", true, driver);
		waitForElementByBy(By.xpath("//span[@class='message' and contains(text(), '"+message+"')]"));
		PageObjectLogging.log("writeOnChat", "Message: "+message+" is visible on chat board", true, driver);
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
//		Point p = privateMassageButton.getLocation();
//		CommonFunctions.MoveCursorToElement(p, driver);
//		CommonFunctions.ClickElement();
		executeScript("document.querySelectorAll('.private')[2].click()", driver);
		PageObjectLogging.log("selectPrivateMessage", "private message selected from dropdown", true, driver);
	}
	
	public void selectChatModStatus(WebDriver driver)
	{
		waitForElementByElement(giveChatModStatusButton);
		Point p = giveChatModStatusButton.getLocation();
		CommonFunctions.MoveCursorToElement(p, driver);
		CommonFunctions.ClickElement();
		PageObjectLogging.log("selectChatModStatus", "chat mod status is clicked", true, driver);
		try {
			Thread.sleep(1500);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	
	
	public void clickOnMainChat(WebDriver driver)
	{
//		Point p = mainChatButton.getLocation();
//		CommonFunctions.MoveCursorToElement(p, driver);
//		CommonFunctions.ClickElement();
		executeScript("document.querySelectorAll('.public.wordmark img.wordmark')[0].click()", driver);
		PageObjectLogging.log("clickOnMainChat", "main chat is clicked", true, driver);
	}
	

	
	public void clickOnPrivateChat(String user, WebDriver driver)
	{
//		By privateChatUserButton = By.xpath("//li[@id='priv-user-"+user+"']");
//		Point p = driver.findElement(privateChatUserButton).getLocation();
//		CommonFunctions.MoveCursorToElement(p, driver);
//		CommonFunctions.ClickElement();
		executeScript("document.querySelectorAll('#priv-user-"+user+"')[0].click()", driver);
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
//		WebElement e = driver.findElement(privateMessagesUserButton);
//		Point p = e.getLocation();
//		CommonFunctions.MoveCursorToElement(p, driver);		
//		CommonFunctions.ClickElement();
//		CommonFunctions.ClickElement();
		executeScript("document.querySelectorAll('#priv-user-"+userName+"')[0].click()", driver);
		executeScript("document.querySelectorAll('#priv-user-"+userName+"')[0].click()", driver);
		waitForElementByBy(userContextMenu);
		PageObjectLogging.log("clickPrivateMessageUser", "private messages user "+userName+" is clicked", true, driver);
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
		executeScript("document.querySelectorAll('#user-"+userName+"')[0].click()", driver);
//		executeScript("document.querySelectorAll('#user-"+userName+"')[0].click()", driver);
		PageObjectLogging.log("clickOnDifferentUser", userName+" button clicked", true, driver);
	}
	
	public void clickOnBlockedDifferentUser(String userName, WebDriver driver)
	{
		By userButton = By.xpath("//div[@class='Rail']//li[@id='user-"+userName+"']/img");
		waitForElementByBy(userButton);
		executeScript("document.querySelectorAll('#user-"+userName+"')[0].click()", driver);
		executeScript("document.querySelectorAll('#user-"+userName+"')[0].click()", driver);
		PageObjectLogging.log("clickOnDifferentUser", userName+" button clicked", true, driver);
	}
	
	
	/**
	 * @author Karol Kujawiak
	 * @param driver
	 * clicks on block private message button, should be executed after clickPrivateMessageUser()
	 */
	public void blockPrivateMessage(WebDriver driver)
	{
//		waitForElementByElement(blockPrivateMassageButton);
//		Point p = blockPrivateMassageButton.getLocation();
//		CommonFunctions.MoveCursorToElement(p, driver);		
//		CommonFunctions.ClickElement();
//		CommonFunctions.ClickElement();
		executeScript("document.querySelectorAll('.private-block')[0].click()", driver);
//		executeScript("document.querySelectorAll('.private-block')[0].click()", driver);
		PageObjectLogging.log("blockPrivateMessageFromUser", "private messages are blocked now", true, driver);
	}
	
	/**
	 * @author Karol Kujawiak
	 * @param userName
	 * @param driver
	 * clicks on allow private message button, should be executed after clickOnDifferentUser() method, if private messages from user were blocked in the past
	 */
	public void allowPrivateMessageFromUser(String userName, WebDriver driver)
	{
		
//		Point p = allowPrivateMassageButton.getLocation();
//		CommonFunctions.MoveCursorToElement(p, driver);
//		CommonFunctions.ClickElement();
		executeScript("document.querySelectorAll('.private-allow')[0].click()", driver);
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
		waitForElementByBy(userContextMenu);
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
	
}
