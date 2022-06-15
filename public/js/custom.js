$(document).ready(function () {

    //for manage Errors

    class Errors {
        constructor() {
            this.errors = {};
        }

        has(field) {
            return this.errors.hasOwnProperty(field);
        }

        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }

        record(errors) {
            this.errors = errors;
        }
    }

    //for sidebar

    resizeTemplate()
    $(window).resize(resizeTemplate)

    function resizeTemplate() {
        if ($(window).width() <= 768) {
            $('#sidebar').collapse('hide');
        } else {
            $('#sidebar').collapse('show');
        }
    }


    $('#sidebar').on('hide.bs.collapse', function (e) {
        if (e.target == this) {
            $('#main').removeClass('col-md-10');
        }
    })
    $('#sidebar').on('show.bs.collapse', function (e) {
        if (e.target == this) {
            $('#main').addClass('col-md-10');
        }
    });

    //end sidebar

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });


//  create product

    $('#newProductForm').submit(function (e) {
        e.preventDefault();

        let data = new FormData($(this)[0]);
        let _token = $('#newProductForm input[name="_token"]').val();

        let err = new Errors();

        let saveBtn = $('#newProductForm #save');

        saveBtn.html("لطفا منتظر بمانید...");
        saveBtn.prop("disabled", true);

        $.ajax({
            url: '/admin/products',
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': _token
            }, success: function (response) {

                saveBtn.html("در حال انتقال...");

                swal({
                    "timer": 1800,
                    "text": response.message,
                    "buttons": {
                        "cancel": false,
                        "confirm": false
                    },
                    "title": "",
                    "icon": "success"
                });
                setTimeout(function () {
                    window.location.replace("/admin/products");
                }, 1800)
            }, error: function (errors) {

                saveBtn.html("ثبت محصول");
                saveBtn.prop("disabled", false);

                err.record(errors.responseJSON.errors);
                $('.error').remove();
                checkError(['name', 'price', 'weight', 'dimensions',
                    'category_id', 'count', 'description'], err);
            }
        });
    });


    //tag delete
    $('.deleteBtn').click(function (e) {
        e.preventDefault();
        let id = $(this).attr("data-id");
        let model = $(this).attr("data-model");
        let _token = $('#deleteForm input[name="_token"]').val();

        swal({
            title: '',
            text: "آیا حذف شود؟",
            icon: 'warning',
            buttons: [
                'بستن',
                'بله',
            ],
        }).then((result) => {
            if (result) {
                $.ajax({
                    url: '/admin/' + model + '/' + id,
                    type: 'post',
                    data: {_method: 'DELETE'},
                    headers: {
                        'X-CSRF-TOKEN': _token
                    }, success: function (response) {
                        swal({
                            "timer": 1800,
                            "text": response.message,
                            "buttons": {
                                "cancel": false,
                                "confirm": false
                            },
                            "title": "",
                            "icon": "success"
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 1800)
                    }, error: function (error) {
                    }
                });
            }
        })
    });


    function checkError(inputs, errors) {
        $.each(inputs, function (index, key) {
            if (errors.has(key)) {
                $('#' + key + '').after('<div class="error" ' +
                    'role="alert">' + errors.get(key) + '</div>');
            }
        })
    }

});

function getCategory(category) {
    console.log(category.value);
    let data = new FormData();
    data.append("parent_id", category.value);
    let _token = $('#newProductForm input[name="_token"]').val();
    $.ajax({
        url: '/admin/products/getCategoryChildren',
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': _token
        }, success: function (response) {
            $.each(response.categories, function (index, key) {
                $('#category_id').append(
                    '<option value="' + key.id + '">' + key.name + '</option>'
                );
            });
        }
    });
}

$(document).ready(function () {
    $('#div_search').slideUp(0);
    $('#div_transport').slideUp(0);
    $('.d_down_1').removeClass('hide');
    $('.d_down_1').slideUp(0);

    $('.car_number, .admin_roles').slideUp(0);

    $('#btn_search').click(function () {
        $('#div_search').slideToggle(600);
    });

    $('.d_down_click').click(function () {
        $(this).next('div .d_down_1').slideToggle(600).siblings('.d_down_1').slideUp(600);
    });

    $('#btn_transport').click(function (e) {
        e.preventDefault();
        $('#div_transport').slideToggle(600);
    });
});


