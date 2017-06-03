<?php

namespace App\Models;
use DateTime;
/**
 * @Entity @Table(name="davis_hourly") 
 **/
class DavisHourly extends AbstractDavis
{
    public function __construct(Davis $davis = null) {
        if($davis !== null) {
            $dateTime = clone $davis->getDateTime();
            $dateTime->setTime($dateTime->format('H'),0);
            $this->setDateTime($dateTime);
        
            $this->validUVIndex = false;
            $this->validSolarRad = false;
            $this->validRain = false;
            $this->validBar = false;
            $this->validWindDir = false;
            $this->validWindSpeed = false;
            $this->validDewPt = false;
            $this->validOutHum = false;
            $this->validLowTemp = false;
            $this->validHiTemp = false;
            $this->validTempOut = false;
            
            $this->amountWindDir = 0;
            $this->amountUVIndex = 0;
            $this->amountSolarRad = 0;
            $this->amountRain = 0;
            $this->amountBar = 0;
            $this->amountWindDir = 0;
            $this->amountWindSpeed = 0;
            $this->amountDewPt = 0;
            $this->amountOutHum = 0;
            $this->amountLowTemp = 0;
            $this->amountHiTemp = 0;
            $this->amountTempOut = 0;
            $this->amountData = 0;
        }
    }

    public function mergeDavis($davis)
    {
        $this->setTempOut($this->getTempOut() + $davis->getTempOut());
        $this->setHiTemp(max($this->getHiTemp(), $davis->getHiTemp())) ;
        
        $has_value = $davis->getLowTemp() !== null;
        if($this->getLowTemp() === null && $has_value) {
            $this->setlowTemp($davis->getLowTemp());
        } elseif($has_value) {
            $this->setLowTemp(min($this->getLowTemp(), $davis->getLowTemp()));
        }

        $this->setOutHum($this->getOutHum() + $davis->getOutHum());
        $this->setDewPt($this->getDewPt() + $davis->getDewPt());
        $this->setWindSpeed($this->getWindSpeed() + $davis->getWindSpeed());
        $this->setBar($this->getBar() + $davis->getBar());
        $this->setrain($this->getRain() + $davis->getRain());
        $this->setSolarRad($this->getSolarRad() + $davis->getSolarRad());
        $this->setUVIndex($this->getUVIndex() + $davis->getUVIndex());

        $this->amountData++;
        $this->amountTempOut += $davis->getTempOut() !== null;
        $this->amountHiTemp += $davis->getHiTemp() !== null;
        $this->amountLowTemp += $davis->getLowTemp() !== null;
        $this->amountOutHum += $davis->getOutHum() !== null;
        $this->amountDewPt += $davis->getDewPt() !== null;
        $this->amountWindSpeed += $davis->getWindSpeed() !== null;
        $this->amountBar += $davis->getBar() !== null;
        $this->amountRain += $davis->getRain() !== null;
        $this->amountSolarRad += $davis->getSolarRad() !== null;
        $this->amountUVIndex += $davis->getUVIndex() !== null;
    } 

    public function doPrepare() 
    {
        $this->setTempOut($this->getTempOut() / $this->amountTempOut) ;
        $this->setOutHum($this->getOutHum() / $this->amountOutHum);
        $this->setDewPt($this->getDewPt() / $this->amountDewPt);
        $this->setWindSpeed($this->getWindSpeed() / $this->amountWindSpeed);
        $this->setBar($this->getBar() / $this->amountBar);
        $this->setSolarRad($this->getSolarRad() / $this->amountSolarRad);
        $this->setUVIndex($this->getUVIndex() / $this->amountUVIndex);
        return $this;
    }
    
