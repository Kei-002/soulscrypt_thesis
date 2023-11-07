$(document).ready(() => {
    $.ajax({
        type: "GET",
        enctype: "multipart/form-data",
        processData: false, // Important!
        contentType: false,
        cache: false,
        url: "/api/user/",
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
            console.log(data);
            var table = $("table#user-table-body > tbody:last-child");
            $.each(data.data, function (i, item) {
                console.log(item);
                table.append(`
                <tr class="hover:bg-gray-100">
                                        <td class="p-4 w-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-${item.id}" aria-describedby="checkbox-1" type="checkbox"
                                                    class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-cyan-200 h-4 w-4 rounded">
                                                <label for="checkbox-1" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="p-4 flex items-center whitespace-nowrap space-x-6 mr-12 lg:mr-0">
                                            <img class="h-10 w-10 rounded-full" src="/images/users/test"
                                                alt="test avatar">
                                            <div class="text-sm font-normal text-gray-500">
                                                <div class="text-base font-semibold text-gray-900">${item.name}</div>
                                                <div class="text-sm font-normal text-gray-500">${item.email}</div>
                                            </div>
                                        </td>
                                        <td class="p-4 whitespace-nowrap text-base font-medium text-gray-900">${item.role}</td>
                                        <td class="p-4 whitespace-nowrap text-base font-medium text-gray-900">Philippines
                                        </td>
                                        <td class="p-4 whitespace-nowrap text-base font-normal text-gray-900">
                                            <div class="flex items-center">
                                                <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div> 
                                                <p>Active</p>

                                            </div>
                                        </td>
                                        <td class="p-4 whitespace-nowrap space-x-2">
                                            <button type="button" data-modal-toggle="user-modal"
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
                                            <button type="button" data-modal-toggle="delete-user-modal"
                                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Delete user
                                            </button>
                                        </td>
                                    </tr>`);
            });
        },
        error: function (error) {
            console.log("error");
        },
    });
});