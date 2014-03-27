<?php

namespace Controller;

use \Pusherapp;
use \Input;

class Pusher extends \Controller_Rest
{
    public function get_event()
    {
        $data = array(
            'teamName' => Input::get('teamName'),
            'teamSlug' => Input::get('teamSlug')
        );
        Pusherapp::forge()->trigger('cisco-quiz', Input::get('event'), $data);
        return $this->response();
    }
}
