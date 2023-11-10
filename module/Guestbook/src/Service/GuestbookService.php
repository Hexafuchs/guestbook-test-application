<?php
namespace Guestbook\Service;
use Guestbook\Model\GuestbookModel;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\EventManager\EventManagerInterface;

class GuestbookService
{
    const TABLE_NAME = 'guestbook',
          IDENTIFIER = 'guestbook-service',
          EVENT_PRE_INSERT  = 'guestbook-service-pre-insert',
          EVENT_POST_INSERT = 'guestbook-service-post-insert';

    public function __construct(
        protected AdapterInterface $adapter,
        protected EventManagerInterface $eventManager,
        protected TableGatewayInterface $table)
    {}

    public function findAll()
    {
        return $this->table->select();
    }
    public function add(GuestbookModel $model)
    {
        unset($model->submit);
        $model->dateSigned = date('Y-m-d H:i:s');
        $this->eventManager->trigger(self::EVENT_PRE_INSERT, $this, ['model' => $model]);

        // HERE:: Example of SQL injection

        // Notes: The example is based on actual code from a developer that was trying to insert
        //        data coming from the browser in their DB.

        // -- Start of faulty code --
        /** @var TableGateway */
        $adapter = $this->table->getAdapter();
        assert($adapter instanceof Adapter); // Force Psalm to detect the right type
        $row = $model->extract();
        $result = $adapter->query(
            "INSERT INTO ". $this->table->getTable()." (".implode(',', array_keys($row)).") ".
            "VALUES(".
            sprintf(
                "'%s', '%s', '%s', '%s', '%s', '%s', '%s'",
                $model->id, $model->name, $model->email, $model->message, $model->website, $model->avatar, $model->dateSigned
            ).
            ")",
            Adapter::QUERY_MODE_EXECUTE
        );

        // -- End of faulty code --

        // -- Start of example fix
        // $result = $this->table->insert($model->extract());
        // $this->eventManager->trigger(self::EVENT_POST_INSERT, $this, ['result' => $result]);
        // -- End of example fix


        return $result;
    }
}
