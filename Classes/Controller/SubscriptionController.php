<?php

namespace KaufmannDigital\CleverReach\Controller;


use Neos\Flow\Annotations as Flow;
use KaufmannDigital\CleverReach\Domain\Service\SubscriptionService;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Flow\Mvc\Controller\ActionController;

/**
 * Class SubscriptionController
 *
 * @package KaufmannDigital\CleverReach\Controller
 */
class SubscriptionController extends ActionController
{

    /**
     * @Flow\Inject
     * @var SubscriptionService
     */
    protected $subscriptionService;


    /**
     * Display the registration form
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('node', $this->request->getInternalArgument('__node'));
        $httpRequest = $this->request->getHttpRequest();
        $this->view->assign('sourceUrl', $httpRequest->getBaseUri() . $httpRequest->getRelativePath());
    }

    /**
     * @Flow\Validate(argumentName="receiverData", type="KaufmannDigital.CleverReach:ReceiverData")
     * @param array $receiverData
     */
    public function subscribeAction(array $receiverData)
    {
        /** @var NodeInterface $registrationForm */
        $registrationForm = $this->request->getInternalArgument('__node');

        $this->subscriptionService->create($receiverData, $registrationForm, $this->request->getHttpRequest());

        $this->view->assign('usedDOI', $registrationForm->getProperty('useDOI'));
    }

}
