<?php
namespace App\Service;

use Stripe\StripeClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PaymentService{
    private $config;
    private $client;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->config = $parameterBag->get('payment');
        $this->client = new StripeClient($this->config['privateKey']);
    }

    public function createPaymentIntent(float $amount)
    {
        return $this->client->paymentIntents->create([
            'amount' => $amount * 100,
            'currency' => $this->config['currency'],
        ]);
    }

    public function checkPaymentIntent($id): bool
    {
        $paymentIntent = $this->client->paymentIntents->retrieve($id);

        if($paymentIntent->status === 'succeeded'){
            return true;
        }

        return false;
    }

    public function getPublicKey(): string
    {
        return $this->config['publicKey'];
    }
}