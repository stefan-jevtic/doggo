$(document).ready( () => {

    let usernameAvb = true;
    
    $(document).on('click', 'button.adminUpdateUser', function() {
        const id = $(this).parent().parent().find('.id').text().trim();
        const username = $(this).parent().parent().find('.name').text().trim();
        const email = $(this).parent().parent().find('.email').text().trim();
        const role = $(this).parent().parent().find('.role').text().trim();

        $('#adminUpdateUsername').val(username);
        $('#adminUpdateEmail').val(email);
        $('#UserId').val(id);

        let html = '';

        if(role == 'admin')
            html += '<option value="admin">Admin</option><option value="user">User</option>';
        else
            html += '<option value="user">User</option><option value="admin">Admin</option>';
        $('#adminUpdateRole').html(html);

    })

    $('#adminUpdateUsername').blur( () => {
        const username = $('#adminUpdateUsername').val();
        const checkUsername = 'checkUsername';
        const error = false;
        const id = $('#UserId').val(); 
        const oldUsername = $(`#${id}`).parent().find('.name').text().trim()

        const regUser = /^\w{4,20}$/;

        if(!regUser.test(username)){
            $('.username.error').text('Username is invalid! Must be at least 4 characters long').css({'color': 'red', 'font-size': '12px'});
            error = true;
            usernameAvb = false;
        }

        if(!error && username !== oldUsername){
            $.ajax({
                type: 'POST',
                url: 'includes/ajax.php',
                data: {username, checkUsername},
                success(data){
                    if(data == 'Free'){
                        $('.username.error').text('Valid username!').css({'color': 'green', 'font-size': '12px'});
                        usernameAvb = true;
                    }
                    else{
                        $('.username.error').text('Username is already taken!').css({'color': 'red', 'font-size': '12px'});
                        usernameAvb = false;
                    }
                }
            })
        }

        if(username === oldUsername)
            $('.username.error').text('')
    });

    $('#btnAdminUpdateUser').click( () => {

        const username = $('#adminUpdateUsername').val();
        const email = $('#adminUpdateEmail').val();
        const role = $('#adminUpdateRole').val();
        const id = $('#UserId').val();
        const adminUpdateUser = 'adminUpdateUser';

        let counter = 0;

        const regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        const regUser = /^\w{4,20}$/;
        const regRole = /^(admin|user)$/;

        if(!regRole.test(role)){
            $('.role.error').text('Please, choose from dropdown menu, don\'t modify html. Thanks!').css({'color': 'red', 'font-size': '12px'});
            counter++;
        }
        else{
            $('.role.error').text('');
            
        }


        if(!regEmail.test(email)){
            $('.email.error').text('Email is invalid').css({'color': 'red', 'font-size': '12px'});
            counter++;
        }
        else{
            $('.email.error').text('');
            
        }

        if(!regUser.test(username)){
            $('.username.error').text('Username is invalid! Must be at least 4 characters long').css({'color': 'red', 'font-size': '12px'});
            counter++;
        }
        else{
            $('.username.error').text('');
            
        }


        if(counter < 1 && usernameAvb){
            $.ajax({
                type: 'POST',
                url: 'includes/ajax.php',
                data: {username, email, role, id, adminUpdateUser},
                success(data) {

                    if(data == 'Success'){
                        $('#adminUpdateUser').modal('hide');

                        $('.modalSuccess').modal('toggle');
                        $('.modalSuccess .modal-body .alert-success').text('User data Successfully changed!');

                        setTimeout( () => {
                            $('.modalSuccess').modal('hide');
                        }, 1000);

                        $(`#${id}`).parent().find('.name').text(username);
                        $(`#${id}`).parent().find('.email').text(email);
                        $(`#${id}`).parent().find('.role').text(role);
                    }
                }
            })
        }
    })

});