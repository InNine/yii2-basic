<?php

namespace app\forms;

use app\models\Book;
use yii\base\Model;

/**
 * Class BookForm
 * @package app\forms
 */
class BookForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'string'],
        ];
    }

    /**
     * @param Book $book
     * @return bool
     */
    public function save(Book $book): bool
    {
        foreach (array_intersect($book->attributes, $this->attributes) as $name) {
            $book->$name = $this->$name;
        }
        return $book->validate() && $book->save();
    }

    /**
     * @param Book $book
     */
    public function loadFromModel(Book $book): void
    {
        foreach (array_intersect($book->attributes, $this->attributes) as $name) {
            $this->$name = $book->$name;
        }
    }
}