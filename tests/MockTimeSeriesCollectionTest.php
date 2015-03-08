<?php

namespace adrianclay\Stats\Aggregation;

/**
 * @author Adrian Clay <adieclay@gmail.com>
 * @since  07/03/2015
 */
class MockTimeSeriesCollectionTest extends TimeSeriesCollectionTest
{
    /**
     * @param MockTimestampedSample[] $series
     * @return MockTimeSeriesCollection
     */
    protected function generateTimeSeries( array $series )
    {
        $seriesCollection = [ self::SERIES_NAME => $series ];
        return new MockTimeSeriesCollection( $seriesCollection );
    }
}
//EOF MockTimeSeriesCollectionTest.php