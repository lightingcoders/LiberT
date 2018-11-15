// Cropper
window.Cropper = require('cropperjs/dist/cropper');

// Dropzone
window.Dropzone = require('dropzone/dist/dropzone');
Dropzone.autoDiscover = false;

window.Page = function () {
    let dataTable = {}, dropzone = {}, cropper;

    let handlePictureUpload = function () {
        if ($('div#picture-upload').length > 0) {

            dropzone['#picture-upload'] = new Dropzone(
                "div#picture-upload",
                {
                    url: window._pictureUploadUrl,
                    paramName: 'profile_picture',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    acceptedFiles: 'image/*',
                    addRemoveLinks: false,
                    autoProcessQueue: false,
                    success: function (file, response) {
                        toastr.success(response);
                    },
                    error: function (file, response) {
                        if ($.isPlainObject(response)) {
                            var timeout = 1000;

                            $.each(response.errors, function (key, value) {
                                setTimeout(function () {
                                    toastr.error(value);
                                }, timeout);

                                timeout += 1000;
                            });
                        } else {
                            toastr.error(response);
                        }
                    }
                }
            );


            dropzone['#picture-upload'].on('thumbnail', function (file) {
                // Ignore files which were already cropped and re-rendered
                // to prevent infinite loop
                if (file.cropped) {
                    return;
                }

                // Cache filename to re-assign it to cropped file
                var cachedFilename = file.name;

                // Remove not cropped file from dropzone (we will replace it later)
                dropzone['#picture-upload'].removeFile(file);

                // Dynamically create modals to allow multiple files processing
                var $cropperModal = $('#cropper-custom');

                // 'Crop and Upload' button in a modal
                var $uploadCrop = $cropperModal.find('.crop-upload');

                var $img = $('<img id="img-cropper" style="max-width:100%;"/>');

                // Initialize FileReader which reads uploaded file
                var reader = new FileReader();

                reader.onloadend = function () {
                    // Add uploaded and read image to modal
                    $cropperModal.find('.image-container').html($img);

                    $img.attr('src', reader.result);

                    let image = document.getElementById('img-cropper');

                    // Initialize cropper for uploaded image
                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        autoCropArea: 1,
                        movable: false,
                        cropBoxResizable: true,
                        minContainerWidth: $('.image-container').actual('width'),
                        minContainerHeight: 500,
                        viewMode: 1
                    });
                };

                // Read uploaded file (triggers code above)
                reader.readAsDataURL(file);

                $cropperModal.modal('show');

                // Listener for 'Crop and Upload' button in modal
                $uploadCrop.on('click', function () {
                    // Get cropped image data
                    var uri = cropper.getCroppedCanvas()
                                     .toDataURL("image/jpeg");

                    // Transform it to Blob object
                    var newFile = Page.dataURItoBlob(uri);

                    // Set 'cropped to true' (so that we don't get to that listener again)
                    newFile.cropped = true;

                    // Assign original filename
                    newFile.name = cachedFilename;

                    // add cropped file to dropzone
                    dropzone['#picture-upload'].addFile(newFile);

                    // Upload cropped file with dropzone
                    dropzone['#picture-upload'].processQueue();

                    // We destroy the cropper to avoid duplicate in the next upload
                    cropper.destroy();

                    $cropperModal.modal('hide');
                });
            });
        }
    };

    return {
        init: function () {
            handlePictureUpload();

            this.initDataTable();
        },


        initDataTable: function () {
            $.each(window._tableData, function (index, value) {
                let selector = value['selector'],
                    options  = value['options'];

                dataTable[selector] = $(selector).DataTable(options);


                let searchBox = $('#search-contacts');

                // Set the search textbox functionality in sidebar
                if (searchBox.length > 0) {
                    searchBox.on('keyup', function () {
                        dataTable[selector].search(this.value).draw();
                    });
                }

                $('a[data-action="reload"]').on('click', function () {
                    dataTable[selector].ajax.reload();
                });
            });
        },

        reloadDataTable: function (id) {
            dataTable[id].ajax.reload();
        },

        dataURItoBlob: function (dataURI) {
            var byteString = atob(dataURI.split(',')[1]);
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], {type: 'image/jpeg'});
        }
    }
}();

$(document).ready(function () {
    Page.init();
});
