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

    $(document).on('click', '.adminDeleteUser', function(){
        const id = $(this).parent().parent().find('td.id').text().trim();
        const adminDeleteUser = 'adminDeleteUser';
        const that = this;

        $.ajax({
            type: 'POST',
            url: 'includes/ajax.php',
            data: {id, adminDeleteUser},
            success(data){
                if(data == 'Success'){
                    $(that).parent().parent().remove();
                }
            }
        })
    })

    $(document).on('click', '.adminEditDoggo', function(){
        const root = $(this).parent().parent().parent();
        const title = root.find('.title-doggo').text().trim();
        const desc = root.find('.comment-text').text().trim();
        const textarea = `<textarea class="form-control doggoDesc">${desc}</textarea>`;
        root.find('.comment-text').html(textarea);
        const input = `<input type="text" class="form-control doggoTitle" value="${title}">`;
        root.find('.title-doggo').html(input);

        $(this).text('Update').addClass('updateDoggoDesc');
        $(this).removeClass('adminEditDoggo');
    });

    $(document).on('click', '.updateDoggoDesc', function(){
        const root = $(this).parent().parent().parent();
        const id = root.find('.adminPanelDoggo img').attr('alt').split('&')[1].trim();
        const title = root.find('.doggoTitle').val();
        const desc = root.find('.doggoDesc').val();
        const updateDoggoInfo = 'updateDoggoInfo';
        const that = $(this);

        if(title != '' && desc != ''){
            $.ajax({
                type: 'POST',
                url: 'includes/ajax.php',
                data:{id, title, desc, updateDoggoInfo},
                success(data){
                    if(data){
                        that.addClass('adminEditDoggo');
                        that.html('<span class="far fa-edit"></span>').removeClass('updateDoggoDesc');
                        root.find('.title-doggo').text(title);
                        root.find('.comment-text').text(desc);
                    }
                }
            })
        }  
    })

    $(document).on('click', '.adminDeleteDoggo', function(){
        const root = $(this).parent().parent().parent();
        const id = root.find('.adminPanelDoggo img').attr('alt').split('&')[1].trim();
        const deleteDoggo = 'deleteDoggo';

        if(confirm("Are you sure?")){
            $.ajax({
                type: 'POST',
                url: 'includes/ajax.php',
                data: {id, deleteDoggo},
                success(data){
                    if(data){
                        root.parent().remove();
                    }
                }
            })
        }
    })

    $(document).on('click', '.page-link.pagination', function(e){
        e.preventDefault();
        $(this).parent().parent().find('.active').removeClass('active');
        const num = $(this).text().trim();
        const pagginate = 'pagginate'
        const that = this;
        $.ajax({
            type: 'POST',
            url: 'includes/ajax.php',
            data: {num, pagginate},
            success(data){
                if(data){
                    data = JSON.parse(data);
                    let html = '';
                    data.map( row => {
                        html += `<li class="list-group-item">
                        <div class="row"><div class="col-xs-2 col-md-1 adminPanelDoggo"><img src="${row.photo}" class="rounded-circle img-responsive" alt="${row.title}&${row.id}" /></div><div class="col-xs-10 col-md-11 abu"><div><div class="title-doggo">${row.title}</div><div class="mic-info">By: <b>${row.username}</b> on <b>${row.date}</b></div></div><div class="comment-text">${row.desc}</div><div class="action"><button type="button" class="btn btn-primary btn-xs adminEditDoggo" title="Edit"><span class="far fa-edit"></span></button><button type="button" class="btn btn-danger btn-xs adminDeleteDoggo" title="Delete"><span class="far fa-trash-alt"></span></button></div></div></div>
                        </li>`;
                    })
                    $('ul.list-group').html(html);
                    $(that).parent().addClass('active');
                }
            }
        })
    })
});