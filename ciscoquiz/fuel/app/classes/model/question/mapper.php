<?php

namespace Model\Question;

use \Model\Question\Entity;
use \DB;

class Mapper
{
    public static function loadById($id)
    {
        $result = DB::select()
            ->from('questions')
            ->where('id','=',$id)
            ->execute()
            ->as_array();

        if ($result) {
            $question = new Entity($result[0]);
            return $question;
        }
        return FALSE;
    }

    public static function fetchAll()
    {
        $questions = array();
        
        $result = DB::select()
            ->from('questions')
            ->execute()
            ->as_array();

        if ($result) {
            foreach ($result as $question) {
                $questions[] = new Entity($question);
            }

            return $questions;
        }

        return FALSE;
    }
    
    public static function updateQuestion($id, $question)
    {
        $result = DB::update('questions')
            ->value('question', $question)
            ->where('id', '=', $id)
            ->execute();
        
        if($result) {
            return $result;
        }
        return FALSE;
    }
    
    public static function updateAnswer($id, $answer)
    {
        $result = DB::update('questions')
            ->value('answer', $answer)
            ->where('id', '=', $id)
            ->execute();
        
        if($result) {
            return $result;
        }
        return FALSE;
    }    
}
