<?php

namespace App\Controller;

use App\DTO\ResponseDTO;
use App\DTO\ValidationFieldDTO;
use App\Exception\JobRequestPersistException;
use App\Factory\JobRequestFactoryInterface;
use App\Service\JobRequestServiceInterface;
use App\Validator\JobRequestPayloadValidator;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;

/**
 * @package App\Controller
 * @Route("/job_request")
 */
class JobRequestController extends FOSRestController
{
    const HTTP_STATUS_BAD_REQUEST = 400;
    const HTTP_STATUS_CREATED = 201;
    const HTTP_STATUS_CONFLICT = 409;

    /** @var JobRequestServiceInterface */
    private $jobRequestService = null;

    /** @var JobRequestFactoryInterface */
    private $jobRequestFactory = null;

    /** @var LoggerInterface */
    private $logger;

    /**
     * @param JobRequestServiceInterface $jobRequestService
     * @param JobRequestFactoryInterface $jobRequestFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        JobRequestServiceInterface $jobRequestService,
        JobRequestFactoryInterface $jobRequestFactory,
        LoggerInterface $logger
    )
    {
        $this->jobRequestService = $jobRequestService;
        $this->jobRequestFactory = $jobRequestFactory;
        $this->logger = $logger;
    }

    /**
     * @Route("/api/job_request", methods={"POST"})
     *
     * Creates a job service request in the system.
     * @param Request $request
     * @return JsonResponse
     */
    public function postAction(Request $request)
    {
        try {
            $requestBody = $request->getContent();

            $jobRequestValidateErrors = [];
            $jobRequestIsValid = (new JobRequestPayloadValidator())->isValidRequestPayload($requestBody, $jobRequestValidateErrors);
            if (!$jobRequestIsValid) {
                return $this->buildInvalidRequestErrorResponse($jobRequestValidateErrors);
            }

            $jobRequestDTO = $this->jobRequestFactory->buildJobRequestDTO($requestBody);

            $this->jobRequestService->createNewJobRequest($jobRequestDTO);

            return $this->buildSuccessfulCreationResponse();
        } catch (JobRequestPersistException $ex) {
            $this->logger->error("[JobRequestController][JobRequestPersistException] {$ex->getMessage()}");

            return $this->buildPersistErrorResponse("Could not create job request. ({$ex->getMessage()})");
        }
    }

    /**
     * @return JsonResponse
     */
    private function buildSuccessfulCreationResponse(): JsonResponse
    {
        return $this->json(new ResponseDTO(ResponseDTO::STATUS_SUCCESS, "Success"), self::HTTP_STATUS_CREATED);
    }

    /**
     * @param array $jobRequestParseErrors
     *
     * @return JsonResponse
     */
    private function buildInvalidRequestErrorResponse(array $jobRequestParseErrors): JsonResponse
    {
        $responseDTO = new ResponseDTO(ResponseDTO::STATUS_ERROR, "Job request invalid. Missing fields.");

        foreach ($jobRequestParseErrors as $field => $error) {
            $responseDTO->addField(new ValidationFieldDTO($field, $error));
        }

        return $this->json($responseDTO, self::HTTP_STATUS_BAD_REQUEST);
    }

    /**
     * @param string $errorMessage
     *
     * @return JsonResponse
     */
    private function buildPersistErrorResponse(string $errorMessage): JsonResponse
    {
        return $this->json(new ResponseDTO(ResponseDTO::STATUS_ERROR, $errorMessage), self::HTTP_STATUS_CONFLICT);
    }
}
