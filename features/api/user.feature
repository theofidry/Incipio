@user
Feature: User management
  As an administrator, I should be able to manage users.

  Background:
    Given I authenticate myself as admin

  Scenario: Get a collection
    When I send a GET request to "/api/users"
    Then the response status code should be 200
    And I should get a paged collection with the context "/api/contexts/User"

  Scenario: Get a resource
    Given I have "admin" which is a "ApiBundle\Entity\User" with the following properties:
      | property                           | value                                      | type   |
      | createdAt                          | ~                                          | scalar |
      | endingSchoolYear                   | null                                       | scalar |
      | endingSchoolYear                   | null                                       | scalar |
      | fullname                           | "Admin NIMDA"                              | scalar |
      | jobs                               |                                            | array  |
      | organizationEmail                  | null                                       | scalar |
      | organizationEmailCanonical         | null                                       | scalar |
      | studentConvention                  |                                            | object |
      | studentConvention->@id             | "/api/student_conventions/ADMNIM20130112"  | scalar |
      | studentConvention->@type           | "StudentConvention"                        | scalar |
      | studentConvention->dateOfSignature | "2013-01-12T00:00:00+01:00"                | scalar |
      | types                              |                                            | array  |
      | types[0]                           |  1                                         | scalar |
      | username                           | "admin"                                    | scalar |
      | email                              | "admin@incipio.fr"                         | scalar |
      | roles                              |                                            | array  |
      | roles[0]                           | "ROLE_SUPER_ADMIN"                         | scalar |
      | roles[1]                           | "ROLE_USER"                                | scalar |
      | updatedAt                          | ~                                          | scalar |
    Given "admin" database identifier is 2
    Then I send a GET request to "/api/users/2"
    And the response status code should be 200
    And I should get a resource page with the context "/api/contexts/User"
    And I should have the following JSON body:
      | key                                | value                                      | type   |
      | @context                           | "/api/contexts/User"                       | scalar |
      | @id                                | "/api/users/2"                             | scalar |
      | @type                              | "User"                                     | scalar |
      | createdAt                          | ~                                          | scalar |
      | endingSchoolYear                   | null                                       | scalar |
      | endingSchoolYear                   | null                                       | scalar |
      | fullname                           | "Admin NIMDA"                              | scalar |
      | jobs                               |                                            | array  |
      | organizationEmail                  | null                                       | scalar |
      | organizationEmailCanonical         | null                                       | scalar |
      | studentConvention                  |                                            | object |
      | studentConvention->@id             | "/api/student_conventions/ADMNIM20130112"  | scalar |
      | studentConvention->@type           | "StudentConvention"                        | scalar |
      | studentConvention->dateOfSignature | ~                                          | scalar |
      | types                              |                                            | array  |
      | types[0]                           |  1                                         | scalar |
      | username                           | "admin"                                    | scalar |
      | email                              | "admin@incipio.fr"                         | scalar |
      | roles                              |                                            | array  |
      | roles[0]                           | "ROLE_SUPER_ADMIN"                         | scalar |
      | roles[1]                           | "ROLE_USER"                                | scalar |
      | updatedAt                          | ~                                          | scalar |

  Scenario: It should be possible to get users by username or email
    When I send a "GET" request to "/api/users/1"
