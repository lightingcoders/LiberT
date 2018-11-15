<?php

namespace App\Http\Controllers\Administration\Configuration;

use App\Models\EmailComponent;
use App\Models\NotificationTemplate;
use App\Notifications\Authentication\UserRegistered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jackiedo\DotenvEditor\DotenvEditor;

class NotificationController extends Controller
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
        'MAIL_DRIVER', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 'MAIL_PASSWORD', 'MAIL_ENCRYPTION',
        'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME', 'SPARKPOST_SECRET', 'SES_KEY', 'SES_SECRET', 'SES_REGION',
        'MAILGUN_DOMAIN', 'MAILGUN_SECRET', 'SMS_PROVIDER', 'NEXMO_KEY', 'NEXMO_SECRET', 'NEXMO_PHONE',
        'AFRICASTALKING_USERNAME', 'AFRICASTALKING_KEY', 'AFRICASTALKING_FROM'
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
     * Show configurations page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('administration.configuration.notification.index')->with([
            'env' => $this->getEditableValues(),
            'email_component' => emailComponent()
        ]);
    }

    /**
     * Update general configurations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateGeneral(Request $request)
    {
        $this->setEditableValues($request->all());

        $message = __("Your configuration has been updated!");

        return success_response($request, $message);
    }

    /**
     * Update email components
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateComponent(Request $request)
    {
        $email_component = emailComponent();

        $email_component->fill([
            'header' => $request->header,
            'footer' => $request->footer,
        ]);

        $email_component->save();

        $message = __("Your configuration has been updated!");

        return success_response($request, $message);
    }

    /**
     * Update notification templates
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateTemplate(Request $request)
    {
        $template = NotificationTemplate::where('name', $request->name)->first();

        $template->fill($request->only(['subject', 'intro_line', 'outro_line', 'message']));

        if ($request->has('action')) {
            $template->action = json_encode($request->action);
        }

        $template->save();

        $message = __("Your template has been updated!");

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
