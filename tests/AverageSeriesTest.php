<?php

namespace adrianclay\Stats\Aggregation;
use adrianclay\Stats\Aggregation\AverageSeries\AveragedSamples;

/**
 * @author Adrian Clay <adieclay@gmail.com>
 * @since 07/03/2015
 */
class AverageSeriesTest extends \PHPUnit_Framework_TestCase
{
    const SERIES_NAME = 'test';

    const SAMPLE = 200;
    const FROM_TIME = 0;
    const TO_TIME = 200;
    const ONE_SECOND = 1;
    const ONE_MINUTE = 60;
    const SAMPLE_TIMESTAMP = 100;

    public function testEmptyAverage()
    {
        $averageSeries = new AverageSeries( new MockTimeSeriesCollection( [] ) );
        $this->assertSame( [], $averageSeries->getAverageSeries( self::SERIES_NAME, self::FROM_TIME, self::TO_TIME, self::ONE_SECOND ) );
    }

    public function testAverageSingleDataPoint()
    {
        $averageSeries = $this->createAverageSeriesFromSeries( [ $this->generateSample() ] );
        $averaged = $averageSeries->getAverageSeries( self::SERIES_NAME, self::FROM_TIME, self::TO_TIME, self::ONE_SECOND );
        $this->assertEquals( [ new AveragedSamples( self::SAMPLE_TIMESTAMP, [ self::SAMPLE ] ) ], $averaged );
    }

    public function testAverageSameDataPoint()
    {
        $singleDataPoint = $this->generateSample();
        $averageSeries = $this->createAverageSeriesFromSeries( [ $singleDataPoint, $singleDataPoint ] );
        $averaged = $averageSeries->getAverageSeries( self::SERIES_NAME, self::FROM_TIME, self::TO_TIME, self::ONE_SECOND );
        $this->assertEquals( [ new AveragedSamples( self::SAMPLE_TIMESTAMP, [ self::SAMPLE, self::SAMPLE ] ) ], $averaged );
    }

    public function testAverageWithTwoIntervals()
    {
        $averageSeries = $this->createAverageSeriesFromSeries( $this->generateConsecutiveSamplesSeries() );
        $averaged = $averageSeries->getAverageSeries( self::SERIES_NAME, self::FROM_TIME, self::TO_TIME, self::ONE_SECOND );
        $this->assertEquals( [ new AveragedSamples( self::SAMPLE_TIMESTAMP,     [ self::SAMPLE ] ),
                               new AveragedSamples( self::SAMPLE_TIMESTAMP + 1, [ self::SAMPLE ] ) ], $averaged );
    }

    public function testAverageWithMinuteInterval()
    {
        $averageSeries = $this->createAverageSeriesFromSeries( $this->generateConsecutiveSamplesSeries() );
        $averaged = $averageSeries->getAverageSeries( self::SERIES_NAME, self::FROM_TIME, self::TO_TIME, self::ONE_MINUTE );
        $this->assertEquals( [ new AveragedSamples( self::ONE_MINUTE, [ self::SAMPLE, self::SAMPLE ] ) ], $averaged );
    }

    public function testAverageFromTooHigh()
    {
        $averageSeries = $this->createAverageSeriesFromSeries( $this->generateConsecutiveSamplesSeries() );
        $averagedSamples = $averageSeries->getAverageSeries( self::SERIES_NAME, self::SAMPLE_TIMESTAMP + 10, self::TO_TIME, self::ONE_MINUTE );
        $this->assertEquals( [], $averagedSamples );
    }

    public function testAverageToTooSmall()
    {
        $averageSeries = $this->createAverageSeriesFromSeries( $this->generateConsecutiveSamplesSeries() );
        $averagedSamples = $averageSeries->getAverageSeries( self::SERIES_NAME, self::FROM_TIME, self::SAMPLE_TIMESTAMP - 10, self::ONE_MINUTE );
        $this->assertEquals( [], $averagedSamples );
    }

    public function testAverageInvalidName()
    {
        $invalidSeriesName = 'pants';
        $averageSeries = $this->createAverageSeriesFromSeries( [ $this->generateSample() ] );
        $averaged = $averageSeries->getAverageSeries( $invalidSeriesName, self::FROM_TIME, self::TO_TIME, self::ONE_SECOND );
        $this->assertEquals( [], $averaged );
    }

    public function testMisalignedTimestamps()
    {
        $averageSeries = $this->createAverageSeriesFromSeries( [ $this->generateSampleAt( 50 ),
                                                                 $this->generateSampleAt( 69 ) ] );
        $from = 40;
        $averaged = $averageSeries->getAverageSeries( self::SERIES_NAME, $from, 100, 30 );
        $this->assertEquals( [ new AveragedSamples( $from, [ self::SAMPLE, self::SAMPLE ] ) ], $averaged );
    }

    /**
     * @param array $series
     * @return AverageSeries
     */
    private function createAverageSeriesFromSeries( array $series )
    {
        return new AverageSeries( new MockTimeSeriesCollection( [ self::SERIES_NAME => $series ] ) );
    }

    /**
     * @return MockTimestampedSample
     */
    private function generateSample()
    {
        return $this->generateSampleAt( self::SAMPLE_TIMESTAMP );
    }

    /**
     * @param $timestamp
     * @return MockTimestampedSample
     */
    private function generateSampleAt( $timestamp )
    {
        return new MockTimestampedSample( $timestamp, self::SAMPLE );
    }

    /**
     * @return array
     */
    private function generateConsecutiveSamplesSeries()
    {
        return [ $this->generateSampleAt( self::SAMPLE_TIMESTAMP ),
                 $this->generateSampleAt( self::SAMPLE_TIMESTAMP + 1 ) ];
    }


}
//EOF AverageSeriesTest.php