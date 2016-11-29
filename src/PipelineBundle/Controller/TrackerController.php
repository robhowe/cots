<?php
/**
 * src/PipelineBundle/Controller/TrackerController.php
 *
 * This is the core class of the PipelineBundle
 * where all the real processing happens.
 * This tracks "counts" of "things".
 *
 * PHP version 5.6
 *
 * @category   Cots
 * @package    PipelineBundle
 * @author     Rob Howe <rob@robhowe.com>
 * @copyright  2016 Rob Howe
 * @license    This file is proprietary and subject to the terms defined in file LICENSE.txt
 * @version    Bitbucket via git: $Id$
 * @link       http://cots.robhowe.com
 * @since      version 1.0
 */

namespace PipelineBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use PipelineBundle\Event\ThingEvent;
use PipelineBundle\Entity\Thing;


class TrackerController extends Controller
{
    /**
     * @Route("/tracker/{thingName}/{increment}/{direction}",
     *     requirements={"increment":"^[-|+]?\d+$","direction":"up|down"})
     * @Method({"GET","POST"})
     */
    public function trackerAction($thingName, $increment, $direction)
    {
        $em = $this->getDoctrine()->getManager();

        $thing = $this->getDoctrine()
            ->getRepository('PipelineBundle:Thing')
            ->find($thingName);
        if (!$thing) {  // This must be our first time seeing a thing with this name
            $thing = new Thing();
            $thing->setName($thingName);
            $thing->setAmount(0);
        }

        $thing->incrementAmount($increment, $direction);

        $em->persist($thing);  // tells Doctrine you want to eventually save $thing
        $em->flush();  // actually executes the INSERT or UPDATE query

        $dispatcher = $this->get('event_dispatcher');
        $event = new ThingEvent();
        $event->thingName = $thingName;
        $event->increment = $increment;
        $event->direction = $direction;
        $event->amount    = $thing->getAmount();

        $dispatcher->dispatch(ThingEvent::EVENT_NAME, $event);

        $response = 'SUCCESS';
        //$response = 'DEBUG: '.__METHOD__.'('.$thingName.', '.$increment.', '.$direction.")<br>\n";

        return new Response($response);
    }
}
