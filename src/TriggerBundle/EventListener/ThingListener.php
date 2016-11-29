<?php
// src/TriggerBundle/EventListener/ThingListener.php
namespace TriggerBundle\EventListener;

use Swift_Mailer;
use Swift_Message;
use Twig_Environment;
use Symfony\Component\DependencyInjection\ContainerInterface;
use PipelineBundle\Event\ThingEvent;

class ThingListener
{
    // These NOTICE_* consts must also match the thing_*.html.twig filenames:
    const NOTICE_ZERO = 0;  // when Thing amount reaches 0
    const NOTICE_TEN  = 10;  // every 10 Things

    protected $twig;
    protected $mailer;
    protected $container;


    public function __construct(Twig_Environment $twig, Swift_Mailer $mailer, ContainerInterface $container)
    {
        $this->twig      = $twig;
        $this->mailer    = $mailer;
        $this->container = $container;
    }


    /**
     * For this simple project, there is currently only one event to deal with.
     */
    public function onThingAction(ThingEvent $event)
    {
        //echo 'DEBUG '.__METHOD__.'('.$event->thingName.', '.$event->increment.', '.$event->direction.")<br>\n";

        // Add whatever email-condition logic you want here:
        if ($event->amount <= 0) {
            $this->sendNotice(self::NOTICE_ZERO, $event);
        }
        if ($event->amount && $event->amount % 10 == 0) {
            $this->sendNotice(self::NOTICE_TEN, $event);
        }
    }


    /**
     * @TODO - move this method and related data to its own class when needed
     */
    protected function sendNotice($type, ThingEvent $event)
    {
        //echo 'DEBUG '.__METHOD__.'('.$type.") sending email<br>\n";

        $message = Swift_Message::newInstance()
            ->setFrom($this->container->getParameter('cots.trigger_bundle.notice_from_email'))
            ->setTo($this->container->getParameter('cots.trigger_bundle.notice_to_email'))
            ->setBody($this->twig->render(
                        "TriggerBundle:Email:thing_{$type}.html.twig",
                        array(
                            'thingName' => $event->thingName
                        )
                    )
                );
            // @TODO ->addPart($this->twig->render(...text/plain...));
        if ($type === self::NOTICE_ZERO) {
            $message->setSubject('CoTs Notice: inventory depleted');
        }
        if ($type === self::NOTICE_TEN) {
            $message->setSubject('CoTs Notice: 10 more');
        }

        return $this->mailer->send($message);
    }
}
