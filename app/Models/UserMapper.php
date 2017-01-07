<?php
/**
 * Created by PhpStorm.
 * User: sparrow
 * Date: 12/25/16
 * Time: 10:58 AM
 */

namespace Models;

use \Core\AbstractDataMapper;
use \Models\User;

class UserMapper extends AbstractDataMapper
{
    protected $entityTable = "user";

    public function insert(User $user)
    {
        $user->id = $this->adapter->insert(
            $this->entityTable,
            array("username"  => $user->username,
            "email" => $user->email)
        );
        return $user->id;
    }

    public function delete($id)
    {
        if ($id instanceof User) {
            $id = $id->id;
        }

        return $this->adapter->delete($this->entityTable, array("id = $id"));
    }

    protected function createEntity(array $row)
    {
        return new User($row["username"], $row["email"]);
    }

}