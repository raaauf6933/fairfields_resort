$(document).ready(function () {
    if (sessionStorage.getItem("user_info") == null)
        window.location = "../../../authentication/login.html";

    $("#user_admin").html(
        JSON.parse(sessionStorage.getItem("user_info")).name
    );



    if (
        sessionStorage.getItem("walkin_room_details") == null
    )
        window.location = "./select_date.html";

    let room_details = JSON.parse(
        sessionStorage.getItem("walkin_room_details")
    );

    let counter_guest = 0;
    room_details.map((room) => {
        counter_guest += room.new_capacity;
    });

    for (i = 1; counter_guest >= i; i++) {
        $("#num_guest").append("<option value='" + i + "'>" + i + "</option>");
    }
    $("#guest_form").submit((e) => {
        e.preventDefault();
        let first_name = e.target[0].value;
        let last_name = e.target[1].value;
        let gender = e.target[2].checked
            ? e.target[2].value
            : e.target[3].value;
        let email = e.target[4].value;
        let contact_num = e.target[5].value;
        let num_guest = e.target[6].options.selectedIndex;
        let address = e.target[7].value;
        let city = e.target[8].value;
        let zipcode = e.target[9].value;

        let guest_object = {};
        guest_object.first_name = first_name;
        guest_object.last_name = last_name;
        guest_object.gender = gender;
        guest_object.email = email;
        guest_object.contact_num = contact_num;
        guest_object.num_guest = num_guest;
        guest_object.address = address;
        guest_object.city = city;
        guest_object.zipcode = zipcode;

        console.log(guest_object);

        sessionStorage.setItem(
            "walkin_guest_details",
            JSON.stringify(guest_object)
        );

        window.location = "./review_booking.html";
    });
});