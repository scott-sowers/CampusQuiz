<?php

namespace Controller;

use \Auth;
use \Input;
use \Response;
use \View;
use \ViewModel;

class Quiz extends \Controller_Template
{
    public function action_index()
	{
		$this->template->title = 'Buzzer';
        $this->template->content = View::forge('quiz/buzzer');
	}

    public function action_scoreboard()
    {
        if (Auth::has_access('quiz.score')) {
            $this->template->title = 'Scoreboard';
            $this->template->content = ViewModel::forge('quiz/scoreboard');            
        } else {
            Response::redirect('/quiz/login');
        }

    }
    
    public function action_edit()
    {
        if (Auth::has_access('quiz.edit')) {
            $this->template->title = 'Edit Game';
            $this->template->content = ViewModel::forge('quiz/edit');
        } else {
            Response::redirect('/quiz/login');
        }
    }

    public function action_404()
    {
        $this->template->title = 'Page Not Found';
        $this->template->content = View::forge('quiz/404');
    }

    public function action_login()
    {
        $data = array();

        if (Auth::check()) {
            Response::redirect('/scoreboard');
        }

        // If so, you pressed the submit button. Let's go over the steps.
        if (Input::method() == 'POST')
        {

            // Check the credentials. This assumes that you have the previous table created and
            // you have used the table definition and configuration as mentioned above.
            if (Auth::login(\Input::param('username'),\Input::param('password')))
            {
                // Credentials ok, go right in.
                Response::redirect('/scoreboard');
            }
            else
            {
                // Oops, no soup for you. Try to login again. Set some values to
                // repopulate the username field and give some error text back to the view.
                $data['username']    = Input::post('username');
                $data['login_error'] = 'Wrong username/password combo. Try again';
            }
        }
        
        $this->template->title = 'Login';
        $this->template->content = View::forge('quiz/login',$data);
    }

    public function action_logout()
    {
        Auth::logout();
        Response::redirect('/quiz/login');
    }
}