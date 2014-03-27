<?php
    
namespace Model\Points;

class Entity
{
    protected $_id;
    protected $_value;

    public function __construct($data = array())
    {
        $this->populate($data);
    }

    public function populate($data)
    {
        if (array_key_exists('id',$data)) {
            $this->setId($data['id']);
        }

        if (array_key_exists('value',$data)) {
            $this->setValue($data['value']);
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

    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->_value;
    }
}
