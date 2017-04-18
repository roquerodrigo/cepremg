<?php

namespace App\Models;

/**
 * @Entity @Table(name="davis")
 **/
class Davis
{
    /**
     * @var \DateTime Hora do registro
     * @Id @Column(type="datetime")
     */
    private $dateTime;

    /**
     * @var float Temperatura
     * @Column(type="float")
     */
    private $tempOut;

    /**
     * @var float Maior temperatura
     * @Column(type="float")
     */
    private $hiTemp;

    /**
     * @var float Menor temperatura
     * @Column(type="float")
     */
    private $lowTemp;

    /**
     * @var int Umidade do ar
     * @Column(type="float")
     */
    private $outHum;

    /**
     * @var float Temperatura de ponto de orvalho
     * @Column(type="float")
     */
    private $dewPt;

    /**
     * @var float Intensidade do vento
     * @Column(type="float")
     */
    private $windSpeed;

    /**
     * @var float Direção do vento
     */
    private $windDir;


    /**
     * @var float Pressão atmosférica
     * @Column(type="float")
     */
    private $bar;

    /**
     * @var float Precipitação
     * @Column(type="float")
     */
    private $rain;

    /**
     * @var int Radiação solar
     * @Column(type="float")
     */
    private $solarRad;

    /**
     * @var float Índice ultra-violeta
     * @Column(type="float")
     */
    private $UVIndex;
}