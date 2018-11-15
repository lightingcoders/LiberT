<?php

namespace App\Http\Controllers\Administration\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jackiedo\DotenvEditor\DotenvEditor;

class SettingsController extends Controller
{

    /**
     * @var DotenvEditor
     */
    protected $editor;

    /**
     * Defines the editable keys in the .env file
     *
     * @var array
     */
    protected $editable_keys = [
        'SET_DEFAULT_CURRENCY', 'SET_TX_PREFERENCE', 'SET_MIN_TX_CONFIRMATIONS', 'SET_BTC_TRADE_FEE',
        'SET_BTC_LOCKED_BALANCE', 'SET_DOGE_TRADE_FEE', 'SET_DOGE_LOCKED_BALANCE', 'SET_LTC_TRADE_FEE',
        'SET_LTC_LOCKED_BALANCE', 'SET_DASH_TRADE_FEE', 'SET_DASH_LOCKED_BALANCE',
    ];

    /**
     * NotificationController constructor.
     *
     * @param DotenvEditor $editor
     */
    public function __construct(DotenvEditor $editor)
    {
        $this->editor = $editor;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('administration.configuration.settings.index')->with([
            'env' => $this->getEditableValues()
        ]);
    }

    /**
     * Update general configurations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->setEditableValues($request->all());

        $message = __("Your configuration has been updated!");

        return success_response($request, $message);
    }

    /**
     * Get the editable values of the .env file
     *
     * @return array
     */
    private function getEditableValues()
    {
        return $this->editor->getKeys($this->editable_keys);
    }

    /**
     * Set the editable values of the .env file
     *
     * @param array $values
     */
    private function setEditableValues(array $values)
    {
        $values = collect($values);

        $setter = $values->filter(function ($value, $key) {
            return in_array($key, $this->editable_keys);
        })->map(function ($value, $key) {
            return ['key' => $key, 'value' => $value];
        });

        $this->editor->setKeys($setter->toArray());

        $this->editor->save();
    }
}
