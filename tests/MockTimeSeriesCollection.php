<?php

namespace adrianclay\Stats\Aggregation;

/**
 * @author Adrian Clay <adieclay@gmail.com>
 * @since  07/03/2015
 */
class MockTimeSeriesCollection implements TimeSeriesCollection
{
    /** @var array */
    private $seriesCollection;

    /**
     * @param array $seriesCollection
     */
    function __construct( array $seriesCollection )
    {
        $this->seriesCollection = $seriesCollection;
    }


    /**
     * Get a time series - a series of values over a timeslice.
     * @param string $name
     * @param int    $from
     * @param int    $to
     * @return TimestampedSample[]
     */
    public function getTimeSeries( $name, $from, $to )
    {
        $timeFilter = function ( TimestampedSample $sample ) use ( $from, $to ) {
            return $sample->getTimestamp() >= $from && $sample->getTimestamp() <= $to;
        };
        return $this->seriesCollection[$name] ? array_filter( $this->seriesCollection[$name], $timeFilter ) : [ ];
    }
}
//EOF MockTimeSeriesCollection.php