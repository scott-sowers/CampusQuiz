<?php
    
namespace Model\Category;

class Entity
{
    protected $_id;
    protected $_name;

    public function __construct($data = array())
    {
        $this->populate($data);
    }

    public function populate($data)
    {
        if (array_key_exists('id',$data)) {
            $this->setId($data['id']);
        }

        if (array_key_exists('name',$data)) {
            $this->setName($data['name']);
        }
    }

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }
}
