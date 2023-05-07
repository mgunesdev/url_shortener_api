<?php

namespace App\Http\Controllers;

use App\Events\UrlVisitEvent;
use App\Models\Url;
use App\Services\UrlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;

class UrlController extends BaseController
{
    /**
     * @param  Request  $request
     * @param  string  $slug
     * @return RedirectResponse
     */
    public function __invoke(Request $request, string $slug): RedirectResponse
    {
        $urlObj = Url::where('slug', $slug)->firstOrFail();

        Event::dispatch(new UrlVisitEvent($urlObj, $request->ip()));

        return redirect($urlObj->link);
    }



    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $perPage = $request->perPage ?? 10;
        $urls = Url::where('user_id', $request->user()->id)->orderBy('created_at', 'DESC')->paginate($perPage);
        return $this->sendResponse($urls);
    }


    /**
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function detail(Request $request, $id): JsonResponse
    {
        $obj = Url::find($id);
        if (!$obj)
            return $this->sendError('Url not found');

        return $this->sendResponse($obj);
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'link' => 'required|string|unique:urls',
            'slug' => 'string|nullable|unique:urls'
        ]);

        if ($validator->fails())
            return $this->sendError('Validation Error.', (array)$validator->errors());

        try {
            $service = new UrlService(
                $request->user()->id, $request->name, $request->link, $request->slug
            );
            $urlObj = $service->create();
        } catch (\Exception $ex) {
            return $this->sendError('Url Service Error.', ['message' => $ex->getMessage()]);
        }

        return $this->sendResponse($urlObj, 'Url created successfully');
    }


    /**
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'link' => 'required|string|unique:urls',
            'slug' => 'string|nullable|unique:urls'
        ]);

        if ($validator->fails())
            return $this->sendError('Validation Error.', (array)$validator->errors());

        try {
            $service = new UrlService(
                $request->user()->id, $request->name, $request->link, $request->slug
            );
            $urlObj = $service->update($id);
        } catch (\Exception $ex) {
            return $this->sendError('Url Service Error.', ['message' => $ex->getMessage()]);
        }

        return $this->sendResponse($urlObj, 'Url created successfully');
    }

    /**
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function delete(Request $request, $id): JsonResponse
    {
        $obj = Url::find($id);
        if (!$obj)
            return $this->sendError('Url not found');

        $obj->delete();

        return $this->sendResponse([], 'Url deleted successfully');
    }
}
