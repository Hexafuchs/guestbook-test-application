<?php
namespace Guestbook\Service\Factory;
use Guestbook\Model\GuestbookModel;
use Guestbook\Service\GuestbookService;
use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

class GuestbookServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $eventManager = $container->get('EventManager');
        $eventManager->addIdentifiers([GuestbookService::IDENTIFIER]);
        $tableGateway = new TableGateway(
            GuestbookService::TABLE_NAME,
            $container->get('guestbook-db-adapter'),
            null,
            new HydratingResultSet(
                new ObjectPropertyHydrator(),
                new GuestbookModel
            )
        );
        return new GuestbookService(
            $container->get('guestbook-db-adapter'),
            $eventManager,
            $tableGateway
        );
    }
}
