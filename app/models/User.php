<?php
 
namespace App\models;

/**
 * @Entity @Table(name="User")
 **/
class User
{
	/**
     * @var int Chave de implementação
     * @Id @Column(type="integer") @GeneratedValue
     */
	protected $id;

	/**
     * @var string Login de Usuário
     * @Column(name="userName",type="string", length=15, unique=true, nullable=false) 
     */
	protected $userName;

	/**
	 * @var text Senha do Usuário
	 * @Column(type="text", nullable=false)
	 */
	protected $password;

	/**
	 * @var string Nome do Usuário
	 * @Column(name="name",type="string",length=30, nullable=false)
	 */
	protected $name;

	/**
	 * @param string name
	 * @param string value
	 */
	public function __set($name, $value)
    {
        if(property_exists(get_class($this), $name)) {
            $this->$name = $value;
        }
    }

    /**
	 * @param string name
	 * @return mixed
	 */
    public function __get($name)
    {
        if(property_exists(get_class($this), $name))
        	return $this->$name;
        return null;
    }
}