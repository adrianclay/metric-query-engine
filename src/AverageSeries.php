<?php

namespace adrianclay\Stats\Aggregation;

use adrianclay\Stats\Aggregation\AverageSeries\AveragedSamples;

/**
 * @author Adrian Clay <adieclay@gmail.com>
 * @since  07/03/2015
 */
class AverageSeries
{
    /** @var TimeSeriesCollection */
    private $timeSeriesCollection;

    /**
     * @param TimeSeriesCollection $timeSeriesCollection
     */
    function __construct( TimeSeriesCollection $timeSeriesCollection )
    {
        $this->timeSeriesCollection = $timeSeriesCollection;
    }

    /**
     * @param string $name
     * @param int    $from
     * @param int    $to
     * @param int    $interval
     * @return AveragedSamples[]
     */
    public function getAverageSeries( $name, $from, $to, $interval )
    {
        $timestampedValues = $this->timeSeriesCollection->getTimeSeries( $name, $from, $to );
        $timeBuckets = [ ];
        foreach ( $timestampedValues as $timestampedValue ) {
            $timestamp = $timestampedValue->getTimestamp();
            $timeBuckets[intval( ( $timestamp - $from ) / $interval )][] = $timestampedValue->getSample();
        }
        return array_values( \array_map( function ( $timestampKey, $timeBucket ) use ( $interval, $from ) {
            return new AveragedSamples( $timestampKey * $interval + $from, $timeBucket );
        }, array_keys( $timeBuckets ), $timeBuckets ) );
    }

}
//EOF AverageSeries.php