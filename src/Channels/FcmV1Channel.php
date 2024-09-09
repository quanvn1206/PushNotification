<?php

namespace Edujugon\PushNotification\Channels;

use Edujugon\PushNotification\Messages\PushMessage;

class FcmV1Channel extends GcmChannel
{
    /**
     * {@inheritdoc}
     */
    protected function pushServiceName()
    {
        return 'fcmv1';
    }
    protected function buildData(PushMessage $message)
    {
        $data = [];
        if ($message->title != null || $message->body != null || $message->click_action != null) {
            $data = [
                'notification' => [
                    'title' => $message->title,
                    'body' => $message->body,
//                    'sound' => $message->sound,
//                    'color' => $message->color,
//                    'click_action' => $message->click_action,
                ],
//                'android'=>[]
            ];

            // Set custom badge number when isset in PushMessage
            if (! empty($message->badge)) {
                $data['notification']['badge'] = $message->badge;
            }

            // Set icon when isset in PushMessage
            if (! empty($message->icon)) {
                $data['notification']['icon'] = $message->icon;
            }
            if (! empty($message->click_action)) {
                $data['android']= [
                        "notification"=> [
                        "click_action"=> $message->click_action
                    ]
                ];
            }
        }

        if (! empty($message->extra)) {
            $data['data'] = $message->extra;
        }

        return $data;
    }
}
