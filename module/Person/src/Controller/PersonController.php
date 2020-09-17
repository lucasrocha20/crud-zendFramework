<?php

namespace Person\Controller;

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
        return new ViewModel();
    }

    public function saveAction() {
        return new ViewModel();
    }

    public function editAction() {
        return new ViewModel();
    }

    public function removeAction() {
        return new ViewModel();
    }

    public function confirmationAction() {
        return new ViewModel();
    }
}