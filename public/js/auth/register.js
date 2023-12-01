$(document).ready(() => {
    $('#register_button').on('click', function(e) {
        e.preventDefault();
        var data = $("#register_form")[0];
        let formData = new FormData(data);
        for (var pair of formData.entries()) {
            console.log(pair[0] + "," + pair[1]);
        }

        $.ajax({
            type: "POST",
            // cache: false,
            contentType: false,
            processData: false,
            url: "/api/auth/register",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                // localStorage.setItem("token", data.access_token);
                console.log("Register Success");
                window.location.href = "http://localhost:8000/login"     
               
            },
            error: function (error) {
                console.log("error");
            },
        });
    })
});