@en.wikipedia.beta.wmflabs.org @firefox @internet_explorer_10 @login @safari @test2.wikipedia.org
Feature: VisualEditor Cite

  Background:
    Given I go to the "Cite VisualEditor Test" page with content "Cite VisualEditor Test"
      And I click in the editable part
      And I click the Cite button
      And I can see the Cite User Interface

  Scenario: Website
    When I click Website
      And I fill in the first textarea with "http://en.wikipedia.org/"
      And I fill in the second textarea with "Website Source title"
      And I fill in the third textarea with "Website Source date 28 July 2014"
      And I fill in the fourth textarea with "28 July 2014"
      And I fill in the fifth textarea with "Website title"
      And I fill in the sixth textarea with "Website publisher"
      And I fill in the seventh textarea with "Website Last name"
      And I fill in the eighth textarea with "Website First name"
      And the Website input field titles are in the correct order
      And I click Add more information
      And I see Show more fields
      And I type in a field name "New website field"
      And I click the new field label
      And I fill in the new field "New website field contents"
      And I click Insert Citation
      And I click Save page
      And I click Review your changes
    Then diff view should show the Website citation added

  Scenario: Book
    When I click Book
      And I fill in the first textarea with "Book title"
      And I fill in the second textarea with "Book author last name"
      And I fill in the third textarea with "Book author first name"
      And I fill in the fourth textarea with "Book publisher"
      And I fill in the fifth textarea with "2014"
      And I fill in the sixth textarea with "9780743273565"
      And I fill in the seventh textarea with "Location of publication"
      And I fill in the eighth textarea with "123"
      And the Book input field titles are in the correct order
      And I click Add more information
      And I type in a field name "New book field"
      And I click the new field label
      And I fill in the new field "New book field contents"
      And I click Insert Citation
      And I click Save page
      And I click Review your changes
    Then diff view should show the Book citation added

  Scenario: News
    When I click News
      And I fill in the first textarea with "News URL"
      And I fill in the second textarea with "News Source title"
      And I fill in the third textarea with "News Last name"
      And I fill in the fourth textarea with "News First name"
      And I fill in the fifth textarea with "News Source date"
      And I fill in the sixth textarea with "News Work"
      And I fill in the seventh textarea with "News URL access date"
      And the News input field titles are in the correct order
      And I click Insert Citation
      And I click Save page
      And I click Review your changes
  Then diff view should show the News citation added

  Scenario: Journal
    When I click Journal
      And I fill in the first textarea with "Journal title"
      And I fill in the second textarea with "Journal Source date"
      And the Journal input field titles are in the correct order
      And I click Insert Citation
      And I click Save page
      And I click Review your changes
  Then diff view should show the Journal citation added

  Scenario: Basic
    When I click Basic
    Then I should see the VisualEditor interface
      And I should see the Options use this group text
      And I should see the General references