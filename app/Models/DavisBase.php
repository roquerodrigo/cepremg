<?php

namespace App\Models;

/**
 * @MappedSuperclass
 **/
class DavisBase
{
    /**
     * @var int Chave de implementação
     * @Id @Column(name="id", type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var \DateTime Hora do registro
     * @Column(name="date_time", type="datetime", unique=true)
     */
    protected $dateTime;

    /**
     * @var float Temperatura
     * @Column(name="temp_out", type="float", nullable=true)
     */
    protected $tempOut = null;

    /**
     * @var float Maior temperatura
     * @Column(name="hi_temp", type="float", nullable=true)
     */
    protected $hiTemp = null;

    /**
     * @var float Menor temperatura
     * @Column(name="low_temp", type="float", nullable=true)
     */
    protected $lowTemp = null;

    /**
     * @var int Umidade do ar
     * @Column(name="out_hum", type="float", nullable=true)
     */
    protected $outHum = null;

    /**
     * @var float Temperatura de ponto de orvalho
     * @Column(name="dew_pt", type="float", nullable=true)
     */
    protected $dewPt = null;

    /**
     * @var float Intensidade do vento
     * @Column(name="wind_speed", type="float", nullable=true)
     */
    protected $windSpeed = null;

    /**
     * @var float Direção do vento
     * @Column(name="wind_dir", type="string", length=3, nullable=true)
     */
    protected $windDir = null;

    /**
     * @var float Pressão atmosférica
     * @Column(name="bar", type="float", nullable=true)
     */
    protected $bar = null;

    /**
     * @var float Precipitação
     * @Column(name="rain", type="float", nullable=true)
     */
    protected $rain = null;

    /**
     * @var int Radiação solar
     * @Column(name="solar_rad", type="float", nullable=true)
     */
    protected $solarRad = null;

    /**
     * @var float Índice ultra-violeta
     * @Column(name="uv_index", type="float", nullable=true)
     */
    protected $UVIndex = null;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return DavisBase
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return DavisBase
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * @return float
     */
    public function getTempOut()
    {
        return $this->tempOut;
    }

    /**
     * @param float $tempOut
     *
     * @return DavisBase
     */
    public function setTempOut($tempOut)
    {
        $this->tempOut = $tempOut;

        return $this;
    }

    /**
     * @return float
     */
    public function getHiTemp()
    {
        return $this->hiTemp;
    }

    /**
     * @param float $hiTemp
     *
     * @return DavisBase
     */
    public function setHiTemp($hiTemp)
    {
        $this->hiTemp = $hiTemp;

        return $this;
    }

    /**
     * @return float
     */
    public function getLowTemp()
    {
        return $this->lowTemp;
    }

    /**
     * @param float $lowTemp
     *
     * @return DavisBase
     */
    public function setLowTemp($lowTemp)
    {
        $this->lowTemp = $lowTemp;

        return $this;
    }

    /**
     * @return int
     */
    public function getOutHum()
    {
        return $this->outHum;
    }

    /**
     * @param int $outHum
     *
     * @return DavisBase
     */
    public function setOutHum($outHum)
    {
        $this->outHum = $outHum;

        return $this;
    }

    /**
     * @return float
     */
    public function getDewPt()
    {
        return $this->dewPt;
    }

    /**
     * @param float $dewPt
     *
     * @return DavisBase
     */
    public function setDewPt($dewPt)
    {
        $this->dewPt = $dewPt;

        return $this;
    }

    /**
     * @return float
     */
    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

    /**
     * @param float $windSpeed
     *
     * @return DavisBase
     */
    public function setWindSpeed($windSpeed)
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    /**
     * @return float
     */
    public function getWindDir()
    {
        return $this->windDir;
    }

    /**
     * @param float $windDir
     *
     * @return DavisBase
     */
    public function setWindDir($windDir)
    {
        $this->windDir = $windDir;

        return $this;
    }

    /**
     * @return float
     */
    public function getBar()
    {
        return $this->bar;
    }

    /**
     * @param float $bar
     *
     * @return DavisBase
     */
    public function setBar($bar)
    {
        $this->bar = $bar;

        return $this;
    }

    /**
     * @return float
     */
    public function getRain()
    {
        return $this->rain;
    }

    /**
     * @param float $rain
     *
     * @return DavisBase
     */
    public function setRain($rain)
    {
        $this->rain = $rain;

        return $this;
    }

    /**
     * @return int
     */
    public function getSolarRad()
    {
        return $this->solarRad;
    }

    /**
     * @param int $solarRad
     *
     * @return DavisBase
     */
    public function setSolarRad($solarRad)
    {
        $this->solarRad = $solarRad;

        return $this;
    }

    /**
     * @return float
     */
    public function getUVIndex()
    {
        return $this->UVIndex;
    }

    /**
     * @param float $UVIndex
     *
     * @return DavisBase
     */
    public function setUVIndex($UVIndex)
    {
        $this->UVIndex = $UVIndex;

        return $this;
    }
}
