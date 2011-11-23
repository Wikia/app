package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;
import java.util.*;

public class WallTest extends BaseTest {
	
	@Test(groups={"CI"})
	public void testPostingOnWall() throws Exception {
		openAndWait("wiki/Message_Wall:WikiaBot");
		
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
		openAndWait("wiki/Message_Wall:WikiaBot?reload");
		
		// make sure wall was loaded
		waitForElement("css=#Wall");
		
		// check again after refresh if messages were posted
		assertTrue(session().isTextPresent(msgbody));
		assertTrue(session().isTextPresent(replybody));
	}
	
	@Test(groups={"CI"})
	public void testCondensedThreads() throws Exception {
		openAndWait("wiki/Message_Wall:WikiaBot");
		
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
		openAndWait("wiki/Message_Wall:WikiaBot?reload");
		
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
		openAndWait("wiki/Message_Wall:WikiaBot");
		waitForWallEntryFields();
		
		// send new message
		writeNewPost("test message", msgbody);
		// check if there is new element on a page containing posted message
		assertTrue(session().isTextPresent(msgbody));
		
		//check if there is no edit link for user
		loginAsRegular();
		openAndWait("wiki/Message_Wall:WikiaBot");
		waitForWallEntryFields();
		assertTrue( !session().isElementPresent(firstMsg + " .edit-message") );
		
		msgbody = "ThisIsTestEditMessage: " + new Date().toString();
		
		// send new message
		writeNewPost("test message", msgbody);
		// check if there is new element on a page containing posted message
		assertTrue( session().isTextPresent(msgbody) );
		
		//check if there is no edit link for user
		assertTrue( session().isElementPresent(firstMsg + " .edit-message") );
		
		//reloads
		openAndWait("wiki/Message_Wall:WikiaBot?reload");
		waitForWallEntryFields();
		assertTrue( session().isElementPresent(firstMsg + " .edit-message") );
		
		//check if message title and body are the same after clicking edit button
		String prevTitle = session().getText(firstMsg + " .msg-title a");
		String prevBody = session().getText(firstMsg + " .msg-body");
		String titleArea = firstMsg + " .msg-title textarea:not([tabindex=-1])";
		String bodyArea = firstMsg + " .msg-body textarea:not([tabindex=-1])";
		String saveBtn = firstMsg + " .save-edit";
		
		session().click(firstMsg + " .edit-message");
		
		assertTrue( session().isElementPresent(titleArea) );
		assertTrue( session().isElementPresent(bodyArea) );
		assertTrue( session().isElementPresent(saveBtn) );
		assertTrue( session().isElementPresent(firstMsg + " .cancel-edit") );
		assertTrue( (session().getText(titleArea).equals(prevTitle)) );
		assertTrue( (session().getText(bodyArea).equals(prevBody)) );
		
		//edit the message
		session().type(titleArea, prevTitle + " (edited)");
		session().type(bodyArea, prevBody + " (edited)");
		session().click(saveBtn);
		
		assertTrue( session().isTextPresent(prevTitle + " (edited)") );
		assertTrue( session().isTextPresent(prevBody + " (edited)") );
		
		//reload and check if the new textes are still there
		openAndWait("wiki/Message_Wall:WikiaBot?reload2");
		waitForWallEntryFields();
		
		assertTrue( session().isTextPresent(prevTitle + " (edited)") );
		assertTrue( session().isTextPresent(prevBody + " (edited)") );
		
		//check if there is an edit link for staff
		logout();
		loginAsStaff();
		openAndWait("wiki/Message_Wall:WikiaBot");
		waitForWallEntryFields();
		assertTrue( session().isElementPresent(firstMsg + " .edit-message") );
	}
	
	private void writeNewPost(String title, String body) throws Exception {
		session().type("WallMessageTitle", title);
		session().type("WallMessageBody", body);
		session().click("css=#WallMessageSubmit");
		
		// make sure that it was send
		waitForElementNotPresent("css=textarea#WallMessageBody:contains('" + body + "')");
		waitForElementNotVisible("css=#WallMessageSubmit");
	}
	
	private void writeReplyToFirstMsg(String body) throws Exception {
		String firstmsg = "css=.comments > .message:first-child > .replies .new-reply ";
		
		session().type(firstmsg + "textarea:not([tabindex=-1])",body);
		session().click(firstmsg+ ".replyButton");
		
		// make sure it was send
		waitForElementNotVisible(firstmsg + ".replyButton");
	}
	
	private void waitForWallEntryFields() throws Exception {
		// make sure that the page is loaded
		waitForElement("css=textarea#WallMessageTitle");
		waitForElement("css=textarea#WallMessageBody");
		waitForElement("css=#WallMessageSubmit");
	}

}
