<?php

namespace app\models;

use yii\db\ActiveRecord;

class News extends ActiveRecord
{
    public static function tableName()
    {
        return 'yii_news';
    }

    public function getAllActive()
    {
        $newsList = $this->find()->joinWith('categories')->all();

        //@TODO: make this filtering on sql level
        foreach ($newsList as $index => $newsItem) {
            if (!$newsItem->categories->is_active) {
                unset($newsList[$index]);
            }
        }
        return $newsList;
    }

    public function getAllForCategory($categoryId)
    {
        return $this->findAll(['is_active' => 1, 'category_id' => $categoryId]);
    }

    public function getAll()
    {
        return $this->find()->All();
    }

    public function getCategories()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
