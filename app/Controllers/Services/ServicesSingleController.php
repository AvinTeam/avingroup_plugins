<?php
namespace AvinGroup\App\Controllers\Services;

use AvinGroup\App\Controllers\Controller;
use AvinGroup\App\Services\Services\ServicesSingleService;
use Exception;

(defined('ABSPATH')) || exit;

class ServicesSingleController extends Controller
{

    protected $service;

    public function __construct()
    {
        $this->service = new ServicesSingleService;
    }

    public function index($request)
    {

        try {

            wp_send_json_success($this->service->index($request), 200);

        } catch (Exception $e) {

            wp_send_json_error([
                'massage' => $e->getMessage(),
             ], 400);

        }

    }

}
