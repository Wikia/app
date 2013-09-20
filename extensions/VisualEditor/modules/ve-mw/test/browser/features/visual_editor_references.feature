@ie6-bug  @ie7-bug  @ie8-bug @ie9-bug @ie10-bug @test2.wikipedia.org @en.wikipedia.beta.wmflabs.org @login
Feature: VisualEditor References

    Given I am logged in
      And I am at my user page
    When I click Edit for VisualEditor
      And I click Reference
      And I can see the References User Interface
      And I enter THIS IS CONTENT into Content box
      And I click Insert reference
    Then link to More menu should be visible
