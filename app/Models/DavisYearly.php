<?php

namespace App\Models;

/**
 * @Entity @Table(name="davis_yearly")
 **/
class DavisYearly extends DavisBase
{
    use DavisCompiled;

    public function __construct(DavisMonthly $davis = null)
    {
        if ($davis !== null) {
            $dateTime = clone $davis->getDateTime();
            $dateTime->setDate($dateTime->format('Y'), 1, 1);
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
                'WNW' => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'NW'  => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'NNW' => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'N'   => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'NNE' => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'NE'  => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'ENE' => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'E'   => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'ESE' => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'SE'  => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'SSE' => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'S'   => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'SSW' => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'SW'  => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'WSW' => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
                'W'   => ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0],
            ];

            $this->amountUVIndex = ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0];
            $this->amountSolarRad = ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0];
            $this->amountRain = ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0];
            $this->amountBar = ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0];
            $this->amountWindSpeed = ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0];
            $this->amountDewPt = ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0];
            $this->amountOutHum = ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0];
            $this->amountLowTemp = ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0];
            $this->amountHiTemp = ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0];
            $this->amountTempOut = ['1-3' => 0, '4-6' => 0, '7-9' => 0, '10-12' => 0];

            $this->amountData = 0;
        }
    }

    /**
     * @param $davis DavisYearly
     */
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

        $month = $davis->getDateTime()->format('m');


        if ($month <= 3) {
            $interval = '1-3';
        } else if ($month > 3 && $month <= 6) {
            $interval = '4-6';
        } else if ($month > 6 && $month <= 9) {
            $interval = '7-9';
        } else {
            $interval = '10-12';
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
        $cd4 = 0;
        foreach ($this->amountWindDir as $value) {
            $cd1 += $value['1-3'];
            $cd2 += $value['4-6'];
            $cd3 += $value['7-9'];
            $cd4 += $value['10-12'];
        }
        if ($cd1 >= 8640 && $cd2 >= 8640 && $cd3 >= 8640 && $cd4 >= 8640) {
            $this->validWindDir = true;
        }
        unset($cd1, $cd2, $cd3, $cd4);

        if ($this->amountTempOut['1-3'] >= 8640 &&
            $this->amountTempOut['4-6'] >= 8640 &&
            $this->amountTempOut['7-9'] >= 8640 &&
            $this->amountTempOut['10-12'] >= 8640
        ) {
            $this->validTempOut = true;
        }

        if ($this->amountHiTemp['1-3'] >= 8640 &&
            $this->amountHiTemp['4-6'] >= 8640 &&
            $this->amountHiTemp['7-9'] >= 8640 &&
            $this->amountTempOut['10-12'] >= 8640
        ) {
            $this->validHiTemp = true;
        }

        if ($this->amountLowTemp['1-3'] >= 8640 &&
            $this->amountLowTemp['4-6'] >= 8640 &&
            $this->amountLowTemp['7-9'] >= 8640 &&
            $this->amountTempOut['10-12'] >= 8640
        ) {
            $this->validLowTemp = true;
        }

        if ($this->amountOutHum['1-3'] >= 8640 &&
            $this->amountOutHum['4-6'] >= 8640 &&
            $this->amountOutHum['7-9'] >= 8640 &&
            $this->amountTempOut['10-12'] >= 8640
        ) {
            $this->validOutHum = true;
        }

        if ($this->amountDewPt['1-3'] >= 8640 &&
            $this->amountDewPt['4-6'] >= 8640 &&
            $this->amountDewPt['7-9'] >= 8640 &&
            $this->amountTempOut['10-12'] >= 8640
        ) {
            $this->validDewPt = true;
        }

        if ($this->amountWindSpeed['1-3'] >= 8640 &&
            $this->amountWindSpeed['4-6'] >= 8640 &&
            $this->amountWindSpeed['7-9'] >= 8640 &&
            $this->amountTempOut['10-12']
        ) {
            $this->validWindSpeed = true;
        }

        if ($this->amountBar['1-3'] >= 8640 &&
            $this->amountBar['4-6'] >= 8640 &&
            $this->amountBar['7-9'] >= 8640 &&
            $this->amountTempOut['10-12'] >= 8640
        ) {
            $this->validBar = true;
        }

        if ($this->amountRain['1-3'] >= 8640 &&
            $this->amountRain['4-6'] >= 8640 &&
            $this->amountRain['7-9'] >= 8640 &&
            $this->amountTempOut['10-12'] >= 8640
        ) {
            $this->validRain = true;
        }

        if ($this->amountSolarRad['1-3'] >= 8640 &&
            $this->amountSolarRad['4-6'] >= 8640 &&
            $this->amountSolarRad['7-9'] >= 8640 &&
            $this->amountTempOut['10-12'] >= 8640
        ) {
            $this->validSolarRad = true;
        }

        if ($this->amountUVIndex['1-3'] >= 8640 &&
            $this->amountUVIndex['4-6'] >= 8640 &&
            $this->amountUVIndex['7-9'] >= 8640 &&
            $this->amountTempOut['10-12'] >= 8640
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
