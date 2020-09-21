<?php

namespace Person\Controller;

use Person\Form\PersonForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PersonController extends AbstractActionController {

    private $table;

    public function __construct($table) {
        $this->table = $table;
    }

    public function indexAction() {
        return new ViewModel(['persons' => $this->table->getAll()]);
    }

    public function addAction() {
        $form = new PersonForm();
        $form->get('submit')->setValue('Adicionar');
        $request = $this->getRequest();

        if(!$request->isPost()) {
            return new ViewModel(['form'=>$form]);
        }

        $person = new \Person\Model\Person();
        $form->setData($request->getPost());

        if(!$form->isValid()) {
            return new ViewModel(['form'=>$form]);
        }

        // $person->exchangeArray($form->getData());

        $this->table->savePerson($form->getData());

        return $this->redirect()->toRoute('person');
    }

    public function saveAction() {
        return new ViewModel();
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id',0);

        if($id === 0) {
            return $this->redirect()->toRoute('person',['action'=>'add']);
        }

        try {
            $person = $this->table->getPerson($id);
        } catch(Exception $err) {
            return $this->redirect()->toRoute('person',['action'=>'index']);
        }

        $form = new PersonForm();
        $form->bind($person);
        $form->get('submit')->setAttribute('value', 'Salvar');
   
        $request = $this->getRequest();
        $viewData = ['id'=>$id, 'form'=>$form];
     
        if(!$request->isPost()) {
            return $viewData;
        }
    
        $form->setData($request->getPost());
        if(!$form->isValid()) {
            return $viewData;
        }
  
        // $person->exchangeArray($form->getData());
        $this->table->savePerson($person);
        return $this->redirect()->toRoute('person');

        return new ViewModel();
    }

    public function removeAction() {
        return new ViewModel();
    }

    public function confirmationAction() {
        return new ViewModel();
    }
}