
$(document).ready(() => {
    const $targetEl = document.getElementById('user-modal');
    const modal = new Modal($targetEl);
    $("#user_table").DataTable({
        info: false,
        searching: false,
        ordering: false,
        paging: false,
        processing: true,
        // info: true,
        stateSave: true,
        ajax: {
            url: "http://127.0.0.1:8000/api/user",
            dataSrc: "",
            // beforeSend: function (xhr) {
            //     xhr.setRequestHeader(
            //         "Authorization",
            //         "Bearer " + localStorage.getItem("token")
            //     );
            // },
        },
        order: [0, "dec"],
        // data: data,
        columns: [
            {
                data: null,
                render: function (data, type, row) {
                    return (
                            `<td class="p-4 w-4">
                            <div class="flex items-center">
                                <input id="${data.id}" aria-describedby="checkbox-1" type="checkbox"
                                    class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-cyan-200 h-4 w-4 rounded">
                                <label for="checkbox-1" class="sr-only">checkbox</label>
                            </div>
                        </td>`
                    );
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                            `<td class="p-4 flex items-center whitespace-nowrap space-x-6 mr-12 lg:mr-0">
                            <img class="h-10 w-10 rounded-full" src="/images/users/test"
                                alt="avatar">
                            <div class="text-sm font-normal text-gray-500">
                                <div class="text-base font-semibold text-gray-900">${data.name}</div>
                                <div class="text-sm font-normal text-gray-500">${data.email}</div>
                            </div>
                        </td>`
                    );
                },
            },
            { data: "user_type" },
            { data: "phonenum" },
            {
                data: null,
                render: function (data, type, row) {
                    if (data.status == 'verified')  {
                        return (
                            `<td class="p-4 whitespace-nowrap text-base font-normal text-gray-900">
                            <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>
                                <p>Verified</p>
                            </div>
                        </td>`
                    );
                    }
                    else {
                        return (
                            `<td class="p-4 whitespace-nowrap text-base font-normal text-gray-900">
                            <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-red-400 mr-2"></div>
                                <p>Unverified</p>
                            </div>
                        </td>`
                    );
                    }
                    
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                       `<td class="p-4 whitespace-nowrap space-x-2">
                       <button type="button" data-modal-toggle="user-modal" id="user_edit" data-id="${data.id}"
                           class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                           <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                               xmlns="http://www.w3.org/2000/svg">
                               <path
                                   d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                               </path>
                               <path fill-rule="evenodd"
                                   d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                   clip-rule="evenodd"></path>
                           </svg>
                           Edit user
                       </button>
                       <button type="button" data-modal-toggle="delete-user-modal" id="user_delete" data-id="${data.id}"
                           class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                           <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                               xmlns="http://www.w3.org/2000/svg">
                               <path fill-rule="evenodd"
                                   d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                   clip-rule="evenodd"></path>
                           </svg>
                           Delete user
                       </button>
                   </td>`
                    );
                },
            },
            // {
            //     data: null,
            //     render: function (data, type, row) {
            //         return (
            //             "<a href='#' class='user_delete' id='user_delete' data-id=" +
            //             data.id +
            //             "><i class='fa-solid fa-trash-can' aria-hidden='true' style='font-size:24px; color:red;'></a></i>"
            //         );
            //     },
            // },
        ],
    });

    $("#user_table #user_table_body").on("click", "button#user_edit", function (e) {
        e.preventDefault();
        // $("#user-modal").modal("show");
        var id = $(this).data("id");
        // var id = $(e.relatedTarget).attr("id");
        console.log(id);
        modal.show();
 
        $.ajax({
            type: "GET",
            enctype: "multipart/form-data",
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/user/" + id + "/edit",
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
                // console.log(data);
                $user = data.user;
                $account = data.account;
                // console.log($user);
                // console.log($account);
                $("#edit-user-id").val($user.id);
                $("#edit-first-name").val($account.first_name);
                $("#edit-last-name").val($account.last_name);
                $("#edit-addressline").val($account.address);
                $("#edit-phone-num").val($account.phonenum);
                $("#edit-email").val($user.email);

                // $("#edit-role option").each(function () {
                //     if ($(this).val() == $user.role) {
                //         $(this).prop("selected", true);
                //     }
                // });

                console.log($user.role);
                // if ($user.role == "admin") {
                //     $("#edit-role").val("employee");
                // } else {
                //     $("#edit-role").val($user.role);
                // }

                // $("#img_path").html(
                //     `<img src="${data.img_path}" width="100" class="img-fluid img-thumbnail">`);
                // $("#dispCustomer").attr("src", data.img_path);
                // $("#edit-role").val($user.role).change();
            },
            error: function (error) {
                console.log("error");
            },
        });
    });


    $("#update_user_button").on("click", function (e) {
        e.preventDefault();
        var id = $("#edit-user-id").val();
        console.log(id);
        var data = $("#update_user_form")[0];
        console.log(data);

        let formData = new FormData(data);
        for (var pair of formData.entries()) {
            console.log(pair[0] + "," + pair[1]);
        }
        $.ajax({
            type: "POST",
            // cache: false,
            contentType: false,
            processData: false,
            url: "/api/user-update/" + id,
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            // beforeSend: function (xhr) {
            //     xhr.setRequestHeader(
            //         "Authorization",
            //         "Bearer " + localStorage.getItem("token")
            //     );
            // },
            dataType: "json",
            success: function (data) {
                // console.log(data.img_path);
                // $("#update_user_modal").modal("hide");
                modal.hide();
                $("#user_table").DataTable().ajax.reload();
                console.log("data", data);
                // console.log("message", data.message);
                // console.log("request", data.request);
                // toastr.success(data.message);
            },
            error: function (error) {
                console.log("error");
            },
        });
    });



    const $deleteModal = document.getElementById('delete-user-modal');
    const deleteModal = new Modal($deleteModal);
    $("#user_table #user_table_body").on("click", "button#user_delete", function (e) {
        e.preventDefault();
        // $("#user-modal").modal("show");
        var id = $(this).data("id");
        // var id = $(e.relatedTarget).attr("id");
        var table = $("#user_table").DataTable();
        var id = $(this).data("id");
        var $row = $(this).closest("tr");
        console.log(id);
        deleteModal.show();
        $('#delete_sure').attr('data-id' , id); 
        $('#delete-user-modal').find('#delete_sure').click(function () {
            console.log("this is a test")
            $.ajax({
                type: "DELETE",
                url: "/api/user/" + id,
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content"),
                },
                // beforeSend: function (xhr) {
                //     xhr.setRequestHeader(
                //         "Authorization",
                //         "Bearer " + localStorage.getItem("token")
                //     );
                // },

                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    console.log(data);
                    // bootbox.alert('success');
                    $row.fadeOut(2000, function () {
                        table.row($row).remove().draw(false);
                    });
                    deleteModal.hide()
                    // toastr.success(data.message);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        })
        // $.ajax({
        //     type: "GET",
        //     enctype: "multipart/form-data",
        //     processData: false, // Important!
        //     contentType: false,
        //     cache: false,
        //     url: "/api/user/" + id + "/edit",
        //     headers: {
        //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        //     },
        //     beforeSend: function (xhr) {
        //         xhr.setRequestHeader(
        //             "Authorization",
        //             "Bearer " + localStorage.getItem("token")
        //         );
        //     },
        //     dataType: "json",
        //     success: function (data) {
        //         // console.log(data);
        //         $user = data.user;
        //         $account = data.account;
        //         // console.log($user);
        //         // console.log($account);
        //         $("#edit-user-id").val($user.id);
        //         $("#edit-first-name").val($account.first_name);
        //         $("#edit-last-name").val($account.last_name);
        //         $("#edit-addressline").val($account.address);
        //         $("#edit-phone-num").val($account.phonenum);
        //         $("#edit-email").val($user.email);

        //         // $("#edit-role option").each(function () {
        //         //     if ($(this).val() == $user.role) {
        //         //         $(this).prop("selected", true);
        //         //     }
        //         // });

        //         console.log($user.role);
        //         // if ($user.role == "admin") {
        //         //     $("#edit-role").val("employee");
        //         // } else {
        //         //     $("#edit-role").val($user.role);
        //         // }

        //         // $("#img_path").html(
        //         //     `<img src="${data.img_path}" width="100" class="img-fluid img-thumbnail">`);
        //         // $("#dispCustomer").attr("src", data.img_path);
        //         // $("#edit-role").val($user.role).change();
        //     },
        //     error: function (error) {
        //         console.log("error");
        //     },
        // });
    });

    // $("#delete-user-modal").on("click", "a#delete_sure", function (e) {
    //     e.preventDefault();
    //     // $("#user-modal").modal("show");
    //     var id = $(this).data("id");
    //     // var id = $(e.relatedTarget).attr("id");
    //     console.log(id);
    //     var table = $("#user_table").DataTable();
    //     var id = $(this).data("id");
    //     var $row = $(this).closest("tr");


    //     // deleteModal.show();
    //     // $('#delete_sure').attr('data-id' , id); 
    //     // $.ajax({
    //     //     type: "GET",
    //     //     enctype: "multipart/form-data",
    //     //     processData: false, // Important!
    //     //     contentType: false,
    //     //     cache: false,
    //     //     url: "/api/user/" + id + "/edit",
    //     //     headers: {
    //     //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //     //     },
    //     //     beforeSend: function (xhr) {
    //     //         xhr.setRequestHeader(
    //     //             "Authorization",
    //     //             "Bearer " + localStorage.getItem("token")
    //     //         );
    //     //     },
    //     //     dataType: "json",
    //     //     success: function (data) {
    //     //         // console.log(data);
    //     //         $user = data.user;
    //     //         $account = data.account;
    //     //         // console.log($user);
    //     //         // console.log($account);
    //     //         $("#edit-user-id").val($user.id);
    //     //         $("#edit-first-name").val($account.first_name);
    //     //         $("#edit-last-name").val($account.last_name);
    //     //         $("#edit-addressline").val($account.address);
    //     //         $("#edit-phone-num").val($account.phonenum);
    //     //         $("#edit-email").val($user.email);

    //     //         // $("#edit-role option").each(function () {
    //     //         //     if ($(this).val() == $user.role) {
    //     //         //         $(this).prop("selected", true);
    //     //         //     }
    //     //         // });

    //     //         console.log($user.role);
    //     //         // if ($user.role == "admin") {
    //     //         //     $("#edit-role").val("employee");
    //     //         // } else {
    //     //         //     $("#edit-role").val($user.role);
    //     //         // }

    //     //         // $("#img_path").html(
    //     //         //     `<img src="${data.img_path}" width="100" class="img-fluid img-thumbnail">`);
    //     //         // $("#dispCustomer").attr("src", data.img_path);
    //     //         // $("#edit-role").val($user.role).change();
    //     //     },
    //     //     error: function (error) {
    //     //         console.log("error");
    //     //     },
    //     // });
    // });


























    });