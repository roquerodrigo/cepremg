<?php

namespace App\Models;

/**
 * @Entity @Table(name="users")
 **/
class User
{
    /**
     * @var int Chave de implementação
     * @Id @Column(type="integer",options={"unsigned":true}) @GeneratedValue
     */
    private $id;

    /**
     * @var string Login de Usuário
     * @Column(name="username",type="string", length=15, unique=true, nullable=false)
     */
    private $username;

    /**
     * @var string Senha do Usuário
     * @Column(type="text", nullable=false)
     */
    private $password;

    /**
     * @var string Nome do Usuário
     * @Column(name="name",type="string",length=30, nullable=false)
     */
    private $name;

    /**
     * @var int Nível de privilégio do usuário [0]ROOT       : pode desativar usuários;
     *          [1]COMMOM USER: pode apenas popular o banco.
     * @Column(name="privilege",type="smallint", nullable=false, options={"default":1, "unsigned":true})
     */
    private $privilege = 1;

    /**
     * @var bool Usuário está ou não habilitado
     * @Column(name="isAble",type="boolean", nullable=false, options={"default":true})
     */
    private $isAble = true;

    /**
     * @return int
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * @param int $privilege
     *
     * @return User
     */
    public function setPrivilege(int $privilege)
    {
        $this->privilege = $privilege;

        return $this;
    }

    /**
     * @return int
     */
    public function getIsAble()
    {
        return $this->isAble;
    }

    /**
     * @param int $isAble
     *
     * @return User
     */
    public function setIsAble(int $isAble)
    {
        $this->isAble = $isAble;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * @param string $userName
     *
     * @return User
     */
    public function setUserName($userName)
    {
        $this->username = $userName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
