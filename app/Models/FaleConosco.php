<?php


namespace App\Models;


/**
 * @Entity @Table(name="mensagens")
 **/
class FaleConosco
{
    /**
     * @var int Chave de implementação
     * @Id @Column(type="integer",options={"unsigned":true}) @GeneratedValue
     */
    private $id;

    /**
     * @var string Nome da pessoa
     * @Column(name="nome",type="string", length=50, unique=false, nullable=false)
     */
    private $nome;
    /**
     * @var string Instituicao
     * @Column(name="instituicao",type="string", length=50, unique=false, nullable=false)
     */
    private $instituicao;

    /**
     * @var string Mensagem da pessoa
     * @Column(name="mensagem",type="string", length=2000, unique=false, nullable=false)
     */
    private $finalidade;

    /**
     * @var bool Se foi arquivado ou nao
     * @Column(name="isArquivado",type="boolean", nullable=false, options={"default":false})
     */
    private $isArquivado = false;

    /**
     * @var string Data solicitada
     * @Column(name="periodo",type="string", length=100, unique=false, nullable=false)
     */
    private $periodo;

    /**
     * @var bool Se foi lida ou nao
     * @Column(name="lida",type="boolean", nullable=false, options={"default":false})
     */
    private $lida = false;

    /**
     * @param int $id
     *
     * @return FaleConosco
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $nome
     *
     * @return FaleConosco
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @param string $instituicao
     *
     * @return FaleConosco
     */
    public function setInstituicao($instituicao)
    {
        $this->instituicao = $instituicao;

        return $this;
    }

    /**
     * @param string $finalidade
     *
     * @return FaleConosco
     */
    public function setFinalidade($finalidade)
    {
        $this->finalidade = $finalidade;

        return $this;
    }

    /**
     * @param bool $isArquivado
     *
     * @return FaleConosco
     */
    public function setIsArquivado($isArquivado)
    {
        $this->isArquivado = $isArquivado;

        return $this;
    }

    /**
     * @param string $periodo
     *
     * @return FaleConosco
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

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
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getInstituicao()
    {
        return $this->instituicao;
    }

    /**
     * @return string
     */
    public function getFinalidade()
    {
        return $this->finalidade;
    }

    /**
     * @return bool
     */
    public function isArquivado()
    {
        return $this->isArquivado;
    }

    /**
     * @return string
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * @return bool
     */
    public function isLida()
    {
        return $this->lida;
    }

    /**
     * @param bool $lida
     *
     * @return FaleConosco
     */
    public function setLida($lida)
    {
        $this->lida = $lida;

        return $this;
    }


}