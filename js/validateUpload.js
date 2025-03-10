const uploadForm = document.getElementById("form-upload");

uploadForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const project_name = uploadForm.elements["doc_username"].value.trim();
    const file_input = uploadForm.elements["file"];
    const file_name = file_input.files[0]; // Correctly access the uploaded file
    const messageArea = document.querySelector(".message-area");
     const allowedExtensions=["docs","pdf"];

    // Validation for empty fields
    if (project_name === "" || !file_name) {
        messageArea.innerHTML = "Kindly fill all fields";
        messageArea.classList.add("message-error");

        setTimeout(() => {
            messageArea.innerHTML = "";
            messageArea.classList.remove("message-error");
        }, 6000);
        return;
    }
    const pdfExtension=file_name.name.split(".").pop().toLowerCase();
     if(!allowedExtensions.includes(pdfExtension)){
        messageArea.innerHTML="Only docs and pdf format allowed";
        messageArea.classList.add("message-error");

        setTimeout(()=>{
            messageArea.innerHTML="";
            messageArea.classList.remove("message-error");
        },6000);
        return;
     }

    // ✅ If validation passes, reset the form
    uploadForm.reset();

    messageArea.innerHTML = "File uploaded successfully!";
    messageArea.classList.add("message-success");

    setTimeout(() => {
        messageArea.innerHTML = "";
        messageArea.classList.remove("message-success");
        window.location.href="./view_upload.html"
    }, 6000);
});
