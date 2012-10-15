package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;
import java.util.*;


public class WallTest extends MiniEditorBaseTest {
	private String testWallDevboxUrl = "wiki/Message_Wall:WikiaBot?useskin=oasis";
	private String testWallUrl = "wiki/Message_Wall:QATestsBot?useskin=oasis";

	@Test(groups={"CI"})
	public void testPostingOnWall() throws Exception {
		openAndWait( getTestWallUrl() );
		
		String msgbody = "ThisIsTestMessageBody: " + new Date().toString();
		String replybody = "ThisIsTestReply: " + new Date().toString();
		
		// make sure that the page is loaded
		waitForElement("css=textarea#WallMessageTitle");
		waitForElement("css=textarea#WallMessageBody");
		waitForElement("css=#WallMessageSubmit");
		
		// send new message
		writeNewPost("test message", msgbody);
		// check if there is new element on a page containing posted message
		assertTrue(session().isTextPresent(msgbody));
		
		// post a reply
		writeReplyToFirstMsg(replybody);
		
		// check if there is a new element on page containing reply
		assertTrue(session().isTextPresent(replybody));
		
		// reload page
		openAndWait( getTestWallUrl() + "&reload" );
		
		// make sure wall was loaded
		waitForElement("css=#Wall");
		
		// check again after refresh if messages were posted
		assertTrue(session().isTextPresent(msgbody));
		assertTrue(session().isTextPresent(replybody));
	}
	
	@Test(groups={"CI"})
	public void testCondensedThreads() throws Exception {
		openAndWait( getTestWallUrl() );
		
		String msgbody = "CondensedThreadsTest: " + new Date().toString();
		String replybody = "ThisIsTestReply: " + new Date().toString();
		
		// make sure that the page is loaded
		waitForElement("css=textarea#WallMessageTitle");
		waitForElement("css=textarea#WallMessageBody");
		waitForElement("css=#WallMessageSubmit");
		
		// send new message
		writeNewPost("test message", msgbody);
		
		String firstmsg = "css=.comments > .message:first-child > .replies .new-reply ";
		
		for(int i=1; i<=5; ++i) {
			writeReplyToFirstMsg(replybody + " " + i);
		}
		
		// reload page
		openAndWait( getTestWallUrl() + "&reload" );
		
		// make sure wall was loaded
		waitForElement("css=#Wall");
		
		// check again after refresh if messages were posted
		assertTrue(session().isTextPresent(msgbody));
		assertTrue(session().isTextPresent("View all 5 replies"));
		assertTrue(session().isTextPresent(replybody + " 4"));
		assertTrue(session().isTextPresent(replybody + " 5"));
	}

