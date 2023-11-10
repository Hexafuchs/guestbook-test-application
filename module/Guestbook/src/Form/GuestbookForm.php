<?php
namespace Guestbook\Form;
use Laminas\Form\ {Element, Form};
use Laminas\Hydrator\HydratorInterface;

class GuestbookForm extends Form
{
    protected $config;
    public function __construct(HydratorInterface $hydrator, array $options = [])
    {
        parent::__construct(__CLASS__, $options);
        $this->setHydrator($hydrator);
        $this->addElements();
    }
    public function setConfig($config)
    {
        $this->config = $config;
    }
    public function addElements()
    {
        // set form tag attribs
        $this->setAttributes(['method' => 'post']);

        // assign elements
        $name = new Element\Text('name');
        $name->setLabel('Name');
        $this->add($name);
        $email = new Element\Email('email');
        $email->setLabel('Email Address');
        $this->add($email);
        $website = new Element\Url('website');
        $website->setLabel('Website');
        $this->add($website);
        $message = new Element\Textarea('message');
        $message->setLabel('Comments');
        $message->setAttributes(['rows' => 4, 'cols' => 80]);
        $this->add($message);
        $submit = new Element\Submit('submit');
        $submit->setAttributes(['value' => 'Sign Guestbook',
                                'style' => 'color:white;background-color:green;']);
        $this->add($submit);
    }
}
