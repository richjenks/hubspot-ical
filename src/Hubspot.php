<?php namespace RichJenks\HubspotICal;

/**
 * Interacts with the Hubspot API
 */
class Hubspot {

	/**
	 * API config options
	 * @var array
	 */
	private $config;

	/**
	 * HTTP client
	 * @var object
	 */
	private $client;

	/**
	 * Accepts dependencies
	 *
	 * @param array  $config API config options
	 * @param object $client HTTP client
	 */
	public function __construct($config, $client) {
		$this->config = $config;
		$this->client = $client;
	}

	/**
	 * Constructs usable array of calendar data
	 *
	 * @param int $length Number of events to return
	 * @param int $offset Offset on which to start the segment
	 * @return array Calendar data
	 */
	public function get($length = false, $offset = 0) {
		$data = $this->sanitize($this->api());
		if ($length) $data = array_slice($data, $offset, $length);
		return $data;
	}

	/**
	 * Gets calendar events from Hubspot API
	 * @return array Raw calendar JSON
	 */
	private function api() {

		// Query string data
		$query = [
			'hapikey'   => $this->config->key,
			'startDate' => '25969000',      // 1970
			'endDate'   => '2147483647000', // 2038
		];

		// Get HTTP response
		$response = $this->client->request(
			'GET',
			$this->config->url,
			[
				'query' => $query,
				'verify' => false,
			]
		);

		return json_decode($response->getBody());

	}

	/**
	 * Sanitizes raw calendar JSON from Hubspot API
	 * @param  array $raw Raw calendar data
	 * @return array      Sanitized calendar data
	 */
	private function sanitize($raw) {

		$calendar = [];

		foreach ($raw as $event) {

			// Convert milliseconds into date
			$date = date('Y-m-d', $event->eventDate / 1000);

			// Sanitize event categories
			$category = $event->category;
			$category = str_replace('-', ' ', $category);
			$category = ucwords($category);

			// Construct event title
			if (is_null($event->name)) {
				$event->name = $event->description;
			}
			$title = sprintf('%s: %s', $category, $event->name);

			// Sanitized data
			$calendar[] = [
				'date'     => $date,
				'summary'  => $title,
				'location' => $event->url,
			];
		}

		return $calendar;

	}

}
