<?php

namespace adrianclay\Stats\Aggregation\AverageSeries;

use adrianclay\Stats\Aggregation\AverageSeries;

/**
 * @author Adrian Clay <adieclay@gmail.com>
 * @since  07/03/2015
 */
class AveragedSamplesTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyAverage()
    {
        $averagedSamples = new AveragedSamples( [ ] );
        $this->assertNull( $averagedSamples->getAggregatedValue() );
    }

    public function testSingleSample()
    {
        $averagedSamples = new AveragedSamples( [ 1 ] );
        $this->assertSame( 1, $averagedSamples->getAggregatedValue() );
    }

    public function testAverageTwoSamples()
    {
        $averagedSamples = new AveragedSamples( [ 1, 2 ] );
        $this->assertSame( ( 1 + 2 ) / 2, $averagedSamples->getAggregatedValue() );
    }

}
//EOF AveragedSamplesTest.php