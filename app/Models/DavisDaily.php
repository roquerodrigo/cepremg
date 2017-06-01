<?php

namespace App\Models;

/**
 * @Entity @Table(name="davis_daily")
 **/
class DavisDaily extends Davis
{
	/**
     * @var int Dado preenche ou não os requisitos minimos para ser usado na visualização
     *  0 - dado inválido para qualquer visualização
     *  1 - dado inválido apenas para visualização de chuva
     *  2 - dado válido para qualquer visualização
     * @Column(name="minRequirement",type="integer", nullable=false, options={"default":0})
     */
    private $minRequirement = 0;

    /**
     * @var int Quantidade de dados usados para produzir o valor dessa coluna, será usado para
     * efetuar operações do tipo UPDATE
     * @Column(name="amountData",type="integer", nullable=false, options={"default":0})
     */
    private $amountData = 0;

    /**
     * @param int $minRequirement
     *
     * @return DavisDaily
     */
    public function setMinRequirement($minRequirement)
    {
        $this->minRequirement = $minRequirement;

        return $this;
    }

    /**
    * @return int
    */
    public function getMinRequirement()
    {
        return $this->minRequirement;
    }

    /**
     * @param int $amountData
     *
     * @return DavisDaily
     */
    public function setAmountData($amountData)
    {
        $this->amountData = $amountData;

        return $this;
    }

    /**
    * @return int
    */
    public function getAmountData()
    {
        return $this->amountData;
    }

}