$(document).ready(function () {

    $('.money').simpleMoneyFormat();

    $('[data-toggle="tooltip"]').tooltip();

    kamaDatepicker('date', {
        markToday: true
    });
    kamaDatepicker('date_2', {
        markToday: true
    });

    setTimeout(function () {
        $('#preloader').fadeOut('slow', function () {});
    }, 50);

    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('.btn_modal_star').click(function () {
        let id = $(this).attr('data-id');
        let des = $(this).attr('data-title');
        $('#description').html(des);
        $('.mark_id').val(id);
    });

    $('.check_status').on('change', function () {
        let status = null;
        let id = $(this).attr('data-id');
        if ($(this).is(':checked')) {
            status = 1;
        } else {
            status = 0;
        }

        $.ajax({
            method: 'get',
            url: '/admin/SMS/change_status/' + id + '/' + status,

            success: function (response) {
                swal({
                    text: "تغییر وضعیت داده شد",
                    icon: "success",
                    buttons: false
                });
            },
            error: function () {

            }
        });
    });

    $('.check_active').on('change', function () {
        let active = null;
        let id = $(this).attr('data-id');
        if ($(this).is(':checked')) {
            active = 1;
        } else {
            active = 0;
        }

        $.ajax({
            method: 'get',
            url: '/admin/users/change_active/' + id + '/' + active,

            success: function (response) {
                swal({
                    text: "تغییر وضعیت داده شد",
                    icon: "success",
                    buttons: false
                });
            },
            error: function () {

            }
        });
    });

    $('.product_active').on('change', function () {
        let active = null;
        let id = $(this).attr('data-id');
        if ($(this).is(':checked')) {
            active = 1;
        } else {
            active = 0;
        }

        $.ajax({
            method: 'get',
            url: '/admin/products/product_active/' + id + '/' + active,

            success: function (response) {
                swal({
                    text: "تغییر وضعیت داده شد",
                    icon: "success",
                    buttons: false
                });
            },
            error: function () {

            }
        });
    });

    $('.star').on('change', function () {
        let active = null;
        let id = $(this).attr('data-id');
        if ($(this).is(':checked')) {
            active = 0;
        } else {
            active = 1;
        }

        $.ajax({
            method: 'get',
            url: '/admin/orders/mark/' + id + '/' + active,

            success: function (response) {
                console.log(response);
                swal({
                    text: "انجام شد",
                    icon: "success",
                    buttons: false,
                    timer: 1000
                });
            },
            error: function () {

            }
        });
    });


    $('.add_address').click(function (e) {
        e.preventDefault();
        $('.div_address').prepend(
            '<div class="col-md-5 border rounded-lg" style="margin-right: 35px;margin-left: 35px;margin-bottom: 10px">' +
            '<input name="address_index" type="text" class="form-control my-2 col-md-4 small" height="5px" placeholder="شاخص آدرس">' +
            '<textarea name="address" class="form-control mb-1" rows="1" placeholder="آدرس"></textarea>' +
            '<textarea name="description_adr" class="form-control mb-1" rows="2" placeholder="توضیحات"></textarea>' +
            '</div>'
        );
        $(this).prop("disabled", true);
    });


    $('.btn_search_mobile').click(function (e) {
        e.preventDefault();
        let mobile = $('.mobile').val();

        $.ajax({
            method: 'GET',
            url: '/admin/customers/mobile_search/' + mobile,
            success: function (response) {
                $('.input_user_id').append(
                    '<input type="hidden" name="user_id" value="' + response['user']['id'] + '">');
                $('#name').val(response['user']['name']);
                $('#last_name').val(response['user']['last_name']);
                $('#phone').val(response['user']['phone']);

                $.each(response['addresses'], function (key, val) {
                    $('.div_address').append(
                        '<div class="container">' +
                        '<div class="form cf">' +
                        '<section class="plan cf">' +
                        '<input type="radio" name="address_id" id="' + val.id + '" value="' + val.id + '" class="mx-3 my-auto" data-id="' + val.id + '">' +
                        '<label class="free-label text-dark" for="' + val.id + '">' + val.address_index + '     ' + val.address + ' </label>' +
                        '</section>' +
                        '</div>' +
                        '</div>'
                    );
                });

            },
            error: function () {
                swal({
                    title: "",
                    text: "کاربر یافت نشد!",
                    icon: "warning",
                    buttons: false,
                    timer: 900,
                });
            }


        });
    });


    $('#Transmitted').click(function () {
        let check = [];
        $("input:checkbox[name=change_status]:checked").each(function () {
            check.push($(this).val())
        });
        let _token = $('.csrf input[name="_token"]').val();
        $.ajax({
            method: 'post',
            url: '/admin/waits/Transmitted',
            data: {check: check},
            headers: {
                'X-CSRF-TOKEN': _token
            },
            success: function (response) {
                location.reload();
            },
            error: function () {
                swal({
                    text: "خطایی رخ داده است!",
                    icon: "error",
                    buttons: false
                });
            }
        });

    });
    $('#notTransmitted').click(function () {
        let check = [];
        $("input:checkbox[name=change_status]:checked").each(function () {
            check.push($(this).val())
        });
        let _token = $('.csrf input[name="_token"]').val();
        $.ajax({
            method: 'post',
            url: '/admin/waits/notTransmitted',
            data: {check: check},
            headers: {
                'X-CSRF-TOKEN': _token
            },
            success: function (response) {
                location.reload();
            },
            error: function () {
                swal({
                    text: "خطایی رخ داده است!",
                    icon: "error",
                    buttons: false
                });
            }


        });

    });

    $('.select_level').change(function () {
        if ($(this).val() === 'admin') {
            $('.car_number').slideUp(0);
            $('.admin_roles').slideDown(500);
        } else if ($(this).val() === 'driver') {
            $('.admin_roles').slideUp(0);
            $('.car_number').slideDown(500);
        }
    });
    let twoarray = [];
    $('.product_save').click(function (e) {
        e.preventDefault();


        let id = $('#products').find(':selected').attr('value');
        let price = $('#products').find(':selected').attr('price');
        let name = $('#products').find(':selected').text();
        let count = $('#count').val();
        let defection = $('#defection').val();

        $('#count').val("");
        $('#defection').val("");

        if (count < 1 || id < 1) {
            swal({
                title: "",
                text: "لطفا نام و تعداد کالا را وارد کنید!",
                icon: "warning",
            });
        } else {
            item = {};
            item["id"] = id;
            item["count"] = count;
            item["name"] = name;
            item["defection"] = defection;
            item["price"] = price;

            twoarray.push(item);

            $('.product_table').empty();
            $.each(twoarray, function (key, val) {
                $('.product_table').append(
                    '<tr>' +
                    '<td>' + val.name + '</td>' +
                    '<td>' + val.count + '</td>' +
                    '<td>' + val.count * val.price + '</td>' +
                    '<td>' + val.defection + '</td>' +
                    '<td class="text-center">' +
                    '<a class="btn btn-sm btn-outline-danger fa fa-trash delete_product" data-id=' + val.id + '></a>' +
                    '</td>' +
                    '</tr>'
                );
            });

        }

    });


    $('.form_submit').submit(function (e) {
        $('.final_btn').prop("disabled", false).html('لطفا منتظر بمانید.........');
        e.preventDefault();
        let _token = $('input[name="_token"]').val();
        let data = new FormData($('.form_submit')[0]);
        let t = JSON.stringify(twoarray);
        data.append("product_list", t);
        $('.error').html("");
        $.ajax({
            type: 'POST',
            url: '/admin/factors',
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                $('.final_btn').prop("disabled", true).html('ثبت نهایی انجام شد');
                swal({
                    title: "با موفقیت ثبت شد.",
                    text: "شما در حال انتقال به صفحه چاپ فاکتور هستید",
                    icon: "success",
                    buttons: false,
                    timer: 2000
                });
                setTimeout(location.reload.bind(location), 1600);
                setTimeout(window.location.href = "/admin/factors/" + response, 2600);
            }, error: function (response) {
                swal({
                    text: "اطلاعات وارد شده را بررسی کنید",
                    icon: "error",
                    buttons: false,
                    timer: 2000
                });
                let errors = response.responseJSON.errors;
                $('#mobile_error').html(errors['mobile']);
                $('#name_error').html(errors['name']);
                $('#last_name_error').html(errors['last_name']);
                $('#date_error').html(errors['date']);
                $('#phone_error').html(errors['phone']);
                $('#transport_error').html(errors['transport']);
                $('#service_error').html(errors['service']);
                $('#product_list_error').html(errors['product_list[]']);
                $('.final_btn').prop("disabled", false).html('ثبت نهایی انجام نشد');
            }
        })
    });

    $('.form_destroy').submit(function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let name = $(this).data('name');
        let _token = $('.form_destroy input[name="_token"]').val();
        swal({
            title: "",
            text: "آیا حذف شود؟",
            icon: "error",
            showCancelButton: true,
            dangerMode: true,
            buttons: ["خیر", "بله"],
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method: 'POST',
                        url: '/admin/' + name + '/' + id,
                        data: {_method: 'DELETE'},
                        headers: {
                            'X-CSRF-TOKEN': _token
                        }
                    }).done(function () {
                        swal("با موفقیت حذف شد", {
                            icon: "success",
                            button: false,
                            timer: 2000
                        });
                        setTimeout(location.reload.bind(location), 1600);
                    });
                } else {

                }
            });
    });


    /*$('.type_payment').change(function () {
        if ($(this).val() === '2') {
            $('.discount').prop('disabled', true);
        } else {
            $('.discount').prop('disabled', false);
        }
    });*/


    let countuser = $('#data_chart').data('countuser');
    let counttrans = $('#data_chart').data('counttrans');

    let ctx = document.getElementById('myChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['مشتری', 'فاکتورهای تسویه نشده', 'آدرس های منتقل شده'],
            datasets: [{
                label: '',
                data: [countuser, 19, counttrans],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            response: true
        }
    });

});