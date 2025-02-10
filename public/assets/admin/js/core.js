function sweet_alert(icon, title , text, showCancelButton =  false, cancelButtonText ='Tidak', confirmButtonText = 'OK', html = ''){
    return Swal.fire({
        title: title,
        icon: icon,
        html: text,
        reverseButtons: !0,
        showCancelButton : showCancelButton,
        cancelButtonText : cancelButtonText,
        confirmButtonText : confirmButtonText,
        allowOutsideClick: false,
    })
}

function loader(){
    return Swal.fire({
          title: 'Mohon Tunggu',
          width: 600,
          padding: '3em',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });
}

function isJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function httpRequest(
    url,
    method,
    data,
    dataType = false,
    contentType = false,
    processData = false,
    showErrorDetail = false,
    withLoader = true
) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: method,
            data : data,
            dataType: dataType,
            contentType: contentType,
            processData: processData,
        })
        .then(function(data){
            if(isJsonString(data)){

                resolve(JSON.parse(data));
            }else{
                if(typeof data == 'object'){
                    resolve(data);
                }
                reject(data.message)
            }
        })
        .fail(function(error){
            let res = JSON.parse(error.responseText);
            reject(res.message)
        })
    });
}



$(document).ready(function(){
    $(document).on('submit', '#form', async function (e) {
        let text = $(':input[type="submit"]').html();
        try {
            e.preventDefault();
            var formData = new FormData(this);
            $(':input[type="submit"]').html(`<i class='fas fa-spinner fa-pulse'></i> Processing...`)
            $(':input[type="submit"]').prop('disabled', true);
            let res = await httpRequest($(this).attr("action"), $(this).attr("method"), formData, 'html');
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
})

function formatRupiah(angka, prefix){
	var rupiah = '';
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
}
