$(document).ajaxStop(function () {
    //$('#loading').modal({dismissible: true});
    $("#overlay").fadeOut(300);
    $('.helper_loader').modal('hide');
});

$(document).ajaxStart(function () {
    //$('#loading').modal();
    $("#overlay").fadeIn(300);
});

$(function () {
    $('[data-toggle="popover"]').popover();
});

$(document).ready(function () {
    $('#info').bind('DOMNodeInserted', function (event) {
        $('#info').slideDown().delay(3500).slideUp(500, function () {
            $('#info').empty();
        });
    });

    $('.toggle-next').click(function (event) {
        var next = $(this).next();

        if ($(next).hasClass('sub-nav')) {
            event.defaultPrevented();
            event.preventDefault();
        }

        $(this).next().slideToggle();
    });
    var inputs = document.querySelectorAll('.custom-file-upload');
    Array.prototype.forEach.call(inputs, function (input) {
        var label = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener('change', function (e) {
            var fileName = '';
            if (this.files && this.files.length > 1)
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
            else
                fileName = e.target.value.split('\\').pop();

            if (fileName)
                label.querySelector('span').innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });
    });
});

$(document).on('submit', 'form.async', function (event) {
    event.preventDefault();
    var form = $(this);
    var target = $(form.data('target'));
    if (target.length < 1) {
        target = $('#info');
    }

    $("#overlay").fadeIn(300);
    $(this).ajaxSubmit({
        type: form.attr('method'),
        success: function (data) {
            $(target).html(data.message);
            var toggleOnSuccess = $(form.data('toggle'));
            $(toggleOnSuccess).toggle();
            toastr.success(data.message, '', {timeOut: 5000})
            $('#processBtn').hide();
            $('#submitBtn').fadeIn();

            $('#processBtnOne').hide();
            $('#submitBtnOne').fadeIn();

        },
        error: function (data) {
            var result = JSON.parse(data.responseText);
            $(target).prepend(result.message);
            toastr.error(result.message, '', {timeOut: 5000})
            $('#processBtn').hide();
            $('#submitBtn').fadeIn();

            $('#processBtnOne').hide();
            $('#submitBtnOne').fadeIn();
        },
        complete: function (data) {
            var result = JSON.parse(data.responseText);
            if (result.reload) {
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }

            if (result.redirect) {
                setTimeout(function () {
                    location.href = result.redirect;
                }, 2000);
            }
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $('#file-upload-progress').show().attr('value', percentComplete);
        }
    })
});
jQuery(function ($) {

    // Function which adds the 'animated' class to any '.animatable' in view
    var doAnimations = function () {

        // Calc current offset and get all animatables
        var offset = $(window).scrollTop() + $(window).height(),
            $animatables = $('.animatable');

        // Unbind scroll handler if we have no animatables
        if ($animatables.length == 0) {
            $(window).off('scroll', doAnimations);
        }

        // Check all animatables and animate them if necessary
        $animatables.each(function (i) {
            var $animatable = $(this);
            if (($animatable.offset().top + $animatable.height() - 20) < offset) {
                $animatable.removeClass('animatable').addClass('animated');
            }
        });

    };

    // Hook doAnimations on scroll, and trigger a scroll
    $(window).on('scroll', doAnimations);
    $(window).trigger('scroll');

});

$(document).on('click', 'a.async', function (event) {
    event.preventDefault();
    var link = $(this);
    var target = $(link.attr('data-target'));
    if (target.length < 1) {
        target = $('#info');
    }

    $("#overlay").fadeIn(300);
    $.ajax({
        type: 'GET',
        url: link.attr('href'),
        cache: true,
        timeout: 60000,
        success: function (data, status) {
            $(target).html(data.message);
            toastr.success(data.message, 'Success', {timeOut: 5000})
        },
        error: function (data) {
            var result = JSON.parse(data.responseText);
            $(target).prepend(result.message);
            toastr.error(result.message, 'Error', {timeOut: 5000})
        }, complete: function (data) {
            var result = JSON.parse(data.responseText);
            if (result.reload) {
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }

            if (result.redirect) {
                setTimeout(function () {
                    location.href = result.redirect;
                }, 2000);
            }
        }
    });
    return false;
});

