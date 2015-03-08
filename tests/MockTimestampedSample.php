<?php

namespace adrianclay\Stats\Aggregation;

/**
 * @author Adrian Clay <adieclay@gmail.com>
 * @since  07/03/2015
 */
class MockTimestampedSample implements TimestampedSample
{
    /** @var int */
    private $timestamp;
    /** @var float */
    private $value;

    /**
     * @param int   $timestamp
     * @param float $value
     */
    function __construct( $timestamp, $value )
    {
        $this->timestamp = $timestamp;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return float
     */
    public function getSample()
    {
        return $this->value;
    }
}
//EOF MockTimestampedSample.php