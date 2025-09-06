<?php
namespace AvinGroup\App\Controllers\Partners;

use AvinGroup\App\Controllers\Controller;
use AvinGroup\App\Services\Partners\PartnersSingleService;
use Exception;

(defined('ABSPATH')) || exit;

class PartnersSingleController extends Controller
{

    protected $service;

    public function __construct()
    {
        $this->service = new PartnersSingleService;
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
