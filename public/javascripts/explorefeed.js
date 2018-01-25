$(document).ready( () => {

    $('.comment-button-link').click( function(e) {
        e.preventDefault();
        const root = $(this).parent().parent().find('.insert-comment');
        if(root.hasClass('active')){
           root.removeClass('active');
        }
        else {
           root.addClass('active');
           root.find('textarea').focus();
        }
    })

    $(document).on('click', '.send_comment', function() {
        const root = $(this).parent().parent().parent();
        const id_doggo = root.find('.img-responsive').attr('alt').split('&')[1].trim()
        const id_user = root.find('.session-user-id').val();
        const text = root.find('.comment-textarea').val();
        const insertComment = 'insertComment';
        
        $.ajax({
            type: 'POST',
            url: 'includes/ajax.php',
            data: {id_doggo, id_user, text, insertComment},
            success(data){
                if(data){
                    data = JSON.parse(data);
                    let html = '<div class="each-comment"><span class="user-image"><img src="'+data['avatar']+'" alt="'+data['name']+'&'+id_user+'"></span><span class="user-name"><b>'+data['name']+'</b></span><small class="form-test text-muted date-commented">'+new Date()+'</small><div class="user-message"><p>'+text+'</p></div></div>';
                    root.find('.list-of-comments').append(html);
                    root.find('.insert-comment textarea').val('');
                    root.find('.insert-comment').removeClass('active');
                }
            }
        })
    })
})