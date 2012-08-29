package com.wikia.webdriver.TestCases;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.Common.Templates.TestTemplate_Two_Drivers;
import com.wikia.webdriver.PageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.PageObjects.PageObject.ChatPageObject.ChatPageObject;

public class ChatTests extends TestTemplate_Two_Drivers{

	
	
	
	/*
	 *  Test 1: One user opens chat Edit

    1. A user opens Special:Chat. He is the only person on-line.
    2. The main chat room is opened for him and he can see: message area, userlist and entry field.
    3. At the top of message area is wiki's wordmark/name.
    4. At the top of userlist he sees his avatar and name. Below that is a list of other users which is empty.
    5. There is no chevron next to the wiki wordmark on userlist.
    6. In the message area a message with his name appears: "user A has joined the chat." 
    
    dropped from automation scope - this test case will be executed as a part of all test cases.
	 */


	/*
	 *  Test 2: Two users open chat Edit

    1. There are two users: user A and user B.
    2. Both open Special:Chat on the same wiki.
    3. The main chat room is opened for them and each can see: message area, userlist and entry field.
    4. At the top of message area is wiki's wordmark/name.
    5. At the top of userlist each user can see his avatar and name. Below that is a list of other users in the chat room.
    6. There is a chevron next to the wiki wordmark on userlist. It is opened by default.
    7. A user can click on the chevron to toggle userlist.
    8. In the message area both users see a message with his name: "user A has joined the chat." or "user B has joined the chat." 
	 */
	@Test
	public void Chat_001_two_users_open_chat()
	{
		//first user opens the chat
		HomePageObject home = new HomePageObject(driver);
		CommonFunctions.logOut(Properties.userName, driver);
		home.openHomePage();
		CommonFunctions.logIn(Properties.userName, Properties.password, driver);
		ChatPageObject chat1 = new ChatPageObject(driver);
		chat1.openChatPage();
		chat1.verifyChatPage();
		//second user opens the chat		
		HomePageObject home2 = new HomePageObject(driver2);
		CommonFunctions.logOut(Properties.userName, driver2);
		home2.openHomePage();
		CommonFunctions.logIn(Properties.userName2, Properties.password2, driver2);
		ChatPageObject chat2 = new ChatPageObject(driver2);
		chat2.openChatPage();
		chat2.verifyChatPage();
		chat1.verifyUserJoinToChat(Properties.userName2);		
	}
	
	/*
	 *  Test 3: Changes in drop-down menu #1
	1. User clicks on a different user name with left mouse button. Drop-down menu appears.
    2. There are three options to choose: User Profile Message Wall, Contributions, Private message.
    3. If user is an admin there should be also: Give ChatMod status and Kickban (if clicked user is not a chat moderator or admin).
	 */
	
	@Test
	public void Chat_002_changes_in_drop_down_menu_1()
	{
		//first user opens the chat
		HomePageObject home = new HomePageObject(driver);
		CommonFunctions.logOut(Properties.userName, driver);
		home.openHomePage();
		CommonFunctions.logIn(Properties.userName, Properties.password, driver);
		ChatPageObject chat1 = new ChatPageObject(driver);
		//second user opens the chat		
		HomePageObject home2 = new HomePageObject(driver2);
		CommonFunctions.logOut(Properties.userName, driver2);
		home2.openHomePage();
		CommonFunctions.logIn(Properties.userName2, Properties.password2, driver2);
		ChatPageObject chat2 = new ChatPageObject(driver2);
		chat2.openChatPage();
		chat1.openChatPage();
		chat1.verifyChatPage();
		chat1.clickOnDifferentUser(Properties.userName2, driver);
		chat1.verifyNormalUserDropdown();
	}
	
	/*
	 *   Test 4: Changes in drop-down menu #2
	1. There are two users in the chat room: user A and user B. User B private message are blocked by user A.
    2. User A clicks with a left mouse button on user B name. Drop-down menu appears.
    3. There are three options to choose: User Profile, Contributions, Allow Private Messages.
    4. If user A is an admin there should be also Give ChatMod status and Kickban (if clicked user is not a chat moderator or admin). - to next test case 
	 */
	
