<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class AbstractRestController extends FOSRestController
{
    const HTTP_STATUS_CODE_OK = 200;
    const HTTP_STATUS_CODE_BAD_REQUEST = 400;
    const HTTP_STATUS_CODE_INTERNAL_ERROR = 500;
    const DATA_MESSAGE = 'message';
    const SUCCESS = 'success';
    const SERVER_ERROR = 'Server Error';
    const PARAM_DATE_FROM = 'date_from';
    const PARAM_DATE_TO = 'date_to';

    /**
     * @param $data
     * @param null|array $groups
     * @param null|bool  $withEmptyField
     *
     * @return View
     */
    protected function createSuccessResponse($data, array $groups = null, $withEmptyField = null)
    {
        $context = new Context();

        if ($groups) {
            $context
                ->setGroups($groups);
        }

        if ($withEmptyField) {
            $context
                ->setSerializeNull(true);
        }

        return View::create()
            ->setStatusCode(self::HTTP_STATUS_CODE_OK)
            ->setData($data)
            ->setContext($context);
    }

    /**
     * @param string $data
     *
     * @return View
     */
    protected function createSuccessStringResponse($data)
    {
        return View::create()
            ->setStatusCode(self::HTTP_STATUS_CODE_OK)
            ->setData([self::DATA_MESSAGE => $data]);
    }
}
