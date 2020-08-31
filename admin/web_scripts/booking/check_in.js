$(document).ready(function () {
    if (sessionStorage.getItem("user_info") == null)
        window.location = "../../authentication/login.html";

    $("#user_admin").html(JSON.parse(sessionStorage.getItem("user_info")).name);

    let table = $("#checkin_table").DataTable({
        responsive: true,
        autoWidth: false,
        ajax: {
            url: "../../php_function/checkin/get_checkin.php",
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

    let global_reservation_id = 0;
    let global_billing_id = 0;
    let global_total_amount = 0;
    let global_total_payed = 0;
    let global_balance = 0;
    let global_additional = 0;

    $("#checkin_table tbody").on("click", "tr", async function () {
        if (table.data().count() > 0) {
            $("#receipts").dataTable().fnDestroy();
            $("#guest_additional").dataTable().fnDestroy();
            $("#modal-lg").modal("show");
            $("#reservation_id").html(table.row(this).data().reservation_id);
            $("#booking_reference").html(table.row(this).data().booking_reference);
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
            global_reservation_id = reservation_id;
            global_billing_id = billing_id;

            let table_receipts = $("#receipts").DataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                bAutoWidth: false,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "../../php_function/checkin/get_upload_receipts.php",
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

            await $.ajax({
                url: "../../php_function/checkin/get_checkin_rooms.php",
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
                url: "../../php_function/checkin/get_payment_history.php",
                data: "billing_id=" + billing_id,
                type: "POST",
                success: function (response) {
                    var payment_history = JSON.parse(response);
                    payment_history.map((e) => {
                        global_total_payed += parseInt(e.payed_capital);
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

            let additional_amount = 0;
            let guest_additional = await $("#guest_additional").DataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                bAutoWidth: false,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "../../php_function/checkin/get_guest_additional.php",
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

            await $.ajax({
                url: "../../php_function/checkin/get_guest_additional.php",
                data: "reservation_id=" + reservation_id,
                type: "POST",
                success: (response) => {
                    JSON.parse(response).map((e) => {
                        global_additional += parseInt(e.total_amount);
                    });
                },
            });

            global_total_amount = 0 + global_additional;
            await $.ajax({
                url: "../../php_function/checkin/get_checkin_billing.php",
                data: "billing_id=" + billing_id,
                type: "POST",
                success: (response) => {
                    var billing_pending = JSON.parse(response);
                    global_total_amount += parseFloat(billing_pending);
                    $("#total_amount").html(global_total_amount);
                },
            });

            global_balance = global_total_amount - global_total_payed;
            $("#balance").html(global_balance);

            $("#modal-lg").on("hidden.bs.modal", function () {
                $("#btn-submit").removeAttr("disabled", "disabled");
                table.ajax.reload();
                $(".guest_details").remove();
            });

            $("#modal-lg").on("hidden.bs.modal", function () {
                global_additional = 0;
                global_balance = 0;
                global_reservation_id = 0;
                global_total_amount = 0;
                global_total_payed = 0;
                global_billing_id = 0;
                table.ajax.reload();
                $(".guest_details").remove();
                $("#btn-submit").removeAttr("disabled", "disabled");
            });

            //additional_type_modal
            $("#modal-additional").on("hidden.bs.modal", function () {
                $("#equictntbl").dataTable().fnClearTable();
                $("#guest_additional").dataTable().fnDestroy();
                guest_additional.ajax.reload();
            });
        }
    });

    $(document).on("click", "#btn-additional", async (e) => {
        $("#modal-additional").modal("show");

        await $.ajax({
            url: "../../php_function/checkin/get_additional_type.php",
            type: "POST",
            success: (response) => {
                let additional_type = JSON.parse(response);
                console.log(additional_type);
                additional_type.map((e) => {
                    $("#additional_type > tbody:last-child").append(
                        "<tr class='additional_type'><td>" +
                        e.additional_type +
                        "</td><td>" +
                        e.additional_amount +
                        "</td><td colspan='2'><form class='add-additional'> <div class='input-group mb-3'><input value='" +
                        global_reservation_id +
                        "' hidden/><input value='" +
                        e.additional_id +
                        "'  hidden/><input type='number' min='1' class='inputAd form-control' aria-describedby='button-addon2' required> <div class='input-group-append'> <button class='btn btn-outline-secondary' ><i class='fas fa-plus'></i></button> </div> </div></form></td></tr>"
                    );
                });
            },
        });

        $(".add-additional").submit(async function (e) {
    
            $("#guest_additional").dataTable().fnDestroy();
            e.preventDefault();
            let reservation_id = e.target[0].value;
            let additional_id = e.target[1].value;
            let qty = e.target[2].value;

            updateGuestadditional = () => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                });

                Toast.fire({
                    type: "success",
                    title: "Additional Added",
                });
            };

            await $.ajax({
                url: "../../php_function/checkin/insert_guest_additional.php",
                data:
                    "reservation_id=" +
                    reservation_id +
                    "&additional_id=" +
                    additional_id +
                    "&qty=" +
                    qty,
                type: "POST",
                success: (response) => {
                    console.log("guest_additional response: " + response);
                    let guest_billing = JSON.parse(response);
                    guest_billing.map((e) => {
                        global_additional = parseInt(e.additional_amount);
                        global_total_amount =
                            parseInt(e.original_capital) + global_additional;
                        global_total_payed = parseInt(e.payed_capital);
                        global_balance = global_total_amount - global_total_payed;
                    });
                    console.log();
                    $("#balance").html(global_balance);
                    $("#total_amount").html(global_total_amount);

                    $(".inputAd").val("");
                    updateGuestadditional();
                },
            });
        });

        $("#modal-additional").on("hidden.bs.modal", function () {
            //table.ajax.reload();

            $(".additional_type").remove();
        });
    });

    updateSuccess = () => {
        $("#modal-lg").modal("hide");
        sessionStorage.setItem("rev_id_invoice", global_reservation_id);
        window.open("./invoice_print/invoice-print.html", "_blank");
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            type: "success",
            title: "Checkout Success",
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

    $("#checkin_form").submit((e) => {
        e.preventDefault();
        $("#btn-submit").attr("disabled", "disabled");
        var payment_amt = parseInt(e.target[3].value);

        $.ajax({
            url: "../../php_function/checkin/update_booking.php",
            data: "billing_id=" + global_billing_id + "&payed_capital=" + payment_amt,
            type: "POST",
            success: function (response) {
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