	@Test
	public void Chat_003_changes_in_drop_down_menu_2()
	{
		//first user opens the chat
		HomePageObject home = new HomePageObject(driver);
		CommonFunctions.logOut(Properties.userName, driver);
		home.openHomePage();
		CommonFunctions.logIn(Properties.userName, Properties.password, driver);
		ChatPageObject chat1 = new ChatPageObject(driver);
		//second user opens the chat		
		HomePageObject home2 = new HomePageObject(driver2);
		CommonFunctions.logOut(Properties.userName, driver2);
		home2.openHomePage();
		CommonFunctions.logIn(Properties.userName2, Properties.password2, driver2);
		ChatPageObject chat2 = new ChatPageObject(driver2);
		chat2.openChatPage();
		chat1.openChatPage();
		chat1.verifyChatPage();
		chat1.clickOnDifferentUser(Properties.userName2, driver);
		chat1.selectPrivateMessage(driver);
		chat1.clickPrivateMessageUser(Properties.userName2, driver);
		chat1.blockPrivateMessage(driver);
		chat1.clickOnDifferentUser(Properties.userName2, driver);
		chat1.verifyBlockedUserDropdown(Properties.userName2);
		chat1.allowPrivateMessageFromUser(Properties.userName2, driver);
	}
	
	/*
	 *   Test 4: Changes in drop-down menu #2 - KICKBAN verification
	1. There are two users in the chat room: user A and user B. User B private message are blocked by user A.
    2. User A clicks with a left mouse button on user B name. Drop-down menu appears.
    3. There are three options to choose: User Profile, Contributions, Allow Private Messages.
    4. If user A is an admin there should be also Give ChatMod status and Kickban (if clicked user is not a chat moderator or admin). 
	 */
	
	@Test
	public void Chat_004_changes_in_drop_down_menu_staff_2()
	{
		//first user opens the chat
		HomePageObject home = new HomePageObject(driver);
		CommonFunctions.logOut(Properties.userName, driver);
		home.openHomePage();
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff, driver);
		ChatPageObject chat1 = new ChatPageObject(driver);
		//second user opens the chat		
		HomePageObject home2 = new HomePageObject(driver2);
		CommonFunctions.logOut(Properties.userName, driver2);
		home2.openHomePage();
		CommonFunctions.logIn(Properties.userName2, Properties.password2, driver2);
		ChatPageObject chat2 = new ChatPageObject(driver2);
		chat2.openChatPage();
		chat1.openChatPage();
		chat1.verifyChatPage();
		chat1.clickOnDifferentUser(Properties.userName2, driver);
		chat1.verifyAdminUserDropdown();
	}
	
	
	/*
	 *    Test 5: "Private Messages" bar
	1. There are two users in the chat room: user A and user B. No "Private Message" bar.
    2. User B opens a private room with user A.
    3. The small header labeled "Private Message" appears on user B's userlist. 
	 */
	
	@Test
	public void Chat_005_private_messages_bar()
	{
		//first user opens the chat
		HomePageObject home = new HomePageObject(driver);
		CommonFunctions.logOut(Properties.userName, driver);
		home.openHomePage();
		CommonFunctions.logIn(Properties.userName, Properties.password, driver);
		ChatPageObject chat1 = new ChatPageObject(driver);
		//second user opens the chat		
		HomePageObject home2 = new HomePageObject(driver2);
		CommonFunctions.logOut(Properties.userName, driver2);
		home2.openHomePage();
		CommonFunctions.logIn(Properties.userName2, Properties.password2, driver2);
		ChatPageObject chat2 = new ChatPageObject(driver2);
		chat2.openChatPage();
		chat1.openChatPage();
		chat1.verifyChatPage();
		chat1.clickOnDifferentUser(Properties.userName2, driver);
		chat1.selectPrivateMessage(driver);
		chat1.verifyPrivateMessageHeader();
	}	
}
