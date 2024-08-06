<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Enums;

enum WebinarType: string
{
    /*
     * Specifies the webinar type. The default type value is 'single_session', which is used to create a single webinar
     * session. The possible values are 'single_session', 'series', 'sequence'. If type is set to 'single_session', a
     * single webinar session is created. If type is set to 'series', a webinar series is created. In this case 2 or
     * more timeframes must be specified for each webinar.
     * Example: 'times': [{'startTime': '...', 'endTime': '...'},{'startTime': '...', 'endTime': '...'},{'startTime': '...', 'endTime': '...'}.
     * If type is set to 'sequence' a sequence of webinars is created. The times object in the body must be replaced by
     * the 'recurrenceStart' object. Example: 'recurrenceStart': {'startTime':'2012-06-12T16:00:00Z', 'endTime': '2012-06-12T17:00:00Z' }.
     * The 'recurrenceEnd' and 'recurrencePattern' body parameter must be specified. Example: , 'recurrenceEnd': '2012-07-10', 'recurrencePattern': 'daily'.
     */
    case SINGLE_SESSION = 'single_session';
    case SERIES = 'series';
    case SEQUENCE = 'sequence';
}
