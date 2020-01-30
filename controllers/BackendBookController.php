<?php


namespace app\controllers;


use app\forms\BookForm;
use app\models\Book;
use app\repositories\BookRepository;
use yii\web\Controller;

/*
 * TODO вынести все в модуль backend
 */

class BackendBookController extends Controller
{
    public function actionIndex()
    {
        $books = (new BookRepository())->getAllWithAuthorName();
        return $this->render('index', ['books' => $books]);
    }

//CRUD
    public function actionCreate()
    {
        $form = new BookForm();
        if (\Yii::$app->request->isAjax) {
            return $this->save($form, new Book());
        }
        return $this->render('create', ['form' => $form]);
    }

    public function actionUpdate($id)
    {
        $book = (new BookRepository())->getOne($id);
        if (!$book) {
            return $this->redirect('/book-backend/index');
        }
        $form = new BookForm();
        $form->loadFromModel($book);
        if (\Yii::$app->request->isAjax) {
            return $this->save($form, $book);
        }
        return $this->render('update', ['form' => $form]);
    }

    public function actionDelete($id)
    {
        (new BookRepository())->deleteBook($id);
        return $this->redirect('/book-backend/index');
    }
    //CRUD END

    /**
     * Чтобы не повторяться
     *
     * @param BookForm $form
     * @param Book $book
     * @return bool
     */
    private function save(BookForm $form, Book $book): bool
    {
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $book->status = Book::STATUS_ACTIVE;
            return $form->save($book);
        }
        return false;
    }
}