$(document).on('click', '.async-check', function (event) {
    event.preventDefault();
    var link = $(this);
    var target = $(link.attr('data-target'));
    if (target.length < 1) {
        target = $('#info');
    }

    if (this.checked) {
        $("#overlay").fadeIn(300);
        $.ajax({
            type: 'GET',
            url: link.data('href'),
            cache: true,
            timeout: 60000,
            success: function (data, status) {
                $(target).html(data.message);
            },
            error: function (data) {
                var result = JSON.parse(data.responseText);
                $(target).prepend(result.message);
            }, complete: function (data) {
                var result = JSON.parse(data.responseText);
                if (result.reload) {
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }

                if (result.redirect) {
                    setTimeout(function () {
                        location.href = result.redirect;
                    }, 2000);
                }
            }
        });
        return false;

    }
});

$(document).on('click', '.delete', function (event) {
    event.preventDefault();
    var token = $('input[name=_token]').val();
    var me = $(this);

    bootbox.confirm({
        message: 'You will not be able to recover this record.',
        closeButton: false,
        callback: function (result) {
            if (result === true) {
                $("#helper_loader").fadeIn(300);
                $.ajax({
                    type: 'DELETE',
                    url: getUrlWithParams($(me).attr('href'), {_token: token}),
                    cache: false,
                    timeout: 60000,
                    success: function (data, status) {
                        $('#info').html(data.message);
                        $(me).closest('tr').remove();
                        toastr.success(data.message, 'Success', {timeOut: 5000})
                    },
                    error: function (data) {
                        var result = JSON.parse(data.responseText);
                        $('#info').prepend(result.message);
                        toastr.error(result.message, 'Error', {timeOut: 5000})
                    },
                    complete: function (data) {
                        bootbox.hideAll();
                        var result = JSON.parse(data.responseText);
                        if (result.reload) {
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }

                        if (result.redirect) {
                            setTimeout(function () {
                                location.href = result.redirect;
                            }, 2000);
                        }
                    }
                });
                return false;
            }
        },
        title: 'Are you sure?'
    });
});


$(document).on('click', 'a.ask-confirmation', function (event) {
    event.preventDefault();
    var token = $('input[name=_token]').val();
    var me = $(this);

    bootbox.confirm({
        message: me.data('message'),
        closeButton: false,
        callback: function (result) {
            if (result === true) {
                $("#helper_loader").fadeIn(300);
                $.ajax({
                    type: 'GET',
                    url: getUrlWithParams($(me).attr('href'), {_token: token}),
                    cache: false,
                    timeout: 60000,
                    success: function (data, status) {
                        $('#info').html(data.message);
                        $(me).closest('tr').remove();
                        toastr.success(data.message, 'Success', {timeOut: 5000})
                    },
                    error: function (data) {
                        var result = JSON.parse(data.responseText);
                        $('#info').prepend(result.message);
                        toastr.error(result.message, 'Error', {timeOut: 5000})
                    },
                    complete: function (data) {
                        bootbox.hideAll();
                        var result = JSON.parse(data.responseText);
                        if (result.reload) {
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }

                        if (result.redirect) {
                            setTimeout(function () {
                                location.href = result.redirect;
                            }, 2000);
                        }
                    }
                });
                return false;
            }
        },
        title: 'Are you sure?'
    });
});

var getUrlWithParams = function (url, data) {
    if (!$.isEmptyObject(data)) {
        url += (url.indexOf('?') >= 0 ? '&' : '?') + $.param(data);
    }

    return url;
};

/* Google Maps */


