import PerfectScrollbar from 'perfect-scrollbar';
import InfiniteLoading from "vue-infinite-loading";

(function (window, document, $) {
    window.pageMixin = {
        data: function () {
            let data = {};

            if (window._vueData !== undefined) {
                data = window._vueData;
            }

            return data;
        },

        mounted: function () {
            this.$nextTick(function () {
                if (this.profile !== undefined) {
                    this.handleIntlPhoneInput();
                    this.handleScrollElements();
                    this.listenForNotifications();
                    this.listenProfilePresence();
                }
            })
        },

        methods: {
            getTwofaCode: function () {
                return '{"code": "' + this.form.twofa_code + '"}';
            },

            getPhoneCode: function () {
                return '{"code": "' + this.form.phone_code + '"}';
            },

            handleIntlPhoneInput: function () {
                let phone = $('#phone');
                let phoneCountry = $('#phone-country');

                if (phone.length > 0) {
                    phone.intlTelInput({
                        initialCountry: 'auto',
                        nationalMode: false,

                        geoIpLookup: function (callback) {
                            $.get("https://ipinfo.io", function () {
                            }, "jsonp")
                             .always(function (resp) {
                                 callback((resp && resp.country) ? resp.country : "");
                             });
                        }
                    });

                    let data = phone.intlTelInput("getSelectedCountryData");

                    phoneCountry.val(data.iso2);

                    phone.on("countrychange", function (e, data) {
                        phoneCountry.val(data.iso2);
                    });
                }
            },

            handleScrollElements: function () {
                if(this.$refs.ratingScrollWrapper){
                    new PerfectScrollbar(this.$refs.ratingScrollWrapper);
                }

                if(this.$refs.notificationsScrollWrapper){
                    new PerfectScrollbar(this.$refs.notificationsScrollWrapper);
                }
            },

            getProfileAvatar: function (user) {
                let avatar = '/images/objects/default-avatar.png';

                if (user.profile && user.profile.picture) {
                    avatar = user.profile.picture;
                }

                return avatar;
            },

            markAsRead: function (id, event) {
                if (this.profile.id !== undefined) {
                    let element = event.currentTarget;

                    let endpoint = '/profile/' + this.profile.name + '/notifications/' + id + '/markAsRead';

                    axios.post(endpoint).then((response) => {
                        window.location.href = element.getAttribute('href')
                    }).catch((error) => {console.log(error)});
                }
            },

            dateDiffForHumans: function(date){
                return moment(date).fromNow();
            },

            listenProfilePresence: function () {
                let vm = this;

                if (vm.profile.id !== undefined) {
                    Echo.private('user.' + vm.profile.id + '.presence')
                        .listen('UserPresenceUpdated', function (e) {
                            vm.profile.presence = e.presence;
                            vm.profile.lastSeen = e.last_seen;
                        });
                }
            },

            listenForNotifications: function () {
                let vm = this;

                if (this.$refs.notificationsScrollWrapper && vm.profile.id !== undefined) {
                    Echo.private('user.' + vm.profile.id)
                        .listen('NotificationsUpdated', function (e) {
                            vm.notifications.current = 0;
                            vm.notifications.data = [];
                            vm.notifications.next = true;
                            vm.notifications.total = 0;

                            vm.$nextTick(function() {
                                vm.$refs.notificationsInfiniteLoading
                                  .$emit('$InfiniteLoading:reset');
                            });
                        });
                }
            },

            ratingInfiniteHandler: function ($state) {
                let vm = this;
                if (this.ratings.next) {
                    axios.post(vm.ratings_endpoint, {
                        page: vm.ratings.current + 1,
                    }).then(function (response) {
                        var ratings = response.data;

                        if (ratings.data.length && vm.ratings.next) {
                            vm.ratings.current = ratings.current_page;
                            vm.ratings.data = vm.ratings.data.concat(ratings.data);
                            vm.ratings.next = Boolean(ratings.next_page_url);
                            vm.ratings.total = ratings.total;
                        } else {
                            vm.ratings.next = false;
                        }

                        $state.loaded();

                        if (!vm.ratings.next) {
                            $state.complete();
                        }
                    }).catch(function (error) {
                        if (error.response) {
                            let response = error.response.data;

                            if ($.isPlainObject(response)) {
                                $.each(response.errors, function (key, value) {
                                    toastr.error(value[0]);
                                });
                            } else {
                                toastr.error(response);
                            }

                            vm.ratings.next = false;

                            $state.complete();
                        } else {
                            console.log(error.message);
                        }
                    });
                } else {
                    $state.complete();
                }
            },

            notificationsInfiniteHandler: function ($state) {
                let vm = this;

                if (this.notifications.next) {
                    axios.post(vm.notifications_endpoint, {
                        page: vm.notifications.current + 1,
                    }).then(function (response) {
                        var notifications = response.data;

                        if (notifications.data.length && vm.notifications.next) {
                            vm.notifications.current = notifications.current_page;
                            vm.notifications.data = vm.notifications.data.concat(notifications.data);
                            vm.notifications.next = Boolean(notifications.next_page_url);
                            vm.notifications.total = notifications.total;
                        } else {
                            vm.notifications.next = false;
                        }

                        $state.loaded();

                        if (!vm.notifications.next) {
                            $state.complete();
                        }
                    }).catch(function (error) {
                        if (error.response) {
                            let response = error.response.data;

                            if ($.isPlainObject(response)) {
                                $.each(response.errors, function (key, value) {
                                    toastr.error(value[0]);
                                });
                            } else {
                                toastr.error(response);
                            }

                            vm.notifications.next = false;

                            $state.complete();
                        } else {
                            console.log(error.message);
                        }
                    });
                } else {
                    $state.complete();
                }
            },
        },

        computed: {
            avatarPresenceObject: function () {
                return {
                    'avatar-online': this.profile.presence === 'online',
                    'avatar-away': this.profile.presence === 'away',
                    'avatar-off': this.profile.presence === 'offline',
                }
            },

            lastSeenPresence: function () {
                let lastSeen = 'Not Available!';

                if (this.profile.lastSeen) {
                    lastSeen = moment(this.profile.lastSeen).fromNow();
                }

                return lastSeen;
            }
        },

        components: {InfiniteLoading},

    };
})(window, document, jQuery);

