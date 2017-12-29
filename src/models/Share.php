<?php

namespace moguyun\plugins\share\models;

use yii\base\Model;
use yii\web\UploadedFile;
use zacksleo\yii2\plugin\models\PluginSetting;

class Share extends Model
{
    public $identify;
    public $title;
    public $description;
    public $url;
    public $image;
    public $imageFile;

    public function rules()
    {
        return [
            [['identify', 'title', 'description', 'url'], 'required'],
            [['identify', 'title', 'description', 'url', 'image'], 'string'],
            ['url', 'url'],
            [
                'imageFile',
                'file',
                'extensions' => ['png', 'jpg', 'jpeg'],
                'skipOnEmpty' => true,
                'maxFiles' => 1,
                'maxSize' => 100 * 1024
            ],
        ];
    }

    public function fields()
    {
        return [
            'title',
            'description',
            'url',
            'image'
        ];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        if (isset($doctor['imageFile'])) {
            $file = UploadedFile::getInstance($this, 'imageFile');
            if (!empty($file)) {
                $this->imageFile = $file;
            }
        }
        if ($this->imageFile instanceof UploadedFile) {
            $date = date('Ymd') . '/';
            $path = \Yii::getAlias('@frontend') . '/web/uploads/' . $date;
            if (!file_exists($path)) {
                mkdir($path);
            }
            $filename = uniqid() . '.' . $this->image->extension;
            $this->uploadedFile->saveAs($path . $filename);
            $this->image = $date . $filename;
        }
    }

    public function save()
    {
        foreach ($this->fields() as $attribute) {
            PluginSetting::set($this->identify, $attribute, $this->$attribute);
        }
        return true;
    }
}
