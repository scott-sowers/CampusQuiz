<?php

namespace Model\Category;

use \Model\Category\Entity;
use \DB;

class Mapper
{
    public static function loadById($id)
    {
        $result = DB::select()
            ->from('categories')
            ->where('id','=',$id)
            ->execute()
            ->as_array();

        if ($result) {
            $category = new Entity($result[0]);
            return $category;
        }
        return FALSE;
    }

    public static function loadByQuestionId($question_id)
    {
        $result = DB::select('categories.id','categories.name')
            ->from('relationships')
            ->join('categories', 'inner')
            ->on('relationships.category_id', '=', 'categories.id')
            ->where('relationships.question_id', '=', $question_id)
            ->execute()
            ->as_array();

        if ($result) {
            $category = new Entity($result[0]);
            return $category;
        }
        return FALSE;
    }

    public static function fetchAll()
    {
        $categories = array();
        
        $result = DB::select()
            ->from('categories')
            ->execute()
            ->as_array();

        if ($result) {
            foreach ($result as $category) {
                $categories[] = new Entity($category);
            }

            return $categories;
        }

        return FALSE;
    }
    
    public static function updateCategory($id, $category)
    {
        $result = DB::update('categories')
            ->value('name', $category)
            ->where('id', '=', $id)
            ->execute();
        
        if($result) {
            return $result;
        }
        return FALSE;
    }
}
