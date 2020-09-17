<?php

namespace Person\Model;

use Zend\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class PersonTable {

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getAll() {
        return $this->tableGateway->select();
    }

    public function getPerson($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();

        if(!$row) {
            throw new RuntimeException(sprintf('Person with id = %d not found', $id));
        }

        return $row;
    }

    public function savePerson(Person $person) {
        $data = [
            'name' => $person->getName(),
            'surname' => $person->getSurname(),
            'email' => $person->getEmail(),
            'situation' => $person->getSituation(),
        ];

        $id = (int) $person->getId();
        
        if($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        $this->tableGateway->update($data,['id'=> $id]);
    }

    public function deletePerson($id) {
        $this->tableGateway->delete(['id'=>(int)$id]);
    }

}