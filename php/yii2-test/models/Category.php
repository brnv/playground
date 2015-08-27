<?php

namespace app\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'yii_news_category';
    }

    public function getAllActive()
    {
        return $this->findAll(['is_active' => 1]);
    }

    public function getAll()
    {
        return $this->find()->All();
    }
}
