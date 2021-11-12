document.addEventListener("click", (e) => {
    const isViewMenu = e.target.matches("[view-menu-button]");
    if (!isViewMenu) return;

    let currentView;
    if (isViewMenu) {
        currentView = document.getElementById(e.target.id + "View");
        console.log(currentView);
        if (!currentView.classList.contains("active")) {
            currentView.classList.toggle("active");
            console.log(currentView);
        }
    }

    document.querySelectorAll(".active").forEach((view) => {
        if (view !== currentView) {
            view.classList.remove("active");
        }
    });
});
