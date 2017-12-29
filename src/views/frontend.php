<?php

use EasyWeChat\Factory;
use moguyun\plugins\share\models\Share;
use yii\web\View;

/* @var $this View */
/* @var $model Share */
$this->registerJsFile('https://res.wx.qq.com/open/js/jweixin-1.2.0.js');
$app = Factory::officialAccount(Yii::$app->params['wechat.officialAccount']);
$json = $app->jssdk->buildConfig(array('onMenuShareTimeline', 'onMenuShareAppMessage'), false);
$js = <<<JS
wx.config($json);
wx.onMenuShareTimeline({
    title: '$model->title',
    link: '$model->url',
    imgUrl: window.location.origin + '$model->image'
});
wx.onMenuShareAppMessage({
    title: '$model->title',
    desc: '$model->description',
    link: '$model->url',
    imgUrl: window.location.origin + '$model->image'
});
JS;
$this->registerJs($js, View::POS_END);
