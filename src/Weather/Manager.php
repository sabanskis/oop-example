<?php

namespace Weather;

use Weather\Api\DataProvider;
use Weather\Api\DbRepository;
use Weather\Api\GoogleApi;
use Weather\Api\JsonApi;
use Weather\Model\Weather;


class Manager
{
    /**
     * @var DataProvider
     */
    private $transporter;

    public function getTodayInfo(): Weather
    {

        return $this->getTransporter()->selectByDate(new \DateTime());
    }

    /**
     * @param DataProvider $transporter
     */
    public function setTransporter($key)
    {

        switch ($key) {
            case 'google-api':
                return $this->transporter = new GoogleApi();
                break;
            case 'local-db':
                return $this->transporter = new DbRepository();
                break;
            case 'json-db':
                return $this->transporter = new JsonApi();
                break;
        }
    }


    public function getWeekInfo(): array
    {
        return $this->getTransporter()->selectByRange(new \DateTime(), new \DateTime('+7 days'));
    }

    /**
     * @return DataProvider
     */
    public function getTransporter()
    {
        return $this->transporter;
    }




}


