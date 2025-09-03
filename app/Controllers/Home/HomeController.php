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

            $this->success([
                'result' => $this->homeService->index(),
             ]);

            // $this->homeService->get_menu_by_location();

        } catch (Exception $e) {

            return $this->error([
                'massage' => $e->getMessage(),
             ]);

        }

    }

}
