$(document).ready( () => {

    let ALL_COMMENTS;
    let all_comments = 'all_comments';
    $.ajax({
        type: 'POST',
        url: 'includes/ajax.php',
        data: { all_comments },
        success(data){
            if(data){
                data = JSON.parse(data);
                ALL_COMMENTS = data;
                console.log(ALL_COMMENTS)
            }
        }
    })

    let crop_for_each = [];
    let id_of_current_doggo = [];

    function slice_comments(obj, id_doggo, niz){
        if(id_of_current_doggo.includes(id_doggo)){
            let crop;
            for(let i=0; i < crop_for_each.length; i++){
                if(crop_for_each[i].doggo_id == id_doggo){
                    crop_for_each[i].crop++;
                    crop = crop_for_each[i].crop;
                }
            }
            let append = niz.slice(crop, crop+1);
            return append;
        }
        else {
            crop_for_each.push(obj);
            id_of_current_doggo.push(id_doggo);
            return niz.slice(3, 4);
        }
    }
  
    $('.load-more').click(function(e){
        e.preventDefault();
        const root = $(this).parent();
        const doggo_id = $(this).attr('href');
        let html = '';
        let crop = 3;
        obj = {doggo_id, crop};
        let comments = ALL_COMMENTS.filter( comment => {
            return comment.id_doggo == doggo_id;
        })

        let res = slice_comments(obj, doggo_id, comments);

        res.map( comm => {
            html += '<div class="each-comment"><span class="user-image"><img src="'+comm.avatar+'" alt="'+comm.username +'&' + comm.id_user+'"></span><span class="user-name"><b>'+comm.username+'</b></span><small class="form-test text-muted date-commented">'+comm.date+'</small><div class="user-message"><p>'+comm.comment+'</p></div></div>';
        })

        root.find('.list-of-comments').append(html);
        


    })

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

    $('.like-button-link').click( function(e) {
        e.preventDefault();
        const root = $(this).parent().parent().parent();
        const id_doggo = parseInt(root.find('.img-responsive').attr('alt').split('&')[1].trim());
        const id_user = parseInt(root.find('.session-user-id').val());
        const likedPost = 'likedPost';
        let like;

        if(root.find('.like-button-link').hasClass('liked')){
            root.find('.like-button-link').removeClass('liked');
            like = 0;
        }
        else{
            root.find('.like-button-link').addClass('liked');
            like = 1;
        }

        $.ajax({
            type: 'POST',
            url: 'includes/ajax.php',
            data: {id_user, id_doggo, like, likedPost},
            success(data){
                if(data){
                    let num_likes = root.find('.statistics').find('.likes-counter').text().replace(/[^\d]/g, '').trim();
                    if(like == 0) {
                        root.find('.statistics').find('.likes-counter').text(--num_likes + ' likes');
                    }
                    else {
                        root.find('.statistics').find('.likes-counter').text(++num_likes + ' likes');
                    }
                    
                    if(root.find('.dislike-button-link').hasClass('disliked')){
                        root.find('.dislike-button-link').removeClass('disliked');
                        let num_dislikes = root.find('.statistics').find('.dislikes-counter').text().replace(/[^\d]/g, '').trim();
                        root.find('.statistics').find('.dislikes-counter').text(--num_dislikes + ' dislikes');
                    }
                }
            }
        })
    })

    $('.dislike-button-link').click( function(e) {
        e.preventDefault();
        const root = $(this).parent().parent().parent();
        const id_doggo = parseInt(root.find('.img-responsive').attr('alt').split('&')[1].trim());
        const id_user = parseInt(root.find('.session-user-id').val());
        const dislikedPost = 'dislikedPost';
        let dislike;

        if(root.find('.dislike-button-link').hasClass('disliked')){
            root.find('.dislike-button-link').removeClass('disliked');
            dislike = 0;
        }
        else{
            root.find('.dislike-button-link').addClass('disliked');
            dislike = 1;
        }

        $.ajax({
            type: 'POST',
            url: 'includes/ajax.php',
            data: {id_user, id_doggo, dislike, dislikedPost},
            success(data){
                if(data){
                    let num_dislikes = root.find('.statistics').find('.dislikes-counter').text().replace(/[^\d]/g, '').trim();
                    if(dislike == 0) {
                        root.find('.statistics').find('.dislikes-counter').text(--num_dislikes + ' dislikes');
                    }
                    else{
                        root.find('.statistics').find('.dislikes-counter').text(++num_dislikes + ' dislikes');
                    }
                    if(root.find('.like-button-link').hasClass('liked')){
                        root.find('.like-button-link').removeClass('liked');
                        let num_likes = root.find('.statistics').find('.likes-counter').text().replace(/[^\d]/g, '').trim();
                        root.find('.statistics').find('.likes-counter').text(--num_likes + ' likes');
                    }
                }
            }
        })
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
                    const date = new Date();
                    const date_now = date.getFullYear()+'-'+date.getMonth()+1+'-'+date.getDate()+' '+date.getHours()+':'+date.getMinutes()+':'+date.getSeconds();
                    let html = '<div class="each-comment"><span class="user-image"><img src="'+data['avatar']+'" alt="'+data['name']+'&'+id_user+'"></span><span class="user-name"><b>'+data['name']+'</b></span><small class="form-test text-muted date-commented">'+date_now+'</small><div class="user-message"><p>'+text+'</p></div></div>';
                    root.find('.list-of-comments').append(html);
                    root.find('.insert-comment textarea').val('');
                    root.find('.insert-comment').removeClass('active');
                    let num_comm = root.find('.statistics').find('.comments-counter').text().replace(/[^\d]/g, '').trim();
                    root.find('.statistics').find('.comments-counter').text(++num_comm + ' comments');
                }
            }
        })
    })
})