	@Test(groups={"CI"})
	public void testEditMessage() throws Exception {
		String msgbody = "ThisIsTestEditMessage: " + new Date().toString();
		String firstMsg = "css=.comments > .message:first-child";
		
		//post a message as "A Wikia Contributor"
		logout();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		
		// send new message
		writeNewPost("test message", msgbody);
		// check if there is new element on a page containing posted message
		assertTrue(session().isTextPresent(msgbody));
		
		//check if there is no edit link for user
		loginAsRegular();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		assertTrue( !session().isElementPresent(firstMsg + " .edit-message") );
		
		msgbody = "TestEditMessage: " + new Date().toString();
		
		// send new message
		writeNewPost("test message " + new Date().toString(), msgbody);
		// check if there is new element on a page containing posted message
		assertTrue( session().isTextPresent(msgbody) );
		
		//check if there is edit link for user
		assertTrue( session().isElementPresent(firstMsg + " .edit-message") );
		
		//reloads
		openAndWait( getTestWallUrl() + "&reload" );
		waitForWallEntryFields();
		assertTrue( session().isElementPresent(firstMsg + " .edit-message") );
		
		//check if message title and body are the same after clicking edit button
		String prevTitle = session().getText(firstMsg + " .msg-title a");
		String prevBody = session().getText(firstMsg + " .msg-body");
				
		String saveBtn = firstMsg + " .save-edit";
		String bodyArea = "";
		String titleArea = "";
		
		session().click(firstMsg + " .edit-message");

		if(("true".equals(session().getEval("window.wgEnableMiniEditorExt")))){
			bodyArea = "//ul[@class='comments']/li[1]/blockquote";
			titleArea = firstMsg + " .msg-title textarea";
			
			// wait for editor to load
			waitForElement(firstMsg + " span.cke_buttons");
			// title textarea may load after editor is done loading
			waitForElement (titleArea);
			
			this.switchToSourceMode(bodyArea);
			
			assertTrue( this.getMiniEditorText(bodyArea).equals(prevBody) );
		} else {
			titleArea = firstMsg + " .msg-title textarea:nth-child(2)";
			bodyArea = firstMsg + " .msg-body textarea:not([tabindex=-1])";

			assertTrue( session().isElementPresent(titleArea) );
			assertTrue( session().isElementPresent(bodyArea) );
	
			assertTrue( (session().getText(bodyArea).equals(prevBody)) );	
		}

		assertTrue( session().isElementPresent(saveBtn) );
		assertTrue( session().isElementPresent(firstMsg + " .cancel-edit") );

		assertTrue( (session().getText(titleArea).equals(prevTitle)) );
		
		//edit the message
		session().type(titleArea, prevTitle + " (edited)");
		if ("true".equals(session().getEval("window.wgEnableMiniEditorExt"))) {
			this.miniEditorType(bodyArea, prevBody + " (edited)");			
		} else {
			session().type(bodyArea, prevBody + " (edited)");
		}

		session().click(saveBtn);
		
		// wait for follow link to reappear
		waitForElement(firstMsg + " .follow");
		waitForTextPresent(prevBody + " (edited)");
		assertTrue( session().isTextPresent(prevTitle + " (edited)") );
		
		//reload and check if the new textes are still there
		openAndWait( getTestWallUrl() + "&reload2" );
		waitForWallEntryFields();
		waitForElement(firstMsg);
		
		assertTrue( session().isTextPresent(prevTitle + " (edited)") );
		assertTrue( session().isTextPresent(prevBody + " (edited)") );
		
		//check if there is an edit link for staff
		logout();
		loginAsStaff();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		assertTrue( session().isElementPresent(firstMsg + " .edit-message") );
	}
	
	@Test(groups={"CI"})
	public void testEditReply() throws Exception {
		String msgbody = "ThisIsTestEditReply (message): " + new Date().toString();
		String firstMsg = "css=.comments > .message:first-child";
		String replybody = "ThisIsTestEditReply (reply): " + new Date().toString();
		String firstReply = firstMsg +" .replies .message:first-child";
		
		//post a message as "A Wikia Contributor"
		logout();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		
		//send new message
		writeNewPost("test message " + new Date().toString(), msgbody);
		//check if there is new element on a page containing posted message
		assertTrue( session().isTextPresent(msgbody) );
		
		//send new reply
		writeReplyToFirstMsg(replybody);
		//check if there is new element on a page containing posted reply
		assertTrue( session().isTextPresent(replybody) );
		
		//check if there is no edit link for user
		loginAsRegular();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		assertFalse( session().isElementPresent(firstReply + " .edit-message") );
		
		msgbody = "ThisIsTestEditReply (message): " + new Date().toString();
		replybody = "ThisIsTestEditReply (reply): " + new Date().toString();
		
		// send new message
		writeNewPost("test message " + new Date().toString(), msgbody);
		// check if there is new element on a page containing posted message
		assertTrue( session().isTextPresent(msgbody) );
		
		//send new reply
		writeReplyToFirstMsg(replybody);
		//check if there is new element on a page containing posted reply
		assertTrue( session().isTextPresent(replybody) );
		
		//check if there is an edit link for user's reply
		assertTrue( session().isElementPresent(firstReply + " .edit-message") );
		
		//reloads
		openAndWait( getTestWallUrl() + "&reload" );
		waitForWallEntryFields();
		assertTrue( session().isElementPresent(firstReply + " .edit-message") );

		String prevReplyBody = editFirstReply(" (reply edited)");
		
		waitForElement(firstReply + " .msg-body p");
		assertTrue( session().isTextPresent(prevReplyBody + " (reply edited)") );
		
		//reload and check if the new reply text is still there
		openAndWait( getTestWallUrl() + "&reload2" );
		waitForWallEntryFields();
		
		waitForElement(firstMsg);
		assertTrue( session().isTextPresent(prevReplyBody + " (reply edited)") );
		
		//check if there is an edit link for staff
		logout();
		loginAsStaff();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		assertTrue( session().isElementPresent(firstReply + " .edit-message") );
	}
	
