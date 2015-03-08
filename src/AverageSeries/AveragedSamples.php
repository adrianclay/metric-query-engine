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

    /**
     * @param array $samples
     */
    function __construct( array $samples )
    {
        $this->samples = $samples;
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
}
//EOF AveragedSamples.php