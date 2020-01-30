<?php

namespace app\repositories;

use app\models\Author;
use app\models\Book;
use yii\db\ActiveQuery;

/**
 * Class BookRepository
 * @package app\repositories
 */
class BookRepository
{
    /**
     * @param bool $active
     * @return ActiveQuery
     */
    public function getQuery($active = true): ActiveQuery
    {
        return $active ? Book::find()->andWhere([Book::tableName() . '.status' => Book::STATUS_ACTIVE]) : Book::find();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAllWithAuthorName(): array
    {
        return $this
            ->getQuery(true)
            ->joinWith(Author::tableName())
            ->select([Book::tableName() . '.name AS book_name', Author::tableName() . '.name AS author_name'])
            ->asArray()
            ->all();
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null|Book
     */
    public function getOne($id): Book
    {
        return $this
            ->getQuery(true)
            ->andWhere(['id' => $id])
            ->one();
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteBook($id): bool
    {
        $book = $this->getOne($id);
        if (!$book) {
            return false;
        }
        $book->status = Book::STATUS_DELETED;
        return $book->validate() && $book->save();
    }
}