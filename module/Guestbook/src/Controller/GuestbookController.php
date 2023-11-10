<?php
namespace Guestbook\Controller;

use Guestbook\Service\GuestbookService;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;

class GuestbookController extends AbstractActionController
{
    public function __construct(GuestbookService $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        return new ViewModel(['guestList' => $this->service->findAll()]);
    }
}
