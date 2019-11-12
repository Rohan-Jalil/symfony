<?php


namespace App\Services;


use App\Entity\Branch;
use App\Entity\Store;
use App\Repository\StoreBranchRepository;
use App\Repository\StoreRepository;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\Query\GeocodeQuery;
use Geocoder\StatefulGeocoder;
use Http\Adapter\Guzzle6\Client;
use Symfony\Component\Form\FormInterface;

/**
 * Class StoreManager
 * @package App\Services
 */
class StoreManager
{
    /**
     * @var StoreRepository
     */
    private $storeRepository;
    /**
     * @var StoreBranchRepository
     */
    private $branchRepository;

    /**
     * StoreManager constructor.
     * @param StoreRepository $storeRepository
     * @param StoreBranchRepository $branchRepository
     */
    public function __construct(StoreRepository $storeRepository, StoreBranchRepository $branchRepository)
    {
        $this->storeRepository = $storeRepository;
        $this->branchRepository = $branchRepository;
    }

    /**
     * @param FormInterface $form
     * @param Store $store
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createOrUpdateStore(FormInterface $form, Store $store)
    {
        $store->setStoreName($form->getData()['storeName']);
        if (!$store->getId()) {
            $store->setCreatedAt(new \DateTime());
        }
        $store->setUpdatedAt(new \DateTime());

        $this->storeRepository->save($store);
    }

    /**
     * @param FormInterface $form
     * @param Branch $storeBranch
     * @param $latitude
     * @param $longitude
     * @throws \Exception
     */
    public function createOrUpdateStoreBranch(FormInterface $form, Branch $storeBranch, $latitude, $longitude)
    {
        $formData = $form->getData();
        $storeBranch->setStore($formData['store']);
        $storeBranch->setName($formData['name']);
        $storeBranch->setStreet($formData['street']);
        $storeBranch->setCounty($formData['county']);
        $storeBranch->setState($formData['state']);
        $storeBranch->setZipcode((int)$formData['zipcode']);
        $storeBranch->setLongitude((float)$longitude);
        $storeBranch->setLatitude((float)$latitude);
        $storeBranch->setNumberOfEmployees($formData['numberOfEmployees']);
        if (!$storeBranch->getId()) {
            $storeBranch->setCreatedAt(new \DateTime());
        }
        $storeBranch->setUpdatedAt(new \DateTime());

        $this->branchRepository->save($storeBranch);
    }

    /**
     * @return array
     */
    public function getAllStores()
    {
        return $this->storeRepository->findAll();
    }

    /**
     * @param Branch $storeBranch
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteStoreBranch(Branch $storeBranch)
    {
        return $this->branchRepository->delete($storeBranch);
    }

    /**
     * @param $locations
     * @return array
     */
    public function getAverageEmployees($locations)
    {
        $branches = $this->branchRepository->getBranches($locations);
        $avg = 0;
        if ($locations && !$branches) {
            return ['avg' => $avg, 'message' => 'No branch found within this location'];
        }
        $branches = $branches ? $branches : $this->branchRepository->findAll();
        $totalEmployee = 0;
        array_walk($branches, function ($branch) use (&$totalEmployee, $locations){
            $totalEmployee += $branch->getNumberOfEmployees();
            $locations[] = $branch->getId();
        });

        $avg = $totalEmployee / count($branches);
        return [
            'avg' => $avg,
            'message' => "Average Count of Employee within all " . ($locations ? "locations " . json_encode($locations) : "") . " branches are: {$avg}"
        ];
    }
}
