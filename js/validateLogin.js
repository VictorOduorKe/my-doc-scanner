const loginForm = document.querySelector("#login-form");

loginForm.addEventListener("submit", (e) => {
    e.preventDefault();
    
    const btn = document.querySelector(".login_btn");
    const messageArea = document.querySelector(".message-area");
    const formData = new FormData(loginForm);

    

    fetch("./database/process_login.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        messageArea.innerHTML = ""; 

        if (data.status === "success") {
            messageArea.innerHTML = data.message;
            messageArea.classList.add("login-success");
            loginForm.reset();
            btn.innerHTML = "Processing...";
            btn.disabled = true;
            setTimeout(() => {
               window.location.href=data.redirect;
                messageArea.innerHTML = "";
                messageArea.classList.remove("login-success");
            }, 2000);
        } else {
            messageArea.innerHTML = data.message;
            messageArea.classList.add("message-error");
            btn.innerHTML = "Login"; 
            btn.disabled = false; 
            
            setTimeout(() => {
                messageArea.innerHTML = "";
                messageArea.classList.remove("message-error");
            }, 3000);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong. Please try again.");
        btn.innerHTML = "Login";
        btn.disabled = false; 
    });
});
