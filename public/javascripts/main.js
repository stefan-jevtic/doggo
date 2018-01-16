$(document).ready( () => {

    let usernameAvailability = false;

    $('#tbUsername').blur( () => {
        const username = $('#tbUsername').val();
        const checkUsername = 'checkUsername';
        const error = false;

        const regUser = /^\w{4,20}$/;

        if(!regUser.test(username)){
            $('.username.error').text('Username is invalid! Must be at least 4 characters long').css({'color': 'red', 'font-size': '12px'});
            error = true;
        }

        if(!error){
            $.ajax({
                type: 'POST',
                url: 'includes/ajax.php',
                data: {username, checkUsername},
                success(data){
                    if(data == 'Free'){
                        $('.username.error').text('Valid username!').css({'color': 'green', 'font-size': '12px'});
                        usernameAvailability = true;
                    }
                    else{
                        $('.username.error').text('Username is already taken!').css({'color': 'red', 'font-size': '12px'});
                    }
                }
            })
        }
    });

    $('#btnSignUp').click( () => {
        const email = $('#tbEmail').val();
        const username = $('#tbUsername').val();
        const password = $('#tbPassword').val();
        const retype = $('#tbPasswordRetype').val();
        // const avatar = $('#avatar').val().replace('C:\\fakepath\\', '').trim();
        // const extension = avatar.split('.').pop();
        const signin = 'signin';

        let error = false;

        const regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        const regUser = /^\w{4,20}$/;
        const regPass = /^[A-z0-9]{5,20}\W?[A-z0-9]{0,20}$/;
        //const regAvatar = /^(png|jpe?g)$/;

        if(!regEmail.test(email)){
            $('.email.error').text('Email is invalid').css({'color': 'red', 'font-size': '12px'});
            error = true;
        }
        else{
            $('.email.error').text('');
            error = false;
        }

        if(!regUser.test(username)){
            $('.username.error').text('Username is invalid! Must be at least 4 characters long').css({'color': 'red', 'font-size': '12px'});
            error = true;
        }
        else{
            $('.username.error').text('');
            error = false;
        }

        if(!regPass.test(password)){
            $('.password.error').text('Password must be at least five characters long').css({'color': 'red', 'font-size': '12px'});
            error = true;
        }
        else{
            $('.password.error').text('');
            error = false;
        }

        if(password !== retype){
            $('.retype.error').text('Passwords don\'t match').css({'color': 'red', 'font-size': '12px'});
            error = true;
        }
        else{
            $('.retype.error').text('Matching!').css({'color': 'green', 'font-size': '12px'});
            error = false;
        }

        // if(!regAvatar.test(extension)){
        //     $('.avatar.error').text('Extension don\'t match! Must be jpg, png or jpeg').css({'color': 'red', 'font-size': '12px'});
        //     error = true;
        // }
        // else{
        //     $('.avatar.error').text('');
        //     error = false;
        // }


        if(!error && usernameAvailability){
            $.ajax({
                type: 'POST',
                url: 'includes/ajax.php',
                data: {email, username, password, signin},
                success(data){
                    if(data == 'Success'){
                        $('.modalSuccessSignIn').modal('toggle');
                        setTimeout( () => {
                            $('.modalSuccessSignIn').modal('hide');
                        }, 1000);

                        $('#tbEmail').val('');
                        $('#tbUsername').val('');
                        $('#tbPassword').val('');
                        $('#tbPasswordRetype').val('');
                        $('.retype.error').text('');
                    }
                    else {
                        $('.modalFailedSignIn').modal('toggle');
                        setTimeout( () => {
                            $('.modalFailedSignIn').modal('hide');
                        }, 1000);
                    }
                }
            })
        }
    });


    $('#btnLogin').click( () => {
        const username = $('#tbUsernameLogin').val();
        const password = $('#tbPasswordLogin').val();
        const login = 'login';

        if(username !== '' && password !== '') {
            $.ajax({
                type: 'POST',
                url: 'includes/ajax.php',
                data: {username, password, login},
                success(data){
                    if(data == 'Login failed'){
                        $('.modalFailedLogin').modal('toggle');
                        setTimeout( () => {
                            $('.modalFailedLogin').modal('hide');
                        }, 1000);
                        $('.required-fields').text('');
                    }
                    else{
                        window.location = 'http://localhost/doggo/index.php';
                        $('.required-fields').text('');
                    }
                }
            })
        }
        else{
            $('.required-fields').text('Please fill out all fields!').css({'color': 'red', 'font-size': '12px'});
        }
    });

    $(".btn-pref .btn").click(function () {
        $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
        // $(".tab").addClass("active"); // instead of this do the below 
        $(this).removeClass("btn-default").addClass("btn-primary");   
    });

    $('#btnUpdateUsername').click( () => {

        const username = $('#tbChangeUsername').val();
        const changeUser = 'changeUser';
        const checkUsername = 'checkUsername';

        let error = false;
        let available = false;

        const regUser = /^\w{4,20}$/;


        if(!regUser.test(username)){
            $('.username.error').text('Username is invalid! Must be at least 4 characters long').css({'color': 'red', 'font-size': '12px'});
            error = true;
        }
        else{
            $('.username.error').text('');
            error = false;
        }

        $.ajax({
            type: 'POST',
            url: 'includes/ajax.php',
            data: {username, checkUsername},
            success(data){
                if(data == 'Free'){
                    $('.username.error').text('Valid username!').css({'color': 'green', 'font-size': '12px'});
                    available = true;
                }
                else{
                    $('.username.error').text('Username is already taken!').css({'color': 'red', 'font-size': '12px'});
                    available = true;
                }
            }
        })

        if(!error && !available){
            $.ajax({
                type: 'POST',
                url: 'includes/ajax.php',
                data: {username, changeUser},
                success(data){
                    if(data == 'Success'){
                        
                        $('.modalSuccess').modal('toggle');
                        $('.modalSuccess .modal-body .alert-success').text('Username successfully changed!');

                        setTimeout( () => {
                            $('.modalSuccess').modal('hide');
                        }, 1000);

                        $('#tbChangeUsername').val('');
                        $('#changeUsername').modal('hide');
                        $('.username.error').text('');
                        $('.user-row').html(username);
                        $('.card-title').html(username);
                    }
                }
            })
        }
    })

    $('.close').click( () => {
        $('#tbChangeUsername').val('');
        $('#tbChangeEmail').val('');
    });


    $('#btnUpdateEmail').click( () => {
        const email = $('#tbChangeEmail').val();
        const changeEmail = 'changeEmail';

        let error = false;

        const regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        if(!regEmail.test(email)){
            $('.email.error').text('Email is invalid').css({'color': 'red', 'font-size': '12px'});
            error = true;
        }
        else{
            $('.email.error').text('');
            error = false;
        }

        if(!error){
            $.ajax({
                type: 'POST',
                url: 'includes/ajax.php',
                data: {email, changeEmail},
                success(data){
                    if(data == 'Success'){
                        
                        $('.modalSuccess').modal('toggle');
                        $('.modalSuccess .modal-body .alert-success').text('Email successfully changed!');

                        setTimeout( () => {
                            $('.modalSuccess').modal('hide');
                        }, 1000);

                        $('#tbChangeEmail').val('');
                        $('#changeEmail').modal('hide');
                        $('.email.error').text('');
                        $('.email.row').html(email);
                    }
                }
            })
        }
    });

    $(document).on('click', '.changeProfile', function(e){
        e.preventDefault();

        const href = $(this).find('img').attr('src');
        const changeProfile = 'changeProfile';
        
        $.ajax({
            type: 'POST',
            url: 'includes/ajax.php',
            data: {href, changeProfile},
            success(data){
                if(data === 'both'){
                    const old_href = $('.useravatar').find('img').attr('src');
                    $('.useravatar').find('img').attr('src', href);
                    $('.card-background').find('img').attr('src', href);
                    $('.avatar.row').find('img').attr('src', href);
                    const html = "<a href=\"#\" class=\"changeProfile\"><div class=\"card\" style=\"width: 18rem; display: inline-block;\"><img class=\"card-img-top\" src=\""+old_href+"\" alt=\"Card image cap\"><div class=\"card-body\"><!-- <h5 class=\"card-title\">Card title</h5><a href=\"#\" class=\"btn btn-primary\">Set as profile</a> --></div></div></a>";
                    $('.recently-used').append(html);
                }
                else if(data === 'one'){
                    $('.useravatar').find('img').attr('src', href);
                    $('.card-background').find('img').attr('src', href);
                    $('.avatar.row').find('img').attr('src', href);
                }
            }
        })
    })
});