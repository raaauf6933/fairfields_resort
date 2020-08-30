$(document).ready(function () {
    if (sessionStorage.getItem("user_info") == null)
        window.location = "../../authentication/login.html";

    $("#user_admin").html(JSON.parse(sessionStorage.getItem("user_info")).name);

    //get all pending bookings
    let table = $("#check_out").DataTable({
        responsive: true,
        autoWidth: false,
        ajax: {
            url: "../../php_function/checkout/get_checkout.php",
            dataSrc: "",
        },
        columns: [
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
        ],
    });

    let global_reservation_id = 0;
    $("#check_out tbody").on("click", "tr", async function () {
        if (table.data().count() > 0) {
            $("#receipts").dataTable().fnDestroy();
            $("#guest_additional").dataTable().fnDestroy();
            //console.log(table.row(this).data());
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

            global_reservation_id = table.row(this).data().reservation_id;

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
                    url: "../../php_function/checkout/get_upload_receipts.php",
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
                url: "../../php_function/checkout/get_checkout_rooms.php",
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

            $.ajax({
                url: "../../php_function/checkout/get_payment_history.php",
                data: "billing_id=" + billing_id,
                type: "POST",
                success: function (response) {
                    var payment_history = JSON.parse(response);
                    payment_history.map((e) => {
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

            let guest_additional = await $("#guest_additional").DataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                bAutoWidth: false,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "../../php_function/checkout/get_guest_additional.php",
                    dataSrc: "",
                    type: "POST",
                    data: { reservation_id: reservation_id },
                },
                columns: [
                    {
                        data: "description",
                    },
                    {
                        data: "Qty",
                    },
                    {
                        data: "additional_amount",
                    },
                    {
                        data: "total_amount",
                    },
                ],
            });

            var total_amount = 0;
            await $.ajax({
                url: "../../php_function/checkout/get_checkout_billing.php",
                data: "reservation_id=" + reservation_id,
                type: "POST",
                success: (response) => {
                    var guest_billing = JSON.parse(response);
                    guest_billing.map((e) => {
                        total_amount += parseInt(e.original_capital);
                        total_amount += parseInt(e.additional_amount);
                    });

                    $("#total_amount").html(total_amount);
                },
            });

            $("#modal-lg").on("hidden.bs.modal", function () {
                table.ajax.reload();
                $(".guest_details").remove();
            });
        }
    });

    $("#checkout_form").submit((e) => {
        e.preventDefault();
        sessionStorage.setItem("rev_id_invoice", global_reservation_id);
        window.open("./invoice_print/invoice-print.html", "_blank");
    });
});