<?php
namespace App\Models;
use DateTime;
/**
 * @Entity @Table(name="davis_yearly")
 **/
class DavisYearly extends AbstractDavis
{
    public function __construct(DavisMonthly $davis = null) {
        if($davis !== null) {
            $dateTime = clone $davis->getDateTime();
            $dateTime->setDate($dateTime->format('Y'),1,1);
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

            $this->amountUVIndex = [];
            $this->amountSolarRad = [];
            $this->amountRain = [];
            $this->amountBar = [];
            $this->amountWindSpeed = [];
            $this->amountDewPt = [];
            $this->amountOutHum = [];
            $this->amountLowTemp = [];
            $this->amountHiTemp = [];
            $this->amountTempOut = [];
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

        $month = $davis->getDateTime()->format('m');
        if($month <= 3) {
            $arr = $davis->getAmountWindDir();
            foreach ($arr as $key => $value) {
                $this->amountWindDir[$key]['1-3'] += $value;
            }   
            $this->amountTempOut['1-3'] += $davis->getAmountTempOut();
            $this->amountHiTemp['1-3'] += $davis->getAmountHiTemp();
            $this->amountLowTemp['1-3'] += $davis->getAmountLowTemp();
            $this->amountOutHum['1-3'] += $davis->getAmountOutHum();
            $this->amountDewPt['1-3'] += $davis->getAmountDewPt();
            $this->amountWindSpeed['1-3'] += $davis->getAmountWindSpeed();
            $this->amountBar['1-3'] += $davis->getAmountBar();
            $this->amountRain['1-3'] += $davis->getAmountRain();
            $this->amountSolarRad['1-3'] += $davis->getAmountSolarRad();
            $this->amountUVIndex['1-3'] += $davis->getAmountUVIndex();
        } elseif ($month <= 6) {
            $arr = $davis->getAmountWindDir();
            foreach ($arr as $key => $value) {
                $this->amountWindDir[$key]['4-6'] += $value;
            } 
            $this->amountTempOut['4-6'] += $davis->getAmountTempOut();
            $this->amountHiTemp['4-6'] += $davis->getAmountHiTemp();
            $this->amountLowTemp['4-6'] += $davis->getAmountLowTemp();
            $this->amountOutHum['4-6'] += $davis->getAmountOutHum();
            $this->amountDewPt['4-6'] += $davis->getAmountDewPt();
            $this->amountWindSpeed['4-6'] += $davis->getAmountWindSpeed();
            $this->amountBar['4-6'] += $davis->getAmountBar();
            $this->amountRain['4-6'] += $davis->getAmountRain();
            $this->amountSolarRad['4-6'] += $davis->getAmountSolarRad();
            $this->amountUVIndex['4-6'] += $davis->getAmountUVIndex();
        } elseif ($month <= 9) {
            $arr = $davis->getAmountWindDir();
            foreach ($arr as $key => $value) {
                $this->amountWindDir[$key]['7-9'] += $value;
            } 
            $this->amountTempOut['7-9'] += $davis->getAmountTempOut();
            $this->amountHiTemp['7-9'] += $davis->getAmountHiTemp();
            $this->amountLowTemp['7-9'] += $davis->getAmountLowTemp();
            $this->amountOutHum['7-9'] += $davis->getAmountOutHum();
            $this->amountDewPt['7-9'] += $davis->getAmountDewPt();
            $this->amountWindSpeed['7-9'] += $davis->getAmountWindSpeed();
            $this->amountBar['7-9'] += $davis->getAmountBar();
            $this->amountRain['7-9'] += $davis->getAmountRain();
            $this->amountSolarRad['7-9'] += $davis->getAmountSolarRad();
            $this->amountUVIndex['7-9'] += $davis->getAmountUVIndex();
        } else {
            $arr = $davis->getAmountWindDir();
            foreach ($arr as $key => $value) {
                $this->amountWindDir[$key]['10-12'] += $value;
            } 
            $this->amountTempOut['10-12'] += $davis->getAmountTempOut();
            $this->amountHiTemp['10-12'] += $davis->getAmountHiTemp();
            $this->amountLowTemp['10-12'] += $davis->getAmountLowTemp();
            $this->amountOutHum['10-12'] += $davis->getAmountOutHum();
            $this->amountDewPt['10-12'] += $davis->getAmountDewPt();
            $this->amountWindSpeed['10-12'] += $davis->getAmountWindSpeed();
            $this->amountBar['10-12'] += $davis->getAmountBar();
            $this->amountRain['10-12'] += $davis->getAmountRain();
            $this->amountSolarRad['10-12'] += $davis->getAmountSolarRad();
            $this->amountUVIndex['10-12'] += $davis->getAmountUVIndex();
        }
        $this->amountData += $davis->getAmountData();
        
    } 

    public function doPrepare() 
    {
        $cd1 = 0;
        $cd2 = 0;
        $cd3 = 0;
        $cd4 = 0;
        foreach ($this->amountWindDir as $value) {
            $cd1 += $value['1-3'];
            $cd2 += $value['4-6'];
            $cd3 += $value['7-9'];
            $cd4 += $value['10-12'];
        }
        if($cd1 >= 8640 && $cd2 >= 8640 && $cd3 >= 8640 && $cd4 >= 8640) {
            $this->validWindDir = true;
        }
        unset($cd1, $cd2, $cd3, $cd4);
        
        if($this->amountTempOut['1-3'] >= 8640 &&
           $this->amountTempOut['4-6'] >= 8640 &&
           $this->amountTempOut['7-9'] >= 8640 &&
           $this->amountTempOut['10-12'] >= 8640) {
            $this->validTempOut = true;
        }

        if($this->amountHiTemp['1-3'] >= 8640 &&
           $this->amountHiTemp['4-6'] >= 8640 &&
           $this->amountHiTemp['7-9'] >= 8640 &&
           $this->amountTempOut['10-12'] >= 8640) {
            $this->validHiTemp = true;
        }

        if($this->amountLowTemp['1-3'] >= 8640 &&
           $this->amountLowTemp['4-6'] >= 8640 &&
           $this->amountLowTemp['7-9'] >= 8640 &&
           $this->amountTempOut['10-12'] >= 8640) {
            $this->validLowTemp = true;
        }

        if($this->amountOutHum['1-3'] >= 8640 &&
           $this->amountOutHum['4-6'] >= 8640 &&
           $this->amountOutHum['7-9'] >= 8640 &&
           $this->amountTempOut['10-12'] >= 8640) {
            $this->validOutHum = true;
        }

        if($this->amountDewPt['1-3'] >= 8640 && 
           $this->amountDewPt['4-6'] >= 8640 &&
           $this->amountDewPt['7-9'] >= 8640 &&
           $this->amountTempOut['10-12'] >= 8640) {
            $this->validDewPt = true;
        }

        if($this->amountWindSpeed['1-3'] >= 8640 &&
           $this->amountWindSpeed['4-6'] >= 8640 &&
           $this->amountWindSpeed['7-9'] >= 8640 &&
           $this->amountTempOut['10-12']) {
            $this->validWindSpeed = true;
        }

        if($this->amountBar['1-3'] >= 8640 &&
           $this->amountBar['4-6'] >= 8640 &&
           $this->amountBar['7-9'] >= 8640 &&
           $this->amountTempOut['10-12'] >= 8640) {
            $this->validBar = true;
        }

        if($this->amountRain['1-3'] >= 8640 &&
           $this->amountRain['4-6'] >= 8640 &&
           $this->amountRain['7-9'] >= 8640 &&
           $this->amountTempOut['10-12'] >= 8640) {
            $this->validRain = true;
        }

        if($this->amountSolarRad['1-3'] >= 8640 &&
           $this->amountSolarRad['4-6'] >= 8640 &&
           $this->amountSolarRad['7-9'] >= 8640 &&
           $this->amountTempOut['10-12'] >= 8640) {
            $this->validSolarRad = true;
        }

        if($this->amountUVIndex['1-3'] >= 8640 &&
           $this->amountUVIndex['4-6'] >= 8640 &&
           $this->amountUVIndex['7-9'] >= 8640 &&
           $this->amountTempOut['10-12'] >= 8640) {
            $this->validUVIndex = true;
        }
        $aTempOut = array_sum($this->amountTempOut);
        $aOutHum = array_sum($this->amountOutHum);
        $aDewPt = array_sum($this->amountDewPt);
        $aWindSpeed = array_sum($this->amountWindSpeed);
        $aBar = array_sum($this->amountBar);
        $aSolarRad = array_sum($this->amountSolarRad);
        $aUVIndex  = array_sum($this->amountUVIndex);

        if($aTempOut != 0){
            $this->setTempOut($this->getTempOut() / $aTempOut) ;
        }
        if($aOutHum != 0){
            $this->setOutHum($this->getOutHum() / $aOutHum);
        }
        if($aDewPt != 0){
            $this->setDewPt($this->getDewPt() / $aDewPt);
        }
        if($aWindSpeed != 0){
            $this->setWindSpeed($this->getWindSpeed() / $aWindSpeed);
        }
        if($aBar != 0){
            $this->setBar($this->getBar() / $aBar);
        }
        if($aSolarRad != 0){
            $this->setSolarRad($this->getSolarRad() / $aSolarRad);
        }
        if($aUVIndex != 0){
            $this->setUVIndex($this->getUVIndex() / $aUVIndex);
        }

        unset($aTempOut,$aOutHum,$aDewPt,$aWindSpeed,$aBar,$aSolarRad,$aUVIndex);
        $aWindDir = [];
        foreach ($this->amountWindDir as $key => $value) {
            $aWindDir[$key] = array_sum($value);
        }

        $this->setWindDir(array_keys($aWindDir, max($aWindDir))[0]);
        unset($aWindDir);
        return $this;
    }
    
    public function undoPrepare() 
    {
        $aTempOut = array_sum($this->amountTempOut);
        $aOutHum = array_sum($this->amountOutHum);
        $aDewPt = array_sum($this->amountDewPt);
        $aWindSpeed = array_sum($this->amountWindSpeed);
        $aBar = array_sum($this->amountBar);
        $aSolarRad = array_sum($this->amountSolarRad);
        $aUVIndex  = array_sum($this->amountUVIndex);

        $this->setTempOut($this->getTempOut() * $aTempOut) ;
        $this->setOutHum($this->getOutHum() * $aOutHum);
        $this->setDewPt($this->getDewPt() * $aDewPt);
        $this->setWindSpeed($this->getWindSpeed() * $aWindSpeed);
        $this->setBar($this->getBar() * $aBar);
        $this->setSolarRad($this->getSolarRad() * $aSolarRad);
        $this->setUVIndex($this->getUVIndex() * $aUVIndex);
        return $this;
    } 

	/**
     * @var bool dado é valido para exibição
     * @Column(name="valid_uv_index",type="boolean", nullable=false, options={"default":false})
     */
    private $validUVIndex;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_uv_index",type="array", nullable=false)
     */
    private $amountUVIndex;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_solar_rad",type="boolean", nullable=false, options={"default":false})
     */
    private $validSolarRad;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_solar_rad",type="array", nullable=false)
     */
    private $amountSolarRad;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_rain",type="boolean", nullable=false, options={"default":false})
     */
    private $validRain;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_rain",type="array", nullable=false)
     */
    private $amountRain;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_bar",type="boolean", nullable=false, options={"default":false})
     */
    private $validBar;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_bar",type="array", nullable=false)
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
     * @Column(name="amount_wind_speed",type="array", nullable=false)
     */
    private $amountWindSpeed;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_dew_pt",type="boolean", nullable=false, options={"default":false})
     */
    private $validDewPt;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_dew_pt",type="array", nullable=false)
     */
    private $amountDewPt;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_out_hum",type="boolean", nullable=false, options={"default":false})
     */
    private $validOutHum;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_out_hum",type="array", nullable=false)
     */
    private $amountOutHum;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_low_temp",type="boolean", nullable=false, options={"default":false})
     */
    private $validLowTemp;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_low_temp",type="array", nullable=false)
     */
    private $amountLowTemp;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_hi_temp",type="boolean", nullable=false, options={"default":false})
     */
    private $validHiTemp;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_hi_temp",type="array", nullable=false)
     */
    private $amountHiTemp;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_temp_out",type="boolean", nullable=false, options={"default":false})
     */
    private $validTempOut;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_temp_out",type="array", nullable=false)
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
