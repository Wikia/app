@ie6-bug  @ie7-bug  @ie8-bug @ie9-bug @ie10-bug @test2.wikipedia.org @login
Feature: VisualEditor References

  Background:
    Given I am logged in
      And I am at my user page
      When I click Edit for VisualEditor
      And I click Reference

  Scenario: Type into boxes
    Given I can see the References User Interface
    When I enter THIS IS CONTENT into Content box
      And I click Insert reference
    Then link to references dialog should be visible
