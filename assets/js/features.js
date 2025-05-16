feather.replace(); // Crucial: Replace data-feather attributes with SVG icons

const sidebarToggle = document.getElementById("sidebar-toggle");
const sidebar = document.getElementById("sidebar");

if (sidebarToggle && sidebar) {
  sidebarToggle.addEventListener("click", function () {
    sidebar.classList.toggle("collapsed");
  });
}

// Display current date
const currentDateElement = document.getElementById("current-date");
if (currentDateElement) {
  const now = new Date();
  const options = { year: "numeric", month: "long", day: "numeric" };
  currentDateElement.textContent = now.toLocaleDateString("en-US", options);
}