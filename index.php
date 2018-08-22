<?php namespace RichJenks\HubSpotICal;

require 'vendor/autoload.php';

// Dependencies
$deps = (object) [
	'config' => require 'config.php',
	'guzzle' => new \GuzzleHttp\Client,
	'ical'   => new \Eluceo\iCal\Component\Calendar('hubspot.com'),
	'logger' => new \Katzgrau\KLogger\Logger(__DIR__.'/logs'),
];

// Explicitly set calendar name
$deps->ical->setName('HubSpot');
$deps->ical->setDescription('HubSpot');

// Get calendar data
$hubspot = new HubSpot($deps->config, $deps->guzzle);
$events  = $hubspot->get();

// Get iCal
$ical = new ICal($deps->config, $deps->ical, $events);
$ical->launch();

// Captain's Log
$deps->logger->info($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown user agent');