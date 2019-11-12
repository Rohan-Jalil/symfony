<?php


namespace App\Controller;


use App\Entity\Branch;
use App\Entity\Store;
use App\Form\StoreBranchFormType;
use App\Services\StoreManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BranchController
 * @package App\Controller
 */
class BranchController extends AbstractController
{
    /**
     * @var StoreManager
     */
    private $storeManager;

    /**
     * BranchController constructor.
     * @param StoreManager $storeManager
     */
    public function __construct(StoreManager $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @Route(path="store/{id}/branches", name="show_store_branch_list", methods={"GET"})
     */
    public function showStoreBranchList(Request $request, $id)
    {
        $stores = $this->storeManager->getAllStores();
        return $this->render('store/index.html.twig', ['stores' => $stores]);
    }

    /**
     * @Route(path="store/{store_id}/branch/{branch_id}", name="show_store_branch", methods={"GET"})
     * @ParamConverter(name="store", class="App\Entity\Store", options={"id"="store_id"})
     * @ParamConverter(name="branch", class="App\Entity\Branch", options={"id"="branch_id"})
     * @param Store $store
     * @param Branch $branch
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showStoreBranch(Store $store, Branch $branch)
    {
        return $this->render('store_branch/branch.html.twig', [
            'store' => $store,
            'branch' => $branch
        ]);
    }

    /**
     * @Route(path="store-branch/{id}", name="create_update_store_branch", defaults={"id" = null}, methods={"GET", "POST"})
     * @ParamConverter(name="id", isOptional=true, class="App\Entity\Branch", options={
     *     "id" = "id"
     * })
     */
    public function createOrUpdateStoreBranch(Request $request, ?Branch $storeBranch)
    {
        $storeBranch = $storeBranch ? $storeBranch : new Branch();
        $errors = null;
        $form = $this->createForm(StoreBranchFormType::class,
            null,
            [
                'action' => $this->generateUrl('create_update_store_branch', [
                    'id' => $storeBranch->getId()
                ]),
                'method' => 'POST',
                'storeBranch' => $storeBranch
            ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $latitude = $request->get('latitude');
                $longitude = $request->get('longitude');
                $this->storeManager->createOrUpdateStoreBranch($form, $storeBranch, $latitude, $longitude);
                return $this->redirectToRoute('show_store_list');
            } catch (\Exception $e) {
                $errors = $e->getMessage();
            }
        }
        return $this->render('store_branch/form.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    /**
     * @Route(path="store-branch/delete/{id}", name="delete_store_branch", methods={"DELETE"})
     * @ParamConverter(name="id", class="App\Entity\Branch", options={
     *     "id" = "id"
     * })
     * @param Request $request
     * @param Branch|null $storeBranch
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteBranch(Request $request, Branch $storeBranch)
    {
        $this->storeManager->deleteStoreBranch($storeBranch);
        return $this->json(['status' => 'success']);
    }
}