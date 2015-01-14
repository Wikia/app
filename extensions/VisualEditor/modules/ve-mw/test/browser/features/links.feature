@chrome @en.wikipedia.beta.wmflabs.org @firefox @login @test2.wikipedia.org
Feature: VisualEditor Links

  Background:
    Given I go to the "Links VisualEditor Test" page with content "Links VisualEditor Test"
      And I click in the editable part
      And I click the Link button
      And I can see the Link User Inteface

  Scenario: Enter external link
  When I enter http://www.example.com into link Content box
    And I click the blue text
    And I click < to close Link User Interface
    And I click Save page
    And I click Links Review your changes
  Then an external link appears in the diff view

  Scenario: Enter internal link
  When I enter Main Page into link Content box
    And I click the blue text for Matching Page
    And I click < to close Link User Interface
    And I click Save page
    And I click Links Review your changes
  Then an internal link appears in the diff view

  Scenario: Enter non-existing link
    When I enter DoesNotExist into link Content box
    And I click the blue text for New Page
    And I click < to close Link User Interface
    And I click Save page
    And I click Links Review your changes
    Then a non-existing link appears in the diff view
