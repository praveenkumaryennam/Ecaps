$(() => {
    var fileupload = $("#image");
    var button = $(".btnFileUpload");
    button.click(function () {
        fileupload.click();
    });
});

//Image priview
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgpri').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
$("#image").change(function () {
    readURL(this);
});

$.validator.setDefaults({
    errorClass: 'help-block',

    highlight: function (e) {
        $(e).closest('td').addClass('has-error');
    },
    unhighlight: function (e) {
        $(e).closest('td').removeClass('has-error');
    }
});

$('form').validate({
	rules: {
        name:{
            required: true,
        },
        lname:{
            required: true,
        },
        gender:{
            required: true,
        },
        mobile:{
            required: true,
            number:true
        },
        email:{
            required: true,
            email: true
        },
        dob:{
            required: true,
        },
        phone:{
            required: true,
            number:true
        },
        role:{
            required: true,
        },
        code:{
            required: true,
        },
        doj:{
            required: true,
        },
        designation:{
            required: true,
        },
        department:{
            required: true,
        },
        lab_department:{
            required: true,
        },
        location:{
            required: true,
        },
        pan:{
            required: true,
        },
        uid:{
            required: true,
        },
        address1:{
            required: true,
        },
        address2:{
            required: true,
        },
        username:{
            required: true,
        },
        password:{
            required: true,
        }
    }
});