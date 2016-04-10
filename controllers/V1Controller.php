<?php

namespace app\controllers;

use Yii;

use app\models\ApiV1;

use yii\web\Controller;

class V1Controller extends Controller
{
    /**
     * @api {post} /name search a name
     * @apiName Name search
     * @apiGroup Name search
     * @apiVersion 0.1.1
     * @apiDescription Search a name. Input and output in JSON format.
     *
     * @apiParam {String} name
     *
     * @apiSuccess {Number} Score
     *
     * @apiSampleRequest /name
     *
     * @apiParamExample {json} Request-Example:
     *   {
     *       "name":"Osama Bin Laden",
     *   }
     *
     * @apiError BadRequest Invalid JSON data in request body: Syntax error.
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *       "error": "Invalid JSON data in request body: Syntax error."
     *     }
     *
     * @apiError InvalidRequest Invalid request. The param name is required.
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *       "error": "Invalid request. The param name is required."
     *     }
     *
     * @apiError MethodNotAllowed This url can only handle the following request methods: POST.
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 405 Method Not Allowed
     *     {
     *       "error": "This url can only handle the following request methods: POST."
     *     }
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *    [
     *        {
     *            "score": 100
     *        }
     *    ]
     */
    public function actionName(){

        //return['score'=>100];
        $search = new ApiV1();

        $timeStart = microtime(true);

        Yii::info(Yii::$app->request->post());



        // the input arrives in CamelCase format
        $search->attributes = Yii::$app->request->post();

        // validate
        if($search->validate()){
            $search->search($search->name);
            Yii::info('Search web service took '.microtime(true) - $timeStart.' seconds');

            return $search;
        }

        return $search;

    }


    /**
     * Verbs available. Only get
     * @return type
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'name'  => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * Custom content negotiaton
     * @param type $action
     * @return type
     */
    public function beforeAction($action) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }
}