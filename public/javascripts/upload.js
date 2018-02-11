$(document).ready( () => {
    $('#btnUploadDoggo').click( (e) => {

        e.preventDefault();

        const title = $('#tbDoggoTitle').val();
        const description = $('#taDoggoDescription').val();
        const category = parseInt($('#ddlDoggoCategory').val());
        const file_path = $('#flDoggo').val();
        const extension = file_path.split('.').pop();
        let counter = 0;

        const regTitle = /^[A-Za-z0-9]{1,20}(\s?[A-Za-z0-9]{1,20}){0,3}$/;
        // const regDesc = /^[A-Za-z0-9\.\!\?\-\_\,]{1,20}(\s?[A-Za-z0-9\.\!\?\-\_\,]{1,40}){0,20}$/;
        const regCategory = /^(1|2|3|4)$/;
        const regExtension = /^(png|jpe?g)$/;

       
        if(!regTitle.test(title)){
            counter++;
            $('.title.error').text('Title is invalid! Min 4 chars, max 20').css({'color': 'red', 'font-size': '12px'});
        }

        if(description.length < 5 || description.length > 100){
            counter++;
            $('.description.error').text('Description is invalid! Min 5 chars, max 100').css({'color': 'red', 'font-size': '12px'});
        }

        if(!regCategory.test(category)){
            counter++;
            $('.category.error').text('Category is invalid! Don\'t modify html').css({'color': 'red', 'font-size': '12px'});
        }

        if(!regExtension.test(extension)){
            $('.doggo.error').text('File is invalid! Must be .png, .jpg or .jpeg').css({'color': 'red', 'font-size': '12px'});
            counter++;
        }

        if(counter === 0)
            $('#doggoForm').submit();
        
    })
})