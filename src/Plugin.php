<?php

namespace moguyun\plugins\share;

use moguyun\plugins\share\models\Share;
use yii;
use zacksleo\yii2\plugin\components\Plugin as IPlugin;
use zacksleo\yii2\plugin\models\PluginSetting;

class Plugin extends IPlugin
{
    public function init()
    {
        $this->identify = 'share';
        $this->name = '微信分享';
        $this->version = '0.0.1';
        $this->description = '自定义微信分享的标题、描述、链接和图片';
        $this->copyright = '蘑菇云';
        $this->website = 'http://www.moguyun.ltd';
        $this->icon = 'icon.svg';
    }

    public function hooks()
    {
        return [
            'global_footer' => 'globalFooter'
        ];
    }

    public function globalFooter()
    {
        $model = new Share();
        $model->attributes = [
            'title' => $this->getSetting('title'),
            'description' => $this->getSetting('description'),
            'url' => $this->getSetting('url'),
            'image' => $this->getSetting('image'),
        ];
        echo $this->render('frontend', [
            'model' => $model
        ]);
    }

    public function admincp()
    {
        $model = new Share();
        $model->attributes = [
            'title' => $this->getSetting('title'),
            'description' => $this->getSetting('description'),
            'url' => $this->getSetting('url'),
            'image' => $this->getSetting('image'),
        ];
        $model->identify = $this->identify;
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->session->setFlash('success', '设置成功');
        }
        return $this->render('admincp', [
            'model' => $model
        ]);
    }

    public function install()
    {
        $this->setSetting('title', '');
        $this->setSetting('description', '');
        $this->setSetting('url', '');
        $this->setSetting('image', '');
        return true;
    }

    public function uninstall()
    {
        PluginSetting::deleteAll([
            'plugin' => $this->identify
        ]);
        return true;
    }
}
