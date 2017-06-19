<?php

namespace App\Models;

/**
 * @Entity @Table(name="davis_daily")
 **/
class DavisDaily extends DavisBase
{
    use DavisCompiled;

    const MIN_DATA_COUNT = 3;

    public function __construct(DavisHourly $davis = null)
    {
        if ($davis !== null) {
            $dateTime = clone $davis->getDateTime();
            $dateTime->setTime(0, 0);
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

            $arrayHoras = ['0-9' => 0, '10-14' => 0, '15-23' => 0];

            $this->amountWindDir = [
                'WNW' => $arrayHoras,
                'NW'  => $arrayHoras,
                'NNW' => $arrayHoras,
                'N'   => $arrayHoras,
                'NNE' => $arrayHoras,
                'NE'  => $arrayHoras,
                'ENE' => $arrayHoras,
                'E'   => $arrayHoras,
                'ESE' => $arrayHoras,
                'SE'  => $arrayHoras,
                'SSE' => $arrayHoras,
                'S'   => $arrayHoras,
                'SSW' => $arrayHoras,
                'SW'  => $arrayHoras,
                'WSW' => $arrayHoras,
                'W'   => $arrayHoras,
            ];

            $this->amountUVIndex = $arrayHoras;
            $this->amountSolarRad = $arrayHoras;
            $this->amountRain = $arrayHoras;
            $this->amountBar = $arrayHoras;
            $this->amountWindSpeed = $arrayHoras;
            $this->amountDewPt = $arrayHoras;
            $this->amountOutHum = $arrayHoras;
            $this->amountLowTemp = $arrayHoras;
            $this->amountHiTemp = $arrayHoras;
            $this->amountTempOut = $arrayHoras;

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

        $hora = $davis->getDateTime()->format('H');

        if ($hora <= 9) {
            $interval = '0-9';
        } else if ($hora > 9 && $hora <= 14) {
            $interval = '10-14';
        } else {
            $interval = '15-23';
        }


        $arr = $davis->getAmountWindDir();
        foreach ($arr as $key => $value) {
            $this->amountWindDir[$key][$interval] += $value;
        }

        $this->amountTempOut[$interval] += $davis->getAmountTempOut();
        $this->amountHiTemp[$interval] += $davis->getAmountHiTemp();
        $this->amountLowTemp[$interval] += $davis->getAmountLowTemp();
        $this->amountOutHum[$interval] += $davis->getAmountOutHum();
        $this->amountDewPt[$interval] += $davis->getAmountDewPt();
        $this->amountWindSpeed[$interval] += $davis->getAmountWindSpeed();
        $this->amountBar[$interval] += $davis->getAmountBar();
        $this->amountRain[$interval] += $davis->getAmountRain();
        $this->amountSolarRad[$interval] += $davis->getAmountSolarRad();
        $this->amountUVIndex[$interval] += $davis->getAmountUVIndex();

        $this->amountData += $davis->getAmountData();
    }

    public function doPrepare()
    {
        $cd1 = 0;
        $cd2 = 0;
        $cd3 = 0;

        foreach ($this->amountWindDir as $value) {
            $cd1 += $value['0-9'];
            $cd2 += $value['10-14'];
            $cd3 += $value['15-23'];
        }

        if ($cd1 >= self::MIN_DATA_COUNT &&
            $cd2 >= self::MIN_DATA_COUNT &&
            $cd3 >= self::MIN_DATA_COUNT
        ) {
            $this->validWindDir = true;
        }

        unset($cd1, $cd2, $cd3);

        if ($this->amountTempOut['0-9'] >= self::MIN_DATA_COUNT &&
            $this->amountTempOut['10-14'] >= self::MIN_DATA_COUNT &&
            $this->amountTempOut['15-23'] >= self::MIN_DATA_COUNT
        ) {
            $this->validTempOut = true;
        }

        if ($this->amountHiTemp['0-9'] >= self::MIN_DATA_COUNT &&
            $this->amountHiTemp['10-14'] >= self::MIN_DATA_COUNT &&
            $this->amountHiTemp['15-23'] >= self::MIN_DATA_COUNT
        ) {
            $this->validHiTemp = true;
        }

        if ($this->amountLowTemp['0-9'] >= self::MIN_DATA_COUNT &&
            $this->amountLowTemp['10-14'] >= self::MIN_DATA_COUNT &&
            $this->amountLowTemp['15-23'] >= self::MIN_DATA_COUNT
        ) {
            $this->validLowTemp = true;
        }

        if ($this->amountOutHum['0-9'] >= self::MIN_DATA_COUNT &&
            $this->amountOutHum['10-14'] >= self::MIN_DATA_COUNT &&
            $this->amountOutHum['15-23'] >= self::MIN_DATA_COUNT
        ) {
            $this->validOutHum = true;
        }

        if ($this->amountDewPt['0-9'] >= self::MIN_DATA_COUNT &&
            $this->amountDewPt['10-14'] >= self::MIN_DATA_COUNT &&
            $this->amountDewPt['15-23'] >= self::MIN_DATA_COUNT
        ) {
            $this->validDewPt = true;
        }

        if ($this->amountWindSpeed['0-9'] >= self::MIN_DATA_COUNT &&
            $this->amountWindSpeed['10-14'] >= self::MIN_DATA_COUNT &&
            $this->amountWindSpeed['15-23'] >= self::MIN_DATA_COUNT
        ) {
            $this->validWindSpeed = true;
        }

        if ($this->amountBar['0-9'] >= self::MIN_DATA_COUNT &&
            $this->amountBar['10-14'] >= self::MIN_DATA_COUNT &&
            $this->amountBar['15-23'] >= self::MIN_DATA_COUNT
        ) {
            $this->validBar = true;
        }

        if ($this->amountRain['0-9'] >= self::MIN_DATA_COUNT &&
            $this->amountRain['10-14'] >= self::MIN_DATA_COUNT &&
            $this->amountRain['15-23'] >= self::MIN_DATA_COUNT
        ) {
            $this->validRain = true;
        }

        if ($this->amountSolarRad['0-9'] >= self::MIN_DATA_COUNT &&
            $this->amountSolarRad['10-14'] >= self::MIN_DATA_COUNT &&
            $this->amountSolarRad['15-23'] >= self::MIN_DATA_COUNT
        ) {
            $this->validSolarRad = true;
        }

        if ($this->amountUVIndex['0-9'] >= self::MIN_DATA_COUNT &&
            $this->amountUVIndex['10-14'] >= self::MIN_DATA_COUNT &&
            $this->amountUVIndex['15-23'] >= self::MIN_DATA_COUNT
        ) {
            $this->validUVIndex = true;
        }

        $aTempOut = array_sum($this->amountTempOut);
        $aOutHum = array_sum($this->amountOutHum);
        $aDewPt = array_sum($this->amountDewPt);
        $aWindSpeed = array_sum($this->amountWindSpeed);
        $aBar = array_sum($this->amountBar);
        $aSolarRad = array_sum($this->amountSolarRad);
        $aUVIndex = array_sum($this->amountUVIndex);

        if ($aTempOut != 0) {
            $this->setTempOut($this->getTempOut() / $aTempOut);
        }
        if ($aOutHum != 0) {
            $this->setOutHum($this->getOutHum() / $aOutHum);
        }
        if ($aDewPt != 0) {
            $this->setDewPt($this->getDewPt() / $aDewPt);
        }
        if ($aWindSpeed != 0) {
            $this->setWindSpeed($this->getWindSpeed() / $aWindSpeed);
        }
        if ($aBar != 0) {
            $this->setBar($this->getBar() / $aBar);
        }
        if ($aSolarRad != 0) {
            $this->setSolarRad($this->getSolarRad() / $aSolarRad);
        }
        if ($aUVIndex != 0) {
            $this->setUVIndex($this->getUVIndex() / $aUVIndex);
        }

        unset($aTempOut, $aOutHum, $aDewPt, $aWindSpeed, $aBar, $aSolarRad, $aUVIndex);

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
        $aUVIndex = array_sum($this->amountUVIndex);

        $this->setTempOut($this->getTempOut() * $aTempOut);
        $this->setOutHum($this->getOutHum() * $aOutHum);
        $this->setDewPt($this->getDewPt() * $aDewPt);
        $this->setWindSpeed($this->getWindSpeed() * $aWindSpeed);
        $this->setBar($this->getBar() * $aBar);
        $this->setSolarRad($this->getSolarRad() * $aSolarRad);
        $this->setUVIndex($this->getUVIndex() * $aUVIndex);

        return $this;
    }
}