	@Test(groups={"CI"})
	public void testNavigateToBrickPage() throws Exception {
		String msgbody = "ThisIsTestNavigateToBrickPage: " + new Date().toString();
		String replybody = "ThisIsTestReply: " + new Date().toString();
		String firstMsg = "css=.comments > .message:first-child";
		
		//post a message as "A Wikia Contributor"
		logout();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		
		writeNewPost("test message", msgbody);
		
		for(int i=1; i<=10; ++i) {
			writeReplyToFirstMsg(replybody + " " + i);
		}
		
		String msgTitle = session().getText(firstMsg + " .msg-title a");
		String msgBody = session().getText(firstMsg + " .msg-body");
		
		openAndWait( getTestWallUrl() + "&reload" );
		assertTrue( session().isElementPresent(firstMsg + " .msg-title a") );
		clickAndWait(firstMsg + " .msg-title a");
		
		assertTrue( session().isElementPresent("css=#WallBrickHeader > .WallName") );
		assertTrue( session().isElementPresent("css=#WallBrickHeader > .Title") );
		//assertEquals( session().getText("css=#WallBrickHeader > .Title"), msgTitle );
		assertTrue( session().getText("css=#WallBrickHeader > .Title").equals(msgTitle) );
		assertTrue( session().isElementPresent("css=#Wall > .comments > .SpeechBubble") );
		//make sure there are no condensed replies
		assertFalse( session().isElementPresent("css=#Wall > .comments > .replies > .load-more") );
	}
	
	@Test(groups={"CI"})
	public void testRemoveThreadFromWall() throws Exception {
		String newDate = new Date().toString();
		String msgTitle = "Test Message (removing thread from wall test) " + newDate;
		String msgBody = "ThisIsTestMessageBody: " + newDate;
		
		//post a message as "A Wikia Contributor"
		logout();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		//send new message
		writeNewPost(msgTitle, msgBody);
		//check if there is new element on a page containing posted message
		assertTrue( session().isTextPresent(msgTitle) );
		assertTrue( session().isTextPresent(msgBody) );
		
		String firstMsg = "css=.comments > .message:first-child";
		String buttons = firstMsg + " .buttons";
		String removeBtn = buttons + " .remove-message";
		
		//check if there is NO buttons' menu for anons
		assertFalse( session().isElementPresent(buttons) );
		
		//login as regular user
		loginAsRegular();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		
		//check if there IS buttons' menu for a regular user
		assertTrue( session().isElementPresent(buttons) );
		
		//check if there IS remove option
		assertTrue( session().isElementPresent(removeBtn) );
		session().click(removeBtn);
		
		//check if modal appeared
		String modal = "css=.modalContent";
		waitForElement(modal);
		
		checkModal(modal, msgBody, false, true);
		
		//click remove button
		session().click(modal + " #WikiaConfirmOk");
		verifyRemoveDelete(true, true, firstMsg);
		
		//undo removing
		session().click(firstMsg + " .message-undo-remove");
		
		waitForElement(firstMsg);
		checkIfMessageIsBack(firstMsg, msgBody, msgTitle);
		quickRemoveAndReload(removeBtn, modal, msgBody,  getTestWallUrl() + "&reload" );
		
		//check if there is NO our message
		waitForElement(firstMsg);
		assertFalse( session().getText(firstMsg + " .msg-title").equals(msgTitle) );
		assertFalse( session().getText(firstMsg + " .msg-body").equals(msgBody) );
	}
	
	@Test(groups={"CI"})
	public void testRemoveThreadFromThreadPage() throws Exception {
		String newDate = new Date().toString();
		String msgTitle = "Test Message (removing thread from thread page test) " + newDate;
		String msgBody = "ThisIsTestMessageBody: " + newDate;
		
		//just-in-case
		logout();
		
		//login as regular user
		loginAsRegular();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		
		//send a message
		writeNewPostAndForward(msgTitle, msgBody, getTestWallUrl() + "&reload" );
		
		session().click( "css=.msg-title a" );
		waitForWallThreadPageEntryField();
		
		String firstMsg = "css=.comments > .message:first-child";
		String buttons = firstMsg + " .buttons";
		String removeBtn = buttons + " .remove-message";
		
		//check if there IS buttons' menu for a regular user
		assertTrue( session().isElementPresent(buttons) );
		
		//check if there IS remove option
		waitForElement(removeBtn);
		assertTrue( session().isElementPresent(removeBtn) );
		session().click(removeBtn);
		
		//check if modal appeared
		String modal = "css=.modalContent";
		waitForElement(modal);
		
		checkModal(modal, msgBody, false, true);
		
		//click remove button and verify if thread disappeared
		session().click(modal + " #WikiaConfirmOk");
		verifyRemoveDelete(true, true, firstMsg);
		
		//undo removing
		session().click(firstMsg + " .message-undo-remove");
		waitForElement(firstMsg + ":not(.message-removed)");
		
		//check if message is back
		checkIfMessageIsBack(firstMsg, msgBody, msgTitle);
	}
	
