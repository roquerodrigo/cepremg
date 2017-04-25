<?phps
 
namespace App\Models;
/*
 * @Entity 
 * @Table(name="user")
 **/
class User
{
	/**
     * @var int Chave de implementação
     * @Id @Column(type="integer") @GeneratedValue
     */
	protected $id;

	/**
     * @var string Nome de Usuário
     * @Column(type="text", unique=true, nullable=false) 
     */
	protected $userName;

	/* 
	 * @var string
	 * @Column(type="text", nullable=false)
	 */
	protected $password;

	/* 
	 * @var string
	 * @Column(type="text", nullable=false)
	 */
	protected $name;

	/* 
	 * @param string name
	 * @param string value
	 */
	public function __set($name, $value)
    {
        if(property_exists(get_class($this), $name)) {
            $this->$name = $value;
        }
    }

    /* 
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