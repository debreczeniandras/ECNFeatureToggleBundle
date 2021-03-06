<?php

/*
 * This file is part of the ECNFeatureToggle package.
 *
 * (c) Pierre Groth <pierre@elbcoast.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ecn\FeatureToggleBundle\Tests\EventListener;

use Ecn\FeatureToggleBundle\Configuration\Feature;
use Ecn\FeatureToggleBundle\EventListener\ControllerListener;
use Ecn\FeatureToggleBundle\Tests\EventListener\Fixture\FooControllerFeatureAtClass;
use Ecn\FeatureToggleBundle\Tests\EventListener\Fixture\FooControllerFeatureAtClassAndMethod;
use Ecn\FeatureToggleBundle\Tests\EventListener\Fixture\FooControllerFeatureAtMethod;
use Doctrine\Common\Annotations\AnnotationReader;
use Ecn\FeatureToggleBundle\Service\FeatureService;
use Ecn\FeatureToggleBundle\Voters\VoterRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ControllerListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ControllerListener
     */
    private $listener;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var FilterControllerEvent
     */
    private $event;

    public function setUp()
    {
        $this->listener = new ControllerListener(
            new AnnotationReader(),
            new FeatureService([], [], new VoterRegistry())
        );
        $this->request = $this->createRequest();

        // trigger the autoloading of the @Feature annotation
        class_exists('Ecn\FeatureToggleBundle\Configuration\Feature');
    }

    public function tearDown()
    {
        $this->listener = null;
        $this->request = null;
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testFeatureAnnotationAtMethod()
    {
        $controller = new FooControllerFeatureAtMethod();

        $this->event = $this->getFilterControllerEvent([$controller, 'barAction'], $this->request);
        $this->listener->onKernelController($this->event);
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testFeatureAnnotationAtClass()
    {
        $controller = new FooControllerFeatureAtClass();
        $this->event = $this->getFilterControllerEvent(array($controller, 'barAction'), $this->request);
        $this->listener->onKernelController($this->event);
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testFeatureAnnotationAtClassAndMethod()
    {
        $controller = new FooControllerFeatureAtClassAndMethod();
        $this->event = $this->getFilterControllerEvent(array($controller, 'barAction'), $this->request);
        $this->listener->onKernelController($this->event);
    }

    protected function createRequest()
    {
        return new Request([], [], []);
    }

    /**
     * @param         $controller
     * @param Request $request
     *
     * @return FilterControllerEvent
     */
    protected function getFilterControllerEvent($controller, Request $request)
    {
        /** @var Kernel|\PHPUnit_Framework_MockObject_MockObject $mockKernel */
        $mockKernel = $this->getMockForAbstractClass('Symfony\Component\HttpKernel\Kernel', array('', ''));

        return new FilterControllerEvent($mockKernel, $controller, $request, HttpKernelInterface::MASTER_REQUEST);
    }
}
