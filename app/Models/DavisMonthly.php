<?php

namespace App\Models;

/**
 * @Entity @Table(name="davis_monthly")
 **/
class DavisMonthly extends DavisBase
{
    use DavisCompiled;

    public function __construct(DavisDaily $davis = null)
    {
        if ($davis !== null) {
            $dateTime = clone $davis->getDateTime();
            $dateTime->setDate($dateTime->format('Y'), $dateTime->format('m'), 1);
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
        $this->setTempOut($this->getTempOut() + $davis->getTempOut());
        $this->setHiTemp(max($this->getHiTemp(), $davis->getHiTemp()));

        $hasLowTemp = $davis->getLowTemp() !== null;

        if ($hasLowTemp) {
            if ($this->getLowTemp() === null) {
                $this->setlowTemp($davis->getLowTemp());
            } else {
                $this->setLowTemp(min($this->getLowTemp(), $davis->getLowTemp()));
            }
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

        if ($this->amountUVIndex >= 2880) {
            $this->validUVIndex = true;
        }
        if ($this->amountSolarRad >= 2880) {
            $this->validSolarRad = true;
        }
        if ($this->amountRain == $this->amountData && $this->amountRain >= 2880) {
            $this->validRain = true;
        }
        if ($this->amountBar >= 2880) {
            $this->validBar = true;
        }

        $wdirSum = 0;
        foreach ($this->amountWindDir as $value) {
            $wdirSum += $value;
        }

        if ($wdirSum >= 2880) {
            $this->validWindDir = true;
        }

        if ($this->amountWindSpeed >= 2880) {
            $this->validWindSpeed = true;
        }
        if ($this->amountDewPt >= 2880) {
            $this->validDewPt = true;
        }
        if ($this->amountOutHum >= 2880) {
            $this->validOutHum = true;
        }
        if ($this->amountLowTemp >= 2880) {
            $this->validLowTemp = true;
        }
        if ($this->amountHiTemp >= 2880) {
            $this->validHiTemp = true;
        }
        if ($this->amountTempOut >= 2880) {
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
