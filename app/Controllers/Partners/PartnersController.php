<?php
namespace AvinGroup\App\Controllers\Partners;

use AvinGroup\App\Controllers\Controller;
use AvinGroup\App\Services\Partners\PartnersService;
use Exception;

(defined('ABSPATH')) || exit;

class PartnersController extends Controller
{

    protected $service;

    public function __construct()
    {
        $this->service = new PartnersService;
    }

    public function single($request)
    {

        try {

            wp_send_json_success($this->service->single($request), 200);

        } catch (Exception $e) {

            wp_send_json_error([
                'massage' => $e->getMessage(),
             ], 400);

        }

    }

}
