<?php
namespace common\components;

use common\helpers\CatalogTreeHelper;
use skeeks\cms\models\CmsTree;
use skeeks\cms\models\Tree;
use yii\base\InvalidConfigException;
use Yii;
use skeeks\cms\base\Component;
use yii\db\ActiveRecord;
use yii\db\Exception;

class XmlProductImport extends Component
{
    private $category;

    public function import()
    {
        if (\Yii::$app->request->get('run') || \Yii::$app->request->post())
        {
            $view = Yii::$app->getView();
            if(!\Yii::$app->appSettings->getXmlProductImport())
            {
                $view->registerJs("alert('Не указан файл');");
                return 'error';
            }
            $file = \Yii::$app->appSettings->getXmlProductImport();
            $content = file_get_contents($file);
            if(!$content)
            {
                $view->registerJs("alert('Неверный путь к файлу');");
                return 'error';
            }
            $sxe = simplexml_load_string($content);
            if (!$sxe)
            {
                foreach(libxml_get_errors() as $error)
                {
                    return 'error: '.$error->message;
                }
            }
            $shop = $sxe->shop;
            $categories = $shop->categories->children();
            $offers = $shop->offers;
            //var_dump($categories->category);

            $catalog = Tree::find()
                ->where(['code' => 'catalog'])->andWhere(['level' => 1])->one();

            foreach($sxe->shop->categories->category as $item) {

                if((int) $item->pid) {
                    //$item->level = $this->getLevel($categories->category,$item->pid,2);
                    //var_dump($item);
                }
                else {
                    $params = [];
                    $params['name'] = (string) $item->name;
                    $params['level'] = 2;
                    $params['pid'] = $catalog->id;
                    $tree_id = $this->checkTree($params);
                    var_dump($tree_id);
                }
            }

            /*foreach (self::$category as $k => $category)
            {
                if($category['pid']) {
                    $n_pid = self::checkParent($category['pid']);

                }
                else
                {
                    // проверика и создание раздела
                    print_r($k);
                    unset(self::$category[$k]);
                }
                //print_r($category->id);
                //print_r($category->name);
                //print_r($category->pid);
            }*/
            //var_dump($categories);


            //var_dump($categories);*/
            /*$catalog = Tree::find()
                ->where(['code' => 'catalog'])->andWhere(['level' => 1])->one();
            var_dump($catalog->id);*/


            return 'done!';
        }
    }

    private function getLevel($pid,$level)
    {
        foreach ($this->category as $item) {
            if($item->id == $pid) {
                if($item->pid) return $this->getLevel($this->category,$item->pid,$level+1);
                else return $level+1;
                break;
            }
        }
        return $level;
    }

    private function checkTree($params)
    {
        $model = Tree::find()
            ->andWhere(['name' => $params['name']])
            ->andWhere(['tree_type_id' => '5'])
            ->andWhere(['level' => $params['level']])
            ->andWhere(['pid' => $params['pid']])
            ->one();
        if(!$model)
        {
            $childTree = new Tree();
            $parent = Tree::find()->where(['id' => $params["pid"]])->one();
            $childTree->priority = Tree::PRIORITY_STEP;

            //Элемент с большим приоритетом
            if ($treeChildrens = $parent->getChildren()->orderBy(['priority' => SORT_DESC])->one())
            {
                $childTree->priority = $treeChildrens->priority + Tree::PRIORITY_STEP;
                $childTree->name = $params['name'];
            }
            if($parent && $parent->processAddNode($childTree))
            {
                return $childTree->id;
            }
            return false;
        }
        return $model->id;
    }
}