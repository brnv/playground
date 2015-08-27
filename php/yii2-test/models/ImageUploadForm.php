<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class ImageUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules() {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload() {
        if ($this->validate()) {
            $this->imageFile->saveAs(
                dirname(__DIR__) . '/web/files/' . $this->imageFile->baseName . '.'
                . $this->imageFile->extension
            );
            return true;
        } else {
            return false;
        }
    }
}
