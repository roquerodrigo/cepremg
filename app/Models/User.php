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
     * @var int Nível de privilégio do usuário
     *          [0]ROOT       : pode desativar usuários;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

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
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAble()
    {
        return $this->isAble;
    }

    /**
     * @param bool $isAble
     *
     * @return User
     */
    public function setIsAble($isAble)
    {
        $this->isAble = $isAble;

        return $this;
    }
}
