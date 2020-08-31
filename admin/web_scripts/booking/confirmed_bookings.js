$(document).ready(function () {
    if (sessionStorage.getItem("user_info") == null)
        window.location = "../../authentication/login.html";
    $("#user_admin").html(JSON.parse(sessionStorage.getItem("user_info")).name);

    let table = $("#confirmed_booking").DataTable({
        responsive: true,
        autoWidth: false,
        ajax: {
            url: "../../php_function/confirmed_booking/get_confirmed.php",
            dataSrc: "",
        },
        columns: [
            {
                data: "reservation_id",
                render: function (data, type, full, meta) {
                    let checkin_date = full.checkin_date;
                    let date_now = moment(new Date()).format("YYYY-MM-DD");
                    if (checkin_date == date_now) {
                        return "<span style='height: 15px; width: 15px; border-radius: 50%; display: inline-block; background:#2ba5d4;'></span>";
                    } else {
                        return "";
                    }
                },
            },
            {
                data: "reservation_id",
            },
            {
                data: "first_name",
                render: function (data, type, full, meta) {
                    let status = full;
                    return status.first_name + " " + status.last_name;
                },
            },
            {
                data: "reservation_date",
                render: function (data, type, full, meta) {
                    let status = data;
                    return moment(status).format("YYYY-MM-DD hh:mm a");
                },
            },
            {
                data: "checkin_date",
            },
            {
                data: "checkout_date",
            },
            {
                data: "num_guest",
            },
        ],
    });
    let rev_id = 0;
    $("#confirmed_booking tbody").on("click", "tr", async function () {
        if (table.data().count() > 0) {
            $("#receipts").dataTable().fnDestroy();
            $("#modal-lg").modal("show");
            $("#reservation_id").html(table.row(this).data().reservation_id);
            $("#booking_reference").html(
                table.row(this).data().booking_reference
            );
            $("#number_guest").html(table.row(this).data().num_guest);
            $("#name").html(
                table.row(this).data().first_name +
                " " +
                table.row(this).data().last_name
            );
            $("#contact_number").html(table.row(this).data().contact_number);
            $("#email").html(table.row(this).data().email);
            $("#address").html(
                table.row(this).data().addressline_1 +
                " " +
                table.row(this).data().city +
                " " +
                table.row(this).data().zipcode
            );
            $("#billing_id").val(table.row(this).data().billing_id);

            var reservation_id = table.row(this).data().reservation_id;
            var billing_id = table.row(this).data().billing_id;
            rev_id = reservation_id;
            let table_receipts = $("#receipts").DataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                bAutoWidth: false,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url:
                        "../../php_function/confirmed_booking/get_upload_receipts.php",
                    type: "POST",
                    dataSrc: "",
                    data: { reservation_id: reservation_id },
                },
                columns: [
                    {
                        data: "receipt_photo_id",
                    },
                    {
                        data: "upload_date",
                        render: function (data, type, full, meta) {
                            let status = data;
                            return moment(status).format("YYYY-MM-DD hh:mm a");
                        },
                    },
                ],
            });

            $("#receipts tbody").on("click", "tr", async function () {
                $("#modal-image").modal("show");
                $("#receipt_img").attr(
                    "src",
                    "../../dist/img/bank_receipts/" +
                    table_receipts.row(this).data().photo +
                    ""
                );
            });

            $.ajax({
                url: "../../php_function/confirmed_booking/get_confirmed_rooms.php",
                data: "reservation_id=" + reservation_id,
                type: "POST",
                success: function (response) {
                    var pending_rooms = JSON.parse(response);
                    pending_rooms.map((e) => {
                        $("#confirmed_rooms > tbody:last-child").append(
                            "<tr class='guest_details'><td>" +
                            e.roomtype_name +
                            "</td><td>" +
                            e.room_num +
                            "</td><td>" +
                            e.room_price +
                            "</td></tr>"
                        );
                    });
                },
            });

            var total_amount_payed = 0;
            await $.ajax({
                url: "../../php_function/confirmed_booking/get_payment_history.php",
                data: "billing_id=" + billing_id,
                type: "POST",
                success: function (response) {
                    var payment_history = JSON.parse(response);
                    payment_history.map((e) => {
                        total_amount_payed += parseInt(e.payed_capital);
                        $("#payment_history > tbody:last-child").append(
                            "<tr class='guest_details'><td>" +
                            e.payed_capital +
                            "</td><td>" +
                            moment(e.payment_date).format("YYYY-MM-DD hh:mm a") +
                            "</td></tr>"
                        );
                    });
                },
            });

            var total_amount = 0;
            await $.ajax({
                url:
                    "../../php_function/confirmed_booking/get_confirmed_billing.php",
                data: "billing_id=" + billing_id,
                type: "POST",
                success: (response) => {
                    var billing_pending = JSON.parse(response);
                    total_amount = parseFloat(billing_pending);
                    $("#total_amount").html(total_amount);
                },
            });

            var balance = total_amount - total_amount_payed;
            $("#balance").html(balance);

            $("#modal-lg").on("hidden.bs.modal", function () {
                $("#btn-submit").removeAttr("disabled", "disabled");
                table.ajax.reload();
                $(".guest_details").remove();
            });
        }
    });


    updateSuccess = () => {
        $("#modal-lg").modal("hide");
        sessionStorage.setItem("rev_id_invoice", rev_id);
        window.open("./invoice_print/invoice-print.html", "_blank");
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            type: "success",
            title: "Booking Updated",
        });
    };

    updateHigh = () => {
        $("#btn-submit").removeAttr("disabled", "disabled");
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            type: "warning",
            title: "Too much payment amount",
        });
    };

    updateError = () => {
        $("#btn-submit").removeAttr("disabled", "disabled");
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            type: "error",
            title: " Insufficient Payment Amount",
        });
    };

    $("#confirmed_form").submit((e) => {
        e.preventDefault();
        var billing_id = e.target[1].value;
        var payment_amt = parseInt(e.target[2].value);
        $("#btn-submit").attr("disabled", "disabled");


        $.ajax({
            url: "../../php_function/confirmed_booking/update_booking.php",
            data: "billing_id=" + billing_id + "&payed_capital=" + payment_amt,
            type: "POST",
            success: function (response) {
                console.log(response);
                if (response == '"1"') {
                    updateSuccess();
                } else if (response == '"2"') {
                    updateHigh();
                } else {
                    updateError();
                }
            },
        });
    });
});