<?php

namespace AppBundle\Twig;

use AppBundle\Entity\User;
use AppBundle\Services\MenuManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class AppExtension
 * @package AppBundle\Twig
 */
class AppExtension extends \Twig_Extension
{
    protected $menuManager;
    protected $cabinetMenu;
    protected $request;
    protected $token;
    protected $authorizationChecker;

    /**
     * AppExtension constructor.
     * @param MenuManager $menuManager
     * @param RequestStack $requestStack
     */
    public function __construct(
        MenuManager $menuManager,
        RequestStack $requestStack,
        TokenStorage $token,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->menuManager = $menuManager;
        $this->request = $requestStack->getCurrentRequest();
        $this->token = $token;
        $this->authorizationChecker = $authorizationChecker;

        if ($this->token->getToken() !== null && $this->token->getToken()->getUser() instanceof User) {
            /** User $user */
            $user = $this->token->getToken()->getUser();

            if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $this->cabinetMenu = [
                    [
                        'parent' => [
                            'name' => 'Мій Профіль',
                        ],
                        'children' => [
                            [
                                'name' => 'Перегляд',
                                'route' => 'check_profile',
                                'routeParams' => [

                                ],
                            ],
                            [
                                'name' => 'Редагування',
                                'route' => 'user_edit',
                                'routeParams' => [
                                    'slug' => $user->getSlug()
                                ],
                            ],
                            [
                                'name' => 'Зміна паролю',
                                'route' => 'change_password',
                                'routeParams' => [

                                ],
                            ],
                        ],
                    ],
                    [
                        'parent' => [
                            'name' => 'Запити на благодійність',
                        ],
                        'children' => [
                            [
                                'name' => 'Створити запит',
                                'route' => 'charity_new',
                                'routeParams' => [

                                ],
                            ],
                            [
                                'name' => 'Перегляд запитів',
                                'route' => 'charity_manager_index',
                                'routeParams' => [

                                ],
                            ],
                        ],
                    ],
                    [
                        'parent' => [
                            'name' => 'Адміністрування',
                        ],
                        'children' => [
                            [
                                'name' => 'Новий тег',
                                'route' => 'tag_new',
                                'routeParams' => [

                                ],
                            ],
                            [
                                'name' => 'Усі теги',
                                'route' => 'tag_manager_index',
                                'routeParams' => [

                                ],
                            ],
                            [
                                'name' => 'Нова категорія',
                                'route' => 'category_new',
                                'routeParams' => [

                                ],
                            ],
                            [
                                'name' => 'Усі категорії',
                                'route' => 'category_manager_index',
                                'routeParams' => [

                                ],
                            ],
                        ],
                    ],
                ];
            } elseif ($this->authorizationChecker->isGranted('ROLE_USER')) {
                $this->cabinetMenu = [
                    [
                        'parent' => [
                            'name' => 'Мій Профіль',
                        ],
                        'children' => [
                            [
                                'name' => 'Перегляд',
                                'route' => 'check_profile',
                                'routeParams' => [

                                ],
                            ],
                            [
                                'name' => 'Редагування',
                                'route' => 'user_edit',
                                'routeParams' => [
                                    'slug' => $user->getSlug()
                                ],
                            ],
                            [
                                'name' => 'Зміна паролю',
                                'route' => 'change_password',
                                'routeParams' => [

                                ],
                            ],
                        ],
                    ],
                    [
                        'parent' => [
                            'name' => 'Запити на благодійність',
                        ],
                        'children' => [
                            [
                                'name' => 'Створити запит',
                                'route' => 'charity_new',
                                'routeParams' => [

                                ],
                            ],
                            [
                                'name' => 'Перегляд запитів',
                                'route' => 'charity_manager_index',
                                'routeParams' => [

                                ],
                            ],
                        ],
                    ],
                ];
            }


        } else {
            $this->cabinetMenu = [
                [
                    'parent' => [
                        'name' => 'Запити на благодійність',
                    ],
                    'children' => [
                        [
                            'name' => 'Створити запит',
                            'route' => 'charity_new',
                            'routeParams' => [

                            ],
                        ],
                        [
                            'name' => 'Перегляд запитів',
                            'route' => 'charity_manager_index',
                            'routeParams' => [

                            ],
                        ],
                    ],
                ],
            ];
        }
    }

    public function getFilters()
    {
        return parent::getFilters(); // TODO: Change the autogenerated stub
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('page_title', [$this, 'getPageTitle']),
            new \Twig_SimpleFunction('all_categories', [$this, 'getAllCategories']),
            new \Twig_SimpleFunction('available_languages', [$this, 'getAvailableLanguages']),
            new \Twig_SimpleFunction('current_language', [$this, 'getCurrentLanguage']),
            new \Twig_SimpleFunction('available_cities', [$this, 'getAvailableCities']),
            new \Twig_SimpleFunction('current_city', [$this, 'getCurrentCity']),
            new \Twig_SimpleFunction('important_charities', [$this, 'getImportantCharities']),
            new \Twig_SimpleFunction('active_charities', [$this, 'getActiveCharities']),
            new \Twig_SimpleFunction('completed_charities', [$this, 'getCompletedCharities']),
            new \Twig_SimpleFunction('tag_cloud_elements', [$this, 'getTagCloudElements']),
            new \Twig_SimpleFunction('cabinet_menu_elements', [$this, 'getCabinetMenuElements']),
            new \Twig_SimpleFunction('active_parent_cabinet_menu_element_name', [$this, 'getActiveParentCabinetMenuElementName']),
            new \Twig_SimpleFunction('active_child_cabinet_menu_element_name', [$this, 'getActiveChildCabinetMenuElementName']),
        ];
    }

    public function getPageTitle()
    {
        return $this->menuManager->getPageTitle();
    }

    public function getAllCategories()
    {
        return $this->menuManager->getAllCategories();
    }

    public function getAvailableLanguages()
    {
        return $this->menuManager->getAvailableLanguages();
    }

    public function getCurrentLanguage()
    {
        return $this->menuManager->getCurrentLanguage();
    }

    public function getAvailableCities()
    {
        return $this->menuManager->getAvailableCities();
    }

    public function getCurrentCity()
    {
        return $this->menuManager->getCurrentCity();
    }

    public function getImportantCharities()
    {
        return $this->menuManager->getImportantCharities();
    }

    public function getActiveCharities()
    {
        return $this->menuManager->getActiveCharities();
    }

    public function getCompletedCharities()
    {
        return $this->menuManager->getCompletedCharities();
    }

    public function getTagCloudElements()
    {
        return $this->menuManager->getTagCloudElements();
    }

    public function getCabinetMenuElements()
    {
        return $this->cabinetMenu;
    }

    public function getActiveParentCabinetMenuElementName()
    {
        $currentRoute = $this->request->get('_route');

        foreach ($this->cabinetMenu as $menuSection) {
            foreach ($menuSection['children'] as $childElement) {
                if ($currentRoute === $childElement['route']) {
                    return $menuSection['parent']['name'];
                }
            }
        }

        return null;
    }

    public function getActiveChildCabinetMenuElementName()
    {
        $currentRoute = $this->request->get('_route');

        foreach ($this->cabinetMenu as $menuSection) {
            foreach ($menuSection['children'] as $childElement) {
                if ($currentRoute === $childElement['route']) {
                    return $childElement['name'];
                }
            }
        }

        return null;
    }

    public function getName()
    {
        return 'app_extension';
    }
}