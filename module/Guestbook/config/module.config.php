<?php
namespace Guestbook;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Guestbook\Controller\{
    GuestbookController,
    SignupController,
    Factory\GuestbookControllerFactory,
    Factory\SignupControllerFactory
};
use Guestbook\Form\{
    Factory\GuestbookFormFactory,
    GuestbookForm,
};
use Guestbook\Model\GuestbookModel;
use Guestbook\Service\{
    Factory\GuestbookServiceFactory,
    GuestbookService,
};
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'navigation' => [
        'default' => [
            'home' => ['label' => 'Home', 'route' => 'home', 'resource' => 'menu-guestbook-home'],
            'sign' => ['label' => 'Sign', 'uri' => '/guestbook/sign', 'resource' => 'menu-guestbook-sign']
        ]
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => GuestbookController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'guestbook' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/guestbook[/]',
                    'defaults' => [
                        'controller' => GuestbookController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'signup' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/signup[/]',
                    'defaults' => [
                        'controller' => SignupController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'services' => [
            'guestbook-audit-filename' => Module::AUDIT_FILE,
        ],
        'aliases' => [
            // config is in /config/autoload/db.local.php
            'guestbook-db-config' => 'local-db-config',
        ],
        'factories' => [
            GuestbookForm::class => GuestbookFormFactory::class,
            GuestbookService::class => GuestbookServiceFactory::class,
            GuestbookModel::class => InvokableFactory::class
        ],
    ],
    'controllers' => [
        'factories' => [
            GuestbookController::class => GuestbookControllerFactory::class,
            SignupController::class => SignupControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
