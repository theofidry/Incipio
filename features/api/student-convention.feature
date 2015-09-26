
Feature: Student-convention
  this refere to an offial document 
  a user may have a student convention


  Background:
    Given I authenticate myself as admin

#START -----Filter validation-----

  Scenario: get all student convention for a mandate
  #TODO

  Scenario: get all student without student convention for a mandate
  #TODO

  Scenario: get all contractor without student convention (ie anomaly)
  #TODO

#END -----Filter validation-----


#START -----Crud validation-----

  Scenario: I should be able to access to a student convention
#    When I send a GET request to "/api/student-conventions/1"
#    Then I get a resource page with the context "api/contexts/StudentConvention"
#    Then the JSON node ("[^"]+"|'[^']+'|\w+([.,]\w+)) should be equal to ("[^"]+"|'[^']+'|\w+([.,]\w+))

  Scenario: It should be possible to create a student-convention (only related with an existing user)
  When I send a POST request to "/api/student-convention" with body:
  #TODO

  Scenario: It should be possible edit student convention
  When I send a PUT request to "/api/student-convention/ADMNIM20130112" with body:
  
  Then the response status code should be 202
  When I send a GET request to "/api/student-convention/ADMNIM20130112"
  Then the response status code should be 400
  And The JSON should have the following nodes:

  #TODO

  Scenario: It should be possible to delete student convention
  When I send a DELETE request to "/api/student-convention/ADMNIM20130112"
  Then the response status code should be 202
  When I send a GET request to "/api/student-convention/ADMNIM20130112"
  Then the response status code should be 404
#END -----Crud validation-----
