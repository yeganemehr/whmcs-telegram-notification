<?php

namespace WHMCS\Module\Notification\Telegram;

use WHMCS\Module\Notification\DescriptionTrait;
use WHMCS\Module\Contracts\NotificationModuleInterface;
use WHMCS\Notification\Contracts\NotificationInterface;

class Telegram implements NotificationModuleInterface
{
    use DescriptionTrait;

    protected $client;

    public function __construct()
    {
        $this->setDisplayName('Telegram')
            ->setLogoFileName('logo.png');
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.telegram.org/',
            'timeout' => 10
        ]);
    }

    public function settings()
    {
        return [
            'botToken' => [
                'FriendlyName' => 'Telegram Bot API Token',
                'Type' => 'text',
                'Description' => 'You can create token at <a target="_blank" href="https://t.me/BotFather">BotFather</a>',
            ],
        ];
    }

    public function testConnection($settings)
    {
        // Check to ensure bot token were provided and valid
        if (empty($settings['botToken']) || strpos($settings['botToken'], ':') === false) {
            throw new \Exception('Token is empty or invalid, please check and try again.');
        }
        
        $response = $this->client->get("/bot{$settings['botToken']}/getMe");
        if ($response->getStatusCode() !== 200) {
            throw new \Exception((string)$response->getBody());
        }
        // Return an exception if the connection fails.
    }

    public function notificationSettings()
    {
        return [
            'chatID' => [
                'FriendlyName' => 'Telegram Chat ID',
                'Type' => 'text',
                'Description' => 'You can get it from @GetIDsBot or @RawDataBot',
                'Required' => true,
            ],
            'topicGroup' => [
                'FriendlyName' => 'TopicID',
                'Type' => 'text',
                'Description' => 'Topic of the Group.',
                'Placeholder' => ' ',
            ],
        ];
    }

    public function getDynamicField($fieldName, $settings)
    {
        return [];
    }


    public function sendNotification(NotificationInterface $notification, $moduleSettings, $notificationSettings)
    {
        if (!$moduleSettings['botToken']) {
            // Abort the Notification.
            throw new \Exception('No bot token for notification delivery.');
        }
        if (!$notificationSettings['chatID']) {
            throw new \Exception('No chat ID for notification delivery.');
        }

        $data = [
            'chat_id' => $notificationSettings['chatID'],
            'text' => "<b>{$notification->getTitle()}</b>\n\n{$notification->getMessage()}\n\n{$notification->getUrl()}",
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ];
        if (isset($notificationSettings['topicGroup']) and $notificationSettings['topicGroup']) {
            $data['message_thread_id'] = $notificationSettings['topicGroup'];
        }

        $response = $this->client->post("/bot{$moduleSettings['botToken']}/sendMessage", [
            'http_errors' => false,
            'form_params' => $data,
        ]);

        if ($response->getStatusCode() !== 200) {
            // The API returned an error. Perform an action and abort the Notification.
            throw new \Exception((string)$response->getBody());
        }
    }
}
