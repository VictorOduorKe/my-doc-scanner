function logoutUser() {
    fetch("./../database/logout.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `csrf_token=${document.querySelector("input[name='csrf_token']").value}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            window.location.href = data.redirect; // Redirect to login page
        } else {
            console.error("Logout failed:", data.message);
        }
    })
    .catch(error => console.error("Error:", error));
}
const logoutBtn = document.querySelector(".logout");
logoutBtn.addEventListener("click", logoutUser);