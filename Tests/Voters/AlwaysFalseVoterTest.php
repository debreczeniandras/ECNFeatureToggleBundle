<?php

/*
 * This file is part of the ECNFeatureToggle package.
 *
 * (c) Pierre Groth <pierre@elbcoast.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ecn\FeatureToggleBundle\Tests\Voters;

use Ecn\FeatureToggleBundle\Voters\AlwaysFalseVoter;

/**
 * @author Pierre Groth <pierre@elbcoast.net>
 */
class AlwaysFalseVoterTest extends \PHPUnit_Framework_TestCase
{
    public function testVoterPass()
    {
        $voter = new AlwaysFalseVoter();

        $this->assertFalse($voter->pass());
    }
}
