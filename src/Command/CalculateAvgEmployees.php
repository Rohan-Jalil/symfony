<?php


namespace App\Command;


use App\Services\StoreManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CalculateAvgEmployees
 * @package App\Command
 */
class CalculateAvgEmployees extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = "calculate:avg-employees";
    /**
     * @var StoreManager
     */
    private $storeManager;

    /**
     * CalculateAvgEmployees constructor.
     * @param StoreManager $storeManager
     * @param string|null $name
     */
    public function __construct(StoreManager $storeManager, string $name = null)
    {
        parent::__construct($name);
        $this->storeManager = $storeManager;
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('This command calculates average number of employees in a store-branch within the given location')
            ->setHelp('arguments: comma separated location ids');

        $this->addArgument('location_ids', InputArgument::OPTIONAL, 'location ids');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $locations = $input->getArgument('location_ids') ? explode(',', $input->getArgument('location_ids')) : [];
        $avgCountOfEmployees = $this->storeManager->getAverageEmployees($locations);

        $output->writeln($avgCountOfEmployees['message']);
    }
}