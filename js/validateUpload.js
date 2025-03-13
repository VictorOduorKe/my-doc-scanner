const uploadForm = document.getElementById("form-upload");

uploadForm.addEventListener("submit", (e) => {  
    e.preventDefault();
    
    const messageArea = document.querySelector(".message-area");
    const uploadBtn = uploadForm.querySelector("button[type='submit']");

    const formData = new FormData(uploadForm); // Correct way to send FormData

    uploadBtn.innerHTML = "Uploading...";
    uploadBtn.disabled = true;

    fetch("./../database/process_upload.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.text()) // Log response as text to debug
    .then(text => {
        console.log("Server Response:", text); // Check raw response in console
        return JSON.parse(text); // Convert to JSON
    })
    .then(data => {
        if (data.status === "success") {
            messageArea.innerHTML = data.message;
            messageArea.classList.add("message-success");
            uploadForm.reset();
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 3000);
        } else {
            throw new Error(data.message);
        }
    })
    .catch((error) => {
        messageArea.innerHTML = "An error occurred: " + error.message;
        messageArea.classList.add("message-error");
        uploadBtn.innerHTML = "Upload";
        uploadBtn.disabled = false;
    });
});
