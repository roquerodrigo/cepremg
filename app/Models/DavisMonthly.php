<?php

namespace App\Models;
use DateTime;
/**
 * @Entity @Table(name="davis_monthly")
 **/
class DavisMonthly extends AbstractDavis
{
    public function __construct(DavisDaily $davis = null) {
        if($davis !== null) {
            $dateTime = clone $davis->getDateTime();
            $dateTime->setDate($dateTime->format('Y'),$dateTime->format('m'),1);
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
            
            $this->amountWindDir['WNW']=0;            
            $this->amountWindDir['NW']=0;            
            $this->amountWindDir['NNW']=0;            
            $this->amountWindDir['N']=0;            
            $this->amountWindDir['NNE']=0;            
            $this->amountWindDir['NE']=0;            
            $this->amountWindDir['ENE']=0;            
            $this->amountWindDir['E']=0;            
            $this->amountWindDir['ESE']=0;            
            $this->amountWindDir['SE']=0;            
            $this->amountWindDir['SSE']=0;            
            $this->amountWindDir['S']=0;            
            $this->amountWindDir['SSW']=0;            
            $this->amountWindDir['SW']=0;            
            $this->amountWindDir['WSW']=0;            
            $this->amountWindDir['W']=0;

            $this->amountUVIndex = 0;
            $this->amountSolarRad = 0;
            $this->amountRain = 0;
            $this->amountBar = 0;
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

        $arr = $davis->getAmountWindDir();
        foreach ($arr as $key => $value) {
            $this->amountWindDir[$key] += array_sum($value);
        }

        $this->amountData += $davis->getAmountData();
        $this->amountTempOut += array_sum($davis->getAmountTempOut());
        $this->amountHiTemp += array_sum($davis->getAmountHiTemp());
        $this->amountLowTemp += array_sum($davis->getAmountLowTemp());
        $this->amountOutHum += array_sum($davis->getAmountOutHum());
        $this->amountDewPt += array_sum($davis->getAmountDewPt());
        $this->amountWindSpeed += array_sum($davis->getAmountWindSpeed());
        $this->amountBar += array_sum($davis->getAmountBar());
        $this->amountRain += array_sum($davis->getAmountRain());
        $this->amountSolarRad += array_sum($davis->getAmountSolarRad());
        $this->amountUVIndex += array_sum($davis->getAmountUVIndex());
        
    } 

    public function doPrepare() 
    {   
        
        if($this->amountTempOut != 0){
            $this->setTempOut($this->getTempOut() / $this->amountTempOut) ;
        }
        if($this->amountOutHum != 0){
            $this->setOutHum($this->getOutHum() / $this->amountOutHum);
        }
        if($this->amountDewPt != 0){
            $this->setDewPt($this->getDewPt() / $this->amountDewPt);
        }
        if($this->amountWindSpeed != 0){
            $this->setWindSpeed($this->getWindSpeed() / $this->amountWindSpeed);
        }
        if($this->amountBar != 0){
            $this->setBar($this->getBar() / $this->amountBar);
        }
        if($this->amountSolarRad != 0){
            $this->setSolarRad($this->getSolarRad() / $this->amountSolarRad);
        }
        if($this->amountUVIndex != 0){
            $this->setUVIndex($this->getUVIndex() / $this->amountUVIndex);
        }
        $this->setWindDir(array_keys($this->amountWindDir, max($this->amountWindDir))[0]);

        if($this->amountUVIndex >= 2880){
            $this->validUVIndex = true;
        }
        if($this->amountSolarRad >= 2880){
            $this->validSolarRad = true;
        }
        if($this->amountRain == $this->amountData && $this->amountRain >= 2880 ){
            $this->validRain = true;
        }
        if($this->amountBar >= 2880 ){
            $this->validBar = true;
        }

        $wdirSum = 0;
        foreach ($this->amountWindDir as $value) {
            $wdirSum += $value;
        }
        
        if($wdirSum >= 2880){
            $this->validWindDir = true;
        }

        if($this->amountWindSpeed >= 2880){
            $this->validWindSpeed = true;
        }
        if($this->amountDewPt >= 2880){
            $this->validDewPt = true;
        }
        if($this->amountOutHum >= 2880){
            $this->validOutHum = true;
        }
        if($this->amountLowTemp >= 2880){
            $this->validLowTemp = true;
        }
        if($this->amountHiTemp >= 2880){
            $this->validHiTemp = true;
        }
        if($this->amountTempOut >= 2880){
            $this->validTempOut = true;
        }
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
     * @var array ,contagem de direções do vento 
     * @Column(name="amount_wind_dir",type="array", nullable=false)
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

    public function setMinRequirement()
    {
        $this->minRequirement = $minRequirement;
        return $this;
    }

    public function getMinRequirement()
    {
        return $this->minRequirement;
    }

    public function getAmountData()
    {
        return $this->amountData;
    }

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
    public function getAmountWindDir()
    {
        return $this->amountWindDir;
    }
    public function setAmountWindDir($amount) 
    {
        $this->amountWindDir = $amount;
        return $this;
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
