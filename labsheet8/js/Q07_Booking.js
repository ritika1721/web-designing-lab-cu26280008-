// Booking Form Validation

document.getElementById("bookingForm").addEventListener("submit", function(event) {

    event.preventDefault();

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let date = document.getElementById("date").value;
    let guests = document.getElementById("guests").value;

    let message = document.getElementById("message");

    if (name === "" || email === "" || date === "" || guests === "") {
        message.innerHTML = "Please fill all fields.";
        return;
    }

    if (new Date(date) < new Date(new Date().toDateString())) {
        message.innerHTML = "Please select a valid future date.";
        return;
    }

    message.innerHTML = "Your booking request has been submitted successfully!";

    this.reset();
});