<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuditorReadonlyFilter implements FilterInterface
{
    /**
     * Do not allow Auditor to perform mutating actions (POST, PUT, DELETE, or /delete/ endpoints).
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session  = session();
        $userRole = $session->get('role');

        if ($userRole === 'Auditor') {
            $method = strtoupper($request->getMethod());
            $uri    = (string)$request->getUri()->getPath();

            // Check if the request is modifying data
            $isMutatingMethod = in_array($method, ['POST', 'PUT', 'DELETE', 'PATCH']);
            $isDeleteUri      = (strpos($uri, 'delete') !== false || strpos($uri, 'unlink') !== false);

            if ($isMutatingMethod || $isDeleteUri) {
                if ($request->isAJAX() || $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                    $response = service('response');
                    return $response->setJSON([
                        'status'  => 'error',
                        'message' => 'Akses ditolak: Akun Auditor hanya memiliki izin melihat data (Read-Only) dan tidak dapat melakukan perubahan atau penghapusan.',
                    ])->setStatusCode(403);
                }

                $session->setFlashdata('msg_error', 'Akses ditolak: Akun Auditor hanya memiliki izin melihat data (Read-Only) dan tidak dapat melakukan perubahan/penghapusan data.');
                return redirect()->back();
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No after-filter needed
    }
}
