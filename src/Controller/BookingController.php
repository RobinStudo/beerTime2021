<?php

namespace App\Controller;

use App\Entity\Booking;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/booking', name: 'booking_')]
class BookingController extends AbstractController
{
    #[Route('/{reference}/confirmation', name: 'confirmation')]
    public function confirmation(Booking $booking): Response
    {
        return $this->render('booking/confirmation.html.twig', [
            'booking' => $booking,
        ]);
    }
}
