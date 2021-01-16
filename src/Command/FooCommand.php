<?php

namespace App\Command;

use App\DataWarehouse\CategoryDataWarehouse;
use App\DataWarehouse\DataWarehouse;
use App\Entity\Subcategory;
use App\ViewModel\SearchViewModel\CategorySearchViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FooCommand extends Command
{
    private $dw;
private $em;
    public function __construct(string $name = null, CategoryDataWarehouse $dw, EntityManagerInterface $em)
    {
        $this->dw = $dw;
        $this->em = $em;
        parent::__construct($name);
    }

    protected static $defaultName = 'app:foo';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return Command::SUCCESS;
    }
}