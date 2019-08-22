<?php

class UsersService
{
  /**
   * @param string $username
   * @param string $password
   * @return array|null
   */
    public function findUser(string $username, string $password): ?array
    {
        $res = null;

        /** @var Users $user */
        $user = Users::findFirst([
            'username = :username: AND password = :password:',
            'bind' => [
                'username' => $username,
                'password' => $password,
            ],
        ]);

        if ($user) {
            $res = [
                'id' => $user->id,
            ];
        }

        return $res;
    }
}