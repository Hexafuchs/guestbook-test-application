<?php
namespace Guestbook\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Guestbook\Form\GuestbookForm;
use Guestbook\Service\GuestbookService;
use Guestbook\Model\GuestbookModel;
use Guestbook\Controller\SignupController;

class SignupControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new SignupController(
            $container->get(GuestbookForm::class),
            $container->get(GuestbookService::class),
            $container->get(GuestbookModel::class)
        );
    }
}
