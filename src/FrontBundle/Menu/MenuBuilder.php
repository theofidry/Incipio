<?php

namespace FrontBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class MenuBuilder: creates menu for the front layer.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class MenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * @param FactoryInterface     $factory
     * @param TokenStorage         $tokenStorage
     * @param AuthorizationChecker $authorizationChecker
     */
    public function __construct(
        FactoryInterface $factory,
        TokenStorage $tokenStorage,
        AuthorizationChecker $authorizationChecker)
    {
        $this->factory = $factory;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Menu used for the header.
     *
     * @param RequestStack $requestStack
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createHeaderMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        // Dashboard
        $menu->addChild('dashboard',
            [
                'label' => 'Dashboard',
                'route'   => 'dashboard',
            ]
        );

        // Association Management
        $menu->addChild($this->createAssociationManagementMenu());

//        nav navbar-nav navbar-right
        return $menu;
    }

    private function createAssociationManagementMenu()
    {
        $menu = $this->factory->createItem('association-management');
        $menu
            ->setAttribute('dropdown', true)
            ->setLabel('Gestion associative')
        ;

        $menu->addChild('users',
            [
                'label' => 'Liste des membres',
                'route' => 'users',
            ]
        );

        return $menu;
    }

    private function createUserMenu()
    {
        $menu = $this->factory->createItem('user');
        $menu->setAttribute('dropdown', true);

        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')) {
            $menu->setLabel('Anonymous User');

            return $menu;
        }

        // User is properly authenticated
        $user = $this->tokenStorage->getToken();

        $menu->addChild('profile',
            [
                'label' => 'Profil',
                'route' => 'users',
            ]
        );

        $menu->addChild('logout',
            [
                'label' => 'Déconnexion',
                'route' => 'fos_user_security_logout',
            ]
        );

        return $menu;
    }
}
