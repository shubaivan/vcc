<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\AbstractRestController;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class CardController extends AbstractRestController
{
    /**
     * get photo by parameters.
     *
     * @ApiDoc(
     * resource = true,
     * description = "get photo by parameters.",
     *  parameters={
     *  },
     * statusCodes = {
     *      200 = "Successful",
     *      400 = "Bad request"
     * },
     *  section="Card"
     * )
     * @RestView()
     *
     * @param ParamFetcher $paramFetcher
     * @param Request      $request
     *
     * @return View
     */
    public function getCardAction(ParamFetcher $paramFetcher, Request $request)
    {
        return $this->createSuccessResponse(
            ['hello' => 'test'],
            [],
            true
        );
    }
}
