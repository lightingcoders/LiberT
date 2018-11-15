<script type="text/javascript">
    window.Laravel = {
        'csrfToken': '{{csrf_token()}}',
        @if(Auth::check())
        'authId': {{Auth::id()}},
        'authName': '{{Auth::user()->name}}',
        'notificationsEndpoint': '{{route('ajax.profile.unreadNotifications', ['user' => Auth::user()->name])}}',
        'messageEndpoint': '{{route('ajax.profile.activeTradeChats', ['user' => Auth::user()->name])}}',
        @endif
        'broadcaster': '{{env('BROADCAST_DRIVER')}}',
        @if(env('BROADCAST_DRIVER') == "pusher")
        'pusher': {
            'key': '{{config('broadcasting.connections.pusher.key')}}',
            'cluster': '{{config('broadcasting.connections.pusher.options.cluster')}}'
        },
        @endif
        'login2FAEndpoint': '{{route('login.check-2fa')}}',
    };
</script>
