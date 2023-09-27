<?php


// src/Command/CreateUserCommand.php
namespace App\Command;
use App\Entity\Challenge;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'insert-file')]
class InsertFileCommand extends Command
{
    protected static $defaultDescription = 'Insert file in database';

    public $file;
    public $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->file = "";
        $this->entityManager = $entityManager;

        parent::__construct();
    }
    

    public function createChallenge($data){
        $challenge = new Challenge();
        $challenge->setTitle($data[1]);
        $challenge->setCategory($data[2]);
        $challenge->setSubcategory($data[3]);
        $challenge->setDescription($data[5]);
        $challenge -> setPoints(rand(5,15));
        $challenge -> setCreatedAt(new \DateTimeImmutable());
        $challenge -> setDeadline(new \DateTimeImmutable());
        
        $this->entityManager->persist($challenge); // on effectue les mise à jours internes
        $this->entityManager->flush(); // on effectue la mise à jour vers la base de données
    }

    public function readFile(){
            // $challenges = $this -> getDoctrine()->getRepository(Challenge::class)->findAll();
            $lineCount = 0;
            if (($open = fopen("data/ecogestes.csv", "r")) !== false) {
                while (($data = fgetcsv($open, 1000, ",")) !== false) {
                    if ($lineCount >= 2) {
                        // $challenges[] = $data;
                        if(!empty($data[1])){
                           $this -> createChallenge($data);
                        }
                    }
                    
                    $lineCount++;
                }
            }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->readFile();
        return Command::SUCCESS;


    }
}

?>