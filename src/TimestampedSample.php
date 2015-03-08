<?php

namespace adrianclay\Stats\Aggregation;

/**
 * @author Adrian Clay <adieclay@gmail.com>
 * @since  07/03/2015
 */
interface TimestampedSample
{
    /**
     * @return int
     */
    public function getTimestamp();

    /**
     * @return float
     */
    public function getSample();
}
//EOF TimestampedSample.php