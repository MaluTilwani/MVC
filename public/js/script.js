document.querySelector("form").addEventListener("submit", function(e) {
    let email = document.querySelector("input[name=email]").value;
    let pass = document.querySelector("input[name=password]").value;
    if (email === "" || pass === "") {
        e.preventDefault();
        alert("All fields are required!");
    }
});
