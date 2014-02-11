@ie6-bug  @ie7-bug  @ie8-bug @ie9-bug @ie10-bug @login
Feature: VisualEditor cursor

  Background:
    Given I am logged in
      And I am at the cursor test page
      And I click Edit for VisualEditor

Scenario Outline: show hover icons
  When I send right arrow times <arrow_just_before>
    And I do not see the <not_on_page> hover icon
    And I send right arrow times 1
  Then I should see the <visible> hover icon
    And I do not see the <first_wrong> hover icon
    And I do not see the <second_wrong> hover icon
    And I send right arrow times 1
    And I do not see the <again_not_on_page> hover icon
Examples:
  | arrow_just_before | not_on_page  | visible       | first_wrong  | second_wrong | again_not_on_page |
  | 14                | References   | References    | Transclusion | Link         | References        |
  | 42                | Transclusion | Transclusion  | References   | Link         | Transclusion      |
  | 73                | Transclusion | Transclusion  | References   | Link         | Transclusion      |

# The last line of this scenario is different from the Outline above.
# Links text should be navigable and show the hover icon

Scenario: Cursor over link shows link icons
    When I send right arrow times 74
      And I do not see the Link hover icon
      And I send right arrow times 1
    Then I should see the Link hover icon
      And I do not see the References hover icon
      And I do not see the Transclusion hover icon
      And I send right arrow times 1
      And I should see the Link hover icon
