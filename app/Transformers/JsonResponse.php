<?php

namespace App\Transformers;

use \Illuminate\Support\Arr;
use \Illuminate\Support\Str;
use App\Helpers\Translation;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse as LaravelJsonResponse;
use InvalidArgumentException;
use JsonSerializable;

final class JsonResponse
{
    private $data;

    private $originalData;

    private $message;

    private $headers;

    private $statusCode;

    private $useDataWrapper = true;

    public $responseData = [];

    private static $defaultResponseMessage = 'Request was received';

    /**
     * Constructor
     *
     * @param int $statusCode
     * @param string|null $message
     * @param \Illuminate\Contracts\Support\Arrayable|array|null $data
     * @param array $headers
     *
     * @return void
     */
    public function __construct(int $statusCode, string $message = null, $data = null, array $headers = [])
    {
        $this->setStatusCode($statusCode);

        $this->message = (string) $message;
        $this->headers = $headers;

        $this->originalData = $data;
        $this->data = $this->normalizeToArray($data);
    }

    private function setStatusCode(int $statusCode): void
    {
        if (!in_array($statusCode, array_keys(LaravelJsonResponse::$statusTexts))) {
            throw new InvalidArgumentException("Invalid HTTP status code used: {$statusCode}");
        }

        $this->statusCode = $statusCode;
    }

    /**
     * Create a HTTP Json Response with the provided data
     *
     * @param int $statusCode
     * @param string|null $message
     * @param \Illuminate\Contracts\Support\Arrayable|array $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function create(int $statusCode, string $message = null, $data = [], array $headers = []): LaravelJsonResponse
    {
        $response = new self($statusCode, $message, $data, $headers);

        return $response->compose();
    }

    /**
     * Create a HTTP Json Response from another HTTP Json Response changing its format
     *
     * @param \Illuminate\Http\JsonResponse $response
     * @param string|null $message
     * @param bool $wrap
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function createFromResponse(LaravelJsonResponse $response, string $message = null, bool $wrap = false): LaravelJsonResponse
    {
        $data = $response->getData(true);

        $responseData = is_array($data) ? $data : ['message_data' => $data];

        $headers = $response->headers->all();
        $message = (string) ($message ?: Arr::pull($responseData, 'message', ''));

        $response = new self($response->status(), $message, $responseData, $headers);

        if (!$wrap) {
            $response->ignoreDataWrapper();
        }

        return $response->compose();
    }

    public function compose(): LaravelJsonResponse
    {
        $data = $this->prepareResponseData();

        return new LaravelJsonResponse($data, $this->statusCode, $this->headers);
    }

    private function prepareResponseData(): ?array
    {
        if (in_array($this->statusCode, self::statusCodesWithNoResponseData())) {
            return null;
        }

        $isSuccessful = ($this->statusCode >= 100 && $this->statusCode < 400);

        $this->responseData = [
            'status' =>  $isSuccessful ? 'success' : 'error',
            'message' => $this->message ?: self::$defaultResponseMessage,
        ];

        $isSuccessful ? $this->setUpSuccessData() : $this->setUpErrorData();

        if ($this->useDataWrapper) {
            $data = (is_null($this->originalData) || (!$isSuccessful && empty($this->data))) ? null : $this->data;
            $this->responseData[$this->getDataWrapper()] = $data;
        } else {
            $this->responseData = $this->responseData + $this->data;
        }

        return array_filter($this->responseData, function ($value) {
            return !is_null($value);
        });
    }

    private function setUpSuccessData(): void
    {
        $dataEmptyWithoutTranslationAttributes =
            array_key_exists('message_attributes', $this->data) && count($this->data) === 1;

        // Search for "message_attributes" key in $this->data array and pull it
        // Use "success" translation file to translate messages
        $messageData = $this->getTranslationDataInDataAttributeAndFile('message_attributes', 'success');

        $this->responseData['message'] = $messageData['message'];
        $this->data = !$dataEmptyWithoutTranslationAttributes ? $this->data : null;
    }

    private function setUpErrorData(): void
    {
        $oldMessage = $this->message;

        // Search for "error_attributes" key in $this->data array and pull it
        // Use "errors" translation file to translate messages
        $messageData = $this->getTranslationDataInDataAttributeAndFile('error_attributes', 'errors');
        $this->responseData['message'] = $messageData['message'];

        // Add to response if "error_code" is found in the data array or in the message itself
        if (Arr::has($this->data, 'error_code')) {
            $this->responseData['error_code'] = (string) Arr::pull($this->data, 'error_code');
        } elseif ($messageData['key'] && Str::contains($oldMessage, 'error_code.')) {
            $this->responseData['error_code'] = $messageData['key'];
        }
    }

    private function getTranslationDataInDataAttributeAndFile(
        string $data_attribute_name,
        string $translation_key_prefix
    ): array {
        $translation_params = Translation::parseStringToTranslationParameters($this->message);

        $attributes = array_merge(
            $translation_params['attributes'],
            Arr::pull($this->data, $data_attribute_name, [])
        );

        return Translation::translateMessageToArray(
            $translation_params['name'],
            $attributes,
            $translation_key_prefix
        );
    }

    private function getDataWrapper(): ?string
    {
        if (!$this->useDataWrapper) {
            return null;
        }

        return collect(self::dataWrappers())
            ->first(function ($value, $key) {
                return Str::is(str_replace('x', '*', $key), $this->statusCode);
            });
    }

    private function normalizeToArray($data): array
    {
        if (is_array($data)) {
            return $data;
        } elseif ($data instanceof JsonSerializable) {
            return $data->jsonSerialize();
        } elseif ($data instanceof Arrayable) {
            return $data->toArray();
        }

        return (array) $data;
    }

    public function ignoreDataWrapper(): void
    {
        $this->useDataWrapper = false;
    }

    private static function dataWrappers(): array
    {
        return [
            '1xx' => 'information',
            '2xx' => 'data',
            '3xx' => 'redirect_data',
            '422' => 'errors',
            '4xx' => 'error',
            '5xx' => 'error',
        ];
    }

    private static function statusCodesWithNoResponseData()
    {
        return [
            LaravelJsonResponse::HTTP_NO_CONTENT,
        ];
    }
}
