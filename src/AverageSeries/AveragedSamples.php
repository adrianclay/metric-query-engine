<?php

namespace adrianclay\Stats\Aggregation\AverageSeries;

/**
 * @author Adrian Clay <adieclay@gmail.com>
 * @since  07/03/2015
 */
class AveragedSamples
{
    /** @var array */
    private $samples;
    /** @var int */
    private $timestamp;

    /**
     * @param int   $timestamp
     * @param array $samples
     */
    function __construct( $timestamp, array $samples )
    {
        $this->samples = $samples;
        $this->timestamp = $timestamp;
    }

    /**
     * @return float|null
     */
    public function getAggregatedValue()
    {
        if ( empty( $this->samples ) ) {
            return null;
        }
        return \array_sum( $this->samples ) / \count( $this->samples );
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
//EOF AveragedSamples.php