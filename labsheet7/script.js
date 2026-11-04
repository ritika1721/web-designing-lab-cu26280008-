function confirmDelete() {
    return confirm("Are you sure you want to delete?");
}

function validateForm() {
    let name = document.getElementById("name").value;

    if (name == "") {
        alert("Please enter your name");
        return false;
    }

    return true;
}