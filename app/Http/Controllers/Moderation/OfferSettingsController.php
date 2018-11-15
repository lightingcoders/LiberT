<?php

namespace App\Http\Controllers\Moderation;

use App\Models\PaymentMethod;
use App\Models\PaymentMethodCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class OfferSettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('moderation.offer_settings.index', [
            'payment_method_category' => PaymentMethodCategory::all()
                ->pluck('name', 'id')
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function storeOfferTag(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        if ($request->id) {
            Tag::find($request->id)
                ->update($request->all());
        } else {
            Tag::create($request->all());
        }

        $message = __('Tag has been updated!');

        return success_response($request, $message);
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function offerTagsData(Request $request)
    {
        if ($request->ajax()) {
            $categories = Tag::all();

            return DataTables::of($categories)
                ->addColumn('action', function ($data) {
                    return view('moderation.offer_settings.partials.datatable.offer_tag_action')
                        ->with(compact('data'));
                })
                ->make(true);
        } else {
            return abort(404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function deleteOfferTag(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        if($category = Tag::find($request->id)){
            try{
                $category->delete();

                $message = __('Tag has been deleted!');

                return success_response($request, $message);
            }catch (\Exception $e){
                return error_response($request, $e->getMessage());
            }
        }else{
            $message = __('Selected tag could not be found!');

            return error_response($request, $message);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function storePaymentMethodCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        if ($request->id) {
            PaymentMethodCategory::find($request->id)
                ->update($request->all());
        } else {
            PaymentMethodCategory::create($request->all());
        }

        $message = __('Category has been updated!');

        return success_response($request, $message);
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function paymentMethodCategoriesData(Request $request)
    {
        if ($request->ajax()) {
            $categories = PaymentMethodCategory::all();

            return DataTables::of($categories)
                ->addColumn('action', function ($data) {
                    return view('moderation.offer_settings.partials.datatable.payment_method_category_action')
                        ->with(compact('data'));
                })
                ->make(true);
        } else {
            return abort(404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function deletePaymentMethodCategory(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        if($category = PaymentMethodCategory::find($request->id)){
            try{
                $category->delete();

                $message = __('Category has been deleted!');

                return success_response($request, $message);
            }catch (\Exception $e){
                return error_response($request, $e->getMessage());
            }
        }else{
            $message = __('Selected category could not be found!');

            return error_response($request, $message);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function storePaymentMethod(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required|exists:payment_method_categories,id'
        ]);

        if ($request->id) {
            PaymentMethod::find($request->id)
                ->update([
                    'payment_method_category_id' => $request->category,
                    'name' => $request->name
                ]);
        } else {
            PaymentMethod::create([
                'payment_method_category_id' => $request->category,
                'name' => $request->name
            ]);
        }

        $message = __('Payment method has been updated!');

        return success_response($request, $message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function deletePaymentMethod(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        if($category = PaymentMethod::find($request->id)){
            try{
                $category->delete();

                $message = __('Payment method has been deleted!');

                return success_response($request, $message);
            }catch (\Exception $e){
                return error_response($request, $e->getMessage());
            }
        }else{
            $message = __('Selected method could not be found!');

            return error_response($request, $message);
        }
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function paymentMethodsData(Request $request)
    {
        if ($request->ajax()) {
            $methods = PaymentMethod::all();

            return DataTables::of($methods)
                ->addColumn('category', function ($data) {
                    return $data->category->name;
                })
                ->addColumn('action', function ($data) {
                    return view('moderation.offer_settings.partials.datatable.payment_method_action')
                        ->with(compact('data'));

                })
                ->make(true);
        } else {
            return abort(404);
        }
    }
}
