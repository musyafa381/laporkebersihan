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

            // Allow Auditor to submit CS reports & request OTP (Lapor Kendala Kebersihan)
            $isCsReportSubmission = (strpos($uri, 'cs/public/store') !== false || strpos($uri, 'cs/public/send-otp') !== false);
            if ($isCsReportSubmission) {
                return; // Allowed for Auditor!
            }

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

        // Restrict Petugas Logistik role to only allowed modules: Beranda, Alat, CS (Pengajuan Alat), and Profil
        if (in_array($userRole, ['Petugas Logistik', 'Admin Logistik', 'Logistik'])) {
            $uri = trim((string)$request->getUri()->getPath(), '/');
            $disallowedPrefixes = ['keuangan', 'buku', 'wilayah', 'program-kerja', 'pengaturan', 'struktur', 'sop', 'unit', 'app'];
            $isDisallowed = false;

            foreach ($disallowedPrefixes as $prefix) {
                if ($uri === $prefix || strpos($uri, $prefix . '/') === 0) {
                    $isDisallowed = true;
                    break;
                }
            }

            if ($isDisallowed) {
                if ($request->isAJAX() || $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                    $response = service('response');
                    return $response->setJSON([
                        'status'  => 'error',
                        'message' => 'Akses ditolak: Akun Petugas Logistik hanya memiliki izin pada menu Beranda, Data Alat Kebersihan, Pengajuan Alat (CS), dan Profil.',
                    ])->setStatusCode(403);
                }

                $session->setFlashdata('msg_error', 'Akses ditolak: Akun Petugas Logistik khusus bertugas mengelola Data Alat Kebersihan & Pengajuan Logistik.');
                return redirect()->to(base_url('alat'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No after-filter needed
    }
}
