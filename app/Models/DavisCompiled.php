<?php

namespace App\Models;

trait DavisCompiled
{
    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_uv_index",type="boolean", nullable=false, options={"default":false})
     */
    protected $validUVIndex;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_uv_index",type="array", nullable=false)
     */
    protected $amountUVIndex;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_solar_rad",type="boolean", nullable=false, options={"default":false})
     */
    protected $validSolarRad;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_solar_rad",type="array", nullable=false)
     */
    protected $amountSolarRad;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_rain",type="boolean", nullable=false, options={"default":false})
     */
    protected $validRain;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_rain",type="array", nullable=false)
     */
    protected $amountRain;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_bar",type="boolean", nullable=false, options={"default":false})
     */
    protected $validBar;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_bar",type="array", nullable=false)
     */
    protected $amountBar;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_wind_dir",type="boolean", nullable=false, options={"default":false})
     */
    protected $validWindDir;

    /**
     * @var array ,contagem de direções do vento
     * @Column(name="amount_wind_dir",type="array", nullable=false)
     */
    protected $amountWindDir;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_wind_speed",type="boolean", nullable=false, options={"default":false})
     */
    protected $validWindSpeed;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_wind_speed",type="array", nullable=false)
     */
    protected $amountWindSpeed;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_dew_pt",type="boolean", nullable=false, options={"default":false})
     */
    protected $validDewPt;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_dew_pt",type="array", nullable=false)
     */
    protected $amountDewPt;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_out_hum",type="boolean", nullable=false, options={"default":false})
     */
    protected $validOutHum;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_out_hum",type="array", nullable=false)
     */
    protected $amountOutHum;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_low_temp",type="boolean", nullable=false, options={"default":false})
     */
    protected $validLowTemp;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_low_temp",type="array", nullable=false)
     */
    protected $amountLowTemp;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_hi_temp",type="boolean", nullable=false, options={"default":false})
     */
    protected $validHiTemp;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_hi_temp",type="array", nullable=false)
     */
    protected $amountHiTemp;

    /**
     * @var bool dado é valido para exibição
     * @Column(name="valid_temp_out",type="boolean", nullable=false, options={"default":false})
     */
    protected $validTempOut;

    /**
     * @var int Quantidade de dados usados para produzir o valor
     * @Column(name="amount_temp_out",type="array", nullable=false)
     */
    protected $amountTempOut;

    /**
     * @var int Quantidade de dados usados para produzir o valor dessa coluna
     * @Column(name="amount_data",type="integer", nullable=false, options={"default":0})
     */
    protected $amountData;

    /**
     * @return bool
     */
    public function isValidUVIndex()
    {
        return $this->validUVIndex;
    }