    public function undoPrepare() 
    {
        $this->setTempOut($this->getTempOut() * $this->amountTempOut) ;
        $this->setOutHum($this->getOutHum() * $this->amountOutHum);
        $this->setDewPt($this->getDewPt() * $this->amountDewPt);
        $this->setWindSpeed($this->getWindSpeed() * $this->amountWindSpeed);
        $this->setBar($this->getBar() * $this->amountBar);
        $this->setSolarRad($this->getSolarRad() * $this->amountSolarRad);
        $this->setUVIndex($this->getUVIndex() * $this->amountUVIndex);
        return $this;
    }  
    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_uv_index",type="boolean", nullable=false, options={"default":false})
     */
    private $validUVIndex;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_uv_index",type="integer", nullable=false, options={"default":0})
     */
    private $amountUVIndex;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_solar_rad",type="boolean", nullable=false, options={"default":false})
     */
    private $validSolarRad;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_solar_rad",type="integer", nullable=false, options={"default":0})
     */
    private $amountSolarRad;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_rain",type="boolean", nullable=false, options={"default":false})
     */
    private $validRain;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_rain",type="integer", nullable=false, options={"default":0})
     */
    private $amountRain;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_bar",type="boolean", nullable=false, options={"default":false})
     */
    private $validBar;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_bar",type="integer", nullable=false, options={"default":0})
     */
    private $amountBar;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_wind_dir",type="boolean", nullable=false, options={"default":false})
     */
    private $validWindDir;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_wind_dir",type="integer", nullable=false, options={"default":0})
     */
    private $amountWindDir;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_wind_speed",type="boolean", nullable=false, options={"default":false})
     */
    private $validWindSpeed;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_wind_speed",type="integer", nullable=false, options={"default":0})
     */
    private $amountWindSpeed;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_dew_pt",type="boolean", nullable=false, options={"default":false})
     */
    private $validDewPt;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_dew_pt",type="integer", nullable=false, options={"default":0})
     */
    private $amountDewPt;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_out_hum",type="boolean", nullable=false, options={"default":false})
     */
    private $validOutHum;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_out_hum",type="integer", nullable=false, options={"default":0})
     */
    private $amountOutHum;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_low_temp",type="boolean", nullable=false, options={"default":false})
     */
    private $validLowTemp;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_low_temp",type="integer", nullable=false, options={"default":0})
     */
    private $amountLowTemp;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_hi_temp",type="boolean", nullable=false, options={"default":false})
     */
    private $validHiTemp;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_hi_temp",type="integer", nullable=false, options={"default":0})
     */
    private $amountHiTemp;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_temp_out",type="boolean", nullable=false, options={"default":false})
     */
    private $validTempOut;

	/**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_temp_out",type="integer", nullable=false, options={"default":0})
     */
    private $amountTempOut;

    /**
     * @var int Quantidade de dados usados para produzir o valor dessa coluna
     * @Column(name="amount_data",type="integer", nullable=false, options={"default":0})
     */
    private $amountData;

    /**
     * @return DavisDaily
     */
    public function setMinRequirement()
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
     * @return int
     */
    public function getAmountData()
    {
        return $this->amountData;
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

    
    public function getAmountTempOut()
    {
        return $this->amountTempOut;     
    }
    public function getAmountHiTemp()
    {
        return $this->amountHiTemp;
    }
    public function getAmountLowTemp()
    {
        return $this->amountLowTemp;
    }
    public function getAmountOutHum()
    {
        return $this->amountOutHum;
    }
    public function getAmountDewPt()
    {
        return $this->amountDewPt;
    }
    public function getAmountWindSpeed()
    {
        return $this->amountWindSpeed;
    }
    public function getAmountBar()
    {
        return $this->amountBar;
    }
    public function getAmountRain()
    {
        return $this->amountRain;
    }
    public function getAmountSolarRad()
    {
        return $this->amountSolarRad;
    }
    public function getAmountUVIndex()
    {
        return $this->amountUVIndex;
    } 
    public function setAmountTempOut($amount)
    {
        $this->amountTempOut = $amount;
        return $this;        
    }
    public function setAmountHiTemp($amount)
    {
        $this->amountHiTemp = $amount;
        return $this;
    }
    public function setAmountLowTemp($amount)
    {
        $this->amountLowTemp = $amount;
        return $this;
    }
    public function setAmountOutHum($amount)
    {
        $this->amountOutHum = $amount;
        return $this;
    }
    public function setAmountDewPt($amount)
    {
        $this->amountDewPt = $amount;
        return $this;
    }
    public function setAmountWindSpeed($amount)
    {
        $this->amountWindSpeed = $amount;
        return $this;
    }
    public function setAmountBar($amount)
    {
        $this->amountBar = $amount;
        return $this;
    }
    public function setAmountRain($amount)
    {
        $this->amountRain = $amount;
        return $this;
    }
    public function setAmountSolarRad($amount)
    {
        $this->amountSolarRad = $amount;
        return $this;
    }
    public function setAmountUVIndex($amount)
    {
        $this->amountUVIndex = $amount;
        return $this;
    }  
}
