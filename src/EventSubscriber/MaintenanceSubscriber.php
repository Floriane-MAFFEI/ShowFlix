<?php

namespace App\EventSubscriber;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag){
        $this->parameterBag = $parameterBag;
    }

    /**
     * This method is called when a response is returned by the kernel.
     * It adds a maintenance message to the response if the "app.maintenance" parameter is set to true.
     */
    public function onKernelResponse(ResponseEvent $event): void
    {

        // Check if maintenance mode is enabled
        if(!$this->parameterBag->get("app.maintenance")){
                // If maintenance mode is disabled, return early
                return;
        }

        // Check if it's the main request to avoid modifying sub-requests
        if(!$event->isMainRequest()){
            return;
        }

        // Get the response object from the event
        $response = $event->getResponse();

        // Get the content of the response
        $content = $response->getContent();

        // Replace a specific HTML tag in the content with a maintenance message
        $newBody = str_replace("</nav>","</nav><div class='mt-2 alert alert-danger'>Maintenance prévue ". $this->parameterBag->get('app.maintenance')." à 17h00</div>",$content);

        // Update the content of the response
        $response->setContent($newBody);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
