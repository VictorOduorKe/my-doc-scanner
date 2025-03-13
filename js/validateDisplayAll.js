document.addEventListener("DOMContentLoaded", function () {
    fetch("./../database/display_all.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `csrf_token=${document.querySelector("input[name='csrf_token']").value}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            console.log("Projects Data:", data.projects); // Debugging
            displayProjects(data.projects);
            console.log("Projects Data:", data.projects); // Debugging
        } else {
            console.error("Error fetching projects:", data.message);
        }
    })
    .catch(error => console.error("Error:", error));

    function displayProjects(projects) {
        const container = document.querySelector(".card-group");
        container.innerHTML = ""; // Clear previous content
    
        projects.forEach(project => {
            const card = document.createElement("div");
            card.classList.add("card");
    
            card.innerHTML = `
                <div class="user-detail">
                    <p><strong>User: </strong> ${project.username || "N/A"}</p>
                    <p>${project.student_id || "N/A"}</p>
                    <p>${project.project_name || "N/A"}</p>
                    <p>${project.project_description || "N/A"}</p>
                    <p>${project.created_at}</p>
                </div>
                <div class="btn-group">
                    <button class="status">${project.status}</button>
                    <button class="view">
                        <a href="./view-user.html"><i class="fa fa-eye fa-2x"></i></a>
                    </button>
                    <button class="delete"><i class="fa fa-trash fa-2x"></i></button>
                    <button class="btn"><a href="${project.file_path}" class="download" target="_blank" download><i class="fa fa-download fa-2x"></i></a></button>
                </div>
            `;
    
            container.appendChild(card);
        });
    }
});

