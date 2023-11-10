<?php
namespace Guestbook\Controller;

use Guestbook\Listener\CacheAggregate;
use Guestbook\Model\GuestbookModel;
use Guestbook\Service\GuestbookService;
use Laminas\Form\FormInterface;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;

class SignupController extends AbstractActionController
{
    const SUCCESS_ADD = 'Thanks for signing our guestbook!';
    const ERROR_ADD   = 'SORRY ... unable to add you to the guestbook';
    const ERROR_VALID = 'SORRY ... there was a form validation problem';

    public function __construct(
        private FormInterface $form,
        private GuestbookService $service,
        private GuestbookModel $model)
    {
    }

    public function indexAction()
    {
        $post = '';
        $guest = '';
        $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $this->form->bind($this->model);
            $this->form->setData($post);
            if ($this->form->isValid()) {
                $guest = $this->form->getData();
                if ($this->service->add($guest)) {
                    $message = self::SUCCESS_ADD;
                } else {
                    $message = self::ERROR_ADD;
                }
            } else {
                $message = self::ERROR_VALID;
            }
        }
        return new ViewModel(['form' => $this->form, 'message' => $message, 'data' => $post, 'guest' => $guest]);
    }
}
