@chrome @en.wikipedia.beta.wmflabs.org @firefox @test2.wikipedia.org
Feature: VisualEditor Options

  Scenario:
    Given I go to the "Options VisualEditor Test" page with content "Options VisualEditor Test"
      And I click in the editable part
    When I click the hamburger menu
      And I click Options
    Then I should see the options overlay