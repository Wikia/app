@chrome @en.wikipedia.beta.wmflabs.org @firefox @login @test2.wikipedia.org
Feature: VisualEditor References

  Background:
    Given I go to a page that has references
      And I click in the editable part

  Scenario: Creating VisualEditor Reference
    Given I click Reference
      And I can see the References User Interface
    When I enter THIS IS CONTENT into Content box
      And I click Insert reference
    Then link to Insert menu should be visible

  Scenario: Reusing an existing reference
    When I edit the page with Some content related to existing reference
      And I create a reference using existing reference
    Then first link to reference should be visible
      And second link to reference should be visible

