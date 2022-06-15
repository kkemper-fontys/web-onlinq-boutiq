<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MollieController extends AbstractController
{
    #[Route('/mollie', name: 'mollie')]
    public function index(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);
        $amount = $content['amount'];
        $orderId = $content['orderId'];
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey("test_S5z3UfBptxzBNmSteP22B85FEU54Ps");
        dump($content);
        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $amount
            ],
            "description" => "Bestelling bij OurTaste met bestelnr " . $orderId,

            "redirectUrl" => "http://localhost:3000/failed",
            "webhookUrl" => "https://test/orderStatus/" . $orderId,
        ]);

        // STORE THIS ID WITH THE ORDER
        $paymentId = $payment->id;

        $paymentUrl = $payment->getCheckoutUrl();

        $response = new JsonResponse();
        $response->setData([
            'url' => $paymentUrl,
        ]);

        return $response;

    }

    #[Route('/orderStatus/{order}', name: 'orderStatus')]
    public function changeOrderStatus(Request $request, Order $order, MailerInterface $mailer)
    {
        $response = new Response();

        // CREATE EMAIL
        $email = (new Email())
            ->from('test@test.nl')
            ->to('kees@onlinq.nl')
            ->subject('Bedankt voor je bestelling met bestelnummer ' . $order->getId())
            ->text('Je order is verwerkt en we gaan voor je aan de slag!')
            ->html('<p>Je order is verwerkt en we gaan voor je aan de slag!</p>');

        // CREATE MOLLIE CLIENT
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey("test_S5z3UfBptxzBNmSteP22B85FEU54Ps");

        // GET POST DATA
        $postData = $request->get('id');

        // GET PAYMENT DATA
        $payment = $mollie->payments->get($postData);


        if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
            $order->setPaymentStatus("paid");
        } elseif ($payment->isOpen()) {
            $order->setPaymentStatus("open");
        } elseif ($payment->isPending()) {
            $order->setPaymentStatus("pending");
        } elseif ($payment->isFailed()) {
            $order->setPaymentStatus("failed");
        } elseif ($payment->isExpired()) {
            $order->setPaymentStatus("expired");
        } elseif ($payment->isCanceled()) {
            $order->setPaymentStatus("canceled");
        } elseif ($payment->hasRefunds()) {
            $order->setPaymentStatus("refunded");
        } elseif ($payment->hasChargebacks()) {
            $order->setPaymentStatus("chargedback");
        }

        $mailer->send($email);
        $response->setContent('No webhook used');

        return $response;
    }
}
