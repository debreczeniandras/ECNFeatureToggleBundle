<?php

/*
 * This file is part of the ECNFeatureToggle package.
 *
 * (c) Pierre Groth <pierre@elbcoast.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ecn\FeatureToggleBundle\Voters;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Should be used together with VoterInterface
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait VoterTrait
{
    /**
     * @var string
     */
    private $feature;

    /**
     * {@inheritdoc}
     */
    public function setParams(ParameterBag $params)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setFeature($feature)
    {
        $this->feature = $feature;
    }
}