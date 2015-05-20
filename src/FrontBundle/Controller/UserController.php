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

//TODO: remove reference to User
use ApiBundle\Entity\User;
use FrontBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

/**
 * Class UserController.
 *
 * @Route("/users")
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
//TODO: refactor this class, has been autogenerated
class UserController extends BaseController
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="users")
     *
     * @Method("GET")
     * @Template()
     *
     * @param Request $request
     *
     * @return array Users decoded from JSON.
     */
    public function indexAction(Request $request)
    {
        $client = $this->get('api.client');
        $serializer = $this->get('serializer');
        $roleHelper = $this->get('front.security.roles.helper');

        // Retrieve users
        $jsonContent = $client->get('users_cget', $request->getSession()->get('api_token'))->send()->getBody(true);
        $users = $serializer->decode($jsonContent, 'json');

        // Add top level role
        foreach ($users['hydra:member'] as $key => $user) {
            $users['hydra:member'][$key]['topRole'] = $roleHelper->getTopLevelRole($user['roles']);
        }

        return ['users' => $users['hydra:member']];
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/", name="users_create")
     *
     * @Method("POST")
     * @Template()
     *
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('users_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
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
        $entity = new User();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
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
     * @param         $id
     *
     * @return array
     */
    public function showAction(Request $request, $id)
    {
        $client = $this->get('api.client');
        $serializer = $this->get('serializer');

        $response = $client->get(
            $this->get('router')->generate('users_get', ['id' => $id]),
            $request->getSession()->get('api_token')
        )->send();

        if (Response::HTTP_NOT_FOUND === $response->getStatusCode()) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $jsonContent = $response->getBody(true);
        $user = $serializer->decode($jsonContent, 'json');

        return ['user' => $user];
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
     * @param         $id
     *
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        $client = $this->get('api.client');
        $serializer = $this->get('serializer');

        $response = $client->get(
            $this->get('router')->generate('users_get', ['id' => $id]),
            $request->getSession()->get('api_token')
        )->send();

        if (Response::HTTP_NOT_FOUND === $response->getStatusCode()) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $jsonContent = $response->getBody(true);
        $user = $serializer->decode($jsonContent, 'json');

        return [
            'user' => $user,
            'edit_form' => $this->createEditForm($user)->createView(),
        ];
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="users_update")
     *
     * @Method("PUT")
     * @Template("ApiUserBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        //TODO
//        $em = $this->getDoctrine()->getManager();
//
//        $entity = $em->getRepository('ApiUserBundle:User')->find($id);
//
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find User entity.');
//        }
//
//        $deleteForm = $this->createDeleteForm($id);
//        $editForm = $this->createEditForm($entity);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isValid()) {
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('users_edit', array('id' => $id)));
//        }
//
//        return array(
//            'entity' => $entity,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        );
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="users_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ApiUserBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('users'));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(),
            $entity,
            array(
                'action' => $this->generateUrl('users_create'),
                'method' => 'POST',
            ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param array $user The user in decoded JSON format.
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
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}