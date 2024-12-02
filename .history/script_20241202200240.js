document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("scholarshipForm");
    const responseDiv = document.getElementById("response");

    form.addEventListener("submit", (event) => {
        event.preventDefault(); // Prevent form from submitting traditionally
        const formData = new FormData(form);

        // Mocking a successful submission (use AJAX for real submission)
        responseDiv.style.display = "block";
        responseDiv.style.backgroundColor = "#e0ffe4";
        responseDiv.style.color = "#2d7a3e";
        responseDiv.innerHTML = `
            <strong>Success!</strong> Your scholarship application has been submitted.<br>
            <ul>
                <li><strong>Name:</strong> ${formData.get("name")}</li>
                <li><strong>Email:</strong> ${formData.get("email")}</li>
                <li><strong>Phone:</strong> ${formData.get("phone")}</li>
                <li><strong>Date of Birth:</strong> ${formData.get("dob")}</li>
                <li><strong>Address:</strong> ${formData.get("address")}</li>
                <li><strong>Course of Study:</strong> ${formData.get("course")}</li>
                <li><strong>Academic Qualification:</strong> ${formData.get("grade")}</li>
            </ul>
        `;

        form.reset(); // Clear form after submission
    });
});
