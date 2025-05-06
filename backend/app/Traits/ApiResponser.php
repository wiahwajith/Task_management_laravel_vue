<?php

namespace App\Traits;

use Log;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;

trait ApiResponser
{
    protected function successResponse($data, $message = '', $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    protected function errorResponse($message = 'An error occurred.', $status = 500, \Throwable $e = null)
    {
        if (app()->environment('local')) {
            Log::error($e);
        }

        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    public function handleAction(callable $callback, string $errorMessage = 'An error occurred')
    {
        try {
            return $callback();
        } catch (QueryException $e) {
            if ($this->isDuplicateEntryError($e)) {
                return $this->errorResponse('Email already exists.', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
    
            return $this->errorResponse($errorMessage, Response::HTTP_INTERNAL_SERVER_ERROR, $e);
        } catch (\Exception $e) {
            return $this->errorResponse($errorMessage, Response::HTTP_INTERNAL_SERVER_ERROR, $e);
        }
    }

    /**
     * Check if exception is a duplicate entry error.
     */
    protected function isDuplicateEntryError(QueryException $e): bool
    {
        return $e->getCode() === '23000' && str_contains($e->getMessage(), 'Duplicate entry');
    }
}
