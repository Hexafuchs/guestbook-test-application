<?php
namespace Guestbook;
use Laminas\Db\Adapter\Adapter;
use Laminas\Mvc\MvcEvent;
use Guestbook\Service\GuestbookService;

class Module
{
    const AUDIT_FILE = __DIR__ . '/../../../data/logs/audit.log';
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->getSharedManager()->attach('*', GuestbookService::EVENT_POST_INSERT, [$this, 'auditInsert']);
    }

    public function auditInsert($e)
    {
        $rows = $e->getParam('result', 0);
        $message = date('Y-m-d H:i:s') . ': Database Insert Was ';
        $message .= ($rows) ? '' : 'NOT';
        $message .= ' Successful : Rows Affected : ' . $rows . PHP_EOL;
        file_put_contents(self::AUDIT_FILE, $message, FILE_APPEND);
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'guestbook-db-adapter' => function ($container) {
                    // defined in /config/autoload/db.local.php
                    return new Adapter($container->get('local-db-config'));
                },
            ],
        ];
    }
}
