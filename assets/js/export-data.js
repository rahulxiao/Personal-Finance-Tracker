document.addEventListener("DOMContentLoaded", function () {
    // Icons
    feather.replace();

    // Current date
    const dateEl = document.getElementById("current-date");
    if (dateEl) {
        dateEl.textContent = new Date().toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric",
        });
    }

    // Tabs
    const tabs = document.querySelectorAll(".export-nav-tab");
    for (let i = 0; i < tabs.length; i++) {
        tabs[i].addEventListener("click", function () {
            for (let j = 0; j < tabs.length; j++) tabs[j].classList.remove("active");
            this.classList.add("active");
            const tabId = this.getAttribute("data-tab");
            const panes = document.querySelectorAll(".export-tab-pane");
            for (let k = 0; k < panes.length; k++)
                panes[k].classList.remove("active");
            document.getElementById(tabId + "-tab").classList.add("active");
        });
    }

    // Action buttons
    const exportBtns = document.querySelectorAll(".quick-export-btn");
    for (let i = 0; i < exportBtns.length; i++) {
        exportBtns[i].addEventListener("click", function () {
            const format = this.getAttribute("data-format");
            showNotification(`Exporting in ${format.toUpperCase()}...`, "success");
            setTimeout(() => showExportModal(format), 800);
        });
    }

    const downloadBtns = document.querySelectorAll(
        ".export-actions .action-btn[title='Download']"
    );
    for (let i = 0; i < downloadBtns.length; i++) {
        downloadBtns[i].addEventListener("click", function () {
            const name = this.closest(".export-history-item").querySelector(
                "h4"
            ).textContent;
            showNotification(`Downloading ${name}...`, "success");
        });
    }
});

// Export modal
function showExportModal(format) {
    const modal = document.getElementById("export-download-modal");
    if (modal) {
        if (format) {
            const fileEl = modal.querySelector(".file-name");
            if (fileEl) {
                const date = new Date().toISOString().split("T")[0];
                fileEl.textContent = `financial_export_${date}.${format}`;
            }
        }
        modal.style.display = "flex";

        const closeBtn = modal.querySelector(".close-modal");
        if (closeBtn) {
            closeBtn.addEventListener("click", () => (modal.style.display = "none"));
        }

        window.addEventListener("click", (e) => {
            if (e.target === modal) modal.style.display = "none";
        });

        const downloadBtn = modal.querySelector(".download-btn");
        if (downloadBtn) {
            downloadBtn.addEventListener("click", (e) => {
                e.preventDefault();
                showNotification("Download completed", "success");
                modal.style.display = "none";
            });
        }
    }
}

// Notification
function showNotification(msg, type) {
    const container = document.getElementById("notification-container");
    if (container) {
        const note = document.createElement("div");
        note.className = `notification ${type}`;
        note.innerHTML = `
            <i data-feather="${type === "success" ? "check-circle" : "info"
            }"></i>
            ${msg}
            <button class="notification-close"><i data-feather="x"></i></button>
        `;
        container.appendChild(note);
        feather.replace();

        const closeBtn = note.querySelector(".notification-close");
        if (closeBtn) closeBtn.addEventListener("click", () => note.remove());

        setTimeout(() => note.remove(), 3000);
    }
}
