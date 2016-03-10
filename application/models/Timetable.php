<?php

/*
 * Model for schedule data
 */

class Timetable extends CI_Model {

    protected $xml_day = null;
    protected $xml_period = null;
    protected $xml_course = null;
    protected $weekday = array();
    protected $timeslot = array();
    protected $course = array();

    public function __construct() {
        parent:: __construct();
        $this->xml_day = simplexml_load(DATAPATH, 'winter2016-day.xml');
        $this->xml_period = simplexml_load(DATAPATH, 'winter2016-period.xml');
        $this->xml_course = simplexml_load(DATAPATH, 'winter2016-course.xml');

        //build list of school days
        foreach ($this->xml_day->aDay as $day) {
            $this->weekday[(string) $day['weekday']] = (string) $day;
        }

        //build list of school time periods
        foreach ($this->xml_period->timeslot as $period) {
            $record = new stdClass();
            $record->duration = (string) $period['duration'];
            $record->start = (string) $period['start'];
            $record->end = (string) $period['end'];
            $this->timeslot[$record->start] = $record;
        }
        
        //build list of Term 4 ACIT courses
        foreach ($this->xml_course->aCourse as $courseRecord) {
            $record = new stdClass();
            $record->code = (string) $courseRecord['code'];
            $record->name = (string) $courseRecord['name'];
            $record->aCourse[$record->code] = $record;
        }
    }

}
