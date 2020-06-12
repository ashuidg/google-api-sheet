<?php
require_once __DIR__ .  '/../../library/google-api-php-client/vendor/autoload.php';
// Load the Google API PHP Client Library.
// require_once __DIR__ . '/vendor/autoload.php';

$VIEW_ID = "ga:215111267";
// $start_date = "2020-01-01";
// $end_date = "2020-12-31";
$start_date = "7daysAgo";
$end_date = "today";

$analytics = initializeAnalytics();
// $response = getReport("/exhibition/info/2/");
// $response = getReport("/map/");

$urlrequire = "/news/";
if (isset($_GET["url"])) {
    $urlrequire = $_GET["url"];
}
// print_r($response);
$response = getReport($urlrequire);
if ($response) {
    echo getViews($response);
}
/**
 * Initializes an Analytics Reporting API V4 service object.
 *
 * @return An authorized Analytics Reporting API V4 service object.
 */
function initializeAnalytics()
{

  // Use the developers console and download your service account
    // credentials in JSON format. Place them in this directory or
    // change the key file location if necessary.
    // $KEY_FILE_LOCATION = __DIR__ . '/../library/google-api-php-client/wdmaptest-0f2e6d5ef34b.json';
    $KEY_FILE_LOCATION = __DIR__ . '/../../library/google-api-php-client/keys/pier2-277911-f9a0a03aaa65.json';

    // Create and configure a new client object.
    $client = new Google_Client();
    $client->setApplicationName("Hello Analytics Reporting");
    $client->setAuthConfig($KEY_FILE_LOCATION);
    $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
    $analytics = new Google_Service_AnalyticsReporting($client);
    return $analytics;
}

function getReport($page_path)
{
    global $VIEW_ID, $start_date, $end_date, $analytics;

    $query = [
        "viewId" => $VIEW_ID,
        "dateRanges" => [
            "startDate" => $start_date,
            "endDate" => $end_date
        ],
        "metrics" => [
            "expression" => "ga:pageviews"
        ],
        "dimensions" => [
            "name" => "ga:pagepath"
        ],
        "dimensionFilterClauses" => [
            'filters' => [
                "dimension_name" => "ga:pagepath",
                "operator" => "ENDS_WITH", // valid operators can be found here: https://developers.google.com/analytics/devguides/reporting/core/v4/rest/v4/reports/batchGet#FilterLogicalOperator
                "expressions" => $page_path
            ]
        ]
    ];


    // build the request and response
    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($query));
    // now batchGet the results https://developers.google.com/analytics/devguides/reporting/core/v4/rest/v4/reports/batchGet
    $report = $analytics->reports->batchGet($body);
    return $report;
}

function getViews($reports)
{
    $rows = $reports[0]->getData()->getRows();
    if ($rows) {
        $metrics = $rows[0]->getMetrics()[0]->values[0];
        if ($metrics) {
            return $metrics;
        }
    }
    return false;
}
