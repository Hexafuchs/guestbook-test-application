<?php
namespace Guestbook\Model;
class GuestbookModel
{
    const ERROR_METHOD = 'ERROR: method not found';
    const TABLE_NAME   = 'guestbook';
    public $id = 0;
    public string $name = '';
    public string $email = '';
    public string $website = '';
    public string $message = '';
    public string $avatar  = '';
    public string $dateSigned = '';
    public function extract()
    {
        return get_object_vars($this);
    }
}
