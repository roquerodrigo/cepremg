<?php

namespace App\Models;
use DateTime;
/**
 * @Entity @Table(name="davis_daily")
 **/
class DavisDaily extends AbstractDavis
{
    public function __construct(DavisHourly $davis = NULL) {
        if($davis !== NULL) {
            $dateTime = clone $davis->getDateTime();
            $dateTime->setTime(0,0);

            $this->setDateTime($dateTime);
            $this->setTempOut($davis->getTempOut());
            $this->setHiTemp($davis->getHiTemp());
            $this->setLowTemp($davis->getLowTemp());
            $this->setOutHum($davis->getOutHum());
            $this->setDewPt($davis->getDewPt());
            $this->setWindSpeed($davis->getWindSpeed());
            #$this->windDir = $davis->getWindDir();
            $this->setBar($davis->getBar());
            $this->setRain($davis->getRain());
            $this->setSolarRad($davis->getSolarRad());
            $this->setUVIndex($davis->getUVIndex());
            $this->amountData = $davis->getAmountData();
        }
        $this->minRequirement = 0;    
    }
	/**
     * @var int Dado preenche ou não os requisitos minimos para ser usado na visualização
     *  0 - dado inválido para qualquer visualização
     *  1 - dado inválido apenas para visualização de chuva
     *  2 - dado válido para qualquer visualização
     * @Column(name="minRequirement",type="integer", nullable=false, options={"default":0})
     */
    private $minRequirement;

    /**
     * @var int Quantidade de dados usados para produzir o valor dessa coluna, será usado para
     * efetuar operações do tipo UPDATE
     * @Column(name="amountData",type="integer", nullable=false, options={"default":0})
     */
    private $amountData;

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

    /**
    * @param DavisHourly $davis
    *
    * @return DavisDaily
    */
    public function mergeDavis(DavisHourly $davis)
    {
        $this->amountData += $davis->getAmountData() ;
        $this->setTempOut($this->getTempOut() + $davis->getTempOut());
        $this->setHiTemp = max($davis->getHiTemp(), $this->getHiTemp());
        $this->setLowTemp = max($davis->getLowTemp(), $this->getLowTemp());
        $this->setOutHum($this->getOutHum() + $davis->getOutHum());
        $this->setDewPt($this->getDewPt() + $davis->getDewPt());
        $this->setWindSpeed($this->getWindSpeed() + $davis->getWindSpeed());
        #$this-set >windDir = $davis-> >windDir()getWindDir(); 
        $this->setBar($this->getBar() + $davis->getBar());
        $this->setRain($this->getRain() + $davis->getRain());
        $this->setSolarRad($this->getSolarRad() + $davis->getSolarRad());
        $this->setUVIndex($this->getUVIndex() + $davis->getUVIndex());
    }

    /**
    * Prepara os valores para armazenar no banco (operação AVG)
    * @return DavisDaily
    */
    public function doPrepare() {
        $this->setTempOut($this->getTempOut() / $this->amountData);
        $this->setOutHum($this->getOutHum() / $this->amountData);
        $this->setDewPt($this->getDewPt() / $this->amountData);
        $this->setWindSpeed($this->getWindSpeed()/ $this->amountData);
        $this->setBar($this->getBar() / $this->amountData);
        $this->setSolarRad($this->getSolarRad() / $this->amountData);
        $this->setUVIndex($this->getUVIndex() / $this->amountData);
        return $this;
    }

    /**
    * Desfaz os calculos de AVG usados para o banco
    * @return DavisDaily
    */
    public function undoPrepare() {
        $this->setTempOut($this->getTempOut() * $this->amountData);
        $this->setOutHum($this->getOutHum() * $this->amountData);
        $this->setDewPt($this->getDewPt() * $this->amountData);
        $this->setWindSpeed($this->getWindSpeed() * $this->amountData);
        $this->setBar($this->getBar() * $this->amountData);
        $this->setSolarRad($this->getSolarRad() * $this->amountData);
        $this->setUVIndex($this->getUVIndex() * $this->amountData); 
        return $this;
    }
}
