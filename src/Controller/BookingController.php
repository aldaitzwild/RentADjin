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

    public function add(int $geniePageId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /genie?=' . $geniePageId);
            return;
        }

        $booking = array_map('trim', $_POST);
        $booking = array_map('htmlentities', $booking);
        $errors = $this->testInput($booking);

        if (!empty($errors['input'])) {
            $_SESSION['errorsBooking'] = $errors;
            header('Location: /genie?=' . $geniePageId);
            return;
        }

        if (!$this->isAvailable(intval($booking["genieId"]), $booking["checkin"], $booking["checkout"])) {
            $_SESSION['errorsBooking']["notAvailable"] = "Créneau indisponible";
            return;
        }

        $this->bookingManager->insert($booking);

        header('Location: /genie?=' . $geniePageId);
    }

    public function isAvailable(int $id, string $checkin, string $checkout): bool
    {
        return ($this->bookingManager->overlaps($id, $checkin, $checkout) <= 0);
    }
}
