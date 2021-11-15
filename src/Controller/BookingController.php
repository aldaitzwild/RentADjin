<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\BookingManager;

class BookingController extends AbstractController
{

    private BookingManager $bookingManager;

    public function __construct()
    {
        parent::__construct();
        $this->bookingManager = new BookingManager();
    }
}
