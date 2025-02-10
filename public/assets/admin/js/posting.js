$(document).ready(function(){
    $('#btn-add-posting').click(async function(){
        let res = await httpRequest($(this).data('url'), 'GET')
            $('#modal-content').html(res.data)
            $('#modal').modal('show');
    })
    $(document).on('click', '.like', async function(){
        let res = await httpRequest($(this).data('url-like'), 'GET')
        $(this).html(`<i class="fa fa-thumbs-down" aria-hidden="true"></i>Dislike`)
        $(this).removeClass('like').addClass('dislike')
    })
    $(document).on('click', '.dislike', async function(){
        let res = await httpRequest($(this).data('url-dislike'), 'GET')
        $(this).html(`<i class="fa fa-thumbs-up" aria-hidden="true"></i>Like`)
        $(this).removeClass('dislike').addClass('like')
    })

    $(document).on('click', '.comment', async function(){
        let res = await httpRequest($(this).data('url-comment'), 'GET')
        $('#modal-content').html(res.data)
        $('#modal').modal('show');
    })
    $(document).on('change', '#file-input', function(e){
        const image = document.getElementById("img-preview");
        if (e.target.files.length) {
            const src = URL.createObjectURL(e.target.files[0]);
            image.src = src;
        }
    })

    $(document).on('submit', '#form-comment', async function (e) {
        let text = $(':input[type="submit"]').html();
        try {
            e.preventDefault();
            var formData = new FormData(this);
            $(':input[type="submit"]').html(`<i class='fas fa-spinner fa-pulse'></i> Processing...`)
            $(':input[type="submit"]').prop('disabled', true);
            let res = await httpRequest($(this).attr("action"), $(this).attr("method"), formData, 'html');
            $('#modal').modal('hide');
            $(':input[type="submit"]').prop('disabled', false);
            $(':input[type="submit"]').html(text)

            sweet_alert("success", "Berhasil", res.message).then(function (e) {
                window.location.href = res.data.url;
            }, function (dismiss) {
                return false;
            })
            return false
        } catch (error) {
            $(':input[type="submit"]').prop('disabled', false);
            $(':input[type="submit"]').html(text)
            let _title = "Error";
            sweet_alert("error", _title, error).then(function (e) {
            }, function (dismiss) {
                return false;
            })
        }
    })

    $(document).on('click', '.img-box', async function(){
        let res = await httpRequest($(this).data('url-preview-image'), 'GET')
        $('#modal-content').html(res.data)
        $('#modal').modal('show');
    })
})
