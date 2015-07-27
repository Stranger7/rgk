<?php
/**
 * Created by PhpStorm.
 * User: Novikov Sergey (novikov.stranger@gmail.com)
 * Date: 26.07.2015
 * Time: 19:24
 */

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    const UPLOAD_PATH = 'uploads/';

    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['imageFile'],
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'png, jpg',
                'checkExtensionByMimeType' => false
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'imageFile' => 'Изображение',
        ];
    }

    /**
     * Upload image and save to upload folder with unique filename
     *
     * @return bool|string
     */
    public function upload()
    {
        if ($this->validate()) {
            $filename = time() . '-' // for uniqueness
                . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs(self::UPLOAD_PATH . $filename);
            return $filename;
        } else {
            return false;
        }
    }
}