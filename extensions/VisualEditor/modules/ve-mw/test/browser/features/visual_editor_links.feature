@ie6-bug  @ie7-bug  @ie8-bug  @ie9-bug @ie10-bug @en.wikipedia.beta.wmflabs.org @test2.wikipedia.org @login
Feature: VisualEditor Links

  Background:
    Given I am logged in
      And I am at my user page
    When I click Edit for VisualEditor
      And I click the Link button

  Scenario: Enter external link
  Given I can see the Link User Inteface
  When I enter http://www.example.com into link Content box
    And I click the blue text
    And I click < to close Link User Interface
    And I click Save page
    And I click Review your changes
  Then an external link appears in the diff view

  Scenario: Enter internal link
  Given I can see the Link User Inteface
  When I enter Main Page into link Content box
    And I click the blue text for Matching Page
    And I click < to close Link User Interface
    And I click Save page
    And I click Review your changes
  Then an internal link appears in the diff view

  Scenario: Enter non-existing link
    Given I can see the Link User Inteface
    When I enter DoesNotExist into link Content box
    And I click the blue text for New Page
    And I click < to close Link User Interface
    And I click Save page
    And I click Review your changes
    Then a non-existing link appears in the diff view
