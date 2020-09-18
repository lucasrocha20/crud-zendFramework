<?php

namespace Person\Form;

use Zend\Form\Form;

class PersonForm extends Form {

    public function __construct() {
        parent::__construct('person',[]);

        $this->add(new \Zend\Form\Element\Hidden('id'));
        $this->add(new \Zend\Form\Element\Text('name',['label' => 'Nome']));
        $this->add(new \Zend\Form\Element\Text('surname', ['label' => 'Sobrenome']));
        $this->add(new \Zend\Form\Element\Email('email', ['label' => 'Email']));
        $this->add(new \Zend\Form\Element\Text('situation', ['label' => 'Situação']));

        $submit = new \Zend\Form\Element\Submit('submit');
        $submit->setAttributes(['value'=>'Salvar', 'id'=>'submitbutton']);
        $this->add($submit);
    }

}