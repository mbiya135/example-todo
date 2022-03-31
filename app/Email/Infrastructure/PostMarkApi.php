<?php

declare(strict_types=1);

namespace App\Email\Infrastructure;

use App\Models\Email;
use GuzzleHttp\Client;

final class PostMarkApi implements ProviderEmailApi
{


    public function __construct(
        private Client $httpClient
    ) {
    }

    public function sendEmail(Email $email): void
    {
        // TODO: Implement sendEmail() method.
    }

    /**
     * @param Email $email
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEmailStatus(Email $email): string
    {
        $response = $this->httpClient->get(
            'https://api.postmarkapp.com//messages/outbound/' . $email->messageId . '/details',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Postmark-Server-Token' => '',
                ],
            ]
        );
        $data = json_decode(
            $response->getBody()->getContents(),
            true
        );
        $events = array_filter(
            $data['MessageEvents'],
            fn (array $event) => $event['Type'] === 'Delivered'
        );

        return $events ? current($events)['ReceivedAt'] : '';
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllMessage(): array
    {
        // Todo add exception
        $responses = $this->httpClient->get(
            'https://api.postmarkapp.com//messages/outbound/00b86c43-adc4-4277-973e-7e698a38650f/details',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Postmark-Server-Token' => '',
                ],
                'query' => [
                    'count' => 50,
                    'offset' => 100,
                ],
            ]
        );
        $data = json_decode(
            $responses->getBody()->getContents(),
            true
        );
        Email::create(
            [
                'uuid' => $data['MessageID'],
                'messageId' => $data['MessageID'],
                'mailType' => 1,
                'modelName' => 'test',
                'modelId' => 1,
                'status' => 'sent',
                'from' => $data['From'],
                'from_name' => $data['From'],
                'to' => current($data['Recipients']),
                'cc' => '',
                'bcc' => '',
                'replyTo' => '',
                'body' => '',
                'subject' => '',
                'attachments' => '',
                'numberOfOpens' => 5,
                'firstOpened' => new \DateTimeImmutable(),
                'lastOpenedFrom' => new \DateTimeImmutable(),
                'lastError' => '',
                'TotalTries' => 0,
                'success' => 1,
                'deliveryInformation' => '',
                'sendOn' =>  new \DateTimeImmutable(),
                'deliveredAt' => null,
            ]
        );
        echo 'hererer';
        exit();
        return json_decode(
            $responses->getBody()->getContents(),
            true
        );
    }
}
