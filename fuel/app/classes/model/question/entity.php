<?php

namespace Model\Question;

class Entity
{
    protected $_id;
    protected $_question;
    protected $_answer;
    protected $_points;
    protected $_category;
    
    public function __construct($data = array())
    {
        $this->populate($data);
    }

    public function populate($data)
    {
        if (array_key_exists('id',$data)) {
            $this->setId($data['id']);
        }

        if (array_key_exists('question',$data)) {
            $this->setQuestion($data['question']);
        }

        if (array_key_exists('answer',$data)) {
            $this->setAnswer($data['answer']);
        }

        if (array_key_exists('points',$data)) {
            $this->setPoints($data['points']);
        }

        if (array_key_exists('category',$data)) {
            $this->setCategory($data['category']);
        }

        return $this;
    }

    // ID
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    // Question
    public function setQuestion($question)
    {
        $this->_question = $question;
        return $this;
    }

    public function getQuestion()
    {
        return $this->_question;
    }

    // Answer
    public function setAnswer($answer)
    {
        $this->_answer = $answer;
        return $this;
    }

    public function getAnswer()
    {
        return $this->_answer;
    }

    // Points
    public function setPoints($points)
    {
        $this->_points = $points;
        return $this;
    }

    public function getPoints()
    {
        return $this->_points;
    }

    // Category
    public function setCategory($category)
    {
        $this->_category = $category;
        return $this;
    }

    public function getCategory()
    {
        return $this->_category;
    }
}
