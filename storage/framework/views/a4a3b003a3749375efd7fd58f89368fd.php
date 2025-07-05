<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <span class="navbar-brand">Dashboard</span>
        <button onclick="logout()" class="btn btn-outline-danger">Logout</button>
    </div>
</nav>

<div class="container">
    <h4 class="mb-4">Your Tasks</h4>
    <div id="taskList" class="row g-3"></div>
</div>

<script>
async function loadTasks() {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/tasks", {
        headers: { "Authorization": "Bearer " + token }
    });

    if (!res.ok) {
        alert("Unauthorized");
        return;
    }

    const tasks = await res.json();
    const container = document.getElementById("taskList");
    container.innerHTML = "";

    tasks.forEach(task => {
        const card = document.createElement("div");
        card.className = "col-md-4";
        card.innerHTML = `
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>${task.title}</h5>
                    <p>${task.description}</p>
                    <span class="badge text-bg-${getStatusColor(task.status)}">${task.status}</span>
                    <small class="d-block mt-2 text-muted">Due: ${task.due_date}</small>
                </div>
            </div>
        `;
        container.appendChild(card);
    });
}

if (!localStorage.getItem("token")) {
    window.location.href = "/";
}

function getStatusColor(status) {
    return {
        pending: "secondary",
        in_progress: "warning",
        done: "success"
    }[status] || "dark";
}

function logout() {
    localStorage.clear();
    window.location.href = "/";
}

document.addEventListener("DOMContentLoaded", loadTasks);
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\tes-eval\resources\views/dashboard.blade.php ENDPATH**/ ?>