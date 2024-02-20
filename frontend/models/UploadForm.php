<?php

namespace frontend\models;

use common\service\XmlService;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $myFile;

    public function rules()
    {
        return [
            [['myFile'], 'file', 'skipOnEmpty' => false],
        ];
    }

    public function upload(): bool
    {
        if ($this->validate()) {
            $path = Yii::getAlias('@xml/tmp/' . $this->myFile->baseName . '.' . $this->myFile->extension);
            $this->myFile->saveAs($path);
            return (new XmlService())->xmlToDatabase($path);
        } else {
            return false;
        }
    }
}