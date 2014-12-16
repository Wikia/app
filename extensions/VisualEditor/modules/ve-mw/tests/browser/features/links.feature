@en.wikipedia.beta.wmflabs.org @firefox @internet_explorer_10 @login @safari @test2.wikipedia.org
Feature: VisualEditor Links

  Background:
    Given I go to the "Links VisualEditor Test" page with content "Links VisualEditor Test"
      And I click in the editable part
      And I click the Link button
      And I can see the Link User Inteface

  Scenario: Enter external link
  When I enter external link http://www.example.com into link Content box
    And I click Done to close Link User Interface
    And I click Save page
    And I click Review your changes
  Then an external link appears in the diff view

  Scenario: Enter internal link
  When I enter internal link Main Page into link Content box
    And I click Done to close Link User Interface
    And I click Save page
    And I click Review your changes
  Then an internal link appears in the diff view

  Scenario: Enter non-existing link
    When I enter non existing link DoesNotExist into link Content box
    And I click Done to close Link User Interface
    And I click Save page
    And I click Review your changes
  Then a non-existing link appears in the diff view
