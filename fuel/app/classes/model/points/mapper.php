<?php

namespace Model\Points;

use \Model\Points\Entity;
use \DB;

class Mapper
{
    public static function loadById($id)
    {
        $result = DB::select()
            ->from('points')
            ->where('id','=',$id)
            ->execute()
            ->as_array();

        if ($result) {
            $points = new Entity($result[0]);
            return $points;
        }
        return FALSE;
    }

    public static function loadByQuestionId($question_id)
    {
        $result = DB::select('points.id','points.value')
            ->from('relationships')
            ->join('points', 'inner')
            ->on('relationships.points_id', '=', 'points.id')
            ->where('relationships.question_id', '=', $question_id)
            ->execute()
            ->as_array();

        if ($result) {
            $points = new Entity($result[0]);
            return $points;
        }
        return FALSE;
    }

    public static function fetchAll()
    {
        $points_array = array();
        
        $result = DB::select()
            ->from('points')
            ->execute()
            ->as_array();

        if ($result) {
            foreach ($result as $points) {
                $points_array[] = new Entity($points);
            }

            return $points_array;
        }

        return FALSE;
    }
}
