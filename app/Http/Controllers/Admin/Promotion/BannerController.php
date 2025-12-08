<?php

namespace App\Http\Controllers\Admin\Promotion;

use App\Contracts\Repositories\BannerRepositoryInterface;
use App\Contracts\Repositories\BrandRepositoryInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\ShopRepositoryInterface;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\BannerAddRequest;
use App\Http\Requests\Admin\BannerUpdateRequest;
use App\Services\BannerService;
use App\Traits\FileManagerTrait;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BannerController extends BaseController
{
    use FileManagerTrait {
        delete as deleteFile;
        update as updateFile;
    }

    public function __construct(
        private readonly BannerRepositoryInterface        $bannerRepo,
        private readonly CategoryRepositoryInterface      $categoryRepo,
        private readonly ShopRepositoryInterface          $shopRepo,
        private readonly BrandRepositoryInterface         $brandRepo,
        private readonly ProductRepositoryInterface       $productRepo,
        private readonly BannerService       $bannerService,
    ) {}

    /**
     * @param Request|null $request
     * @param string|null $type
     * @return View Index function is the starting point of a controller
     * Index function is the starting point of a controller
     */
    public function index(Request|null $request, string $type = null): View
    {
        $bannerTypes = $this->bannerService->getBannerTypes();
        $banners = $this->bannerRepo->getListWhereIn(
            orderBy: ['id' => 'desc'],
            searchValue: $request['searchValue'],
            filters: ['theme' => theme_root_path()],
            whereInFilters: ['banner_type' => array_keys($bannerTypes)],
            dataLimit: getWebConfig(name: 'pagination_limit'),
        );

        $categories = $this->categoryRepo->getListWhere(filters: ['position' => 0], dataLimit: 'all');
        $shops = $this->shopRepo->getListWithScope(scope: 'active', dataLimit: 'all');
        $brands = $this->brandRepo->getListWhere(dataLimit: 'all');
        $products = $this->productRepo->getListWithScope(scope: 'active', dataLimit: 'all');
        return view('admin-views.banner.view',  compact('banners', 'categories', 'shops', 'brands', 'products', 'bannerTypes'));
    }

    public function add(BannerAddRequest $request): RedirectResponse
    {
        // Handle multiple images for Hero Slider
        if ($request['banner_type'] === 'Hero Slider' && $request->hasFile('images')) {
            $images = $request->file('images');
            $count = 0;
            $errors = [];
            
            foreach ($images as $key => $image) {
                try {
                    // Validate the file is valid
                    if (!$image->isValid()) {
                        $errors[] = translate('image') . ' ' . ($key + 1) . ' ' . translate('is_invalid');
                        continue;
                    }
                    
                    // Create data array manually for each image
                    $imageName = $this->upload(dir: 'banner/', format: 'webp', image: $image);
                    
                    if (empty($imageName)) {
                        $errors[] = translate('image') . ' ' . ($key + 1) . ' ' . translate('failed_to_upload');
                        continue;
                    }
                    
                    $data = [
                        'banner_type' => $request['banner_type'],
                        'resource_type' => $request['resource_type'] ?? null,
                        'resource_id' => $request[$request->resource_type . '_id'] ?? null,
                        'theme' => theme_root_path(),
                        'title' => $request['title'] ?? null,
                        'sub_title' => $request['sub_title'] ?? null,
                        'button_text' => $request['button_text'] ?? null,
                        'background_color' => $request['background_color'] ?? null,
                        'url' => $request['url'],
                        'photo' => $imageName,
                    ];
                    
                    $this->bannerRepo->add(data: $data);
                    $count++;
                } catch (\Exception $e) {
                    $errors[] = translate('image') . ' ' . ($key + 1) . ': ' . $e->getMessage();
                }
            }
            
            if ($count > 0) {
                $message = translate('banner_added_successfully') . ' (' . $count . ' ' . translate('images') . ')';
                if (!empty($errors)) {
                    $message .= '. ' . translate('some_images_failed') . ': ' . implode(', ', $errors);
                }
                ToastMagic::success($message);
            } else {
                ToastMagic::error(translate('failed_to_upload_images') . ': ' . implode(', ', $errors));
            }
        } else {
            $data = $this->bannerService->getProcessedData(request: $request);
            $this->bannerRepo->add(data: $data);
            ToastMagic::success(translate('banner_added_successfully'));
        }
        
        return redirect()->route('admin.banner.list');
    }

    public function getUpdateView($id): View
    {
        $bannerTypes = $this->bannerService->getBannerTypes();
        $banner = $this->bannerRepo->getFirstWhere(params: ['id' => $id]);
        $categories = $this->categoryRepo->getListWhere(filters: ['position' => 0], dataLimit: 'all');
        $shops = $this->shopRepo->getListWithScope(scope: 'active', dataLimit: 'all');
        $brands = $this->brandRepo->getListWhere(dataLimit: 'all');
        $products = $this->productRepo->getListWithScope(scope: 'active', dataLimit: 'all');
        return view('admin-views.banner.edit', compact('banner', 'categories', 'shops', 'brands', 'products', 'bannerTypes'));
    }

    public function update(BannerUpdateRequest $request, $id): RedirectResponse
    {
        $banner = $this->bannerRepo->getFirstWhere(params: ['id' => $id]);
        $data = $this->bannerService->getProcessedData(request: $request, image: $banner['photo']);
        $this->bannerRepo->update(id: $banner['id'], data: $data);
        ToastMagic::success(translate('banner_updated_successfully'));
        return redirect()->route('admin.banner.list');
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $status = $request->get('status', 0);
        $this->bannerRepo->update(id: $request['id'], data: ['published' => $status]);
        return response()->json([
            'message' => $status == 1 ? translate("banner_published_successfully") : translate("banner_unpublished_successfully"),
        ]);
    }

    public function delete(Request $request): JsonResponse
    {
        $banner = $this->bannerRepo->getFirstWhere(params: ['id' => $request['id']]);
        $this->deleteFile(filePath: '/banner/' . $banner['photo']);
        $this->bannerRepo->delete(params: ['id' => $request['id']]);
        return response()->json(['message' => translate('banner_deleted_successfully')]);
    }
}
