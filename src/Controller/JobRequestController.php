<?php

namespace App\Controller;

use App\DTO\ResponseDTO;
use App\DTO\ValidationFieldDTO;
use App\Exception\JobRequestPersistException;
use App\Factory\JobRequestFactoryInterface;
use App\Service\JobRequestServiceInterface;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package App\Controller
 * @Route("/job_request")
 */
class JobRequestController extends FOSRestController
{
    const HTTP_STATUS_UNPROCESSABLE_ENTITY = 422;
    const HTTP_STATUS_BAD_REQUEST = 410;
    const HTTP_STATUS_CREATED = 201;
    const HTTP_STATUS_GENERAL_SERVER_ERROR = 500;

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
     * @Post("/job_request")
     * @param Request $request
     * @return JsonResponse
     */
    public function postAction(Request $request)
    {
        try {
            $requestBody = $request->getContent();
            $jobRequestParseErrors = [];
            $jobRequestFactory = $this->jobRequestFactory;

            $jobRequestDTO = $jobRequestFactory($requestBody, $jobRequestParseErrors);

            if (!$jobRequestDTO) {
                return $this->buildInvalidRequestErrorResponse($jobRequestParseErrors);
            }

            $jobRequestCreationErrors = [];
            $this->jobRequestService->createNewJobRequest($jobRequestDTO, $jobRequestCreationErrors);

            if (!empty($jobRequestCreationErrors)) {
                return $this->buildValidationErrorResponse($jobRequestCreationErrors);
            }

            return $this->buildSuccessfulCreationResponse();
        } catch (JobRequestPersistException $ex) {
            $this->logger->error("[JobRequestController][JobRequestPersistException] {$ex->getMessage()}");

            return $this->buildGeneralErrorResponse("Could not create job request. ({$ex->getMessage()})");
        } catch (\Exception $ex) {
            $exceptionClass = get_class($ex);
            $this->logger->error("[JobRequestController][$exceptionClass] {$ex->getMessage()}\n{$ex->getTraceAsString()}");

            return $this->buildGeneralErrorResponse("Unexpected server error ({$ex->getMessage()})");
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

    private function buildValidationErrorResponse(array $jobRequestCreationErrors)
    {
        $responseDTO = new ResponseDTO(ResponseDTO::STATUS_ERROR, "Job request invalid. One or more fields are invalid.");

        foreach ($jobRequestCreationErrors as $field => $error) {
            $responseDTO->addField(new ValidationFieldDTO($field, $error));
        }

        return $this->json($responseDTO, self::HTTP_STATUS_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param string $errorMessage
     *
     * @return JsonResponse
     */
    private function buildGeneralErrorResponse(string $errorMessage): JsonResponse
    {
        return $this->json(new ResponseDTO(ResponseDTO::STATUS_ERROR, $errorMessage), self::HTTP_STATUS_GENERAL_SERVER_ERROR);
    }
}
