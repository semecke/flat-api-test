<?php


namespace App\EventListener;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionListener
{
    private $serializer;

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();

        $response_body = $this->serializer->serialize([
            'success' => false,
            'message' => $exception->getMessage(),
            'data' => $exception->data ?? []
        ], 'json', [
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
        ]);

        // Customize your response object to display the exception details
        $response = new JsonResponse();
        $response->setJson($response_body);

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
//            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}