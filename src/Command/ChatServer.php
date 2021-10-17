<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ratchet\Session\SessionProvider;
use Symfony\Component\HttpFoundation\Session\Storage\Handler;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Component\Chat;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

class ChatServer extends Command
{
    protected static $defaultName = 'app:chat-server';

    public function __construct(PdoSessionHandler $sessionHandler)
    {
        parent::__construct();
        $this->sessionHandler = $sessionHandler;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int 
    {
        $server = IoServer::factory(
            new HttpServer(
                new SessionProvider(
                    new WsServer(
                        new Chat()
                    ),
                    $this->sessionHandler
                )
            ),
            8080
        );

        $output->writeln('Server is running');
        $server->run();

    }
}





