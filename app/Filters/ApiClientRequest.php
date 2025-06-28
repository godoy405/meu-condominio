<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class ApiClientRequest implements FilterInterface
{
    /**
   
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $apiKey = $request->getHeaderLine('X-API-KEY');

        if (empty($apiKey)) {
            return Services::response()->setJSON([
                'success' => false,
                'message' => 'API key is missing.',
            ])->setStatusCode(401);
        }

        $result = $this->apiKeyIsValid($apiKey);

        if (! $result) {
            return Services::response()->setJSON([
                'success' => false,
                'message' => 'Invalid or inactive API key.',
            ])->setStatusCode(401);
        }

        // Tudo certo, a chave de API é válida
    }

    private function apiKeyIsValid(string $apiKey): bool
    {
        //! aqui podemos ir buscar a chave de api de clientis autorizados no banco de dados
        //! Não farei isso porque a eesa altura não é o objetivo do curso       
        return $apiKey === 'api-key-123';
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
