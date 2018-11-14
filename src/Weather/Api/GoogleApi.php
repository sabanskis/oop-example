<?php

namespace Weather\Api;

use Weather\Model\NullWeather;
use Weather\Model\Weather;

class GoogleApi implements DataProvider
{
    /**
     * @return Weather
     * @throws \Exception
     */
    public function getToday()
    {
        $today = $this->load(new NullWeather(), new \DateTime());

        return $today;
    }

    /**
     * @param Weather $before
     * @return Weather
     * @throws \Exception
     */
    private function load(Weather $before, $date)
    {
        $now = new Weather();
        $base = $before->getDayTemp();
        $now->setDayTemp(random_int( $base -1 , 1 + $base));
        $base = $before->getNightTemp();
        $now->setNightTemp(random_int(-1 - abs($base), -1 + abs($base)));

        $now->setSky(random_int(1, 3));
        $now->setDate($date);

        return $now;
    }

    /**
     * @param \DateTime $date
     * @return Weather
     */
    public function selectByDate(\DateTime $date): Weather
    {

        return $this->load($this->getDayBefore($date), new \DateTime());
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array
     */
    public function selectByRange(\DateTime $from, \DateTime $to): array
    {

        $days = [];
        $dayBefore = new Weather();
        $dayBefore->setDate($from);
        $dayBefore->setDayTemp(20);
        $dayBefore->setNightTemp(13);
        $dayBefore->setSky(1);
        $index=0;

        $dayTo = clone $to->modify('-1 day');

        for($i = $from; $i < $dayTo; $i->modify('+1 day')) {
            if ($index == 0) {
                $days[]= $this->load($dayBefore, clone $i);
            } else {
                $days[]= $this->load($days[$index-1], clone $i);
            }
            $index++;
        }

        return $days;
    }

    /**
     * @param \DateTime $date
     * @return Weather
     */
    public function getDayBefore(\DateTime $date): Weather
    {
        $dayBefore = new Weather();
        $dayBefore->setDate($date->modify('-1 day'));
        $dayBefore->setDayTemp(10);
        $dayBefore->setNightTemp(6);
        $dayBefore->setSky(1);
        return $dayBefore;
    }
}
