<?php
namespace Guestbook\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Guestbook\Service\GuestbookService;
use Guestbook\Controller\GuestbookController;

class GuestbookControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new GuestbookController(
            $container->get(GuestbookService::class)
        );
    }
}
