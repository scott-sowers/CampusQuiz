<?php

use \Model\QuizService;

class View_Quiz_Scoreboard extends \ViewModel
{
    public function view()
    {
        $this->questions = Quizservice::getQuestions();
        $this->points = Quizservice::getPoints();
        $this->categories = Quizservice::getCategories();
        $this->pointsCount = count($this->points);
        $this->categoryCount = count($this->categories);
    }
}
