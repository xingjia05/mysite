<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rbac\ManagerInterface;
use yii\web\ForbiddenHttpException;

/**
 * Site controller
 */
class BaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $privilege = Yii::$app->params['privilegeList'];
        if (isset($privilege[Yii::$app->getRequest()->pathInfo])) {
            $ret = Yii::$app->user->can($privilege[Yii::$app->getRequest()->pathInfo]);
            if ($ret == false) {
                throw new ForbiddenHttpException;
            }
        }
        return true;
    }
}
