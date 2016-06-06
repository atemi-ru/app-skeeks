<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.03.2015
 */
/* @var $this \yii\web\View */

/*
$model = new \yii\base\DynamicModel([
    'phone' => '+74957222873'
]);
$model->addRule(['phone'], \skeeks\cms\validators\PhoneValidator::className())->validate();

if ($model->hasErrors())
{
    echo 'Некорректный phone: ' . $model->phone;
} else
{
    echo 'phone: ' . $model->phone;
}*/
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-4 hidden-xs">
            <div class="sx-top-phone" style="    font-size: 16px;
    padding-top: 42px;">
                <i class="fa fa-phone"></i>
                <?= \skeeks\cms\cmsWidgets\text\TextCmsWidget::widget([
				'namespace'         => 'header-phones',
				'text'              => <<<HTML
				+7 (999) 111-11-11, +7 (999) 222-22-22
HTML
,
			]); ?>
                <br />
                <a href="#sx-callback" class="sx-fancybox" style="text-decoration: none; border-bottom: 1px dashed">Заказать обратный звонок</a>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="sx-top-logo-block">
                <a href="<?= \yii\helpers\Url::home(); ?>">
                    <img src="<?= \frontend\assets\AppAsset::getAssetUrl('img/logos/logo-colors.svg'); ?>" alt="" />
                    <!--<img src="http://skeeks.com/uploads/all/86/1c/bf/861cbf2340d3da768c623855353c544b.jpg" alt="" />-->
                </a>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 hidden-xs" style="text-align: right;">
            <div style="padding-top: 50px">
                <? if (\Yii::$app->user->isGuest) : ?>
                    <a href="<?= \skeeks\cms\helpers\UrlHelper::construct('cms/auth/login')->setCurrentRef(); ?>">
                        <i class="glyphicon glyphicon-log-in"></i> Вход
                    </a>
                <? else : ?>
                    <a href="<?= \Yii::$app->user->identity->getPageUrl('edit'); ?>">
                        <i class="fa fa-user"></i> Личный кабинет (<?= \Yii::$app->user->identity->displayName; ?>)
                    </a>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>




<!--
    AVAILABLE HEADER CLASSES

    Default nav height: 96px
    .header-md 		= 70px nav height
    .header-sm 		= 60px nav height

    .noborder 		= remove bottom border (only with transparent use)
    .transparent	= transparent header
    .translucent	= translucent header
    .sticky			= sticky header
    .static			= static header
    .dark			= dark header
    .bottom			= header on bottom

    shadow-before-1 = shadow 1 header top
    shadow-after-1 	= shadow 1 header bottom
    shadow-before-2 = shadow 2 header top
    shadow-after-2 	= shadow 2 header bottom
    shadow-before-3 = shadow 3 header top
    shadow-after-3 	= shadow 3 header bottom

    .clearfix		= required for mobile menu, do not remove!

    Example Usage:  class="clearfix sticky header-sm transparent noborder"
-->
<div id="header" class="sticky clearfix">

    <!-- TOP NAV -->
    <header id="topNav">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
            <div class=" sx-menu-bg">

            <!-- Mobile Menu Button -->
            <button class="btn btn-mobile" data-toggle="collapse" data-target=".nav-main-collapse">
                <i class="fa fa-bars"></i>
            </button>

            <!-- BUTTONS -->
            <ul class="pull-right nav nav-pills nav-second-main">

                <!-- SEARCH -->
               <li class="search">
                    <a href="javascript:;">
                        <i class="fa fa-search"></i>
                    </a>
                    <div class="search-box">
                        <form action="/search" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="<?= \Yii::$app->cmsSearch->searchQueryParamName; ?>"  placeholder="Поиск..."  value="<?= \Yii::$app->cmsSearch->searchQuery; ?>" />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Найти</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- /SEARCH -->

                <?= \skeeks\cms\shop\widgets\cart\ShopCartWidget::widget([
                    'namespace' => 'ShopCartWidget-small-top',
                    'viewFile' => '@app/views/widgets/ShopCartWidget/small-top'
                ])?>


            </ul>
            <!-- /BUTTONS -->


            <!-- Logo -->
            <!--<a class="logo pull-left" href="/">
                <img src="<?/*= \frontend\assets\AppAsset::getAssetUrl('img/logos/logo.png'); */?>" alt="" />
            </a>-->

            <!--
                Top Nav

                AVAILABLE CLASSES:
                submenu-dark = dark sub menu
            -->
            <div class="navbar-collapse pull-left nav-main-collapse collapse submenu-dark">
                <nav class="nav-main">

                    <!--
                        NOTE

                        For a regular link, remove "dropdown" class from LI tag and "dropdown-toggle" class from the href.
                        Direct Link Example:

                        <li>
                            <a href="#">HOME</a>
                        </li>
                    -->
                    <?= \skeeks\cms\cmsWidgets\treeMenu\TreeMenuCmsWidget::widget([
                        'namespace'      => 'menu-top',
                        'viewFile'       => '@template/widgets/TreeMenuCmsWidget/menu-top.php',
                        'label'          => 'Верхнее меню',
                        'level'          => '1',
                        'enabledRunCache'=> \skeeks\cms\components\Cms::BOOL_N,
                    ]); ?>


                </nav>
            </div>


            </div>
            </div>
            </div>
        </div>
    </header>
    <!-- /Top Nav -->

</div>



