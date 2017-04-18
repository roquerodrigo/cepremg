<?php

namespace App\Models;

/**
 * @Entity @Table(name="davis")
 **/
class Davis
{
    /**
     * @var int Chave de implementação
     * @Id @Column(type="integer") @GeneratedValue
     */
    private $id;

    /**
     * @var \DateTime Hora do registro
     * @Column(type="datetime", unique=true)
     */
    private $dateTime;

    /**
     * @var float Temperatura
     * @Column(type="float", nullable=true)
     */
    private $tempOut;

    /**
     * @var float Maior temperatura
     * @Column(type="float", nullable=true)
     */
    private $hiTemp;

    /**
     * @var float Menor temperatura
     * @Column(type="float", nullable=true)
     */
    private $lowTemp;

    /**
     * @var int Umidade do ar
     * @Column(type="float", nullable=true)
     */
    private $outHum;

    /**
     * @var float Temperatura de ponto de orvalho
     * @Column(type="float", nullable=true)
     */
    private $dewPt;

    /**
     * @var float Intensidade do vento
     * @Column(type="float", nullable=true)
     */
    private $windSpeed;

    /**
     * @var float Direção do vento
     * @Column(type="string", length=3, nullable=true)
     */
    private $windDir;

    /**
     * @var float Pressão atmosférica
     * @Column(type="float", nullable=true)
     */
    private $bar;

    /**
     * @var float Precipitação
     * @Column(type="float", nullable=true)
     */
    private $rain;

    /**
     * @var int Radiação solar
     * @Column(type="float", nullable=true)
     */
    private $solarRad;

    /**
     * @var float Índice ultra-violeta
     * @Column(type="float", nullable=true)
     */
    private $UVIndex;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Davis
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
     * @return Davis
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
     * @return Davis
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
     * @return Davis
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
     * @return Davis
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
     * @return Davis
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
     * @return Davis
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
     * @return Davis
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
     * @return Davis
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
     * @return Davis
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
     * @return Davis
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
     * @return Davis
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
     * @return Davis
     */
    public function setUVIndex($UVIndex)
    {
        $this->UVIndex = $UVIndex;

        return $this;
    }
}