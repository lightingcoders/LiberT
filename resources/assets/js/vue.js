/**
 * Register Global Vue components
 */
Vue.component('count-down', require('./vue/components/CountDown'));
Vue.component('rating', require('./vue/components/Rating'));
Vue.component('dropzone', require('./vue/components/Dropzone'));
Vue.component('tinymce', require('./vue/components/TinymceVue'));
Vue.component('user-tag', require('./vue/components/UserTag'));
Vue.component('select2', require('./vue/components/Select2'));


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Locale
window.locale = require('browser-locale')();

/**
 * This is the vue instance of the top notification bar. This is used to update
 * elements like notifications in real time.
 */
window.navbar = new Vue({
    el: '#navbar',
    data: {
        bellAnimation: '',
        mailAnimation: '',

        locale: window.locale,

        notifications: {
            total: 0,
            data: [],
            current: 0,
            next: false
        },
        messages: {
            total: 0,
            data: [],
            current: 0,
            next: false
        },
    },

    mounted: function () {
        this.$nextTick(function () {
            this.getNotifications();
            this.listenForNotifications();
            this.getMessages();
            this.listenForMessageAlerts();
        });
    },

    methods: {
        getNotifications: function () {
            let vm = this;

            if (window.Laravel.authId) {
                axios.post(window.Laravel.notificationsEndpoint)
                     .then((response) => {
                         var notifications = response.data;

                         vm.notifications.current = notifications.current_page;
                         vm.notifications.data = notifications.data;
                         vm.notifications.next = Boolean(notifications.next_page_url);
                         vm.notifications.total = notifications.total;
                     })
                     .catch((error) => {
                         console.log(error)
                     });
            }

        },

        getMessages: function () {
            let vm = this;

            if (window.Laravel.authId) {
                axios.post(window.Laravel.messageEndpoint)
                     .then((response) => {
                         var messages = response.data;

                         vm.messages.current = messages.current_page;
                         vm.messages.data = messages.data;
                         vm.messages.next = Boolean(messages.next_page_url);
                         vm.messages.total = messages.total;
                     })
                     .catch((error) => {
                         console.log(error)
                     });
            }
        },

        markAsRead: function (id, event) {
            if (window.Laravel.authId) {
                let element = event.currentTarget;
                let name = window.Laravel.authName;

                let endpoint = '/profile/' + name + '/notifications/' + id + '/markAsRead';

                axios.post(endpoint).then((response) => {
                    window.location.href = element.getAttribute('href')
                }).catch((error) => {console.log(error)});
            }
        },

        playSound: function () {
            new Audio(
                '/sounds/notify.mp3'
            ).play();
        },

        showBellAlert: function () {
            this.bellAnimation = 'rubberBand';
            this.playSound();
        },

        hideBellAlert: function () {
            this.bellAnimation = '';
        },

        showMailAlert: function () {
            this.mailAnimation = 'rubberBand';
            this.playSound();
        },

        hideMailAlert: function () {
            this.mailAnimation = '';
        },

        listenForNotifications: function () {
            let vm = this;

            if (window.Laravel.authId) {
                Echo.private('user.' + window.Laravel.authId)
                    .listen('NotificationsUpdated', function (e) {
                        let prev_total = vm.notifications.total;

                        vm.notifications.current = e.notifications.current_page;
                        vm.notifications.data = e.notifications.data;
                        vm.notifications.next = Boolean(e.notifications.next_page_url);
                        vm.notifications.total = e.notifications.total;

                        if (prev_total < vm.notifications.total) {
                            vm.showBellAlert();
                        }
                    });
            }
        },

        listenForMessageAlerts: function () {
            let vm = this;

            if (window.Laravel.authId) {
                Echo.private('user.' + window.Laravel.authId)
                    .listen('NewMessageAlert', function (e) {
                        vm.getMessages();
                        vm.showMailAlert();
                    });
            }
        },

        truncate: function (n, len) {
            var ext = n.substring(n.lastIndexOf(".") + 1, n.length).toLowerCase();
            var filename = n.replace('.' + ext, '');
            if (filename.length <= len) {
                return n;
            }
            filename = filename.substr(0, len) + (n.length > len ? '[...]' : '');
            return filename + '.' + ext;
        },

        getProfileAvatar: function (user) {
            let avatar = '/images/objects/default-avatar.png';

            if (user.profile && user.profile.picture) {
                avatar = user.profile.picture;
            }

            return avatar;
        },

        dateDiffForHumans: function (date) {
            return moment(date).fromNow();
        },
    }
});


/**
 * The whole of the following comprises of the reusable global instance of all
 * pages. By default one mixin is provided, which is that of the individual page
 */
let mixins = [];

if (window.pageMixin !== undefined) {
    mixins.push(window.pageMixin);
}

window.app = new Vue({
    el: '#app',
    mixins: mixins,
    data: {
        locale: window.locale,
        global: {
            notifications: {
                total: 0,
                data: [],
                current: 0,
                next: false
            },
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            this._initValidation();
            this._initFormElements();
        });
    },

    methods: {
        _initValidation: function () {
            $("input, select, textarea")
                .not("[type=submit], [novalidate]")
                .jqBootstrapValidation();
        },

        _initFormElements: function () {
            let check = $('.skin-square input');

            // Square Checkbox & Radio
            check.iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
            });
        },
    },

});

