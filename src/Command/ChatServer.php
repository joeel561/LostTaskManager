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
use Doctrine\ORM\EntityManagerInterface;
use App\Component\Chat;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

class ChatServer extends Command
{
    protected static $defaultName = 'app:chat-server';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(PdoSessionHandler $sessionHandler, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->sessionHandler = $sessionHandler;
        $this->entityManager = $entityManager;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int 
    {
        $server = IoServer::factory(
            new HttpServer(
                new SessionProvider(
                    new WsServer(
                        new Chat($this->entityManager)
                    ),
                    $this->sessionHandler
                )
            ),
            5050
        );

        $output->writeln('Server is running');
        $server->run();

    }
}





