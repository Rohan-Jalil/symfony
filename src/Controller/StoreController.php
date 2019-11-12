<?php


namespace App\Controller;

use App\Entity\Store;
use App\Form\StoreFormType;
use App\Services\StoreManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StoreController
 * @package App\Controller
 */
class StoreController extends AbstractController
{
    /**
     * @var StoreManager
     */
    private $storeManager;

    /**
     * StoreController constructor.
     * @param StoreManager $storeManager
     */
    public function __construct(StoreManager $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @Route(path="/", name="show_store_list")
     */
    public function storeList()
    {
        $stores = $this->storeManager->getAllStores();
        return $this->render('store/index.html.twig', ['stores' => $stores]);
    }

    /**
     * @Route(path="store/{id}", name="create_update_store", defaults={"id" = null}, methods={"GET", "POST"})
     * @ParamConverter(name="id", isOptional=true, class="App\Entity\Store", options={
     *     "id" = "store_id"
     * })
     */
    public function createOrUpdateStore(Request $request, ?Store $store)
    {
        $errors = null;
        $store = $store ? $store : new Store();
        $form = $this->createForm(StoreFormType::class,
            null,
            [
                'action' => $this->generateUrl('create_update_store', [
                    'id' => $store->getId()
                ]),
                'method' => 'POST',
                'store' => $store
            ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $this->storeManager->createOrUpdateStore($form, $store);
                return $this->redirectToRoute('show_store_list');
            } catch (ORMException $e) {
                $errors = $e->getMessage();
            }
        }
        return $this->render('store/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
