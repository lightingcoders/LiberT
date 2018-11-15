import PerfectScrollbar from "perfect-scrollbar";
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
                this.handleScrollElements();
            })
        },

        methods: {
            handleScrollElements: function () {
                if(this.$refs.ratingScrollWrapper){
                    new PerfectScrollbar(this.$refs.ratingScrollWrapper);
                }
            },

            dateDiffForHumans: function(date){
                return moment(date).fromNow();
            },


            getProfileAvatar: function (user) {
                let avatar = '/images/objects/default-avatar.png';

                if (user.profile && user.profile.picture) {
                    avatar = user.profile.picture;
                }

                return avatar;
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
        },

        components: {InfiniteLoading},

    };
})(window, document, jQuery);

