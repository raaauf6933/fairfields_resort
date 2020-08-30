$(document).ready(function () {
    if (sessionStorage.getItem("user_info") == null)
        window.location = "../../../authentication/login.html";

    $("#user_admin").html(
        JSON.parse(sessionStorage.getItem("user_info")).name
    );



    let reqr_roomtype = (function () {
        var tmp = null;
        $.ajax({
            async: false,
            url: "../../../php_function/walkin/get_roomtype.php",
            type: "POST",
            success: function (data) {
                tmp = data;
            },
        });
        return JSON.parse(tmp);
    })();

    let req_rooms = (function () {
        var tmp = null;
        $.ajax({
            async: false,
            url: "../../../php_function/walkin/get_rooms.php",
            data:
                "check_in=" +
                sessionStorage.getItem("walkin_checkin") +
                "&check_out=" +
                sessionStorage.getItem("walkin_checkout"),
            type: "POST",
            success: function (data) {
                tmp = data;
            },
        });
        return JSON.parse(tmp);
    })();

    reqr_roomtype.map((e) => {
        let counter_rooms = 0;
        req_rooms.map((rooms) => {
            if (rooms.roomtype_id == e.roomtype_id) {
                counter_rooms += 1;
            } else {
            }
        });

        let option = "";

        if (counter_rooms == 0) {
            option = "<option value='0'>No available room</option>";
        } else {
            for (i = 1; counter_rooms >= i; i++) {
                option += "<option value=" + i + ">" + i + "</option>";
            }
        }

        $("#table_rooms > tbody:last-child").append(
            "<tr><td>" +
            e.roomtype_name +
            "</td><td>" +
            e.roomtype_price +
            "</td><td>" +
            e.roomtype_capacity +
            "</td><td>" +
            e.description +
            "</td><td><form class='add-room'><div class='input-group mb-3'><input value='" +
            e.roomtype_id +
            "' hidden/><input value='" +
            e.roomtype_price +
            "' hidden/><input value='" +
            e.roomtype_name +
            "' hidden/><input value='" +
            e.roomtype_capacity +
            "' hidden/><select class='form-control'><option selected hidden disabled></option>" +
            option +
            "</select><div class='input-group-append'><button type='submit' class='room" +
            e.roomtype_id +
            " btn btn-primary' id='room" +
            e.roomtype_id +
            "'>ADD</button></div></div></form></td></tr>"
        );
    });

    let selected_array = [];

    $(".add-room").submit(function (e) {
        e.preventDefault();
        if (e.target[4].value != 0) {
            let roomtype_id = e.target[0].value;
            let roomtype_price = e.target[1].value;
            let roomtype_name = e.target[2].value;
            let roomtype_capacity = e.target[3].value;
            let num_rooms = e.target[4].options.selectedIndex;

            let new_price = roomtype_price * num_rooms;
            let new_capacity = roomtype_capacity * num_rooms;
            let selected_object = {};

            let selected_rooms = [];

            let counter = 1;
            req_rooms.map((rooms) => {
                if (rooms.roomtype_id == roomtype_id && counter <= num_rooms) {
                    selected_rooms.push(rooms.room_id);
                    counter++;
                }
            });

            selected_object.roomtype_id = roomtype_id;
            selected_object.roomtype_name = roomtype_name;
            selected_object.num_rooms = num_rooms;
            selected_object.new_capacity = new_capacity;
            selected_object.new_price = new_price;
            selected_object.room_ids = selected_rooms;

            selected_array.push(selected_object);

            $("#room" + roomtype_id).attr("disabled", "disabled");
            $(".room" + roomtype_id).attr("disabled", "disabled");

            $("#invoice > tbody:last-child").append(
                "<tr id='" +
                roomtype_id +
                "'>" +
                "<th>" +
                roomtype_name +
                "</th>" +
                "<td>" +
                num_rooms +
                "</td>" +
                "<td> " +
                new_price +
                ".00</td>" +
                "<td>" +
                '<button class="btn' +
                roomtype_id +
                ' btn btn-default">' +
                '<i class="fa fa-times"></i>' +
                "</button>" +
                "</td>" +
                "</tr>"
            );

            $(".btn" + roomtype_id).attr(
                "onclick",
                "deleteselected(" + roomtype_id + ")"
            );
        } else {
            Swal.fire({
                icon: "info",
                title: "Oops...",
                text:
                    "This type of room has no available room, Try another booking dates",
            });
        }
    });

    deleteselected = (e) => {
        let room_id = e;
        let new_object = {};

        selected_array = selected_array.filter(check_selected);

        function check_selected(item, index, array) {
            if (item.roomtype_id != room_id) {
                return item;
            }
        }
        //console.log(room_id[0])
        console.log(selected_array);
        $("#" + room_id).remove();
        $("#room" + room_id).removeAttr("disabled", "disabled");
        $(".room" + room_id).removeAttr("disabled", "disabled");
    };

    $("#continue").click((e) => {
        if (selected_array.length != 0) {
            sessionStorage.setItem(
                "walkin_room_details",
                JSON.stringify(selected_array)
            );

            window.location = "guest_details.html";
        } else {
            Swal.fire({
                icon: "warning",
                title: "You forgot something?",
                text: "Please select room first!",
            });
        }
    });
});