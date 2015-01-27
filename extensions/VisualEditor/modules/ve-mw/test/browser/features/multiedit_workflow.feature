# encoding: UTF-8
@chrome @edit_user_page_login @en.wikipedia.beta.wmflabs.org @firefox @login @test2.wikipedia.org
Feature: VisualEditor multi-edit workflow

  Goal of the test is to make sure the "Save" and "Review Changes"
  workflows are consistent even where a user makes multiple page
  edits in the same session.  See this bug ticket:
  https://bugzilla.wikimedia.org/show_bug.cgi?id=57654

  Not implemented as a Scenario outline since the goal is
  to test multiple page edits within a single session.

  Scenario: Make multiple edits to the same article
    Given I enter and save the first edit
    And I enter and save a second edit
    And I enter and save a third edit
    Then the saved page should contain all three edits.
