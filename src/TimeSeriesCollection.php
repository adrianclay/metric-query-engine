<?php

namespace adrianclay\Stats\Aggregation;

/**
 * @author Adrian Clay <adieclay@gmail.com>
 * @since  07/03/2015
 */
interface TimeSeriesCollection
{
    /**
     * Get a time series - a series of values over a timeslice.
     * @param string $name
     * @param int    $from
     * @param int    $to
     * @return TimestampedSample[]
     */
    public function getTimeSeries( $name, $from, $to );
}
//EOF TimeSeriesCollection.php