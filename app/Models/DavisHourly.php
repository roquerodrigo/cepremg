<?php

namespace App\Models;

/**
 * @Entity @Table(name="davis_hourly")
 **/
class DavisHourly extends DavisBase
{
    use DavisCompiled;

    const MIN_DATA_COUNT = 2;

    public function __construct(Davis $davis = null)
    {
        if ($davis !== null) {
            $dateTime = clone $davis->getDateTime();
            $dateTime->setTime($dateTime->format('H'), 0);

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

            $this->amountWindDir = [
                'WNW' => 0,
                'NW'  => 0,
                'NNW' => 0,
                'N'   => 0,
                'NNE' => 0,
                'NE'  => 0,
                'ENE' => 0,
                'E'   => 0,
                'ESE' => 0,
                'SE'  => 0,
                'SSE' => 0,
                'S'   => 0,
                'SSW' => 0,
                'SW'  => 0,
                'WSW' => 0,
                'W'   => 0,

            ];

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
        $this->setTempOut($this->getTempOut() + floatval($davis->getTempOut()));
        $this->setHiTemp(max($this->getHiTemp(), floatval($davis->getHiTemp())));

        $hasLowTemp = $davis->getLowTemp() !== null;

        if ($hasLowTemp) {
            if ($this->getLowTemp() === null) {
                $this->setlowTemp($davis->getLowTemp());
            } else {
                $this->setLowTemp(min($this->getLowTemp(), $davis->getLowTemp()));
            }
        }

        $this->setOutHum($this->getOutHum() + floatval($davis->getOutHum()));
        $this->setDewPt($this->getDewPt() + floatval($davis->getDewPt()));
        $this->setWindSpeed($this->getWindSpeed() + floatval($davis->getWindSpeed()));
        $this->setBar($this->getBar() + floatval($davis->getBar()));
        $this->setRain($this->getRain() + floatval($davis->getRain()));
        $this->setSolarRad($this->getSolarRad() + floatval($davis->getSolarRad()));
        $this->setUVIndex($this->getUVIndex() + floatval($davis->getUVIndex()));

        $this->amountData++;

        if ($davis->getWindDir() !== null) {
            $this->amountWindDir[$davis->getWindDir()]++;
        }

        $this->amountTempOut += floatval($davis->getTempOut() !== null);
        $this->amountHiTemp += floatval($davis->getHiTemp() !== null);
        $this->amountLowTemp += floatval($davis->getLowTemp() !== null);
        $this->amountOutHum += floatval($davis->getOutHum() !== null);
        $this->amountDewPt += floatval($davis->getDewPt() !== null);
        $this->amountWindSpeed += floatval($davis->getWindSpeed() !== null);
        $this->amountBar += floatval($davis->getBar() !== null);
        $this->amountRain += floatval($davis->getRain() !== null);
        $this->amountSolarRad += floatval($davis->getSolarRad() !== null);
        $this->amountUVIndex += floatval($davis->getUVIndex() !== null);
    }

    public function doPrepare()
    {
        if ($this->amountTempOut != 0) {
            $this->setTempOut($this->getTempOut() / $this->amountTempOut);
        }

        if ($this->amountOutHum != 0) {
            $this->setOutHum($this->getOutHum() / $this->amountOutHum);
        }

        if ($this->amountDewPt != 0) {
            $this->setDewPt($this->getDewPt() / $this->amountDewPt);
        }

        if ($this->amountWindSpeed != 0) {
            $this->setWindSpeed($this->getWindSpeed() / $this->amountWindSpeed);
        }

        if ($this->amountBar != 0) {
            $this->setBar($this->getBar() / $this->amountBar);
        }

        if ($this->amountSolarRad != 0) {
            $this->setSolarRad($this->getSolarRad() / $this->amountSolarRad);
        }

        if ($this->amountUVIndex != 0) {
            $this->setUVIndex($this->getUVIndex() / $this->amountUVIndex);
        }

        $this->setWindDir(array_keys($this->amountWindDir, max($this->amountWindDir))[0]);

        if ($this->amountUVIndex >= self::MIN_DATA_COUNT) {
            $this->validUVIndex = true;
        }

        if ($this->amountSolarRad >= self::MIN_DATA_COUNT) {
            $this->validSolarRad = true;
        }

        if ($this->amountRain >= self::MIN_DATA_COUNT) {
            $this->validRain = true;
        }

        if ($this->amountBar >= self::MIN_DATA_COUNT) {
            $this->validBar = true;
        }

        $WindDirSum = 0;
        foreach ($this->amountWindDir as $value) {
            $WindDirSum += $value;
        }

        if ($WindDirSum >= self::MIN_DATA_COUNT) {
            $this->validWindDir = true;
        }

        if ($this->amountWindSpeed >= self::MIN_DATA_COUNT) {
            $this->validWindSpeed = true;
        }

        if ($this->amountDewPt >= self::MIN_DATA_COUNT) {
            $this->validDewPt = true;
        }

        if ($this->amountOutHum >= self::MIN_DATA_COUNT) {
            $this->validOutHum = true;
        }

        if ($this->amountLowTemp >= self::MIN_DATA_COUNT) {
            $this->validLowTemp = true;
        }

        if ($this->amountHiTemp >= self::MIN_DATA_COUNT) {
            $this->validHiTemp = true;
        }

        if ($this->amountTempOut >= self::MIN_DATA_COUNT) {
            $this->validTempOut = true;
        }

        return $this;
    }

    public function undoPrepare()
    {
        $this->setTempOut($this->getTempOut() * $this->amountTempOut);
        $this->setOutHum($this->getOutHum() * $this->amountOutHum);
        $this->setDewPt($this->getDewPt() * $this->amountDewPt);
        $this->setWindSpeed($this->getWindSpeed() * $this->amountWindSpeed);
        $this->setBar($this->getBar() * $this->amountBar);
        $this->setSolarRad($this->getSolarRad() * $this->amountSolarRad);
        $this->setUVIndex($this->getUVIndex() * $this->amountUVIndex);

        return $this;
    }
}
