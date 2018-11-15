<?php

namespace App\Http\Controllers\Administration\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jackiedo\DotenvEditor\DotenvEditor;

class GeneralController extends Controller
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
        'APP_NAME', 'APP_DESCRIPTION', 'APP_KEYWORDS', 'APP_SHORTCUT_ICON',
        'APP_LOGO_ICON', 'NOCAPTCHA_ENABLE', 'NOCAPTCHA_SECRET', 'NOCAPTCHA_SITEKEY',
        'NOCAPTCHA_TYPE', 'APP_LOGO_BRAND', 'BROADCAST_DRIVER', 'PUSHER_APP_ID',
        'PUSHER_APP_KEY', 'PUSHER_APP_SECRET', 'BLOCKCYPHER_TOKEN'
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
     * Show general configuration
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('administration.configuration.general.index')->with([
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