	@Test(groups={"CI"})
	//Covers two UATs:
	//https://internal.wikia-inc.com/wiki/Message_Wall/Remove_and_Restore/UAT#Test_Case_01:_Remove_a_reply_from_thread_and_Undo
	//https://internal.wikia-inc.com/wiki/Message_Wall/Remove_and_Restore/UAT#Test_Case_02:_Remove_a_reply_from_a_thread_and_refresh
	public void testRemoveReply() throws Exception {
		String newDate = new Date().toString();
		String msgTitle = "Test Message (removing a reply test) " + newDate;
		String msgBody = "ThisIsTestMessageBody: " + newDate;
		
		//just-in-case
		logout();
		
		//login as regular user
		loginAsRegular();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		writeNewPostWithReplyAndForward(msgTitle, msgBody, getTestWallUrl() + "&reload" );
		
		String firstMsg = "css=.comments > .message:first-child";
		String firstMsgReplies = firstMsg + " .replies";
		String buttons = firstMsgReplies + " .buttons";
		String removeBtn = buttons + " .remove-message";
		
		//check if there IS buttons' menu for a regular user
		assertTrue( session().isElementPresent(buttons) );
		
		//check if there IS remove option
		assertTrue( session().isElementPresent(removeBtn) );
		session().click(removeBtn);
		
		//check if modal appeared
		String modal = "css=.modalContent";
		waitForElement(modal);
		
		checkModal(modal, msgBody, true, true);
		
		//click remove button and verify if thread disappeared
		session().click(modal + " #WikiaConfirmOk");
		verifyRemoveDelete(true, false, firstMsgReplies);
		
		//undo removing
		session().click(firstMsgReplies + " .message-undo-remove");
		waitForElement(firstMsgReplies + " .message:first-child:not(.message-removed)");
		
		//check if message is back
		assertFalse( session().isElementPresent(firstMsgReplies + " .speech-bubble-message-removed") );
		assertTrue( session().getText(firstMsgReplies + " .message:first-child .msg-body").equals(msgBody + " (reply)") );
	}
	
	@Test(groups={"CI"})
	public void testRemovedReplyPage() throws Exception {
		String newDate = new Date().toString();
		String msgTitle = "Test Message (removed reply page test) " + newDate;
		String msgBody = "ThisIsTestMessageBody: " + newDate;
		
		//just-in-case
		logout();
		
		//login as regular user
		loginAsRegular();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		writeNewPostWithReplyAndForward(msgTitle, msgBody, getTestWallUrl() + "&reload" );
		
		String firstMsg = "css=.comments > .message:first-child";
		String firstMsgReplies = firstMsg + " .replies";
		String buttons = firstMsgReplies + " .buttons";
		String removeBtn = buttons + " .remove-message";
		String threadHistoryBtn = firstMsg + " .thread-history";
		String modal = "css=.modalContent";
		
		session().click(removeBtn);
		waitForElement(modal);
		session().type("reason", msgBody);
		session().click(modal + " #WikiaConfirmOk");
		clickAndWait(threadHistoryBtn);
		
		//we want to be sure if the list is sorted from newest to oldest
		String currentUrl = session().getLocation();
		openAndWait(currentUrl + "&sort=nf");
		
		String removedReplyLink = "css=#WallThreadHistory a:nth-child(3)";
		waitForElement(removedReplyLink);
		clickAndWait(removedReplyLink);
		
		//check if the url has #2 at the end
		currentUrl = session().getLocation();
		String anchor = currentUrl.substring(currentUrl.lastIndexOf("#"));
		assertTrue( anchor.equals("#2") );
		
		String removedReply = firstMsgReplies + " .message-removed";
		waitForElement(removedReply);
		assertTrue( session().isElementPresent(removedReply + " .deleteorremove-infobox") );
		assertTrue( session().isElementPresent(removedReply + " .deleteorremove-bubble .avatar") );
		//usersname of a user who removed the message
		assertTrue( session().isElementPresent(removedReply + " .deleteorremove-bubble .message a:first-child") );
		assertTrue( session().isElementPresent(removedReply + " .deleteorremove-bubble .message .reason") );
		assertTrue( session().isElementPresent(removedReply + " .deleteorremove-bubble .message .timestamp") );
		assertTrue( session().isElementPresent(removedReply + " .message-restore") );
		//is the removal reason correct
		assertTrue( session().getText(removedReply + " .deleteorremove-bubble .message .reason").equals(msgBody) );
		//is there full original removed reply
		assertTrue( session().isElementPresent(removedReply + " .speech-bubble-avatar") );
		assertTrue( session().isElementPresent(removedReply + " .speech-bubble-message a:first-child") );
		assertTrue( session().isElementPresent(removedReply + " .speech-bubble-message .msg-body") );
		assertTrue( session().isElementPresent(removedReply + " .speech-bubble-message .timestamp") );
		//is the text of removed message correct
		assertTrue( session().getText(removedReply + " .speech-bubble-message .msg-body").equals(msgBody + " (reply)") );
	}

