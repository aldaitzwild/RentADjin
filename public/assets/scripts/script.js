if ("active" in localStorage) {
    let active = localStorage.getItem("active");
    document.getElementById(active).classList.toggle("active");
}

document.addEventListener("click", (e) => {
    const isViewMenu = e.target.matches("[view-menu-button]");
    if (!isViewMenu) return;

    let currentView;
    if (isViewMenu) {
        currentView = document.getElementById(e.target.id + "View");
        if (!currentView.classList.contains("active")) {
            currentView.classList.toggle("active");
            localStorage.setItem("active", e.target.id + "View");
        }
    }

    document.querySelectorAll(".active").forEach((view) => {
        if (view !== currentView) {
            view.classList.remove("active");
        }
    });
});
