<?php

namespace App\Models;

/**
 * @Entity @Table(name="users")
 **/
class User
{
    /**
     * @var int Chave de implementação
     * @Id @Column(type="integer") @GeneratedValue
     */
    private $id;

    /**
     * @var string Login de Usuário
     * @Column(name="userName",type="string", length=15, unique=true, nullable=false)
     */
    private $userName;

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
        return $this->userName;
    }

    /**
     * @param string $userName
     *
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

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
