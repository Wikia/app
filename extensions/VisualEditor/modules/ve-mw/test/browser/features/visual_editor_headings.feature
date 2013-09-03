@ie6-bug  @ie7-bug  @ie8-bug  @ie9-bug @ie10-bug @test2.wikipedia.org @login
Feature: VisualEditor Headings

  Background: Open VE and edit page with string
    Given I am logged in
      And I am at my user page
      And I click Edit for VisualEditor
     When I edit the page with a string
       And I click the down arrow on Headings interface
    When I edit the page with a string
      And I click the down arrow on Headings interface

  Scenario: Choose Paragraph Heading
    When I click Paragraph
       And I click Save page
       And I click Review your changes
    Then a paragraph should appear in the diff view

  Scenario: Choose Heading Headinge
    When I click Heading
     And I click Save page
     And I click Review your changes
   Then a heading should appear in the diff view

  Scenario: Choose Subheading1 Heading
    When I click Sub-Heading1
      And I click Save page
      And I click Review your changes
    Then a sub-heading1 should appear in the diff view

  Scenario: Choose Sub-Heading2 Heading
    When I edit the page with a string
    And I click the down arrow on Headings interface
    And I click Sub-Heading2
    And I click Save page
    And I click Review your changes
    Then a sub-heading2 should appear in the diff view
    And I should be able to click the up arrow on the save box

  Scenario: Choose Sub-Heading3 Heading
    When I edit the page with a string
    And I click the down arrow on Headings interface
    And I click Sub-Heading3
    And I click Save page
    And I click Review your changes
    Then a sub-heading3 should appear in the diff view
    And I should be able to click the up arrow on the save box

  Scenario: Choose Sub-Heading4 Heading
    When I edit the page with a string
    And I click the down arrow on Headings interface
    And I click Sub-Heading4
    And I click Save page
    And I click Review your changes
    Then a sub-heading4 should appear in the diff view
    And I should be able to click the up arrow on the save box

  Scenario: Choose Preformatted Heading
    When I edit the page with a string
    And I click the down arrow on Headings interface
    And I click Preformatted
    And I click Save page
    And I click Review your changes
    Then a Preformatted should appear in the diff view
    And I should be able to click the up arrow on the save box

  Scenario: Choose Page title Heading
    When I edit the page with a string
    And I click the down arrow on Headings interface
    And I click Page title
    And I click Save page
    And I click Review your changes
    Then a Page title should appear in the diff view
    And I should be able to click the up arrow on the save box

  Scenario: Choose Subheading1 Heading
    When I click Sub-Heading1
      And I click Save page
      And I click Review your changes
    Then a sub-heading1 should appear in the diff view

  Scenario: Choose Sub-Heading2 Heading
    When I click Sub-Heading2
      And I click Save page
      And I click Review your changes
    Then a sub-heading2 should appear in the diff view

  Scenario: Choose Sub-Heading3 Heading
    When I click Sub-Heading3
      And I click Save page
      And I click Review your changes
    Then a sub-heading3 should appear in the diff view

  Scenario: Choose Sub-Heading4 Heading
    When I click Sub-Heading4
      And I click Save page
      And I click Review your changes
    Then a sub-heading4 should appear in the diff view

  Scenario: Choose Preformatted Heading
    When I click Preformatted
      And I click Save page
      And I click Review your changes
    Then a Preformatted should appear in the diff view

  Scenario: Choose Page title Heading
    When I click Page title
      And I click Save page
      And I click Review your changes
    Then a Page title should appear in the diff view