    /**
     * @param bool $validUVIndex
     *
     * @return DavisCompiled
     */
    public function setValidUVIndex($validUVIndex)
    {
        $this->validUVIndex = $validUVIndex;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountUVIndex()
    {
        return $this->amountUVIndex;
    }

    /**
     * @param int $amountUVIndex
     *
     * @return DavisCompiled
     */
    public function setAmountUVIndex($amountUVIndex)
    {
        $this->amountUVIndex = $amountUVIndex;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValidSolarRad()
    {
        return $this->validSolarRad;
    }

    /**
     * @param bool $validSolarRad
     *
     * @return DavisCompiled
     */
    public function setValidSolarRad($validSolarRad)
    {
        $this->validSolarRad = $validSolarRad;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountSolarRad()
    {
        return $this->amountSolarRad;
    }

    /**
     * @param int $amountSolarRad
     *
     * @return DavisCompiled
     */
    public function setAmountSolarRad($amountSolarRad)
    {
        $this->amountSolarRad = $amountSolarRad;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValidRain()
    {
        return $this->validRain;
    }

    /**
     * @param bool $validRain
     *
     * @return DavisCompiled
     */
    public function setValidRain($validRain)
    {
        $this->validRain = $validRain;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountRain()
    {
        return $this->amountRain;
    }

    /**
     * @param int $amountRain
     *
     * @return DavisCompiled
     */
    public function setAmountRain($amountRain)
    {
        $this->amountRain = $amountRain;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValidBar()
    {
        return $this->validBar;
    }

    /**
     * @param bool $validBar
     *
     * @return DavisCompiled
     */
    public function setValidBar($validBar)
    {
        $this->validBar = $validBar;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountBar()
    {
        return $this->amountBar;
    }

    /**
     * @param int $amountBar
     *
     * @return DavisCompiled
     */
    public function setAmountBar($amountBar)
    {
        $this->amountBar = $amountBar;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValidWindDir()
    {
        return $this->validWindDir;
    }

    /**
     * @param bool $validWindDir
     *
     * @return DavisCompiled
     */
    public function setValidWindDir($validWindDir)
    {
        $this->validWindDir = $validWindDir;

        return $this;
    }

    /**
     * @return array
     */
    public function getAmountWindDir()
    {
        return $this->amountWindDir;
    }

    /**
     * @param array $amountWindDir
     *
     * @return DavisCompiled
     */
    public function setAmountWindDir($amountWindDir)
    {
        $this->amountWindDir = $amountWindDir;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValidWindSpeed()
    {
        return $this->validWindSpeed;
    }

    /**
     * @param bool $validWindSpeed
     *
     * @return DavisCompiled
     */
    public function setValidWindSpeed($validWindSpeed)
    {
        $this->validWindSpeed = $validWindSpeed;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountWindSpeed()
    {
        return $this->amountWindSpeed;
    }

    /**
     * @param int $amountWindSpeed
     *
     * @return DavisCompiled
     */
    public function setAmountWindSpeed($amountWindSpeed)
    {
        $this->amountWindSpeed = $amountWindSpeed;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValidDewPt()
    {
        return $this->validDewPt;
    }

    /**
     * @param bool $validDewPt
     *
     * @return DavisCompiled
     */
    public function setValidDewPt($validDewPt)
    {
        $this->validDewPt = $validDewPt;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountDewPt()
    {
        return $this->amountDewPt;
    }

    /**
     * @param int $amountDewPt
     *
     * @return DavisCompiled
     */
    public function setAmountDewPt($amountDewPt)
    {
        $this->amountDewPt = $amountDewPt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValidOutHum()
    {
        return $this->validOutHum;
    }

    /**
     * @param bool $validOutHum
     *
     * @return DavisCompiled
     */
    public function setValidOutHum($validOutHum)
    {
        $this->validOutHum = $validOutHum;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountOutHum()
    {
        return $this->amountOutHum;
    }

    /**
     * @param int $amountOutHum
     *
     * @return DavisCompiled
     */
    public function setAmountOutHum($amountOutHum)
    {
        $this->amountOutHum = $amountOutHum;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValidLowTemp()
    {
        return $this->validLowTemp;
    }

    /**
     * @param bool $validLowTemp
     *
     * @return DavisCompiled
     */
    public function setValidLowTemp($validLowTemp)
    {
        $this->validLowTemp = $validLowTemp;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountLowTemp()
    {
        return $this->amountLowTemp;
    }

    /**
     * @param int $amountLowTemp
     *
     * @return DavisCompiled
     */
    public function setAmountLowTemp($amountLowTemp)
    {
        $this->amountLowTemp = $amountLowTemp;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValidHiTemp()
    {
        return $this->validHiTemp;
    }

    /**
     * @param bool $validHiTemp
     *
     * @return DavisCompiled
     */
    public function setValidHiTemp($validHiTemp)
    {
        $this->validHiTemp = $validHiTemp;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountHiTemp()
    {
        return $this->amountHiTemp;
    }

    /**
     * @param int $amountHiTemp
     *
     * @return DavisCompiled
     */
    public function setAmountHiTemp($amountHiTemp)
    {
        $this->amountHiTemp = $amountHiTemp;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValidTempOut()
    {
        return $this->validTempOut;
    }

    /**
     * @param bool $validTempOut
     *
     * @return DavisCompiled
     */
    public function setValidTempOut($validTempOut)
    {
        $this->validTempOut = $validTempOut;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountTempOut()
    {
        return $this->amountTempOut;
    }

    /**
     * @param int $amountTempOut
     *
     * @return DavisCompiled
     */
    public function setAmountTempOut($amountTempOut)
    {
        $this->amountTempOut = $amountTempOut;

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
     * @param int $amountData
     *
     * @return DavisCompiled
     */
    public function setAmountData($amountData)
    {
        $this->amountData = $amountData;

        return $this;
    }
}
