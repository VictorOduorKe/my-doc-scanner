document.addEventListener("DOMContentLoaded", function (e) {
    e.preventDefault();
    const uploadForm = document.getElementById("form-upload");
      const messageArea = document.querySelector(".message-area");
    if (uploadForm) {
        uploadForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const fileInput = document.querySelector("input[name='file_path']");
            if (!fileInput.files.length) {
                
                messageArea.innerHTML = "Please select a file to upload.";
                messageArea.classList.add("message-error");
                setTimeout(() => {
                    messageArea.innerHTML = "";
                    messageArea.classList.remove("message-error");
                }, 3000);
                return;
            }

            const formData = new FormData(uploadForm); // Automatically appends all form fields

            fetch("../database/process_upload.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text()) // Get raw response for debugging
            .then(text => {

                try {
                    const data = JSON.parse(text); // Parse JSON response
                    if (data.status === "success") {
                        messageArea.innerHTML = data.message;
                        messageArea.classList.add("message-success");
                        uploadForm.reset();
                        const button=e.target.closest("button");

                        button.innerHTML = "Processing...";
                        messageArea.disabled = true;
                        setTimeout(() => {
                            button.innerHTML = "Upload";
                            messageArea.classList.remove("message-success");
                            window.location.href = data.redirect;
                        }, 3000);
                    } else {
                       messageArea.innerHTML = data.message;
                        messageArea.classList.add("message-error");
                        setTimeout(() => {
                            messageArea.innerHTML = "";
                            messageArea.classList.remove("message-error");
                        }, 3000);
                    }
                } catch (error) {
                    console.error("Invalid JSON response:", text);
                }
            })
            .catch(error => console.error("Fetch Error:", error));
        });
    }
});
