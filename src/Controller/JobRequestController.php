<?php

namespace App\Controller;

use App\DTO\ResponseDTO;
use App\DTO\ValidationFieldDTO;
use App\Factory\JobRequestFactoryInterface;
use App\Service\JobRequestServiceInterface;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package App\Controller
 * @Rest\Route("/job_request")
 */
class JobRequestController extends FOSRestController
{
    const HTTP_STATUS_UNPROCESSABLE_ENTITY = 422;
    const HTTP_STATUS_BAD_REQUEST = 410;
    const HTTP_STATUS_OK = 200;

    /** @var JobRequestServiceInterface */
    private $jobRequestService = null;

    /** @var JobRequestFactoryInterface */
    private $jobRequestFactory = null;

    /**
     * @param JobRequestServiceInterface $jobRequestService
     * @param JobRequestFactoryInterface $jobRequestFactory
     */
    public function __construct(JobRequestServiceInterface $jobRequestService, JobRequestFactoryInterface $jobRequestFactory)
    {
        $this->jobRequestService = $jobRequestService;
        $this->jobRequestFactory = $jobRequestFactory;
    }

    /**
     * @Post("/job_request)
     * @param Request $request
     * @return JsonResponse
     */
    public function postAction(Request $request)
    {
        $requestBody = $request->getContent();
        $jobRequestParseErrors = [];
        $jobRequestFactory = $this->jobRequestFactory;

        $jobRequestDTO = $jobRequestFactory($requestBody, $jobRequestParseErrors);

        if (!$jobRequestDTO) {
            $this->sendInvalidRequestErrorResponse($jobRequestParseErrors);
        }

        $jobRequestCreationErrors = [];
        $this->jobRequestService->createNewJobRequest($jobRequestDTO, $jobRequestCreationErrors);

        if (!empty($jobRequestCreationErrors)) {
            $this->sendValidationErrorResponse($jobRequestCreationErrors);
        }

        return $this->sendSuccessfulCreationResponse();
    }

    /**
     * @return JsonResponse
     */
    private function sendSuccessfulCreationResponse(): JsonResponse
    {
        return $this->json(new ResponseDTO(ResponseDTO::STATUS_SUCCESS, "Success"));
    }

    /**
     * @param array $jobRequestParseErrors
     *
     * @return JsonResponse
     */
    private function sendInvalidRequestErrorResponse(array $jobRequestParseErrors): JsonResponse
    {
        $responseDTO = new ResponseDTO(ResponseDTO::STATUS_ERROR, "Job request invalid. Missing fields.");

        foreach ($jobRequestParseErrors as $field => $error) {
            $responseDTO->addField(new ValidationFieldDTO($field, $error));
        }

        return $this->json($responseDTO, self::HTTP_STATUS_BAD_REQUEST);
    }

    private function sendValidationErrorResponse(array $jobRequestCreationErrors)
    {
        $responseDTO = new ResponseDTO(ResponseDTO::STATUS_ERROR, "Job request invalid. One or more fields are invalid.");

        foreach ($jobRequestCreationErrors as $field => $error) {
            $responseDTO->addField(new ValidationFieldDTO($field, $error));
        }

        return $this->json($responseDTO, self::HTTP_STATUS_UNPROCESSABLE_ENTITY);
    }
}
