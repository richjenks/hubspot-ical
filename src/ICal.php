<?php namespace RichJenks\HubSpotICal;

/**
 * Constructs `.ics` file
 */
class ICal {

	/**
	 * API config options
	 * @var array
	 */
	private $config;

	/**
	 * iCal instance
	 * @var object
	 */
	private $calendar;

	/**
	 * Events data
	 * @var array
	 */
	private $events;

	/**
	 * Accepts dependencies
	 *
	 * @param array  $config   API config options
	 * @param object $calendar iCal creator
	 * @param array  $events   From /RichJenks\HubSpotICal\HubSpot
	 */
	public function __construct($config, $calendar, $events) {
		$this->config   = $config;
		$this->calendar = $calendar;
		$this->events   = $events;
	}

	/**
	 * Makes the magic happen
	 * @param  boolean $echo Echo or print `.ics` file
	 */
	public function launch($echo = false) {
		$this->events($this->events);
		$this->print($echo);
	}

	/**
	 * Outputs the calendar data
	 */
	private function print($echo) {
		if (!$echo) {
			header('Content-Type: text/calendar; charset=utf-8');
			header('Content-Disposition: attachment; filename="cal.ics"');
		}
		echo $this->calendar->render();
	}

	/**
	 * Adds events to the calendar
	 * One element per event
	 * Expects indices `data`, `summary` & `location`
	 *
	 * @param  array $events Event data as specified above
	 * @return [type]         [description]
	 */
	private function events($events) {
		foreach ($events as $event) {
			$ievent = new \Eluceo\iCal\Component\Event();
			$ievent
				->setDtStart(new \DateTime($event['date']))
				->setDtEnd(new \DateTime($event['date']))
				->setSummary($event['summary'])
				->setLocation($event['location'])
				->setNoTime(true)
			;
			$this->calendar->addComponent($ievent);
		}
	}
}
