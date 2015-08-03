<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FrontBundle\Controller;

use FrontBundle\Form\Type\UserFilteringType;
use FrontBundle\Form\Type\UserType;
use GuzzleHttp\Exception\RequestException as ClientRequestException;
use GuzzleHttp\Exception\TransferException as ClientTransferException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/users")
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class UserController extends BaseController
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="users")
     *
     * @Method({"GET", "POST"})
     * @Template()
     *
     * @param Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $filterForm = $this->createUserFilteringForm($request);
        $userRequest = $this->createRequest('GET', 'api_users_cget', $request);

        // Check if a request has been made to filter the list of users
        if ('POST' === $request->getMethod()) {
            // Handle filter form
            // Does not generate errors as we have no means to know if the POST request is for this form or a new user
            $filterForm->handleRequest($request);
            if ($filterForm->isValid()) {
                $data = $filterForm->getData();
                $query = '';

                // Update user request to filter the list of users to match the requested type
                if (null !== $data['user_type']) {
                    $query .= sprintf('filter[where][type]=%s', $data['user_type']);
                }

                if (null !== $data['mandate_id']) {
                    $query .= sprintf('&filter[where][mandate]=%s', $data['mandate_id']);
                }

                $userRequest->setQuery($query);
            } else {
                // If filter form is invalid, expect a POST request for a new user
                $this->createAction($request);
            }
        }
        
        // Retrieve users, since it's a paginated collection go through all available pages
        try {
            $users = $this->sendAndDecode($userRequest, true);
        } catch (ClientTransferException $exception) {
            $this->handleGuzzleException($exception);
            $users = [];
        }

        return [
            'users'       => $users,
            'filter_form' => $filterForm->createView(),
        ];
    }

    /**
     * Creates a new User entity. Should be a dedicated POST endpoint, but as the indexAction handle the filter form
     * which is a post too, this action can't have a dedicated endpoint. Hence is called by indexAction. Still keep the
     * route name because is more convenient for generating routes.
     *
     * @Route("/", name="users_create")
     *
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $createForm = $this->createCreateForm();
        $createForm->handleRequest($request);

        if ($createForm->isValid()) {
            $createRequest = $this->createRequest('POST',
                'api_users_cpost',
                $request,
                [
                    'json' => $createForm->getData()
                ]
            );

            try {
                $createResponse = $this->client->send($createRequest);

                // User properly created, redirect to user show view
                return $this->redirect($this->generateUrl('users_show', ['id' => $createResponse->json()['@id']]));
            } catch (ClientTransferException $exception) {
                $this->handleGuzzleException($exception);
            }
        }

        // Redirect to the form
        return [
            'create_form' => $createForm->createView(),
        ];
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="users_new")
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        return ['new_form' => $this->createCreateForm()->createView()];
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="users_show")
     *
     * @Method("GET")
     * @Template()
     *
     * @param Request $request
     * @param int     $id
     *
     * @return array
     */
    public function showAction(Request $request, $id)
    {
        try {
            $response = $this->client->request(
                'GET',
                'api_users_get',
                $request->getSession()->get('api_token'),
                ['parameters' => ['id' => $id]]
            );

            if (Response::HTTP_NOT_FOUND === $response->getStatusCode()) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $user = $this->decode($response->getBody());

            return [
                'delete_form' => $this->createDeleteForm($id)->createView(),
                'user'        => $user,
            ];
        } catch (ClientRequestException $exception) {
            if (Response::HTTP_NOT_FOUND === $exception->getResponse()->getStatusCode()) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $this->handleGuzzleException($exception);
        } catch (ClientTransferException $exception) {
            $this->handleGuzzleException($exception);
        }

        return $this->redirect($this->generateUrl('users'));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="users_edit")
     *
     * @Method("GET")
     * @Template()
     *
     * @param Request $request
     * @param int     $id
     *
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        try {
            $editResponse = $this->client->send(
                $this->createRequest(
                    'GET',
                    'api_users_get',
                    $request,
                    ['parameters' => ['id' => $id]]
                )
            );

            if (Response::HTTP_NOT_FOUND === $editResponse->getStatusCode()) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $user = $editResponse->json();

            return [
                'user'      => $user,
                'edit_form' => $this->createEditForm($user)->createView(),
            ];
        } catch (ClientTransferException $exception) {
            $this->handleGuzzleException($exception);
        }
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="users_update")
     *
     * @Method("PUT")
     * @Template("ApiUserBundle:User:edit.html.twig")
     *
     * @param Request $request
     * @param int     $id
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, $id)
    {
        $user = [];

        try {
            // Get the user to check if exist and to retrieve its data
            $getUserResponse = $this->client->send(
                $this->createRequest(
                    'GET',
                    'api_users_get',
                    $request,
                    ['parameters' => ['id' => $id]]
                )
            );

            if (Response::HTTP_NOT_FOUND === $getUserResponse->getStatusCode()) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }
            $user = $getUserResponse->json();


            // Handle update request
            $editForm = $this->createEditForm($user);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $updateRequest = $this->createRequest('PUT',
                    'api_users_put',
                    $request,
                    [
                        'json' => $editForm->getData(),
                        'parameters' => ['id' => $id]
                    ]
                );

                $updateRequest = $this->client->send($updateRequest);

                $this->addFlash('success', 'L\'utilisateur a bien été mis à jour.');

                return $this->redirect($this->generateUrl('users_show', ['id' => $id]));
            }
        } catch (ClientRequestException $exception) {
            if (Response::HTTP_NOT_FOUND === $exception->getResponse()->getStatusCode()) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $this->handleGuzzleException($exception);
        } catch (ClientTransferException $exception) {
            $this->handleGuzzleException($exception);
        }

        return ['user' => $user];
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="users_delete")
     *
     * @Method("DELETE")
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $deleteForm = $this->createDeleteForm($id);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isValid()) {
            $deleteRequest = $this->createRequest('DELETE',
                'api_users_delete',
                $request,
                [
                    'parameters' => ['id' => $id]
                ]
            );

            try {
                $this->client->send($deleteRequest);
                $this->addFlash('success', 'L\'utilisateur a bien été supprimé.');
            } catch (ClientRequestException $exception) {
                if (Response::HTTP_NOT_FOUND === $exception->getResponse()->getStatusCode()) {
                    throw $this->createNotFoundException('Unable to find User entity.');
                }

                $this->handleGuzzleException($exception);
            } catch (ClientTransferException $exception) {
                $this->handleGuzzleException($exception);
            }
        } else {
            $this->addFlash('error', $deleteForm->getErrors());
        }

        return $this->redirect($this->generateUrl('users'));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param array|null $user The normalized user.
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createCreateForm(array $user = [])
    {
        $form = $this->createForm(new UserType(),
            $user,
            [
                'action' => $this->generateUrl('users_create'),
                'method' => 'POST',
            ]
        );

        return $form;
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param array $user The normalized user.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(array $user)
    {
        $form = $this->createForm(
            new UserType(),
            $user,
            [
                'action' => $this->generateUrl('users_update', ['id' => $user['@id']]),
                'method' => 'PUT',
            ]
        );

        return $form;
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param int $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createUserFilteringForm(Request $request)
    {
        $mandateFormValues = [];
        $mandates = $this->requestAndDecode(
            'GET',
            'api_mandates_cget',
            $request,
            ['query' => 'filter[order][startAt]=desc'],
            true
        );

        foreach ($mandates as $mandate) {
            $mandateFormValues[$mandate['@id']] = $mandate['name'];
        }

        return $this->createForm(new UserFilteringType($mandateFormValues),
            [
                'action' => $this->generateUrl('users'),
                'method' => 'POST'
            ])
            ->add('submit', 'submit', ['label' => 'Filtrer'])
        ;
    }
}
