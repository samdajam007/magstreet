/**
 * Created by samDAjam on 1/24/2016.
 */

jQuery(document).ready(function () {

    var form = $('#signupForm');

    $(":input").focusin(function () {
        $('.error_message .alert-danger').fadeOut('slow');
    });


    // Prevent form submission on Enter unless validate
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });


    // Validation - Confirm password
    var password = $('#pwd');
    var confirm_password = $('#confirm_pwd');

    function validatePassword() {
        if (password[0].value != confirm_password[0].value) {
            confirm_password[0].setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password[0].setCustomValidity('');
        }
    }

    password[0].onchange = validatePassword;
    confirm_password[0].onkeyup = validatePassword;


    // Validation - Confirm email
    var email = $('#email');
    var confirm_email = $('#confirm_email');

    function validateEmail() {
        if (email[0].value != confirm_email[0].value) {
            confirm_email[0].setCustomValidity("Emails Don't Match");
        } else {
            confirm_email[0].setCustomValidity('');
        }
    }

    email[0].onchange = validateEmail;
    confirm_email[0].onkeyup = validateEmail;


    // Show first fieldset of signupForm
    $('.signupForm fieldset:first-child').fadeIn('slow');


    // Go to next fieldset if validate first fieldset
    $('.signupForm .btn-info.next').on('click', function () {
        var curr_fieldset = $(this).parents('fieldset');
        var go_next = false;
        var name = $('#name');
        var email = $('#email');
        var confirm_email = $('#confirm_email');
        var pwd = $('#pwd');
        var confirm_pwd = $('#confirm_pwd');

        if (name[0].checkValidity() && email[0].checkValidity() && confirm_email[0].checkValidity() && pwd[0].checkValidity() && confirm_pwd[0].checkValidity()) {
            go_next = true;
        }
        else {
            form.find(':submit').click();
        }

        if (go_next) {
            curr_fieldset.fadeOut(400, function () {
                $(this).next().fadeIn();
            });
        }

    });

    $('.signupForm .btn-info.prev').on('click', function () {
        var curr_fieldset = $(this).parents('fieldset');

        curr_fieldset.fadeOut(400, function () {
            $(this).prev().fadeIn();
        });
    });


    // Ajax Submit
    form.submit(function (event) {
        $('#submit').prop('disabled', true);

        $.ajax({
            type: "POST",
            url: "formProcess.php",
            data: form.serialize(),
            cache: false,

            beforeSend: function () {
                $('.loading_img').show();
            },

            success: function (response) {
                $('.loading_img').hide();
                $('#submit').prop('disabled', false);

                if (response.indexOf('successfully') == -1) {
                    $('.error_message .alert-danger').fadeIn('slow').show().html(response);
                }
                else {
                    $('#signupForm').html("<div id='message' class='message'></div>");
                    $('#message').html("<h2>Congratulation!</h2>")
                        .append("<p>" + response + "</p>")
                        .hide()
                        .fadeIn(1500, function () {
                            $('#message').append("<img id='checkmark' src='./img/checkmark.png' alt='checkmark'/>");
                        });
                }
            },

            error: function (data) {
                $('.loading_img').hide();
                if (data.responseText !== '') {
                    $('.error_message .alert-danger').fadeIn('slow').show().text(data.responseText);
                } else {
                    $('.error_message .alert-danger').fadeIn('slow').show().text('Oops! An error occurred and form could not be submitted');
                }
            }

        });
        event.preventDefault();
        return false;
    });

});