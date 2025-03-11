` use strict`;

  document.getElementById("register_form").addEventListener("submit", function(event) {
    event.preventDefault();


  const messageArea=document.querySelector(".message-area");

    const formData = new FormData(this);

    fetch("database/process_register.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes("successfully")) {

          messageArea.innerHTML=data; 
          messageArea.classList.add("message-success");
          setTimeout(() => {
            messageArea.innerHTML=""; 
          messageArea.classList.remove("message-success");
          }, 6000);
          return;
          
        } else {
          messageArea.innerHTML=data; 
          messageArea.classList.add("message-error");
          setTimeout(() => {
            messageArea.innerHTML=""; 
          messageArea.classList.remove("message-error");
          }, 6000);
          return;
        }
    })
    .catch(error => console.error("Error:", error));
});