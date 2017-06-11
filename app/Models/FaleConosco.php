<?php


namespace app\Models;


/**
 * @Entity @Table(name="mensagens")
 **/
class FaleConosco {
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
     * @return FaleConosco
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $nome
     *  @return FaleConosco
     */
    public function setNome(string $nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @param string $instituicao
     *  @return FaleConosco
     */
    public function setInstituicao(string $instituicao)
    {
        $this->instituicao = $instituicao;
        return $this;
    }

    /**
     * @param string $finalidade
     *  @return FaleConosco
     */
    public function setFinalidade(string $finalidade)
    {
        $this->finalidade = $finalidade;
        return $this;
    }

    /**
     * @param bool $isArquivado
     *  @return FaleConosco
     */
    public function setIsArquivado(bool $isArquivado)
    {
        $this->isArquivado = $isArquivado;
        return $this;
    }

    /**
     * @param string $periodo
     *  @return FaleConosco
     */
    public function setPeriodo(string $periodo)
    {
        $this->periodo = $periodo;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getInstituicao(): string
    {
        return $this->instituicao;
    }

    /**
     * @return string
     */
    public function getFinalidade(): string
    {
        return $this->finalidade;
    }

    /**
     * @return bool
     */
    public function isArquivado(): bool
    {
        return $this->isArquivado;
    }

    /**
     * @return string
     */
    public function getPeriodo(): string
    {
        return $this->periodo;
    }

    /**
     * @return bool
     */
    public function isLida(): bool
    {
        return $this->lida;
    }

    /**
     * @param bool $lida
     * @return FaleConosco
     */
    public function setLida(bool $lida)
    {
        $this->lida = $lida;
        return $this;
    }





}