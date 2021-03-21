<?php

require_once __DIR__ . '/vendor/autoload.php';

$b = ['Authorization' => 'Bearer YOURTOKENHERE'];
try {
    \Ratchet\Client\connect('wss://glimesh.tv/api/socket', [], $b)->then(
        function($conn) {
            $conn->on('message', function($msg) {
                echo "Received: {$msg}\n";
            });

            // https://glimesh.github.io/api-docs/docs/chat/websockets/

            $conn->send('["1","1","__absinthe__:control","phx_join",{}]');
            $conn->send('["1","1","__absinthe__:control","doc",{"query":"subscription{ chatMessage(channelId: 6) { user { username avatar } message } }","variables":{} ]');
        }, function (\Throwable $e) {
            echo "Could not connect: {$e->getMessage()}\n";
        }
    );
} catch (\Throwable $th) {
    var_dump($th);
}
