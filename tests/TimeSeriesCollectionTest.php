<?php

namespace adrianclay\Stats\Aggregation;

/**
 * @author Adrian Clay <adieclay@gmail.com>
 * @since 08/03/2015
 */
abstract class TimeSeriesCollectionTest extends \PHPUnit_Framework_TestCase
{
    const SERIES_NAME = 'name';
    const FROM = 10;
    const TO = 11;
    const SAMPLE_VALUE = 1;

    public function testEmptyCollection()
    {
        $this->assertSame( [ ], $this->generateTimeSeries( [ ] )->getTimeSeries( 'bad_name', self::FROM, self::TO ) );
    }

    public function testSingleItem()
    {
        $series = [ new MockTimestampedSample( self::FROM, self::SAMPLE_VALUE ) ];
        $collection = $this->generateTimeSeries( $series );
        $this->assertSame( $series, $collection->getTimeSeries( self::SERIES_NAME, self::FROM, self::TO ) );
    }

    public function testTimstampTooSmall()
    {
        $collection = $this->generateTimeSeries( [ new MockTimestampedSample( self::FROM - 2, self::SAMPLE_VALUE ) ] );
        $this->assertSame( [ ], $collection->getTimeSeries( self::SERIES_NAME, self::FROM, self::TO ) );
    }

    public function testTimstampTooBig()
    {
        $collection = $this->generateTimeSeries( [ new MockTimestampedSample( self::TO + 2, self::SAMPLE_VALUE ) ] );
        $this->assertSame( [ ], $collection->getTimeSeries( self::SERIES_NAME, self::FROM, self::TO ) );
    }


    /**
     * @param MockTimestampedSample[] $series
     * @return TimeSeriesCollection
     */
    abstract protected function generateTimeSeries( array $series );
}
//EOF TimeSeriesCollectionTest.php