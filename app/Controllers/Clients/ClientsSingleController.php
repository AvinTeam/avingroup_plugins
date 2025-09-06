<?php
namespace AvinGroup\App\Controllers\Clients;

use AvinGroup\App\Controllers\Controller;
use AvinGroup\App\Services\Clients\ClientsSingleService;
use Exception;

(defined('ABSPATH')) || exit;

class ClientsSingleController extends Controller
{

    protected $clientsSingleService;

    public function __construct()
    {

        $this->clientsSingleService = new ClientsSingleService;

    }

    public function index($request)
    {

        try {

            wp_send_json_success($this->clientsSingleService->index($request), 200);

        } catch (Exception $e) {

            wp_send_json_error([
                'massage' => $e->getMessage(),
             ], 400);

        }

    }

}
