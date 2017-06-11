<?php
/**
 * Created by PhpStorm.
 * User: lfaria
 * Date: 10/06/17
 * Time: 22:56
 */

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getInstituicao(): string
    {
        return $this->instituicao;
    }

    /**
     * @param string $instituicao
     */
    public function setInstituicao(string $instituicao)
    {
        $this->instituicao = $instituicao;
    }

    /**
     * @return string
     */
    public function getFinalidade(): string
    {
        return $this->finalidade;
    }

    /**
     * @param string $finalidade
     */
    public function setFinalidade(string $finalidade)
    {
        $this->finalidade = $finalidade;
    }

    /**
     * @return bool
     */
    public function isArquivado(): bool
    {
        return $this->isArquivado;
    }

    /**
     * @param bool $isArquivado
     */
    public function setIsArquivado(bool $isArquivado)
    {
        $this->isArquivado = $isArquivado;
    }

    /**
     * @return string
     */
    public function getPeriodo(): string
    {
        return $this->periodo;
    }

    /**
     * @param string $periodo
     */
    public function setPeriodo(string $periodo)
    {
        $this->periodo = $periodo;
    }




}