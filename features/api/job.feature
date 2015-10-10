@job
Feature: Jobs management
  The job of a user is the job he has occupied for a given mandate.
  A job must belong to a mandate.
  At each new mandate, the jobs available are the job enabled.
  A job may be left empty.
  New jobs are created for the current mandate.

  Background:
    Given I authenticate myself as admin



#START -----Filter validation-----

  Scenario: It should be possible to get all the enabled jobs.
   When I send a GET request to "/api/jobs?filter[where][enable]=true"
  Then the response status code should be 200
  And I should get a paged collection with the context "/api/contexts/Job"
  And the JSON node "hydra:totalItems" should be equal to #TODO
  And the job should have a enabled with the value "true"
      #TODO

  Scenario: It should be possible to order jobs by ID, title or abbreviation.
  When I send a GET request to "/api/jobs?filter[order][id]"
  Then the response status code should be 200
  And I should get a paged collection with the context "/api/contexts/Job"
  And the JSON node "hydra:totalItems" should be equal to #TODO
  When I send a GET request to "/api/jobs?filter[order][abbreviation]"
  Then the response status code should be 200
  And I should get a paged collection with the context "/api/contexts/Job"
  And the JSON node "hydra:totalItems" should be equal to #TODO
  When I send a GET request to "/api/jobs?filter[order][title]=User Experience Connector"
  Then the response status code should be 200
  And I should get a paged collection with the context "/api/contexts/Job"
  And the JSON node "hydra:totalItems" should be equal to #TODO
  And the job should have a title with the value "User Experience Connector"
    #TODO

  Scenario: It shoud be possible to find jobs by their abbreviation (an abbreviation may have several jobs).
  When I send a GET request to "/api/jobs?filter[where][abbreviation]=DEPT"
  Then the response status code should be 200
  And I should get a paged collection with the context "/api/contexts/Job"
  And the JSON node "hydra:totalItems" should be equal to #TODO
  And the job should have an abbreviation with the value "DEPT"
    #TODO
    #
  
  Scenario: It shoud be possible to find jobs by their mandate
  When I send a GET request to "/api/jobs?filter[where][manadte]=/api/mandate/5"
  Then the response status code should be 200
  And I should get a paged collection with the context "/api/contexts/Job"
  And the JSON node "hydra:totalItems" should be equal to #TODO
  And the job should have a mandate with the value "/api/mandate/5"

#END -----Filter validation-----

#START -----Crud validation-----

  Scenario: It should be possible to get all the jobs.
    When I send a GET request to "/api/jobs"
    Then I should get a paged collection with the context "/api/contexts/Job"
    And the JSON node "hydra:totalItems" should be greater than 55

    #TODO

  Scenario: It should be possible to create a new job (1)-With valid values but no mandate
  When I send a POST request to "/api/jobs" with body:
    | title        | |
    | abbreviation | |
  Then the response status code should be 201
  When I send a POST request to "/api/jobs"
  Then The last job should have the following nodes:
    | title        | |
    | abbreviation | |
    #TODO

  Scenario: It should be possible to create a new job (2)-With valid values and a mandate
  When I send a POST request to "/api/jobs" with body:
    | title        | |
    | abbreviation | |
    | mandate      | |
  Then the response status code should be 201
  When I send a POST request to "/api/jobs"
  Then The last job should have the following nodes:
    | title        | |
    | abbreviation | |
    | mandate      | |
    #TODO

  Scenario: It should be possible to create a new job (3)-With valid values but non existing mandate
  When I send a POST request to "/api/jobs" with body:
    | title        | |
    | abbreviation | |
    | mandate      | |
  Then the response status code should be 422

  Scenario: It should be possible to create a new job (4)-With invalid values
  When I send a POST request to "/api/jobs" with body:
    | title        | |
    | abbreviation | |
    | mandate      | |
  Then the response status code should be 422

  Scenario: It shoud be possible to see job's informations
  When I send a GET request to "/api/jobs/5"
  Then the response status code should be 200
  And The job should have the following nodes:
    | title        | |
    | abbreviation | |
    | mandate      | |
    #TODO

  Scenario: It should be possible to update a job. (1)-Title or abbreviation
  When I send a PUT request to "/api/jobs/5" with body:
    | title        | |
    | abbreviation | |
    #TODO
  Then the response status code should be 202
  When I send a POST request to "/api/jobs/5"
  And The job should have the following nodes:
    | title        | |
    | abbreviation | |
    | mandate      | |
    #TODO

  Scenario: It should be possible to update a job. (2)-Mandate
  When I send a PUT request to "/api/jobs/5" with body:
    | title        | |
    | abbreviation | |
    #TODO
  When I send a POST request to "/api/jobs/5"
  And The job should have the following nodes:
    | mandate      | |
    #TODO
  When I send a POST request to "/api/jobs/5"
  And The job should have the following nodes:
    | title        | |
    | abbreviation | |
    | mandate      | |
    #TODO

  Scenario: It should be possible to update a job. (1)-Title or abbreviation
  When I send a PUT request to "/api/jobs/5" with body:
    #TODO

  Scenario: It should be possible to delete a job.
  When I send a DELETE request to "/api/jobs/5"
  Then the response status code should be 202
  When I send a GET request to "/api/jobs/5"
  Then the response status code should be 404
      check that the deleting of a job does not destroy the user or the mandate
      check that the deletion of a job is reflected in the mandate and user
      When I send a GET request to "/api/users/??"
      Then the response should be 200
      And the user has no reference to "/api/jobs/5"
      When I send a GET request to "/api/mandates/??"
      Then the response should be 200
      And the mandate has no reference to "/api/jobs/5"

#END -----Crud validation-----
