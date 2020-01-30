<?php


namespace app\controllers;


use app\forms\BookForm;
use app\repositories\BookRepository;
use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actionList()
    {
        return (new BookRepository())->getAllWithAuthorName();
    }

    public function actionUpdate($id)
    {
        $form = new BookForm();
        $book = (new BookRepository())->getOne($id);
        if ($book && $form->load(\Yii::$app->request->post()) && $form->validate() && $form->save($book)) {
            return [
                'status' => 'success'
            ];
        }
        return [
            'status' => 'fail'
        ];
    }

    public function actionView($id)
    {
        return (new BookRepository())->getOne($id);
    }

    public function actionDelete($id)
    {
        $status = (new BookRepository())->deleteBook($id) ? 'success' : 'fail';
        return [
            'status' => $status
        ];
    }
}