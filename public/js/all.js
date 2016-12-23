$(document).ready(function() {

    if (window.isAdmin) {
        $('body').on('click', '.shift1 button,.shift2 button,.shift3 button', function (e) {
            var btn       = $(this);
            var date      = $(this).parents('tr').data('date');
            var shiftText = $(this).parents('td').hasClass('shift1') ? 'לילה' : ($(this).parents('td').hasClass('shift2') ? 'בוקר' : 'ערב');
            var shiftId   = $(this).parents('td').hasClass('shift1') ? '1' : ($(this).parents('td').hasClass('shift2') ? '2' : '3');
            var toStatus  = $(this).hasClass('btn-success') ? 0 : 1;
            var userId    = $(this).data('user');

            $.ajax({
                url: '/shift-change',
                type: 'get',
                data: {
                    user_id: userId,
                    shift: shiftId,
                    date: date,
                    status: toStatus
                },
                beforeSend: function() {
                    btn.blur();
                },
                success: function () {
                    btn.removeClass(toStatus ? 'btn-danger' : 'btn-success')
                        .addClass(toStatus ? 'btn-success' : 'btn-danger');
                },
                error: function () {
                    alert('שגיאה בשמירת נתונים');
                    location.reload();
                }
            });
        });
    } else {
        $('body').on('click', '.shift1,.shift2,.shift3', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var date = $(this).parents('tr').data('date');
            var shiftText = $(this).parents('td').hasClass('shift1') ? 'לילה' : ($(this).parents('td').hasClass('shift2') ? 'בוקר' : 'ערב');
            var shiftId   = $(this).hasClass('shift1') ? '1' : ($(this).hasClass('shift2') ? '2' : '3');

            bootbox.confirm({
                message: "מעוניין להרשם למשמרת "+shiftText+" "+date+"?",
                buttons: {
                    confirm: {
                        label: 'הרשם למשמרת',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'לא משנה',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result) {

                        $.ajax({
                            url: '/shift-add',
                            type: 'get',
                            data: {
                                shift: shiftId,
                                date: date
                            },
                            beforeSend: function() {
                                // btn.blur();
                            },
                            success: function () {
                                // btn.removeClass(toStatus ? 'btn-danger' : 'btn-success')
                                //     .addClass(toStatus ? 'btn-success' : 'btn-danger');
                            },
                            error: function () {
                                alert('שגיאה בשמירת נתונים');
                                location.reload();
                            }
                        });
                    }
                }
            });
        });
    }

});