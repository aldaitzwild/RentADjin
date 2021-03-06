<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\BookingManager;
use DateTime;

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
        $booking['genieId'] = $geniePageId;

        $errors = $this->testInput($booking);

        if (!empty($errors['input'])) {
            $_SESSION['errorsBooking'] = $errors;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return;
        }

        $checkin = new DateTime($booking['checkin']);
        $booking['checkin'] = date_format($checkin, 'Y-m-d');

        $checkout = new DateTime($booking['checkout']);
        $booking['checkout'] = date_format($checkout, 'Y-m-d');

        if ($booking['checkin'] > $booking['checkout']) {
            $_SESSION['errorsBooking']["invalid"] = "La date de fin ne peut être antérieur à la date de début";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return;
        }

        if (!$this->isAvailable($booking["genieId"], $booking["checkin"], $booking["checkout"])) {
            $_SESSION['errorsBooking']["notAvailable"] = "Créneau indisponible";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return;
        }

        $this->bookingManager->insert($booking);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function isAvailable(int $id, string $checkin, string $checkout): bool
    {
        return ($this->bookingManager->overlaps($id, $checkin, $checkout) === 0);
    }
}
