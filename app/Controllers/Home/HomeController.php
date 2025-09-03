<?php
namespace AvinGroup\App\Controllers\Home;

use AvinGroup\App\Controllers\Controller;
use AvinGroup\App\Services\Home\HomeService;
use Exception;

(defined('ABSPATH')) || exit;

class HomeController extends Controller
{

    protected $homeService;

    public function __construct()
    {

        $this->homeService = new HomeService;

    }

    public function index()
    {

        try {

            wp_send_json_success([
                'partners' => $this->homeService->partners(),
             ]);

        } catch (Exception $e) {

            wp_send_json_error([
                'massage' => $e->getMessage(),
             ], 400);

        }

    }

}
