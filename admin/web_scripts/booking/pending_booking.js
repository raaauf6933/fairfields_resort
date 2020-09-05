$(document).ready(function () {
    if (sessionStorage.getItem("user_info") == null)
        window.location = "../../authentication/login.html";
    $("#user_admin").html(
        JSON.parse(sessionStorage.getItem("user_info")).name
    );

    //get all pending bookings
    let table = $("#pending_booking").DataTable({
        responsive: true,
        autoWidth: false,
        ajax: {
            url: "../../php_function/pending_booking/get_pending.php",
            dataSrc: "",
        },
        columns: [
            {
                data: "num_uploaded_recpt",
                render: function (data, type, full, meta) {
                    let status = data;
                    if (status == 0) {
                        return "<span style='height: 15px; width: 15px; background-color: #bbb; border-radius: 50%; display: inline-block; background:red;'></span>";
                    } else {
                        return "<span style='height: 15px; width: 15px; background-color: #bbb; border-radius: 50%; display: inline-block; background:green;'><span>";
                    }
                },
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
                data: "expiration_date",
                render: function (data, type, full, meta) {
                    let status = data;
                    return moment(status).format("YYYY-MM-DD hh:mm a");
                },
            },
        ],
    });

    let global_billing_id;

    $("#pending_booking tbody").on("click", "tr", async function () {
        if (table.data().count() > 0) {
            console.log(table.row(this).data());
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

            global_billing_id = table.row(this).data().billing_id;
            var reservation_id = table.row(this).data().reservation_id;
            var billing_id = table.row(this).data().billing_id;

            let table_receipts = $("#receipts").DataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                bAutoWidth: false,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "../../php_function/pending_booking/get_upload_receipts.php",
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

            $("#receipts tbody").on("click", "tr", function () {
                $("#modal-image").modal("show");
                $("#receipt_img").attr(
                    "src",
                    "../../dist/img/bank_receipts/" +
                    table_receipts.row(this).data().photo +
                    ""
                );
            });

            $.ajax({
                url: "../../php_function/pending_booking/get_pending_rooms.php",
                data: "reservation_id=" + reservation_id,
                type: "POST",
                success: function (response) {
                    var pending_rooms = JSON.parse(response);
                    pending_rooms.map((e) => {
                        $("#pending_rooms > tbody:last-child").append(
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

            var total_amount = 0;
            var downpayment = 0;
            await $.ajax({
                url: "../../php_function/pending_booking/get_pending_billing.php",
                data: "billing_id=" + billing_id,
                type: "POST",
                success: (response) => {
                    var billing_pending = JSON.parse(response);
                    total_amount = parseInt(billing_pending);
                    downpayment = total_amount / 2;

                    $("#downpayment").html(downpayment);
                    $("#total_amount").html(total_amount);
                },
            });

            $("#modal-lg").on("hidden.bs.modal", function () {
                $("#btn-submit").removeAttr("disabled", "disabled");
                table.ajax.reload();
                $(".guest_details").remove();
            });
        }
    });


    updateSuccess = (val) => {
      
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

        $.ajax({
            url: "../../php_function/pending_booking/send_email.php",
            data: "billing_id=" + global_billing_id + "&payed_capital=" + val,
            type: "POST",
            success: function (response) {
                console.log(response)
                $("#modal-lg").modal("hide");
            },
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
    $("#pending_form").submit((e) => {
        e.preventDefault();
        var billing_id = e.target[1].value;
        let payment_amt = parseInt(e.target[2].value);
        $("#btn-submit").attr("disabled", "disabled");

        $.ajax({
            url: "../../php_function/pending_booking/update_booking.php",
            data: "billing_id=" + billing_id + "&payed_capital=" + payment_amt,
            type: "POST",
            success: function (response) {
                if (response == '"1"') {
                    updateSuccess(payment_amt);
                } else if (response == '"2"') {
                    updateHigh();
                } else {
                    updateError();
                }
            },
        });
    });
});