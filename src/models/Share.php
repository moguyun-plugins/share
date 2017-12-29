<?php

namespace moguyun\plugins\share\models;

use yii;
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

    public function attributeLabels()
    {
        return [
            'title' => '分享标题',
            'url' => '分享链接',
            'description' => '分享描述',
            'image' => '图标预览',
            'imageFile' => '分享图标',
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
        $post = Yii::$app->request->post('Share');
        if (isset($post['imageFile'])) {
            $file = UploadedFile::getInstance($this, 'imageFile');
            if (!empty($file)) {
                $this->imageFile = $file;
            }
        }
        if ($this->imageFile instanceof UploadedFile) {
            $date = '/uploads/' . date('Ymd') . '/';
            $path = \Yii::getAlias('@frontend') . '/web/' . $date;
            if (!file_exists($path)) {
                mkdir($path);
            }
            $filename = uniqid() . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($path . $filename);
            $this->image = $date . $filename;
        }
    }

    public function save()
    {
        foreach ($this->fields() as $attribute) {
            PluginSetting::set($this->identify, $attribute, $this->{$attribute});
        }
        return true;
    }
}
