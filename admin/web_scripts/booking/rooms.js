$(document).ready(function () {
    if (sessionStorage.getItem("user_info") == null)
        window.location = "../../authentication/login.html";
    $("#user_admin").html(JSON.parse(sessionStorage.getItem("user_info")).name);
    $.ajax({
        url: "../../php_function/get_rooms.php",
        data: "roomtype_id=" + $("#type").val(),
        type: "POST",
        success: function (response) {
            console.log(response);
            var rooms_ = JSON.parse(response);

            console.log(rooms_);
            rooms_.map((room) => {
                if (room.status == 1) {
                   
                    $("#room_row").append(
                        $(
                            "<div class='open-Modal col-2'><div class='card border shadow'style='width:11rem; height: 5rem; cursor:pointer;'><div class='card-body bg-secondary rounded' data-roomid=" +
                            room.room_num +
                            "><h5 class='card-title'><b>" +
                            room.room_num +
                            "</b></h5></div></div></div>"
                        )
                    );
                } else {
                    if (room.reservation_id == 0) {
                    
                        $("#room_row").append(
                            $(
                                "<div class='open-Modal col-2'><div class='card border shadow'style='width:11rem; height: 5rem; cursor:pointer;'><div class='card-body bg-success rounded' data-roomid=" +
                                room.room_num +
                                "><h5 class='card-title'><b>" +
                                room.room_num +
                                "</b></h5></div></div></div>"
                            )
                        );
                    } else {
           
                        $("#room_row").append(
                            $(
                                "<div class='open-Modal col-2'><div class='card border shadow'style='width:11rem; height: 5rem; cursor:pointer;'><div class='card-body bg-danger rounded' data-roomid=" +
                                room.room_id +
                                " data-reservation-id=" +
                                room.reservation_id +
                                " data-occupied=" +
                                1 +
                                "><h5 class='card-title'><b>" +
                                room.room_num +
                                "</b></h5></div></div></div>"
                            )
                        );
                    }
                } 
/*
                if (room.status == 0) {
                    $("#room_row").append(
                        $(
                            "<div class='open-Modal col-2'><div class='card border shadow'style='width:11rem; height: 5rem; cursor:pointer;'><div class='card-body bg-success rounded' data-roomid=" +
                            room.room_num +
                            "><h5 class='card-title'><b>" +
                            room.room_num +
                            "</b></h5></div></div></div>"
                        )
                    );
                } else if (room.status == 1) {
                    $("#room_row").append(
                        $(
                            "<div class='Modal col-2'><div class='card border shadow'style='width:11rem; height: 5rem; cursor:pointer;'><div class='card-body bg-danger rounded'><h5 class='card-title'><b>" +
                            room.room_num +
                            "</b></h5></div></div></div>"
                        )
                    );
                } else {
                    $("#room_row").append(
                        $(
                            "<div class='col-2'><div class='card border shadow'style='width:11rem; height: 5rem; cursor:pointer;'><div class='card-body bg-secondary rounded'><h5 class='card-title'><b>" +
                            room.room_num +
                            "</b></h5></div></div></div>"
                        )
                    );
                }*/
            });

            $(document).on("click", ".open-Modal", (e) => {
                $("#modal-default").modal("show");
                if (e.target.attributes[3].nodeValue) {
                    let room_id = e.target.attributes[1].nodeValue;
                    let reservation_id = e.target.attributes[2].nodeValue;
                    let room_name = e.target.innerText;

                    $("#room_title").html(room_name);
                    $("#reservation_id").html(reservation_id);

                    $.ajax({
                        url: "../../php_function/room_map/get_reservation.php",
                        data: "reservation_id=" + reservation_id,
                        type: "POST",
                        success: function (response) {
                            let reservation_details = JSON.parse(response);

                            $("#guest_name").html(
                                reservation_details.first_name +
                                " " +
                                reservation_details.last_name
                            );
                            $("#check_in").html(reservation_details.checkin_date);
                            $("#check_out").html(reservation_details.checkout_date);
                        },
                    });
                } else {
                }
            });

            $(document).on("click", "#btn-additional", (e) => {
                $("#modal-additional").modal("show");
            });
        },
    });

    $("#type").change(() => { });
});