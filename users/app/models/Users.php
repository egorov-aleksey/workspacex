<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public const
        COLUMN_ID = 'id',
        COLUMN_USERNAME = 'username',
        COLUMN_PASSWORD = 'password';

    public $id;

    public $username;

    public $password;
}