	@Test(groups={"CI"})
	public void testAdminDeleteThread() throws Exception {
		String newDate = new Date().toString();
		String msgTitle = "Test Message (admin delete thread test) " + newDate;
		String msgBody = "ThisIsTestMessageBody: " + newDate;
		
		//just-in-case
		logout();
		
		//login as regular user
		//and post a message
		loginAsRegular();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		writeNewPost(msgTitle, msgBody);
		
		//login as admin
		//and check if there IS NOT "Delete" option
		logout();
		loginAsSysop();
		openAndWait( getTestWallUrl() );
		waitForWallEntryFields();
		
		String firstMsg = "css=.comments > .message:first-child";
		String buttons = firstMsg + " .buttons";
		String removeBtn = buttons + " .remove-message";
		String adminDeleteBtn = buttons + " .admin-delete-message";
		String threadPageLink = session().getAttribute(firstMsg + " .msg-title a:first-child@href");
		String modal = "css=.modalContent";
		
		assertFalse( session().isElementPresent(adminDeleteBtn) );
		
		//open thread page, remove thread and refresh page
		openAndWait( threadPageLink );
		waitForElement(removeBtn);
		quickRemoveAndReload(removeBtn, modal, msgBody, threadPageLink + "?reload");
		
		//check if there IS "Delete" option
		assertTrue( session().isElementPresent(adminDeleteBtn) );
		
		//delete the thread
		session().click(adminDeleteBtn);
		waitForElement(modal);
		checkModal(modal, msgBody, false, false);
		session().click(modal + " #WikiaConfirmOk");
		
		waitForElement(firstMsg + " .speech-bubble-message-removed");
		assertTrue( session().isElementPresent(firstMsg + " .speech-bubble-message-removed") );
		assertTrue( session().isElementPresent(firstMsg + " .message-undo-remove") );
		assertTrue( session().isTextPresent("This thread has been deleted.") );
		assertFalse( session().isElementPresent(firstMsg + " .msg-title") );
		
		//undo
		session().click(firstMsg + " .message-undo-remove");
		checkIfDeletedMessageIsBack(firstMsg, msgBody, msgTitle);
		
		//delete the thread again and reload the page
		session().click(adminDeleteBtn);
		waitForElement(modal);
		checkModal(modal, msgBody, false, false);
		session().click(modal + " #WikiaConfirmOk");
		openAndWait(threadPageLink + "?reload2");
		
		assertTrue( session().isTextPresent("The message you are trying to view has been deleted.") );
		
		if( isDevBox() ) {
		//TODO: remove this condition when UserRanemTool starts working 
		//and WikiaBot will be renamed to QATestsBot on devboxes
			assertTrue( session().isElementPresent("//div[@id='WikiaArticle']/a[contains(@href,'Message_Wall:WikiaBot')]") );
		} else {
			assertTrue( session().isElementPresent("link=Return to QATestsBot's Wall.") );
		}
		
		assertTrue( session().isElementPresent("link=(View/Restore)") );
		
		session().click("link=(View/Restore)");
		checkIfDeletedMessageIsBack(firstMsg, msgBody, msgTitle);
		
		//check deleteremoveinfobox
		assertTrue( session().isElementPresent(firstMsg + " .deleteorremove-bubble .message a:first-child") );
		assertTrue( session().isElementPresent(firstMsg + " .deleteorremove-bubble .message .reason") );
		assertTrue( session().isElementPresent(firstMsg + " .deleteorremove-bubble .message .timestamp") );
		assertTrue( session().isElementPresent(firstMsg + " .message-restore") );
		assertTrue( session().getText(firstMsg + " .deleteorremove-bubble .message .reason").equals(msgBody) );
		assertFalse( session().isVisible(firstMsg + " .new-reply") );
		
		//restore
		session().click(firstMsg + " .message-restore");
		waitForElement(firstMsg + " .new-reply");
		
		// wait for element to fade in
		Thread.sleep(1000);
		assertTrue( session().isVisible(firstMsg + " .new-reply") );
	}

	
	private void writeNewPost(String title, String body) throws Exception {
		session().type("WallMessageTitle", title);
		if(("true".equals(session().getEval("window.wgEnableMiniEditorExt")))){
			this.loadEditor("//div[@id='wall-new-message']", false);
			this.switchToSourceMode("//div[@id='wall-new-message']");
			this.miniEditorType("//div[@id='wall-new-message']", body);			
		} else {
			session().type("WallMessageBody", body);			
		}

		session().click("css=#WallMessageSubmit");
	
		// make sure that it was send
		waitForElementNotPresent("css=textarea#WallMessageBody:contains('" + body + "')");
		waitForElementNotVisible("css=#WallMessageSubmit");
		
		waitForElement("//ul[@class='comments']" +
				"/li[1 and contains(@class,'SpeechBubble')]" +
				"//p[contains(text(), '" + body + "')]");		
	}
	
