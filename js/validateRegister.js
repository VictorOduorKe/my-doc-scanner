"use strict";

document.getElementById("register_form").addEventListener("submit", (event) => {
    event.preventDefault();

    const messageArea = document.querySelector(".message-area");
    const form = event.target; 
    const formData = new FormData(form);

    fetch("database/process_register.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) 
    .then(data => {
        if (data.status === "success") {
            messageArea.innerHTML = data.message; 
            messageArea.classList.add("register-success");

            form.reset(); 

            setTimeout(() => {
                messageArea.innerHTML = "";
                messageArea.classList.remove("register-success");
                window.location.href = "./login.php";
            }, 6000);

        } else {
            messageArea.innerHTML = data.message; 
            messageArea.classList.add("message-error");

            setTimeout(() => {
                messageArea.innerHTML = "";
                messageArea.classList.remove("message-error");
            }, 6000);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        messageArea.innerHTML = "Something went wrong. Please try again.";
        messageArea.classList.add("message-error");

        setTimeout(() => {
            messageArea.innerHTML = "";
            messageArea.classList.remove("message-error");
        }, 6000);
    });
});
