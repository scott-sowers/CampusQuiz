<?php

namespace Model;

use \Model\Category\Mapper as CategoryMapper;
use \Model\Points\Mapper as PointsMapper;
use \Model\Question\Mapper as QuestionMapper;

class Quizservice
{
    public static function getPoints()
    {
        return PointsMapper::fetchAll();
    }

    public static function getCategories()
    {
        return CategoryMapper::fetchAll();
    }

    public static function getQuestions()
    {
        $questions = QuestionMapper::fetchAll();

        foreach ($questions as $key => $question) {
            $qid = $question->getId();
            $question->setPoints(PointsMapper::loadByQuestionId($qid));
            $question->setCategory(CategoryMapper::loadByQuestionId($qid));
        }

        return $questions;
    }
    
    public static function putQuestion($id, $question)
    {
        return QuestionMapper::updateQuestion($id, $question);
    }
    
    public static function putAnswer($id, $answer)
    {
        return QuestionMapper::updateAnswer($id, $answer);
    }
    
    public static function putCategory($id, $category)
    {
        return CategoryMapper::updateCategory($id, $category);
    }    
}
