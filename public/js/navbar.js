$(document).ready(() => {
    $.ajax({
        type: "POST",
        // cache: false,
        contentType: false,
        processData: false,
        url: "/api/me",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Authorization",
                "Bearer " + localStorage.getItem("token")
            );
        },
        dataType: "json",
        success: function (data) {
            console.log(data)
            $("#auth_div").show();
            $("#guest_div").hide();
            $("#userName").text(data.user.name);
            $("#userEmail").text(data.user.email);

            if(data.user.user_type != "relative") {
                $("#dashboard_link").show();
            }
            console.log(data.user.name + " is logged in");
        },
        error: function (error) {
            $("#auth_div").hide();
            $("#guest_div").show();
            console.log("Guest");
        },
    });

    $("#logout_button").on("click", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            // cache: false,
            contentType: false,
            processData: false,
            url: "/api/auth/logout",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + localStorage.getItem("token")
                );
            },
            dataType: "json",
            success: function (data) {
                localStorage.removeItem("token");
                window.location.href = "http://localhost:8000/";
            },
            error: function (error) {
                console.log(error)
            },
        });
    })
});