	private void writeNewPostAndForward(String title, String body, String url) throws Exception {
		writeNewPost(title, body);
		openAndWait(url);
	}
	
	private void writeReplyToFirstMsg(String body) throws Exception {
		String firstmsg = "css=.comments > .message:first-child > .replies .new-reply ";
		String firstmsg_xpatch = "//ul[@class='comments']//li[1]/ul/li";
		
		if(("true".equals(session().getEval("window.wgEnableMiniEditorExt")))){
			this.loadEditor(firstmsg_xpatch, false);
			this.switchToSourceMode(firstmsg_xpatch);
			this.miniEditorType(firstmsg_xpatch, body);			
		} else {
			session().type(firstmsg + "textarea:not([tabindex=-1])",body);	
		}
		
		session().click(firstmsg+ ".replyButton");
		
		// make sure it was send
		waitForElementNotVisible(firstmsg + ".replyButton");
	}
	
	private String editFirstReply(String add) throws Exception {
		String firstReply = "css=.comments > .message:first-child  .replies .message:first-child";
		String firstReply_xpatch = "//ul[@class='comments']//li[1]/ul/li[1]";

		String prevReplyBody = "";
		
		String saveBtn = firstReply_xpatch + "//button[contains(@class,'save-edit')]";
		
		session().click(firstReply_xpatch + "//li//a[1 and @class='edit-message']");
		
		//check if message title and body are the same after clicking edit button

		if(("true".equals(session().getEval("window.wgEnableMiniEditorExt")))){
			waitForMiniEditor(firstReply_xpatch);
			 this.switchToSourceMode(firstReply_xpatch);
			 prevReplyBody = this.getMiniEditorText(firstReply_xpatch);
			 this.miniEditorType(firstReply_xpatch, prevReplyBody + add);
			 
			session().click(saveBtn);
			waitForElementVisible(firstReply_xpatch + "//div[@class='editarea']//div[contains(@class,'msg-body')]" );			 
		} else {
			prevReplyBody = session().getText(firstReply + " .msg-body");
			String replyBodyArea = firstReply + " .msg-body textarea:not([tabindex=-1])";
			
			assertTrue( session().isElementPresent(replyBodyArea) );
			assertTrue( session().isElementPresent(saveBtn) );
			assertTrue( session().isElementPresent(firstReply + " .cancel-edit") );
			//assertEquals( session().getText(replyBodyArea), prevReplyBody );
			assertTrue( session().getText(replyBodyArea).equals(prevReplyBody) );			
			//edit the message
			session().type(replyBodyArea, prevReplyBody + add);
			session().click(saveBtn);
		}
		
		return prevReplyBody;
	}
	
