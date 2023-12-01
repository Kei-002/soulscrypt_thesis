$(document).ready(() => {
    $('#login_button').on('click', function(e) {
        e.preventDefault();
        var data = $("#login_form")[0];
        let formData = new FormData(data);
        for (var pair of formData.entries()) {
            console.log(pair[0] + "," + pair[1]);
        }

        $.ajax({
            type: "POST",
            // cache: false,
            contentType: false,
            processData: false,
            url: "/api/auth/login",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                localStorage.setItem("token", data.access_token);
                console.log("data", data);
                if(data.user.user_type != "relative") {
                    window.location.href = "http://localhost:8000/dashboard";
                } 
                else {
                     window.location.href = "http://localhost:8000/";
                }            
               
            },
            error: function (error) {
                console.log("error");
            },
        });
    })
});