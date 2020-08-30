$(document).ready(function () {
    if (sessionStorage.getItem("user_info") == null)
        window.location = "../../../authentication/login.html";

    $("#user_admin").html(
        JSON.parse(sessionStorage.getItem("user_info")).name
    );

    error = () => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            type: "error",
            title: "Invalid input dates, please select again",
        });
    };

    warning = () => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            type: "warning",
            title: "Minimum of 1 day bookings",
        });
    };

    info = () => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            type: "info",
            title: "Please input booking date",
        });
    };

    $("#date_sub").submit((e) => {
        e.preventDefault();

        console.log($("#from").val());
        console.log($("#to").val());

        if (
            moment($("#from").val()).format("YYYY-MM-DD") >
            moment($("#to").val()).format("YYYY-MM-DD")
        ) {
            error();
        } else if ($("#from").val() == "" || $("#to").val() == "") {
            info();
        } else if (
            moment($("#from").val()).format("YYYY-MM-DD") ==
            moment($("#to").val()).format("YYYY-MM-DD")
        ) {
            warning();
        } else {
            //session_save
            sessionStorage.setItem(
                "walkin_checkin",
                moment($("#from").val()).format("YYYY-MM-DD")
            );
            sessionStorage.setItem(
                "walkin_checkout",
                moment($("#to").val()).format("YYYY-MM-DD")
            );

            window.location = "./select_rooms.html";
        }
    });
});