<?php

namespace Controller;

use \Auth;
use \Input;
use \Model\Quizservice;

class Api extends \Controller_Rest
{
    public function post_answer()
    {
        $message = '';
        $http_code = 200;
        $id = (int)Input::post('id');
        $result = Quizservice::putAnswer($id, Input::post('answer'));
        
        if ($result) {
            $message = $result . " row(s) updated";
        } else {
            $message = 'Answer could not be updated';
            $http_code = 500;
        }
        
        return $this->response(array(
            'message' => $message,
        ), $http_code);
                        
    }
    
    public function post_question()
    {
        $message = '';
        $http_code = 200;
        $id = (int)Input::post('id');
        $result = Quizservice::putQuestion($id, Input::post('question'));
        
        if ($result) {
            $message = $result . " row(s) updated";
        } else {
            $message = 'Question could not be updated';
            $http_code = 500;
        }
        
        return $this->response(array(
            'message' => $message,
        ), $http_code);
                        
    }
    
    public function post_category()
    {
        $message = '';
        $http_code = 200;
        $id = (int)Input::post('id');
        $result = Quizservice::putCategory($id, Input::post('category'));
        
        if ($result) {
            $message = $result . " row(s) updated";
        } else {
            $message = 'Question could not be updated';
            $http_code = 500;
        }
        
        return $this->response(array(
            'message' => $message,
        ), $http_code);
                        
    }
}