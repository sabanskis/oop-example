<?php

namespace Weather\Controller;

use Weather\Manager;
use Weather\Model\NullWeather;

class StartPage
{
    public function getTodayWeather($param): array
    {

        try {
            $service = new Manager;
            $service->setTransporter($param);

            $weather = $service->getTodayInfo();
        } catch (\Exception $exp) {
            $weather = new NullWeather();
        }


        return ['template' => 'today-weather.twig', 'context' => ['weather' => $weather]];
    }

    public function getWeekWeather($param): array
    {
        try {
            $service = new Manager;
            $service->setTransporter($param);
            $weathers = $service->getWeekInfo();
        } catch (\Exception $exp) {
            $weathers = [];
        }

        return ['template' => 'range-weather.twig', 'context' => ['weathers' => $weathers]];
    }
}
