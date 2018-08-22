# HubSpot iCal

Generates a calendar from HubSpot events that can be shared on Google Calendar.

## Installation

1. Run `composer install`
1. Move `config.sample.php` to `config.php`
1. Login to [HubSpot](https://app.hubspot.com)
1. Click on your face in the top-right
1. Select `Integrations`
1. Click `HubSpot API key` on the left
1. Click `Show key`
1. Copy and paste the key into `config.php`
1. Upload the code to a public URL

## Usage

1. Copy the URL to which you uploaded the code to your clipboard
1. Open [Google Calendar](https://calendar.google.com)
1. Click the `+` next to `Add a friend's calendar` > `From URL`
1. Paste the URL into the field and click `ADD CALENDAR`

## Troubleshooting

Google pings calendar URLs once every 12 hours, which means data can be up to 12 hours old.

To force your calendar to refresh, remove and re-add the calendar with a unique query string so Google treats it as a new calendar.

Example: `https://example.com/ical?abc123`