	private void writeNewPostWithReplyAndForward(String title, String body, String url) throws Exception {
		writeNewPost(title, body + " (top message)");
		writeReplyToFirstMsg(body + " (reply)");
		openAndWait(url);
	}
	
	private void waitForWallEntryFields() throws Exception {
		// make sure that the page is loaded
		waitForElement("css=textarea#WallMessageTitle");
		waitForElement("css=textarea#WallMessageBody");
		waitForElement("css=#WallMessageSubmit");
	}
	
	private void waitForWallThreadPageEntryField() throws Exception {
		waitForElement("css=.new-reply textarea");
		waitForElement("css=.replyButton");
	}
	
	private void checkModal(String modal, String reasonText, Boolean isReply, Boolean isRemove) throws Exception {
		assertTrue( session().isElementPresent(modal + " #reason") );
		assertTrue( session().isElementPresent(modal + " #WikiaConfirmCancel") );
		assertTrue( session().isElementPresent(modal + " #notify-admin") );
		//and if remove button is grayed
		assertTrue( session().isElementPresent(modal + " #WikiaConfirmOk[disabled=disabled]") );
		
		//write reason text and check if remove button is active
		session().type("reason", reasonText);
		assertFalse( session().isElementPresent(modal + " #WikiaConfirmOk[disabled=disabled]") );
		
		if( isReply && isRemove ) {
			assertTrue( session().isTextPresent("Remove this reply") );
		} else if( !isReply && isRemove ) {
			assertTrue( session().isTextPresent("Remove this thread") );
		} else if( isReply && !isRemove ) {
			assertTrue( session().isTextPresent("Delete this reply") );
		} else { //!isReply && !isRemove
			assertTrue( session().isTextPresent("Delete this thread") );
		}
	}
	
	private void verifyRemoveDelete(Boolean isRemove, Boolean isThread, String message) throws Exception {
		waitForElement(message + " .speech-bubble-message-removed");
		assertTrue( session().isElementPresent(message + " .speech-bubble-message-removed") );
		assertTrue( session().isElementPresent(message + " .message-undo-remove") );
		
		if( isThread && isRemove ) {
			assertTrue( session().isTextPresent("This thread has been removed.") );
			assertFalse( session().isElementPresent(message + " .msg-title") );
		} else if( !isThread && isRemove ) {
			assertTrue( session().isTextPresent("This reply has been removed.") );
		} else if( isThread && !isRemove ) {
			assertTrue( session().isTextPresent("This thread has been deleted.") );
			assertFalse( session().isElementPresent(message + " .msg-title") );
		} else { //!isThread && !isRemove
			assertTrue( session().isTextPresent("This reply has been deleted.") );
		}
	}
	
	private void quickRemove(String removeBtn, String modal, String msgBody) throws Exception {
		session().click(removeBtn);
		waitForElement(modal);
		session().type("reason", msgBody);
		session().click(modal + " #WikiaConfirmOk");
	}
	
	private void quickRemoveAndReload(String removeBtn, String modal, String msgBody, String url) throws Exception {
		quickRemove(removeBtn, modal, msgBody);
		openAndWait(url);
	}
	
	private void checkIfMessageIsBack(String message, String content, String title) throws Exception {
		waitForElement( message + " .msg-title");
		assertFalse( session().isElementPresent(message + " .speech-bubble-message-removed") );
		//assertTrue( session().isElementPresent( message + " .msg-title" ) );
		assertTrue( session().getText(message + " .msg-body").equals(content) );
		
		if( !title.equals("") ) {
			assertTrue( session().getText(message + " .msg-title").equals(title) );
		}
	}
	
	private void checkIfDeletedMessageIsBack(String message, String body, String title) throws Exception {
		String deleteremoveBox = message + " .deleteorremove-infobox";
		waitForElement(deleteremoveBox);
		assertTrue( session().isVisible(deleteremoveBox) );
		assertTrue( session().isElementPresent(message + " .msg-title") );
		assertTrue( session().getText(message + " .msg-body").equals(body) );
		
		if( !title.equals("") ) {
			assertTrue( session().getText(message + " .msg-title").equals(title) );
		}
	}
	
	private String getTestWallUrl() {
		if( isDevBox() ) {
			//WikiaBot is the old name of production's user QATestsBot on devboxes
			return testWallDevboxUrl;
		} else {
			return testWallUrl;
		}
	}
	
}
