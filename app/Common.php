<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */
if (!function_exists('image_url')) {
    /**
     * Mengembalikan URL gambar lengkap, mendukung Cloudinary remote URL maupun path lokal.
     *
     * @param string|null $path File name, relative path, atau full remote URL
     * @param string $defaultFolder Default folder fallback jika berupa relative filename (misal: 'uploads', 'uploads/proker', 'uploads/cs')
     * @return string
     */
    function image_url(?string $path, string $defaultFolder = 'uploads'): string
    {
        if (empty($path)) {
            return '';
        }
        $trimmed = trim($path);
        if (str_starts_with($trimmed, 'http://') || str_starts_with($trimmed, 'https://')) {
            return $trimmed;
        }
        if (str_starts_with($trimmed, 'uploads/')) {
            return base_url($trimmed);
        }
        $folder = trim($defaultFolder, '/');
        return base_url(($folder ? ($folder . '/') : '') . ltrim($trimmed, '/'));
    }
}

if (!function_exists('has_valid_image')) {
    /**
     * Memeriksa apakah gambar ada (baik di Cloudinary / remote URL atau di storage lokal).
     *
     * @param string|null $path
     * @return bool
     */
    function has_valid_image(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }
        $trimmed = trim($path);
        if (str_starts_with($trimmed, 'http://') || str_starts_with($trimmed, 'https://')) {
            return true;
        }
        return file_exists(FCPATH . ltrim($trimmed, '/')) || file_exists(FCPATH . 'uploads/' . ltrim($trimmed, '/'));
    }
}
